<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\FrontEndController;
use App\Http\Requests\AddUserProveraRequest;
use App\Http\Requests\UpdateUserProveraRequest;
use App\Models\Korisnik;
use App\Models\Uloga;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class KorisnikController extends FrontEndController
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new Korisnik();
        $uloga = new Uloga();
        try{
            $this->data['uloge'] = $uloga->dohvatiSve();
            $this->data['korisnici'] = $this->model->dohvatiSve();
        } catch (QueryException $e){
            Log::error("Greška pri dohvatanju svih korisnika i uloga: " . $e->getMessage());
            return redirect(route('adminhomepage'));
        }
    }

    public function index()
    {
        return view('admin.korisnik.index', $this->data);
    }

    public function create()
    {

        return view('admin.korisnik.create', $this->data);
    }

    public function store(AddUserProveraRequest $request)
    {
        $this->model->ime = $request->input('regIme');
        $this->model->prezime = $request->input('regPrezime');
        $this->model->email = $request->input('regEmail');
        $this->model->korisnicko_ime = $request->input('regKorIme');
        $this->model->lozinka = $request->input('regLozinka');
        $this->model->token = md5(sha1($request->input('regEmail') . $request->input('regKorIme') . time()));
        $this->model->aktivan = $request->input('add_aktivan');
        $this->model->reset_password = md5(sha1($request->input('regIme') . $request->input('regEmail') . time() . rand()));
        $this->model->datum_registracije = time();
        $this->model->ulogaID = $request->input('add_uloga');

        $slika = $request->file('regSlika');
        $nazivSlike = time() . "_" . $slika->getClientOriginalName();

        $this->model->src = $nazivSlike;
        $this->model->alt = $request->input('regIme') . " " . $request->input('regPrezime');

        try{
            $korisnik = $this->model->dodajKorisnika();

            try{
                $slika->move(public_path() . '/images/profile/', $nazivSlike);

                try{
                    $this->modelAktivnost->aktivnost = "Administrator je dodao korisnika";
                    $this->modelAktivnost->aktivnost_created_at = time();
                    $aktivnost = $this->modelAktivnost->dodajAktivnost();
                } catch (QueryException $e){
                    Log::error("Greška pri dodavanju aktivnosti: " . $e->getMessage());
                }

                return back()->with("uspesnaPoruka", "Uspešno ste dodali korisnika!");

            } catch (FileException $e){
                Log::error("Greška pri prebacivanju slike: " . $e->getMessage());
                return back()->with("neuspesnaPoruka", "Korisnik je dodat, ali bez slike");
            }

        } catch (QueryException $e) {
            Log::error("Greška pri dodavanju korisnika: " . $e->getMessage());
            return back()->with("neuspesnaPoruka", "Greška pri dodavanju korisnika, pokušajte kasnije");
        }
    }

    public function edit($id)
    {
        $this->model->korisnikID = $id;
        try{
            $korisnik = $this->model->dohvatiJednog();
            $this->data['korisnik'] = $korisnik;
            return view('admin.korisnik.edit', $this->data);
        } catch (QueryException $e){
            Log::error("Greška pri dohvatanju jednog korisnika: " . $e->getMessage());
            return redirect(route('adminhomepage'));
        }
    }

    public function update(UpdateUserProveraRequest $request, $id)
    {
        $this->model->korisnikID = $id;
        $this->model->ime = $request->input('regIme');
        $this->model->prezime = $request->input('regPrezime');
        $this->model->email = $request->input('regEmail');
        $this->model->korisnicko_ime = $request->input('regKorIme');
        $this->model->aktivan = $request->input('add_aktivan');
        $this->model->ulogaID = $request->input('add_uloga');


        if($request->file('regSlika'))
        {
            try{
                $korisnikSlikaDelete = $this->model->dohvatiJednog();
                if($korisnikSlikaDelete){
                    try{
                        File::delete(public_path() . '/images/profile/' . $korisnikSlikaDelete->src);
                    } catch (FileException $e){
                        Log::error("Greška pri brisanju slike: " . $e->getMessage());
                        return back()->with("neuspesnaPoruka", "Došlo je do greške, pokušajte kasnije");
                    }
                } else{
                    return back()->with("neuspesnaPoruka", "Došlo je do greške, pokušajte kasnije");
                }
            } catch (QueryException $e){
                Log::error("Greška pri dohvatanju jednog korisnika: " . $e->getMessage());
                return back()->with("neuspesnaPoruka", "Došlo je do greške, pokušajte kasnije");
            }

            $slika = $request->file('regSlika');
            $nazivSlike = time() . "_" . $slika->getClientOriginalName();
            try{
                $slika->move(public_path() . '/images/profile/', $nazivSlike);
                $this->model->src = $nazivSlike;
            } catch (FileException $e){
                Log::error("Greška pri prebacivanju slike: " . $e->getMessage());
                return back()->with("neuspesnaPoruka", "Došlo je do greške, pokušajte kasnije");
            }
        }

        try{
            $korisnik = $this->model->izmeniKorisnika();

            try{
                $this->modelAktivnost->aktivnost = "Administrator je izmenio korisnika";
                $this->modelAktivnost->aktivnost_created_at = time();
                $aktivnost = $this->modelAktivnost->dodajAktivnost();
            } catch (QueryException $e){
                Log::error("Greška pri dodavanju aktivnosti: " . $e->getMessage());
            }

            return back()->with("uspesnaPoruka", "Uspešno ste izmenili korisnika!");

        } catch (QueryException $e){
            Log::error("Greška pri izmeni korisnika: " . $e->getMessage());
            return back()->with("neuspesnaPoruka", "Greška pri izmeni korisnika, pokušajte kasnije");
        }
    }

    public function destroy($id)
    {
        $this->model->korisnikID = $id;

        try{
            $korisnikSlikaDelete = $this->model->dohvatiJednog();
            if($korisnikSlikaDelete){
                try{
                    File::delete(public_path() . '/images/profile/' . $korisnikSlikaDelete->src);
                } catch (FileException $e){
                    Log::error("Greška pri brisanju slike: " . $e->getMessage());
                    return response("Došlo je do greške, pokušajte kasnije");
                }
            } else{
                return response("Došlo je do greške, pokušajte kasnije");
            }
        } catch (QueryException $e){
            Log::error("Greška pri dohvatanju jednog korisnika: " . $e->getMessage());
            return response("Došlo je do greške, pokušajte kasnije");
        }

        try{
            $korisnik = $this->model->obrisiKorisnika();

            try{
                $this->modelAktivnost->aktivnost = "Administrator je obrisao korisnika";
                $this->modelAktivnost->aktivnost_created_at = time();
                $aktivnost = $this->modelAktivnost->dodajAktivnost();
            } catch (QueryException $e){
                Log::error("Greška pri dodavanju aktivnosti: " . $e->getMessage());
            }

            return response("Korisnik uspešno obrisan!");

        } catch (QueryException $e){
            Log::error("Greška pri brisanju korisnika: " . $e->getMessage());
            return response("Greška pri brisanju korisnika, pokušajte kasnije");
        }
    }

}