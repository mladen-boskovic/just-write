<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Aktivnost extends Model
{
    protected $table = "aktivnost";
    protected $primaryKey = "aktivnostID";

    public function dohvatiSve($sort)
    {
        return DB::table($this->table)->orderBy('aktivnost_created_at', $sort)->paginate(10);
    }

    public function dodajAktivnost()
    {
        return DB::table($this->table)->insert([
            "aktivnostID" => null,
            "aktivnost" => $this->aktivnost,
            "aktivnost_created_at" => $this->aktivnost_created_at
        ]);
    }
}
