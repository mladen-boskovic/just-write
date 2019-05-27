<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Lajk extends Model
{
    protected $table = "lajk";
    protected $primaryKey = "lajkID";

    public function lajkProvera()
    {
        return DB::table($this->table)->where([
            ['korisnikID', $this->korisnikID],
            ['objavaID', $this->objavaID]
        ])->first();
    }

    public function dodajLajk()
    {
        return DB::table($this->table)->insert([
            "lajkID" => null,
            "korisnikID" => $this->korisnikID,
            "objavaID" => $this->objavaID
        ]);
    }

    public function obrisiLajk()
    {
        return DB::table($this->table)->where([
            ['korisnikID', $this->korisnikID],
            ['objavaID', $this->objavaID]
        ])->delete();
    }

    public function brojLajkovaObjave()
    {
        return DB::table($this->table)->where('objavaID', $this->objavaID)->count();
    }
}
