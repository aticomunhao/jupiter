<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewExterna extends Model
{
    protected $table = 'ati_v_contribuicoes'; // Nome da view no banco

    public $timestamps = false; // Normalmente views não têm timestamps

    protected $connection = 'sqlsrv'; // Usa a conexão secundária

}
