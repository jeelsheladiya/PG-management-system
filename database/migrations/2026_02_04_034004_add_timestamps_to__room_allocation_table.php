<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimestampsToRoomallocationTable extends Migration
{
    public function up()
    {
        Schema::table('roomallocation', function (Blueprint $table) {
            if (!Schema::hasColumn('roomallocation', 'created_at')) {
                $table->timestamp('created_at')->nullable();
            }
            if (!Schema::hasColumn('roomallocation', 'updated_at')) {
                $table->timestamp('updated_at')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('roomallocation', function (Blueprint $table) {
            if (Schema::hasColumn('roomallocation', 'created_at')) {
                $table->dropColumn('created_at');
            }
            if (Schema::hasColumn('roomallocation', 'updated_at')) {
                $table->dropColumn('updated_at');
            }
        });
    }
}
