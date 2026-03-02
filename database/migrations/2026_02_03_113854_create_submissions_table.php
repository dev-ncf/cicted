<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('abstract');

            $table->foreignId('author_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('thematic_area_id')
                ->constrained('thematic_areas')
                ->cascadeOnDelete();

            $table->enum('status', [
                'em_avaliacao',
                'aceite_com_correcoes',
                'aceite',
                'devolvido'
            ])->default('em_avaliacao');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
