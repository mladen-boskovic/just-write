<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactProveraRequest;
use App\Models\Aktivnost;
use App\Models\Kategorija;
use App\Models\Komentar;
use App\Models\Lajk;
use App\Models\Meni;
use App\Models\Objava;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class FrontEndController extends Controller
{
    protected $data;
    private $modelObjava;
    private $modelKategorija;
    private $modelKomentar;
    private $modelLajk;
    protected $modelAktivnost;
    protected $modelMeni;

    public function __construct()
    {
       $this->modelMeni = new Meni();
        try{
            $this->data['meni'] = $this->modelMeni->dohvatiSve();
        } catch (QueryException $e){
            Log::error("Greška pri dohvatanju menija " . $e->getMessage());
            return abort(500);
        }
        $this->modelObjava = new Objava();
        $this->modelKategorija = new Kategorija();
        $this->modelKomentar = new Komentar();
        $this->modelLajk = new Lajk();
        $this->modelAktivnost = new Aktivnost();
    }

    public function home()
    {
        try{
            $this->data['zadnjaObjava'] = $this->modelObjava->dohvatiZadnjuObjavu();
            $this->data['najpopularnijeObjave'] = $this->modelObjava->dohvatiNajpopularnijeObjave();
            return view('pages.home', $this->data);
        } catch (QueryException $e){
            Log::error("Greška pri dohvatanju zadnje objave i najpopularnijih objava: " . $e->getMessage());
            return abort(500);
        }
    }

    public function contactAdmin(ContactProveraRequest $request)
    {
        $emailKorisnika = $request->input('contactEmail');
        $poruka = $request->input('poruka');

        $to_name = "Mladen Bošković";
        $to_email = "mladenregistracije@gmail.com";
        $data = array("name" => $to_name, "sender" => $emailKorisnika, "poruka" => $poruka);

        try{
            Mail::send('email.contactadmin', $data, function($message) use ($to_name, $to_email) {
                $message->to($to_email, $to_name)
                    ->subject('Poruka za admina');
                $message->from('auditorne.php@gmail.com','Just Write...');
            });

            try{
                $this->modelAktivnost->aktivnost = "Korisnik je poslao email administratoru";
                $this->modelAktivnost->aktivnost_created_at = time();
                $aktivnost = $this->modelAktivnost->dodajAktivnost();
            } catch (QueryException $e){
                Log::error("Greška pri dodavanju aktivnosti: " . $e->getMessage());
            }

            return back()->with('uspesnaPoruka', 'Poruka uspešno poslata!');

        } catch (\Exception $e){
            Log::error("Greška pri slanju email-a: " . $e->getMessage());
            return back()->with("neuspesnaPoruka", "Došlo je do greške, pokušajte kasnije");
        }
    }

    public function userprofile($id)
    {
        $this->modelObjava->korisnikID = $id;
        try{
            $this->data['objave'] = $this->modelObjava->dohvatiObjaveKorisnika();
            return view('pages.userprofile', $this->data);
        } catch (QueryException $e){
            Log::error("Greška pri dohvatanju objava korisnika: " . $e->getMessage());
            return redirect(route('home'));
        }
    }

    public function addobjavauser()
    {
        try{
            $this->data['kategorije'] = $this->modelKategorija->dohvatiSve();
            return view('pages.addobjavauser', $this->data);
        } catch (QueryException $e){
            Log::error("Greška pri dohvatanju svih kategorija: " . $e->getMessage());
            return redirect(route('home'));
        }
    }

    public function updateobjavauser($id)
    {
        $this->modelObjava->objavaID = $id;
        try{
            $objava = $this->modelObjava->dohvatiJednu();
            if(!$objava)
                return redirect(route('home'));
            $this->data['objava'] = $objava;
            $this->data['kategorije'] = $this->modelKategorija->dohvatiSve();
            return view('pages.updateobjavauser', $this->data);
        } catch (QueryException $e){
            Log::error("Greška pri dohvatanju jedne objave i svih kategorija: " . $e->getMessage());
            return redirect(route('home'));
        }
    }

    public function jednaObjava($objavaID, $korisnikID)
    {
        $this->modelObjava->objavaID = $objavaID;
        $this->modelKomentar->objavaID = $objavaID;
        $this->modelLajk->objavaID = $objavaID;
        try{
            $objava = $this->modelObjava->dohvatiJednu();
            if(!$objava)
                return redirect(route('home'));
            $this->data['objava'] = $objava;
            $this->data['komentari'] = $this->modelKomentar->dohvatiKomentareObjave();
            $this->data['brojKomentara'] = $this->modelKomentar->dohvatiBrojKomentaraObjave();
            $this->data['brojLajkova'] = $this->modelLajk->brojLajkovaObjave();

            if($korisnikID){
                $this->modelLajk->korisnikID = $korisnikID;
                try{
                    $this->data['korisnikLajkovao'] = $this->modelLajk->lajkProvera();
                } catch (QueryException $e){
                    Log::error("Greška pri proveri da li je korisnik lajkovao objavu: " . $e->getMessage());
                    return redirect(route('home'));
                }
            } else{
                $this->data['korisnikLajkovao'] = $korisnikID;
            }
            return view('pages.jednaobjava', $this->data);

        } catch (QueryException $e){
            Log::error("Greška pri dohvatanju jedne objave, komentara objave, broja komentara objave i broja lajkova objave: " . $e->getMessage());
            return redirect(route('home'));
        }
    }

    public function objave()
    {
        try{
            $this->data['kategorije'] = $this->modelKategorija->dohvatiSve();
            return view('pages.objave', $this->data);
        } catch (QueryException $e){
            Log::error("Greška pri dohvatanju svih kategorija: " . $e->getMessage());
            return redirect(route('home'));
        }
    }

    public function sveobjave(Request $request)
    {
        try{
            $unos = $request->input('unos');
            $kategorijeStr = $request->input('kategorijeStr');
            if($kategorijeStr){
                $kategorije = explode(', ', $kategorijeStr);
            } else{
                $kategorije = [];
            }
            $sortiranje = $request->input('sortiraj');
            $objave = $this->modelObjava->dohvatiSveObjavePage($unos, $kategorije, $sortiranje);
            return $objave;
        } catch (QueryException $e){
            Log::error("Greška pri dohvatanju objava: " . $e->getMessage());
            return redirect(route('home'));
        }
    }

    public function contact()
    {
        return view('pages.contact', $this->data);
    }

    public function error()
    {
        return view('pages.error', $this->data);
    }

    public function register()
    {
        return view('pages.register', $this->data);
    }

    public function login()
    {
        return view('pages.login', $this->data);
    }

    public function resetpasswordpage()
    {
        return view('pages.resetpassword', $this->data);
    }

    public function author()
    {
        return view('pages.author', $this->data);
    }

    public function admin(){
        return view('admin.adminhome', $this->data);
    }

    public function fallback()
    {
        return view('pages.404', $this->data);
    }
}
