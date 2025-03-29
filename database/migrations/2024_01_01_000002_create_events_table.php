<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->date('start_date');
            $table->time('jam_mulai');
            $table->date('end_date')->nullable();
            $table->time('jam_selesai')->nullable();
            $table->enum('status', ['selesai', 'sedang berlangsung', 'dibatalkan', 'ditunda', 'belum mulai'])
                  ->default('belum mulai');
            $table->text('description')->nullable();
            $table->string('tempat')->nullable();
            $table->string('type')->nullable();
            $table->string('image')->nullable();
            $table->string('kategori')->nullable();
            $table->string('penyelenggara')->nullable();
            $table->unsignedBigInteger('visit_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
