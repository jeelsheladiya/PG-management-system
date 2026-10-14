<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    Room,
    RoomRequest,
    RoomAllocation,
    RoomOccupancy,
    PGMember,
    RoomPricing,
    Payment,
    Amenity,
    RoomChangeRequest,
};
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use App\Mail\BookingSuccessMail;
use Illuminate\Support\Facades\Auth;

class MemberRoomController extends Controller
{
    /* ================= ROOMS LIST ================= */
    // 1. Room List Page
    public function index(Request $request)
    {
        $memberId = session('member_id');

        $query = Room::with('occupancy')->where('Status', 'Active');

        // filter
        if ($request->has('capacity') && $request->capacity != '') {
            $query->where('Capacity', $request->capacity);
        }

        return view('member.rooms.index', [
            'rooms' => $query->get(),
            'member' => PGMember::find($memberId),
            'hasActiveRoom' => RoomAllocation::where('MemberID', $memberId)
                ->where('Status', 'Active')
                ->exists()
        ]);
    }
    /* ================= MY ROOM ================= */
    public function myRoom()
    {
        $memberId = session('member_id');

        $allocation = RoomAllocation::with(['room', 'payment'])
            ->where('MemberID', $memberId)
            ->where('Status', 'Active')
            ->latest('AllocationDate')
            ->first();

        $occupancy = $allocation
            ? RoomOccupancy::where('RoomID', $allocation->RoomID)->first()
            : null;


        return view('member.rooms.my-room', compact('allocation', 'occupancy'));
    }

    /* ================= BOOK ROOM ================= */
    // 2. Member Details Validation Page
    public function bookRoom($roomId)
    {
        $memberId = session('member_id');
        if (RoomAllocation::where('MemberID', $memberId)->where('Status', 'Active')->exists()) {
            return back()->with('error', 'You already have an active room allocation.');
        }

        return view('member.rooms.book', [
            'room' => Room::findOrFail($roomId),
            'member' => PGMember::findOrFail($memberId)
        ]);
    }
    // 3. Confirm Member & Create Pending Allocation
    public function confirmMember(Request $request, $roomId)
    {
        $memberId = session('member_id');
        $request->validate([
            'Name' => 'required',
            'Email' => 'required|email|unique:pgmember,Email,' . $memberId . ',MemberID',
            'AdhaarNumber' => 'required|digits:12|unique:pgmember,AdhaarNumber,' . $memberId . ',MemberID',
            'Phone' => 'nullable|digits:10',
            'ParentsMobile' => 'nullable|digits:10',
            'Course' => 'required',
            'DOB' =>  [
                'required',
                'date',
                'before:' . Carbon::now()->subYears(18)->format('Y-m-d')
            ],
            'Gender' => 'required',
            'Address' => 'required',
            'Pincode' => 'required|digits:6',
        ], [
            // ✅ Custom messages (clean UI)
            'Email.unique' => 'This email is already registered.',
            'AdhaarNumber.unique' => 'Adhaar number already exists.',
        ]);
        // Update Member Profile
        PGMember::where('MemberID', $memberId)->update($request->only([
            'Name',
            'Email',
            'AdhaarNumber',
            'Phone',
            'ParentsMobile',
            'Course',
            'DOB',
            'Gender',
            'Address',
            'Pincode'
        ]));

        // Create Pending Allocation
        $allocation = RoomAllocation::create([
            'MemberID' => $memberId,
            'RoomID' => $roomId,
            'Status' => 'Pending',
            'AllocationDate' => now() // Temporary, will update in final step
        ]);

        return redirect()->route('rooms.payment.page', $allocation->AllocationID);
    }
    /* ================= PAYMENT ================= */
    // 4. Date Selection Page
    public function paymentPage($allocationId)
    {
        $allocation = RoomAllocation::with('room')->findOrFail($allocationId);
        return view('member.payment.page', compact('allocation'));
    }



