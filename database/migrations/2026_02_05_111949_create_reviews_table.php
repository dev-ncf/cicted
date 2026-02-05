<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
   Schema::create('reviews', function (Blueprint $table) {
        $table->id();

        $table->foreignId('registration_id')
              ->constrained('submissions')
              ->cascadeOnDelete();

        $table->boolean('structure_ok')->default(false);
        $table->boolean('content_ok')->default(false);

        $table->integer('score_intro')->default(0);
        $table->integer('score_objectives')->default(0);
        $table->integer('score_methodology')->default(0);
        $table->integer('score_results')->default(0);
        $table->integer('score_conclusions')->default(0);
        $table->integer('score_keywords')->default(0);
        $table->integer('score_style')->default(0);

        $table->integer('score_total')->default(0); // ✅ TOTAL

        $table->text('feedback')->nullable();

        $table->enum('recommendation_type', ['Oral', 'Poster'])->nullable();
        $table->enum('status', ['aceite', 'rejeitado', 'aceite_com_correcoes'])->default('aceite_com_correcoes');

        $table->string('reviewer_file')->nullable(); // caminho do ficheiro

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
