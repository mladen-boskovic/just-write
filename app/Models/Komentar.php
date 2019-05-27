<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Komentar extends Model
{
    protected $table = "komentar";
    protected $primaryKey = "komentarID";

    public function dohvatiSve()
    {
        return DB::table($this->table)
            ->join('korisnik', $this->table . '.korisnikID', '=', 'korisnik.korisnikID')
            ->join('objava', $this->table . '.objavaID', '=', 'objava.objavaID')
            ->paginate(10);
    }

    public function obrisiKomentar()
    {
        return DB::table($this->table)->where('komentarID', $this->komentarID)->delete();
    }

    public function dohvatiKomentareObjave()
    {
        return DB::table($this->table)
            ->join('korisnik', $this->table . '.korisnikID', '=', 'korisnik.korisnikID')
            ->join('objava', $this->table . '.objavaID', '=', 'objava.objavaID')
            ->where($this->table . '.objavaID', $this->objavaID)
            ->select('komentar.komentar', 'komentar.komentarID', 'komentar.komentar_created_at',
                'korisnik.korisnicko_ime', 'korisnik.src', 'korisnik.alt', 'korisnik.korisnikID')
            ->orderBy('komentar.komentar_created_at', 'asc')
            ->get();
    }

    public function dohvatiBrojKomentaraObjave()
    {
        return DB::table($this->table)->where('objavaID', $this->objavaID)->count();
    }

    public function dodajKomentar()
    {
        return DB::table($this->table)->insert([
            "komentarID" => null,
            "komentar" => $this->komentar,
            "korisnikID" => $this->korisnikID,
            "objavaID" => $this->objavaID,
            "komentar_created_at" => $this->komentar_created_at
        ]);
    }
}