    public function paymentPreview(Request $request, $allocationId)
    {
        $request->validate([
            'book_date' => 'required|date|after_or_equal:today',
            'leave_date' => 'required|date|after:book_date',
        ]);

        $allocation = RoomAllocation::with('room')->findOrFail($allocationId);

        $start = Carbon::parse($request->book_date);
        $end = Carbon::parse($request->leave_date);
        $days = max($start->diffInDays($end), 1);

        $pricing = RoomPricing::where('Capacity', $allocation->room->Capacity)
            ->where('EffectiveFrom', '<=', now())
            ->latest('EffectiveFrom')
            ->firstOrFail();

        //  Total Rent
        $months = floor($days / 30);
        $extraDays = $days % 30;
        $totalRentValue = ($months * $pricing->MonthlyRent) + ($extraDays * $pricing->DailyRent);

        // now paying amount
        if ($days <= 30) {
            // if book for days then take all rent
            $amountToPayNow = $totalRentValue;
        } else {
            // if more than a month then take only month rent
            $amountToPayNow = $pricing->MonthlyRent;
        }

        // remaining amount
        $pendingAmount = $totalRentValue - $amountToPayNow;

        return view('member.payment.form', [
            'allocation' => $allocation,
            'days' => $days,
            'months' => $months,
            'extraDays' => $extraDays,
            'totalRentValue' => $totalRentValue,
            'payable_amount' => $totalRentValue,
            'amountToPayNow' => $amountToPayNow,
            'pendingAmount' => $pendingAmount,
            'pricing' => $pricing,
            'book_date' => $request->book_date,
            'leave_date' => $request->leave_date
        ]);
    }



