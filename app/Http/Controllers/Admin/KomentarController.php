<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\FrontEndController;
use App\Http\Requests\KomentarProveraRequest;
use App\Models\Komentar;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Psy\Util\Json;

class KomentarController extends FrontEndController
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new Komentar();
        $this->middleware('korisnikNijePrijavljenProvera');
        $this->middleware('adminProvera', ['except' => ['store', 'destroy']]);
    }

    public function index()
    {
        try{
            $this->data['komentari'] = $this->model->dohvatiSve();
            return view('admin.komentar.index', $this->data);
        } catch (QueryException $e){
            Log::error("Greška pri dohvatanju svih komentara: " . $e->getMessage());
            return redirect(route('adminhomepage'));
        }
    }

    public function store(KomentarProveraRequest $request)
    {
        $this->model->komentar = $request->input('komentar');
        $this->model->korisnikID = $request->input('korisnikID');
        $this->model->objavaID = $request->input('objavaID');
        $this->model->komentar_created_at = time();

        try{
            $komentar = $this->model->dodajKomentar();

            try{
                $this->modelAktivnost->aktivnost = "Korisnik/Administrator je postavio komentar";
                $this->modelAktivnost->aktivnost_created_at = time();
                $aktivnost = $this->modelAktivnost->dodajAktivnost();
            } catch (QueryException $e){
                Log::error("Greška pri dodavanju aktivnosti: " . $e->getMessage());
            }

            return Json::encode("Uspešno ste dodali komentar!");

        } catch (QueryException $e){
            Log::error("Greška pri dodavanju komentara: " . $e->getMessage());
            return Json::encode("Greška pri dodavanju komentara, pokušajte kasnije");
        }
    }

    public function destroy($id)
    {
        $this->model->komentarID = $id;

        try{
            $komentar = $this->model->obrisiKomentar();

            try{
                $this->modelAktivnost->aktivnost = "Korisnik/Administrator je obrisao komentar";
                $this->modelAktivnost->aktivnost_created_at = time();
                $aktivnost = $this->modelAktivnost->dodajAktivnost();
            } catch (QueryException $e){
                Log::error("Greška pri dodavanju aktivnosti: " . $e->getMessage());
            }

            return response("Komentar uspešno obrisan!");
        } catch (QueryException $e){
            Log::error("Greška pri brisanju komentara: " . $e->getMessage());
            return response("Greška pri brisanju komentara, pokušajte kasnije");
        }
    }
}
