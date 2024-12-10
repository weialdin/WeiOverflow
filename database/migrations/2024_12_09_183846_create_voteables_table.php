<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('voteables', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('voteable_id');
            $table->string('voteable_type');
            $table->tinyInteger('vote')->comment('-1: down vote, 1: up vote');
            $table->unique(['user_id', 'voteable_id', 'voteable_type']);
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('voteables');
    }
};
