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
        Schema::create('funcionarios', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('data_expiracao')->nullable(); // Criptografado
            $table->string('bi')->unique()->nullable(); // Criptografado
            $table->date('data_nascimento')->nullable();
            $table->string('tipo_trabalho')->nullable();
            $table->text('cartao_credito')->nullable(); // Criptografado
            $table->string('NIB')->nullable();         // Criptografado
            $table->string('rua')->nullable();
            $table->string('cidade')->nullable();
            $table->string('codigo_postal')->nullable();
            $table->string('pais')->default('Moçambique');
            $table->string('condicao_saude')->nullable(); // Criptografado
            $table->string('medicamento')->nullable(); // Criptografado
            $table->text('historico_comportamento')->nullable(); // Criptografado
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('funcionarios');
    }
};
