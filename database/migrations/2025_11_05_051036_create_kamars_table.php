<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
       Schema::create('kamars', function (Blueprint $table) {
            $table->id();

            $table->foreignId('kos_id')->constrained('kos')->onDelete('cascade');

            $table->string('nomor');

            $table->foreignId('room_type_id')->nullable()
                ->constrained('room_types')
                ->nullOnDelete(); // sama dengan onDelete('set null')

            $table->string('kelas')->nullable();
            $table->string('nama_kamar')->nullable();
            $table->decimal('harga', 10, 2)->nullable();
            $table->text('deskripsi')->nullable();

            $table->enum('status', ['kosong', 'terisi'])->default('kosong');

            $table->foreignId('penghuni_id')->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('kamars');
    }
};