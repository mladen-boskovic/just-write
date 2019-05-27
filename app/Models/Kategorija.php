<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Kategorija extends Model
{
    protected $table = "kategorija";
    protected $primaryKey = "kategorijaID";

    public function dohvatiSve()
    {
        return DB::table($this->table)->get();
    }

    public function dodajKategoriju()
    {
        return DB::table($this->table)->insert([
           "kategorijaID" => null,
           "kategorija" => $this->kategorija
        ]);
    }

    public function izmeniKategoriju()
    {
        return DB::table($this->table)->where('kategorijaID', $this->kategorijaID)
            ->update([
               'kategorija' => $this->kategorija
            ]);
    }

    public function dohvatiJednu()
    {
        return DB::table($this->table)->where('kategorijaID', $this->kategorijaID)->first();
    }

    public function obrisiKategoriju()
    {
        return DB::table($this->table)->where('kategorijaID', $this->kategorijaID)->delete();
    }
}
