<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->default('Sadlers Taxis');
            $table->string('tagline')->nullable();
            $table->string('logo_path')->nullable();
            $table->boolean('show_warning_banner')->default(true);
            $table->text('warning_banner')->nullable();
            $table->string('primary_phone')->nullable();
            $table->string('email')->nullable();
            $table->json('phone_areas')->nullable();
            $table->string('book_online_url')->nullable();
            $table->string('account_booking_url')->nullable();
            $table->string('ios_app_url')->nullable();
            $table->string('android_app_url')->nullable();
            $table->string('footer_copyright_name')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
