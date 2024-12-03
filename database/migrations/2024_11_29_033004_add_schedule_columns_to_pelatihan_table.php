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
        Schema::table('pelatihan', function (Blueprint $table) {
            $table->dateTime('jadwal_pelatihan_mulai')->nullable()->after('deskripsi');
            $table->dateTime('jadwal_pelatihan_selesai')->nullable()->after('jadwal_pelatihan_mulai');
        });
    }

    public function down()
    {
        Schema::table('pelatihan', function (Blueprint $table) {
            $table->dropColumn(['jadwal_pelatihan_mulai', 'jadwal_pelatihan_selesai']);
        });
    }

};
