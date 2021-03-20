<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'client';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'email',
        'credit_card',
        'cep'
    ];
}