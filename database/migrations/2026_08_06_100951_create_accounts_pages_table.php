<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accounts_pages', function (Blueprint $table) {
            $table->id();
            $table->string('heading')->nullable();
            $table->longText('intro_text')->nullable();
            $table->json('benefits')->nullable();
            $table->longText('terms_text')->nullable();
            $table->unsignedBigInteger('new_account_form_id')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accounts_pages');
    }
};
