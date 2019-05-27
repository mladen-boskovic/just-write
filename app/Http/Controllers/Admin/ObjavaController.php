<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\FrontEndController;
use App\Http\Requests\AddObjavaProveraRequest;
use App\Http\Requests\UpdateObjavaProveraRequest;
use App\Models\Kategorija;
use App\Models\Objava;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ObjavaController extends FrontEndController
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new Objava();
        $kategorija = new Kategorija();
        try{
            $this->data['kategorije'] = $kategorija->dohvatiSve();
            $this->data['objave'] = $this->model->dohvatiSve();
        } catch (QueryException $e){
            Log::error("Greška pri dohvatanju svih objava i kategorija: " . $e->getMessage());
            return redirect(route('adminhomepage'));
        }
        $this->middleware('korisnikNijePrijavljenProvera');
        $this->middleware('adminProvera', ['except' => ['store','update', 'destroy']]);
    }

    public function index()
    {
        return view('admin.objava.index', $this->data);
    }

    public function create()
    {
        return view('admin.objava.create', $this->data);
    }

    public function store(AddObjavaProveraRequest $request)
    {
        $this->model->korisnikID = $request->input('addObjavaKorisnikID');
        $this->model->naslov = $request->input('addObjavaNaslov');
        $this->model->tekst = $request->input('addObjavaTekst');
        $this->model->kategorijaID = $request->input('addObjavaKategorija');
        $this->model->objava_created_at = time();
        $this->model->objava_updated_at = time();

        $slika = $request->file('addObjavaSlika');
        $nazivSlike = time() . "_" . $slika->getClientOriginalName();

        $this->model->src = $nazivSlike;
        $this->model->alt = $request->input('addObjavaNaslov');

        try{
            $objava = $this->model->dodajObjavu();

            try{
                $slika->move(public_path() . '/images/objave/', $nazivSlike);

                try{
                    $this->modelAktivnost->aktivnost = "Korisnik/Administrator je dodao objavu";
                    $this->modelAktivnost->aktivnost_created_at = time();
                    $aktivnost = $this->modelAktivnost->dodajAktivnost();
                } catch (QueryException $e){
                    Log::error("Greška pri dodavanju aktivnosti: " . $e->getMessage());
                }

                return back()->with("uspesnaPoruka", "Uspešno ste dodali objavu!");
            } catch (FileException $e){
                Log::error("Greška pri prebacivanju slike: " . $e->getMessage());
                return back()->with("neuspesnaPoruka", "Objava je dodata, ali bez slike");
            }
        }catch (QueryException $e) {
            Log::error("Greška pri dodavanju objave: " . $e->getMessage());
            return back()->with("neuspesnaPoruka", "Greška pri dodavanju objave, pokušajte kasnije");
        }
    }

    public function edit($id)
    {
        $this->model->objavaID = $id;
        try{
            $objava = $this->model->dohvatiJednu();
            $this->data['objava'] = $objava;
            return view('admin.objava.edit', $this->data);
        } catch (QueryException $e){
            Log::error("Greška pri dohvatanju jedne objave: " . $e->getMessage());
            return redirect(route('adminhomepage'));
        }
    }

    public function update(UpdateObjavaProveraRequest $request, $id)
    {
        $this->model->objavaID = $id;
        $this->model->naslov = $request->input('addObjavaNaslov');
        $this->model->tekst = $request->input('addObjavaTekst');
        $this->model->kategorijaID = $request->input('addObjavaKategorija');
        $this->model->objava_updated_at = time();

        if($request->file('addObjavaSlika'))
        {
            try{
                $objavaSlikaDelete = $this->model->dohvatiJednu();
                if($objavaSlikaDelete){
                    try{
                        File::delete(public_path() . '/images/objave/' . $objavaSlikaDelete->src);
                    } catch (FileException $e){
                        Log::error("Greška pri brisanju slike: " . $e->getMessage());
                        return back()->with("neuspesnaPoruka", "Došlo je do greške, pokušajte kasnije");
                    }
                } else{
                    return back()->with("neuspesnaPoruka", "Došlo je do greške, pokušajte kasnije");
                }
            } catch (QueryException $e){
                Log::error("Greška pri dohvatanju jedne objave: " . $e->getMessage());
                return back()->with("neuspesnaPoruka", "Došlo je do greške, pokušajte kasnije");
            }

            $slika = $request->file('addObjavaSlika');
            $nazivSlike = time() . "_" . $slika->getClientOriginalName();
            try{
                $slika->move(public_path() . '/images/objave/', $nazivSlike);
                $this->model->src = $nazivSlike;
            } catch (FileException $e){
                Log::error("Greška pri prebacivanju slike: " . $e->getMessage());
                return back()->with("neuspesnaPoruka", "Došlo je do greške, pokušajte kasnije");
            }
        }

        try{
            $objava = $this->model->izmeniObjavu();

            try{
                $this->modelAktivnost->aktivnost = "Korisnik/Administrator je izmenio objavu";
                $this->modelAktivnost->aktivnost_created_at = time();
                $aktivnost = $this->modelAktivnost->dodajAktivnost();
            } catch (QueryException $e){
                Log::error("Greška pri dodavanju aktivnosti: " . $e->getMessage());
            }

            return back()->with("uspesnaPoruka", "Uspešno ste izmenili objavu!");

        } catch (QueryException $e){
            Log::error("Greška pri izmeni objave: " . $e->getMessage());
            return back()->with("neuspesnaPoruka", "Greška pri izmeni objave, pokušajte kasnije");
        }
    }

    public function destroy($id)
    {
        $this->model->objavaID = $id;

        try{
            $objavaSlikaDelete = $this->model->dohvatiJednu();
            if($objavaSlikaDelete){
                try{
                    File::delete(public_path() . '/images/objave/' . $objavaSlikaDelete->src);
                } catch (FileException $e){
                    Log::error("Greška pri brisanju slike: " . $e->getMessage());
                    return response("Došlo je do greške, pokušajte kasnije");
                }
            } else{
                return response("Došlo je do greške, pokušajte kasnije");
            }
        } catch (QueryException $e){
            Log::error("Greška pri dohvatanju jedne objave: " . $e->getMessage());
            return response("Došlo je do greške, pokušajte kasnije");
        }

        try{
            $objava = $this->model->obrisiObjavu();

            try{
                $this->modelAktivnost->aktivnost = "Korisnik/Administrator je obrisao objavu";
                $this->modelAktivnost->aktivnost_created_at = time();
                $aktivnost = $this->modelAktivnost->dodajAktivnost();
            } catch (QueryException $e){
                Log::error("Greška pri dodavanju aktivnosti: " . $e->getMessage());
            }

            return response("Objava uspešno obrisana!");
        } catch (QueryException $e){
            Log::error("Greška pri brisanju objave: " . $e->getMessage());
            return response("Greška pri brisanju objave, pokušajte kasnije");
        }
    }
}
