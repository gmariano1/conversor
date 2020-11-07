<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $table = 'cotacao';

    protected $fillable = [
        'moeda_conversora',
        'moeda_convertida',
        'valor_conversor',
        'valor_convertido',
        'users_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
