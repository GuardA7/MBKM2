<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJurusanIdToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kolom jurusan_id yang terkait dengan tabel jurusans
            $table->foreignId('jurusan_id')->nullable()->constrained('jurusans')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Menghapus foreign key dan kolom jurusan_id jika migrasi di-rollback
            $table->dropForeign(['jurusan_id']);
            $table->dropColumn('jurusan_id');
        });
    }
}
