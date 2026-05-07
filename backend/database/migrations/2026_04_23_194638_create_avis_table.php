<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('avis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('avisable_type');
            $table->unsignedBigInteger('avisable_id');
            $table->integer('note');
            $table->text('commentaire')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'avisable_type', 'avisable_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('avis');
    }
};
