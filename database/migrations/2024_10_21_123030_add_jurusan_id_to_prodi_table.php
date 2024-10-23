<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJurusanIdToProdiTable extends Migration
{
    public function up()
    {
        Schema::table('prodis', function (Blueprint $table) {
            $table->foreignId('jurusan_id')->nullable()->constrained('jurusans')->onDelete('set null'); // Menambahkan kolom jurusan_id
        });
    }

    public function down()
    {
        Schema::table('prodis', function (Blueprint $table) {
            $table->dropForeign(['jurusan_id']); // Menghapus foreign key
            $table->dropColumn('jurusan_id'); // Menghapus kolom jurusan_id
        });
    }
}
