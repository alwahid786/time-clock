<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPendingColumnsToClocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clocks', function (Blueprint $table) {
            $table->timestamp('pending_time')->nullable()->after('time');
            $table->text('pending_memo')->nullable()->after('memo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clocks', function (Blueprint $table) {
            $table->dropColumn('pending_minutes');
            $table->dropColumn('pending_time');
            $table->dropColumn('pending_memo');
        });
    }
}
