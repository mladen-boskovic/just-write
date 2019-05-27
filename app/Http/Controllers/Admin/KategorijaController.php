<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\FrontEndController;
use App\Http\Requests\KategorijaProveraRequest;
use App\Models\Kategorija;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class KategorijaController extends FrontEndController
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new Kategorija();
    }

    public function index()
    {
        try{
            $this->data['kategorije'] = $this->model->dohvatiSve();
            return view('admin.kategorija.index', $this->data);
        } catch (QueryException $e){
            Log::error("Greška pri dohvatanju svih kategorija: " . $e->getMessage());
            return redirect(route('adminhomepage'));
        }
    }

    public function create()
    {
        return view('admin.kategorija.create', $this->data);
    }

    public function store(KategorijaProveraRequest $request)
    {
        $this->model->kategorija = $request->input('addKategorija');
        try{
            $kategorija = $this->model->dodajKategoriju();

            try{
                $this->modelAktivnost->aktivnost = "Administrator je dodao kategoriju";
                $this->modelAktivnost->aktivnost_created_at = time();
                $aktivnost = $this->modelAktivnost->dodajAktivnost();
            } catch (QueryException $e){
                Log::error("Greška pri dodavanju aktivnosti: " . $e->getMessage());
            }

            return back()->with("uspesnaPoruka", "Uspešno ste dodali kategoriju!");
        }catch (QueryException $e) {
            Log::error("Greška pri dodavanju kategorije: " . $e->getMessage());
            return back()->with("neuspesnaPoruka", "Greška pri dodavanju kategorije, pokušajte kasnije");
        }
    }

    public function edit($id)
    {
        $this->model->kategorijaID = $id;
        try{
            $this->data['kategorija'] = $this->model->dohvatiJednu();
            return view('admin.kategorija.edit', $this->data);
        } catch (QueryException $e){
            Log::error("Greška pri dohvatanju jedne kategorije: " . $e->getMessage());
            return redirect(route('adminhomepage'));
        }
    }

    public function update(KategorijaProveraRequest $request, $id)
    {
        $this->model->kategorijaID = $id;
        $this->model->kategorija = $request->input('addKategorija');

        try{
            $kategorija = $this->model->izmeniKategoriju();

            try{
                $this->modelAktivnost->aktivnost = "Administrator je izmenio kategoriju";
                $this->modelAktivnost->aktivnost_created_at = time();
                $aktivnost = $this->modelAktivnost->dodajAktivnost();
            } catch (QueryException $e){
                Log::error("Greška pri dodavanju aktivnosti: " . $e->getMessage());
            }

            return back()->with("uspesnaPoruka", "Uspešno ste izmenili kategoriju!");
        } catch (QueryException $e){
            Log::error("Greška pri izmeni kategorije: " . $e->getMessage());
            return back()->with("neuspesnaPoruka", "Greška pri izmeni kategorije, pokušajte kasnije");
        }
    }

    public function destroy($id)
    {
        $this->model->kategorijaID = $id;

        try{
            $kategorija = $this->model->obrisiKategoriju();

            try{
                $this->modelAktivnost->aktivnost = "Administrator je obrisao kategoriju";
                $this->modelAktivnost->aktivnost_created_at = time();
                $aktivnost = $this->modelAktivnost->dodajAktivnost();
            } catch (QueryException $e){
                Log::error("Greška pri dodavanju aktivnosti: " . $e->getMessage());
            }

            return response("Kategorija uspešno obrisana!");
        } catch (QueryException $e){
            Log::error("Greška pri brisanju kategorije: " . $e->getMessage());
            return response("Greška pri brisanju kategorije, pokušajte kasnije");
        }
    }
}
