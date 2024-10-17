<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSertifikatTable extends Migration
{
    public function up()
    {
        Schema::create('sertifikats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Foreign key for User
            $table->string('nama_pelatihan'); // Training name
            $table->date('tanggal_berlaku'); // Start date
            $table->date('tanggal_berakhir'); // End date
            $table->string('sertifikat_file'); // Path to certificate file
            $table->timestamps();

            // Define the foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sertifikat');
    }
}
