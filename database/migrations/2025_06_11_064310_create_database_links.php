<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->string('link', 2048)->unique();
            $table->string('title')->nullable();
            $table->foreignId('postby')->constrained('users')->onDelete('cascade');
            $table->enum('catagory', [
                'marketplace',
                'chat room',
                'forums',
                'service',
                'search',
                'directory link',
                'youtube',
                'uploader',
                'news',
                'hosting',
                'other'
            ])->default('other');
            $table->boolean('is_online')->default(false); 
            $table->timestamp('last_checked_at')->nullable(); 
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('links');
    }
};
