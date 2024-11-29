<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    use HasFactory;

    // Campos permitidos para preenchimento em massa
    protected $fillable = [
        'nome',
        'password',
        'email',
        'contacto',
        'idade',
        'sexo',
        'bi',
        'data_nascimento',
        'data_expiracao',
        'tipo_trabalho',
        'cartao_credito',
        'NIB',
        'rua',
        'cidade',
        'codigo_postal',
        'pais',
        'condicao_saude',
        'medicamento',
        'historico_comportamento',
    ];

    // Método para criptografar automaticamente os campos sensíveis
    public function setAttribute($key, $value)
    {
        $encryptedFields = ['password','contacto','tipo_trabalho','data_expiracao', 'bi', 'cartao_credito', 'NIB', 'condicao_saude', 'medicamento', 'historico_comportamento'];

        if (in_array($key, $encryptedFields) && $value) {
            $this->attributes[$key] = encrypt($value);
        } else {
            $this->attributes[$key] = $value;
        }
    }

    // Método para descriptografar os campos sensíveis
    public function getAttribute($key)
    {
        $encryptedFields = ['password','contacto','tipo_trabalho','data_expiracao', 'bi', 'cartao_credito', 'NIB', 'condicao_saude', 'medicamento', 'historico_comportamento'];

        if (in_array($key, $encryptedFields) && isset($this->attributes[$key])) {
            return decrypt($this->attributes[$key]);
        }

        return $this->attributes[$key] ?? null;
    }
}