    public function processStripePayment(Request $request, $allocationId)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Stripe Checkout session
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'inr',
                        'product_data' => ['name' => 'Room Booking Payment'],
                        'unit_amount' => $request->amount * 100, // Stripe counts in Paisa (Amount * 100)
                    ],
                    'quantity' => 1,
                ]
            ],
            'mode' => 'payment',
            // If success then send Data
            'success_url' => route('stripe.success', $allocationId) .
                '?session_id={CHECKOUT_SESSION_ID}&book_date=' . $request->book_date .
                '&leave_date=' . $request->leave_date .
                '&payable_amount=' . $request->payable_amount .
                '&amount=' . $request->amount,
            'cancel_url' => route('rooms.payment.preview', $allocationId),
        ]);

        return redirect($session->url);
    }

    // After Payment Success This logic will Execute
    public function stripeSuccess(Request $request, $allocationId)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

        try {
            // Stripe session varify
            $session = $stripe->checkout->sessions->retrieve($request->get('session_id'));

            if ($session->payment_status === 'paid') {

                return DB::transaction(function () use ($allocationId, $request) {
                    $allocation = RoomAllocation::with('room')->lockForUpdate()->findOrFail($allocationId);

                    //payment table entry
                    Payment::create([
                        'MemberID' => $allocation->MemberID,
                        'AllocationID' => $allocationId,
                        'PeriodStart' => $request->book_date,
                        'PeriodEnd' => $request->leave_date,
                        'RentAmount' => $request->payable_amount,
                        'TotalAmount' => $request->amount,
                        'PaymentDate' => now(),
                        'PaymentMode' => 'Stripe Online',
                        'Status' => 'Paid',
                        'PaymentFor' => 'Room Booking'
                    ]);

                    // allocation table Update
                    $allocation->update([
                        'AllocationDate' => $request->book_date,
                        'ReleaseDate' => $request->leave_date,
                        'Status' => 'Active'
                    ]);

                    // room occupancy upadate
                    RoomOccupancy::where('RoomID', $allocation->RoomID)->increment('CurrentOccupancy');
                    RoomOccupancy::where('RoomID', $allocation->RoomID)->decrement('VacantBeds');


                    $details = [
                        'name' => $allocation->member->Name,
                        'room_no' => $allocation->room->RoomNumber,
                        'book_date' => $request->book_date,
                        'leave_date' => $request->leave_date,
                        'amount' => $request->amount
                    ];

                    // mail send
                    Mail::to($allocation->member->Email)->send(new BookingSuccessMail($details));

                    return redirect()->route('member.my-room')
                        ->with('success', 'Payment Successful! Your room is now active.');
                });
            }
        } catch (\Exception $e) {
            return redirect()->route('rooms.payment.preview', $allocationId)
                ->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }
    /* ================= ROOM REQUEST ================= */
    public function requestRoom($roomId)
    {
        RoomRequest::create([
            'MemberID' => session('member_id'),
            'RoomID' => $roomId,
            'RequestDate' => now(),
            'Status' => 'Pending'
        ]);

        return back()->with('success', 'Room request sent');
    }

    /* ================= AMENITIES ================= */
    public function amenities()
    {
        $amenities = Amenity::where('Status', 'Available')->get();
        return view('member.amenities.index', compact('amenities'));
    }

    //for js in create payment
    public function getRoomPricing($allocationId)
    {
        $allocation = RoomAllocation::with('room')->find($allocationId);
        $pricing = RoomPricing::where('Capacity', $allocation->room->Capacity)
            ->latest('EffectiveFrom')
            ->first();

        return response()->json([
            'monthly' => $pricing->MonthlyRent,
            'daily' => $pricing->DailyRent
        ]);
    }

    public function changeRoomForm()
    {
        $memberId = session('member_id');
        $allocation = RoomAllocation::where('MemberID', $memberId)->where('Status', 'Active')->firstOrFail();

        // Same capacity and Empty Rooms
        $availableRooms = Room::whereHas('occupancy', function ($q) {
            $q->where('VacantBeds', '>', 0);
        })
            ->where('Capacity', $allocation->room->Capacity)
            ->where('RoomID', '!=', $allocation->RoomID)
            ->get();

        return view('member.rooms.change_request', compact('availableRooms', 'allocation'));
    }

    public function storeChangeRequest(Request $request)
    {
        $request->validate([
            'NewRoomID' => 'required|exists:room,RoomID',
            'Reason' => 'required|max:255'
        ]);

        $memberId = session('member_id');
        $currentAllocation = RoomAllocation::where('MemberID', $memberId)->where('Status', 'Active')->first();

        RoomChangeRequest::create([
            'MemberID' => $memberId,
            'OldRoomID' => $currentAllocation->RoomID,
            'NewRoomID' => $request->NewRoomID,
            'Reason' => $request->Reason,
            'Status' => 'Pending'
        ]);

        return redirect()->route('member.my-room')->with('success', 'Room change request sent!');
    }



    public function confirmDetails($room_id)
    {
        // member id from session
        $member_id = session('member_id');

        // if session not have then go to login page
        if (!$member_id) {
            return redirect('/member/login?room_id=' . $room_id)->with('error', 'Please login first');
        }

        // get data
        $member = PGMember::where('MemberID', $member_id)->first();
        $room = Room::findOrFail($room_id);

        // check allocation
        $allocation = RoomAllocation::where('RoomID', $room_id)
            ->where('MemberID', $member_id)
            ->first();

        // if not allocated then create new record for avoid template errror
        if (!$allocation) {
            $allocation = RoomAllocation::create([
                'RoomID' => $room_id,
                'MemberID' => $member_id,
                'AllocationDate' => now(),
                'Status' => 'Pending'
            ]);
        }

        return view('member.confirm_details', compact('member', 'room', 'allocation'));
    }

    public function ConfirmpaymentPage($allocationId)
    {
        $allocation = RoomAllocation::with('room')->findOrFail($allocationId);
        return view('member.confirmpaymentpage', compact('allocation'));
    }

    public function handlePaymentPreview(Request $request, $allocationId)
    {
        $request->validate([
            'Name' => 'required|string|max:255',
            'Email' => 'required|email',
            'AdhaarNumber' => 'required|digits:12',
            'ParentsMobile' => 'required|digits:10',
            'book_date' => 'required|date|after_or_equal:today',
            'leave_date' => 'required|date|after:book_date',
            'adhaar_file' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $allocation = RoomAllocation::with('room')->findOrFail($allocationId);
        $member = PGMember::where('MemberID', $allocation->MemberID)->firstOrFail();
        $memberId = $member->MemberID; // to get MemberID 

        // અપડેટ કરવા માટેનો ડેટા
        $updateData = [
            'Name' => $request->Name,
            'Email' => $request->Email,
            'AdhaarNumber' => $request->AdhaarNumber,
            'ParentsMobile' => $request->ParentsMobile,
            'Course' => $request->Course,
            'DOB' => $request->DOB,
            'Gender' => $request->Gender,
            'Pincode' => $request->Pincode,
            'Address' => $request->Address,
        ];

        // ૨. Aadhaar File (Secure Storage Folder)
        if ($request->hasFile('adhaar_file')) {
            $adhaarName = 'adhaar_' . $memberId . '_' . time() . '.' . $request->adhaar_file->extension();
            $destinationPath = storage_path('app/private/adhaar_files');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $request->file('adhaar_file')->move($destinationPath, $adhaarName);
            $updateData['AdhaarFile'] = $adhaarName; // add data to the array
        }

        // ૩. Profile Picture (Public Folder)
        if ($request->hasFile('profile_pic')) {
            $profileName = 'profile_' . $memberId . '_' . time() . '.' . $request->profile_pic->extension();
            $publicProfilePath = public_path('uploads/profile_pics');

            if (!file_exists($publicProfilePath)) {
                mkdir($publicProfilePath, 0777, true);
            }

            $request->file('profile_pic')->move($publicProfilePath, $profileName);
            $updateData['ProfilePic'] = 'uploads/profile_pics/' . $profileName; // save path
        }

        // update all data
        $member->update($updateData);


        // rent calculation
        $start = Carbon::parse($request->book_date);
        $end = Carbon::parse($request->leave_date);
        $days = max($start->diffInDays($end), 1);

        $pricing = RoomPricing::where('Capacity', $allocation->room->Capacity)
            ->where('EffectiveFrom', '<=', now())
            ->latest('EffectiveFrom')
            ->firstOrFail();

        $months = floor($days / 30);
        $extraDays = $days % 30;
        $totalRentValue = ($months * $pricing->MonthlyRent) + ($extraDays * $pricing->DailyRent);
        $amountToPayNow = ($days <= 30) ? $totalRentValue : $pricing->MonthlyRent;
        $pendingAmount = $totalRentValue - $amountToPayNow;

        return view('member.payment_confirmation', [
            'allocation' => $allocation,
            'days' => $days,
            'months' => $months,
            'extraDays' => $extraDays,
            'totalRentValue' => $totalRentValue,
            'payable_amount' => $totalRentValue,
            'amountToPayNow' => $amountToPayNow,
            'pendingAmount' => $pendingAmount,
            'pricing' => $pricing,
            'book_date' => $request->book_date,
            'leave_date' => $request->leave_date
        ]);
    }


    public function handlePaymentStore(Request $request, $allocationId)
    {

        // dd($request->all());
        // ૧. વેલિડેશન
        $request->validate([
            'payment_mode' => 'required',
            'book_date' => 'required|date',
            'leave_date' => 'required|date',
            'payable_amount' => 'required',
            'amount' => 'required'
        ]);

        // ૨. if cash then direct local save
        if ($request->payment_mode == 'Cash') {
            return $this->completeBookingProcess($request->all(), $allocationId);
        }

        // ૩. Stripe payment gateway set up
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $session = Session::create([
                // 'automatic_payment_methods' કાઢી નાખો અને આ લાઈન ઉમેરો
                'payment_method_types' => ['card'], // અત્યારે કાર્ડ રાખો, એકવાર પેજ ખુલે પછી UPI ઉમેરીશું
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'inr',
                            'product_data' => [
                                'name' => 'Room Booking Payment',
                                'description' => 'Stay from ' . $request->book_date . ' to ' . $request->leave_date,
                            ],
                            'unit_amount' => (int) ($request->amount * 100),
                        ],
                        'quantity' => 1,
                    ]
                ],
                'mode' => 'payment',
                'metadata' => [
                    'allocation_id' => $allocationId,
                    'book_date' => $request->book_date,
                    'leave_date' => $request->leave_date,
                    'payable_amount' => $request->payable_amount,
                    'amount' => $request->amount,
                    'payment_mode' => $request->payment_mode,
                ],
                'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('member.my-room'),
            ]);
            return redirect($session->url);

        } catch (\Exception $e) {
            // return back()->with('error', 'Stripe Error: ' . $e->getMessage());
            dd($e->getMessage());
        }
    }

    public function paymentSuccess(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Stripe માંથી સેશનનો ડેટા ખેંચો
        $session = Session::retrieve($request->get('session_id'));

        // Metadata ને ઓબ્જેક્ટમાંથી એરેમાં ફેરવો
        $meta = $session->metadata;

        return DB::transaction(function () use ($meta) {
            // અહીં $meta->allocation_id વાપરવું કારણ કે Stripe Metadata ઓબ્જેક્ટ આપે છે
            $allocation = RoomAllocation::with('room')->lockForUpdate()->findOrFail($meta->allocation_id);

            // ૧. પેમેન્ટ ટેબલમાં એન્ટ્રી
            Payment::create([
                'MemberID' => $allocation->MemberID,
                'AllocationID' => $meta->allocation_id,
                'PeriodStart' => $meta->book_date,
                'PeriodEnd' => $meta->leave_date,
                'RentAmount' => $meta->payable_amount,
                'DepositAmount' => 0,
                'FineAmount' => 0,
                'TotalAmount' => $meta->amount,
                'PaymentDate' => now(),
                'PaymentMode' => $meta->payment_mode,
                'Status' => ($meta->amount >= $meta->payable_amount) ? 'Paid' : 'Pending',
                'PaymentFor' => 'Room Booking'
            ]);

            // ૨. એલોકેશન અપડેટ
            $allocation->update([
                'AllocationDate' => $meta->book_date,
                'ReleaseDate' => $meta->leave_date,
                'Status' => 'Active'
            ]);

            // ૩. રૂમ ઓક્યુપન્સી અપડેટ
            RoomOccupancy::where('RoomID', $allocation->RoomID)->update([
                'CurrentOccupancy' => DB::raw('CurrentOccupancy + 1'),
                'VacantBeds' => DB::raw('VacantBeds - 1')
            ]);

            return redirect()->route('member.my-room')->with('success', 'Payment successful! Room allocated.');
        });
    }
    public function visiterbookRoom($roomId)
    {
        $memberId = session('member_id');
        if (RoomAllocation::where('MemberID', $memberId)->where('Status', 'Active')->exists()) {
            return back()->with('error', 'You already have an active room allocation.');
        }

        return view('member.rooms.book', [
            'room' => Room::findOrFail($roomId),
            'member' => PGMember::findOrFail($memberId)
        ]);
    }

    private function completeBookingProcess($data, $allocationId)
    {
        return DB::transaction(function () use ($allocationId, $data) {
            $allocation = RoomAllocation::with('room')->lockForUpdate()->findOrFail($allocationId);

            // ૧. પેમેન્ટ ટેબલમાં એન્ટ્રી
            Payment::create([
                'MemberID' => $allocation->MemberID,
                'AllocationID' => $allocationId,
                'PeriodStart' => $data['book_date'],
                'PeriodEnd' => $data['leave_date'],
                'RentAmount' => $data['payable_amount'],
                'DepositAmount' => 0,
                'FineAmount' => 0,
                'TotalAmount' => $data['amount'],
                'PaymentDate' => now(),
                'PaymentMode' => $data['payment_mode'],
                'Status' => ($data['amount'] >= $data['payable_amount']) ? 'Paid' : 'Pending',
                'PaymentFor' => 'Room Booking'
            ]);

            // ૨. એલોકેશન અપડેટ
            $allocation->update([
                'AllocationDate' => $data['book_date'],
                'ReleaseDate' => $data['leave_date'],
                'Status' => 'Active'
            ]);

            // ૩. રૂમ ઓક્યુપન્સી અપડેટ
            RoomOccupancy::where('RoomID', $allocation->RoomID)->update([
                'CurrentOccupancy' => DB::raw('CurrentOccupancy + 1'),
                'VacantBeds' => DB::raw('VacantBeds - 1')
            ]);

            return redirect()->route('member.my-room')->with('success', 'Booking Confirmed with Cash!');
        });
    }
}
