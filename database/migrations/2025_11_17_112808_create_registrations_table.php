<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id(); // Coluna de ID auto-incremental

            // --- Dados Gerais (Obrigatórios) ---
            $table->text('full_names'); // Nome(s) completo(s) do(s) autor(es)
            $table->string('academic_level'); // Doutor, Mestre, etc.
            $table->string('occupation'); // Estudante, Docente, etc.
            $table->string('institution'); // Instituição e país
            $table->string('country'); // Instituição e país
            $table->string('participant_type'); // Orador ou Ouvinte

            // --- Dados Condicionais (Apenas para Oradores, podem ser nulos) ---
            $table->string('presentation_modality')->nullable(); // Mesa-redonda, Poster, etc.
            $table->string('thematic_axis')->nullable(); // Eixo temático (Ciência, Território, etc.)
            $table->text('abstract_content')->nullable(); // O texto do resumo (250-300 palavras)
            $table->string('keywords')->nullable(); // As palavras-chave
            $table->string('abstract_filepath')->nullable(); // Caminho para o ficheiro MS Word submetido

            $table->timestamps(); // Colunas created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registrations');
    }
};