<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnCheckoutToAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->timestamp('check_out')->nullable()->after('datetime');
            $table->timestamp('check_in')->nullable()->after('datetime');
            $table->dropColumn('datetime');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn('check_out');
            $table->dropColumn('check_in');
            $table->timestamp('datetime')->nullable()->after('user_id');
        });
    }
}
