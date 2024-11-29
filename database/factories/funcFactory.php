<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Funcionario;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Funcionario>
 */
class funcFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Funcionario::class;

    public function definition():array
    {
        return [
            'nome' => $this->faker->name(),
            'password'=> $this->faker->word(),
            'email'=> $this->faker->email(),
            'contacto' => $this->faker->phoneNumber(),
            'idade' => $this->faker->numberBetween(18, 100),
            'sexo' => $this->faker->randomElement(['Masculino', 'Feminino']),
            'bi'=> $this->faker->word(),
            'nib'=> $this->faker->word(),
            'data_nascimento'=> $this->faker->date(),
            'data_expiracao'=> $this->faker->date(),
            'tipo_trabalho'=> $this->faker->word(),
            'cartao_credito'=> $this->faker->word(),
            'rua'=> $this->faker->word(),
            'cidade'=> $this->faker->word(),
            'pais'=> $this->faker->word(),
            'codigo_postal'=> $this->faker->word(),
            'condicao_saude'=> $this->faker->word(),
            'medicamento'=> $this->faker->word(),
            'historico_comportamento'=> $this->faker->word(),
        ];
    }
}
