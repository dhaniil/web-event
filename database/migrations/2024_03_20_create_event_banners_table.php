<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('event_banners')) {
            Schema::create('event_banners', function (Blueprint $table) {
                $table->id();
                $table->string('image');
                $table->string('judul')->nullable();
                $table->text('deskripsi')->nullable();
                $table->boolean('is_active')->default(true);
                $table->integer('urutan')->default(0);
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('event_banners');
    }
}; 