<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact_pages', function (Blueprint $table) {
            $table->id();
            $table->string('heading')->nullable();
            $table->longText('intro_text')->nullable();
            $table->unsignedBigInteger('contact_form_id')->nullable();
            $table->string('map_embed_url')->nullable();
            $table->text('office_address')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_pages');
    }
};
