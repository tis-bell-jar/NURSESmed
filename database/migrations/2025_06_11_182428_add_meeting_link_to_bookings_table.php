<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('bookings', function (Blueprint $table) {
        $table->string('meeting_link')->nullable();
    });
}
public function down()
{
    Schema::table('bookings', function (Blueprint $table) {
        $table->dropColumn('meeting_link');
    });
}

};
