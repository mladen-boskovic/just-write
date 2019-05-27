<?php

namespace App\Http\Controllers;

use App\Http\Requests\PromenaProfilneSlikeProveraRequest;
use App\Models\Korisnik;
use App\Models\Lajk;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Psy\Util\Json;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class UserChangesController extends FrontEndController
{
    private $modelKorisnik;
    private $modelLajk;

    public function __construct()
    {
        parent::__construct();
        $this->modelKorisnik = new Korisnik();
        $this->modelLajk = new Lajk();
    }

    public function promenaProfilneSlike(PromenaProfilneSlikeProveraRequest $request)
    {
        $this->modelKorisnik->korisnikID = $request->input('promenaProfilneSlikeKorisnik');

        try{
            $korisnikSlikaDelete = $this->modelKorisnik->dohvatiJednog();
            if($korisnikSlikaDelete){
                try{
                    File::delete(public_path() . '/images/profile/' . $korisnikSlikaDelete->src);
                } catch (FileException $e){
                    Log::error("Greška pri brisanju slike: " . $e->getMessage());
                    return back()->with("promenaSlikeNeuspesno", "Došlo je do greške, pokušajte kasnije");
                }
            } else{
                return back()->with("promenaSlikeNeuspesno", "Došlo je do greške, pokušajte kasnije");
            }
        } catch (QueryException $e){
            Log::error("Greška pri dohvatanju jednog korisnika: " . $e->getMessage());
            return back()->with("promenaSlikeNeuspesno", "Došlo je do greške, pokušajte kasnije");
        }

        $slika = $request->file('profilnaSlika');
        $nazivSlike = time() . "_" . $slika->getClientOriginalName();

        $this->modelKorisnik->src = $nazivSlike;

        try{
            $korisnik = $this->modelKorisnik->promenaProfilneSlike();
            $request->session()->get('korisnik')->src = $nazivSlike;

            try{
                $slika->move(public_path() . '/images/profile/', $nazivSlike);

                try{
                    $this->modelAktivnost->aktivnost = "Korisnik je promenio sliku";
                    $this->modelAktivnost->aktivnost_created_at = time();
                    $aktivnost = $this->modelAktivnost->dodajAktivnost();
                } catch (QueryException $e){
                    Log::error("Greška pri dodavanju aktivnosti: " . $e->getMessage());
                }

                return back()->with("promenaSlikeUspesno", "Uspešno ste promenili sliku!");
            } catch (FileException $e){
                Log::error("Greška pri prebacivanju slike: " . $e->getMessage());
                return back()->with("promenaSlikeNeuspesno", "Došlo je do greške, pokušajte kasnije");
            }

        } catch (QueryException $e){
            Log::error("Greška pri promeni profilne slike: " . $e->getMessage());
            return back()->with("promenaSlikeNeuspesno", "Greška pri promeni slike, pokušajte kasnije");
        }
    }

    public function lajkovanje(Request $request)
    {
        $this->modelLajk->korisnikID = $request->input('korisnikID');
        $this->modelLajk->objavaID = $request->input('objavaID');

        try{
            $korisnikLajkovao = $this->modelLajk->lajkProvera();
            if($korisnikLajkovao){
                try{
                    $korisnikObrisiLajk = $this->modelLajk->obrisiLajk();

                    try{
                        $this->modelAktivnost->aktivnost = "Korisnik/Administrator je uklonio lajk";
                        $this->modelAktivnost->aktivnost_created_at = time();
                        $aktivnost = $this->modelAktivnost->dodajAktivnost();
                    } catch (QueryException $e){
                        Log::error("Greška pri dodavanju aktivnosti: " . $e->getMessage());
                    }

                    return Json::encode('');

                } catch (QueryException $e){
                    Log::error("Greška pri brisanju lajka: " . $e->getMessage());
                    return Json::encode('Došlo je do greške, pokušajte kasnije');
                }
            } else{
                try{
                    $korisnikDodajLajk = $this->modelLajk->dodajLajk();

                    try{
                        $this->modelAktivnost->aktivnost = "Korisnik/Administrator je lajkovao objavu";
                        $this->modelAktivnost->aktivnost_created_at = time();
                        $aktivnost = $this->modelAktivnost->dodajAktivnost();
                    } catch (QueryException $e){
                        Log::error("Greška pri dodavanju aktivnosti: " . $e->getMessage());
                    }

                    return Json::encode('');

                } catch (QueryException $e){
                    Log::error("Greška pri dodavanju lajka: " . $e->getMessage());
                    return Json::encode('Greška pri lajkovanju, pokušajte kasnije');
                }
            }
        } catch (QueryException $e){
            Log::error("Greška pri proveri da li je korisnik lajkovao objavu: " . $e->getMessage());
            return Json::encode('Došlo je do greške, pokušajte kasnije');
        }
    }
}
