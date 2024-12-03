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
    Schema::table('sertifikats', function (Blueprint $table) {
        $table->string('no_sertifikat')->unique()->nullable()->after('id'); // Sesuaikan 'kolom_terakhir' dengan kolom terakhir di tabel
    });
}

public function down()
{
    Schema::table('sertifikat', function (Blueprint $table) {
        $table->dropColumn('no_sertifikat');
    });
}

};
