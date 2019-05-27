<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Korisnik extends Model
{
    protected $table = "korisnik";
    protected $primaryKey = "korisnikID";

    public function registracija()
    {
        $this->ulogaID = DB::table('uloga')->where('uloga', 'Korisnik')->first()->ulogaID;

        return DB::table($this->table)->insert([
            "korisnikID" => null,
            "ime" => $this->ime,
            "prezime" => $this->prezime,
            "email" => $this->email,
            "korisnicko_ime" => $this->korisnicko_ime,
            "lozinka" => md5(sha1($this->lozinka)),
            "token" => $this->token,
            "aktivan" => $this->aktivan,
            "reset_password" => $this->reset_password,
            "ulogaID" => $this->ulogaID,
            "datum_registracije" => $this->datum_registracije,
            "src" => $this->src,
            "alt" => $this->alt
        ]);
    }

    public function prijava()
    {
        return DB::table($this->table)->join('uloga', $this->table . '.ulogaID', '=', 'uloga.ulogaID')
            ->where([
                ["korisnicko_ime", $this->korisnicko_ime],
                ["lozinka", md5(sha1($this->lozinka))],
                ["aktivan", $this->aktivan]
            ])->first();
    }

    public function activateProvera()
    {
        return DB::table($this->table)->where('token', $this->token)->first();
    }

    public function activate()
    {
        return DB::table($this->table)->where('token', $this->token)->update(['aktivan' => 1]);
    }

    public function resetLozinkeEmailUspesnaProvera()
    {
        return DB::table($this->table)->where('email', $this->email)->update(['reset_password' => $this->reset_password]);
    }

    public function resetLozinkeTokenProvera()
    {
        return DB::table($this->table)->where('reset_password', $this->reset_password)->first();
    }

    public function resetPassword()
    {
        return DB::table($this->table)->where('reset_password', $this->token)
            ->update([
                'lozinka' => md5(sha1($this->lozinka)),
                'reset_password' => $this->reset_password
            ]);
    }

    public function promenaProfilneSlike()
    {
        return DB::table($this->table)->where('korisnikID', $this->korisnikID)->update(['src' => $this->src]);
    }

    public function promenaLozinkeProvera()
    {
        return DB::table($this->table)->where([
            ['korisnikID', $this->korisnikID],
            ['lozinka', md5(sha1($this->lozinka))]
        ])->first();
    }

    public function promenaLozinke()
    {
        return DB::table($this->table)->where('korisnikID', $this->korisnikID)->update(['lozinka' => md5(sha1($this->lozinka))]);
    }

    public function dodajKorisnika()
    {
        return DB::table($this->table)->insert([
            "korisnikID" => null,
            "ime" => $this->ime,
            "prezime" => $this->prezime,
            "email" => $this->email,
            "korisnicko_ime" => $this->korisnicko_ime,
            "lozinka" => md5(sha1($this->lozinka)),
            "token" => $this->token,
            "aktivan" => $this->aktivan,
            "reset_password" => $this->reset_password,
            "ulogaID" => $this->ulogaID,
            "datum_registracije" => $this->datum_registracije,
            "src" => $this->src,
            "alt" => $this->alt
        ]);
    }

    public function dohvatiJednog()
    {
        return DB::table($this->table)->join('uloga', $this->table . '.ulogaID', '=', 'uloga.ulogaID')
            ->where('korisnikID', $this->korisnikID)->first();
    }

    public function izmeniKorisnika()
    {
        if(!$this->src)
            $this->src = DB::table($this->table)->where('korisnikID', $this->korisnikID)->first()->src;
        return DB::table($this->table)->where('korisnikID', $this->korisnikID)->update([
            "ime" => $this->ime,
            "prezime" => $this->prezime,
            "email" => $this->email,
            "korisnicko_ime" => $this->korisnicko_ime,
            "aktivan" => $this->aktivan,
            "ulogaID" => $this->ulogaID,
            "src" => $this->src
        ]);
    }

    public function dohvatiSve()
    {
        return DB::table($this->table)->join('uloga', $this->table . '.ulogaID', '=', 'uloga.ulogaID')->paginate(10);
    }

    public function obrisiKorisnika()
    {
        return DB::table($this->table)->where('korisnikID', $this->korisnikID)->delete();
    }

}
