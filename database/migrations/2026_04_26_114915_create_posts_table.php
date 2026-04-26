<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('content');
            $table->integer('risk_score')->nullable();
            $table->string('risk_level')->nullable();
            $table->timestamps();
            $table->index('user_id');
            $table->index('created_at');
            $table->index('risk_level');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};