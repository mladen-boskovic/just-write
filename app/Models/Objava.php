<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Objava extends Model
{
    protected $table = "objava";
    protected $primaryKey = "objavaID";

    public function dodajObjavu()
    {
        return DB::table($this->table)->insert([
            "objavaID" => null,
            "naslov" => $this->naslov,
            "tekst" => $this->tekst,
            "objava_created_at" => $this->objava_created_at,
            "objava_updated_at" => $this->objava_updated_at,
            "korisnikID" => $this->korisnikID,
            "kategorijaID" => $this->kategorijaID,
            "src" => $this->src,
            "alt" => $this->alt
        ]);
    }

    public function dohvatiJednu()
    {
        return DB::table($this->table)
            ->join('korisnik', $this->table . '.korisnikID', '=', 'korisnik.korisnikID')
            ->join('kategorija', $this->table . '.kategorijaID', '=', 'kategorija.kategorijaID')
            ->select('objava.objavaID', 'objava.naslov', 'objava.tekst', 'objava.objava_created_at', 'objava.objava_updated_at',
                'objava.src', 'objava.alt', 'objava.kategorijaID', 'objava.korisnikID', 'korisnik.korisnicko_ime', 'kategorija.kategorija')
            ->where('objavaID', $this->objavaID)->first();
    }

    public function izmeniObjavu()
    {
        if(!$this->src)
            $this->src = DB::table($this->table)->where('objavaID', $this->objavaID)->first()->src;
        return DB::table($this->table)->where('objavaID', $this->objavaID)->update([
            "naslov" => $this->naslov,
            "tekst" => $this->tekst,
            "objava_updated_at" => $this->objava_updated_at,
            "kategorijaID" => $this->kategorijaID,
            "src" => $this->src
        ]);
    }

    public function dohvatiSve()
    {
        return DB::table($this->table)
            ->join('korisnik', $this->table . '.korisnikID', '=', 'korisnik.korisnikID')
            ->join('kategorija', $this->table . '.kategorijaID', '=', 'kategorija.kategorijaID')
            ->select('objava.objavaID', 'objava.naslov', 'objava.tekst', 'objava.objava_created_at', 'objava.objava_updated_at',
                'objava.src', 'objava.alt', 'objava.korisnikID', 'korisnik.korisnicko_ime', 'kategorija.kategorija')->paginate(10);
    }

    public function obrisiObjavu()
    {
        return DB::table($this->table)->where('objavaID', $this->objavaID)->delete();
    }

    public function dohvatiObjaveKorisnika()
    {
        return DB::table($this->table)
            ->join('korisnik', $this->table . '.korisnikID', '=', 'korisnik.korisnikID')
            ->join('kategorija', $this->table . '.kategorijaID', '=', 'kategorija.kategorijaID')
            ->select('objava.objavaID', 'objava.naslov', 'objava.tekst', 'objava.objava_created_at', 'objava.objava_updated_at',
                'objava.src', 'objava.alt', 'kategorija.kategorija')->where('objava.korisnikID', $this->korisnikID)->paginate(5);
    }

    public function dohvatiZadnjuObjavu()
    {
        return DB::table($this->table)
            ->join('korisnik', $this->table . '.korisnikID', '=', 'korisnik.korisnikID')
            ->join('kategorija', $this->table . '.kategorijaID', '=', 'kategorija.kategorijaID')
            ->select('objava.objavaID', 'objava.naslov', 'objava.tekst', 'objava.objava_created_at', 'objava.objava_updated_at',
                'objava.src', 'objava.alt', 'objava.kategorijaID', 'objava.korisnikID', 'korisnik.korisnicko_ime', 'kategorija.kategorija')
            ->orderBy('objava_created_at', 'desc')->first();
    }

    public function dohvatiSveObjavePage($unos, $kategorije, $sortiranje)
    {
        $upit =  DB::table($this->table)
            ->join('korisnik', $this->table . '.korisnikID', '=', 'korisnik.korisnikID')
            ->join('kategorija', $this->table . '.kategorijaID', '=', 'kategorija.kategorijaID')
            ->select('objava.objavaID', 'objava.naslov', 'objava.tekst', 'objava.objava_created_at', 'objava.objava_updated_at',
                'objava.src', 'objava.alt', 'objava.korisnikID', 'korisnik.korisnicko_ime', 'kategorija.kategorija');

        if(count($kategorije))
            $upit = $upit->whereIn('kategorija.kategorijaID', $kategorije);

        if($unos)
            $upit = $upit->where('objava.naslov', 'like', '%'. $unos .'%');

        if($sortiranje != 0)
        {
            if($sortiranje == 1)
                $upit = $upit->orderBy('objava.objava_created_at', 'desc');
            if($sortiranje == 2)
                $upit = $upit->orderBy('objava.objava_created_at', 'asc');
            if($sortiranje == 3)
                $upit = $upit->orderBy('objava.naslov', 'asc');
            if($sortiranje == 4)
                $upit = $upit->orderBy('objava.naslov', 'desc');
        }

        return $upit->get();
    }

    public function dohvatiNajpopularnijeObjave()
    {
        return DB::select('SELECT COUNT(l.objavaID) as broj_lajkova, o.objavaID, o.naslov, o.tekst, o.objava_created_at, o.src, o.alt, o.kategorijaID, o.korisnikID, k.korisnicko_ime, kat.kategorija
                            FROM objava o INNER JOIN korisnik k ON o.korisnikID=k.korisnikID
                            INNER JOIN kategorija kat on o.kategorijaID=kat.kategorijaID
                            INNER JOIN lajk l ON o.objavaID=l.objavaID
                            GROUP BY l.objavaID, o.objavaID, o.naslov, o.tekst, o.objava_created_at, o.src, o.alt, o.kategorijaID, o.korisnikID, k.korisnicko_ime, kat.kategorija
                            ORDER BY broj_lajkova DESC LIMIT 0,4');
    }





}
