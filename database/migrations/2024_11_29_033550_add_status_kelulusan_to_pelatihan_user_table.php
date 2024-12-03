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
    Schema::table('pelatihan_user', function (Blueprint $table) {
        $table->enum('status_kelulusan', ['menunggu', 'lulus', 'tidak_lulus'])->default('menunggu')->after('status_pendaftaran'); // Sesuaikan 'kolom_terakhir'
    });
}

public function down()
{
    Schema::table('pelatihan_user', function (Blueprint $table) {
        $table->dropColumn('status_kelulusan');
    });
}

};
