<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Uloga extends Model
{
    protected $table = "uloga";
    protected $primaryKey = "ulogaID";

    public function dohvatiSve()
    {
        return DB::table($this->table)->get();
    }
}
