<?php

namespace App\Http\Controllers;

use App\Http\Requests\PromenaLozinkeProveraRequest;
use App\Http\Requests\ResetLozinkeEmailProveraRequest;
use App\Http\Requests\ResetLozinkeNovaLozinkaProveraRequest;
use App\Models\Korisnik;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Psy\Util\Json;

class ChangePasswordController extends FrontEndController
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new Korisnik();
    }

    public function resetLozinkeEmailProvera(ResetLozinkeEmailProveraRequest $request)
    {
        $this->model->email = $request->input('email');
        $this->model->reset_password = md5(sha1($request->input('email') . rand() . time() . rand()));

        try{
            $korisnik = $this->model->resetLozinkeEmailUspesnaProvera();

            $to_name = $this->model->email;
            $to_email = $this->model->email;
            $data = array("token" => $this->model->reset_password);

            try{
                Mail::send('email.resetpassword', $data, function($message) use ($to_name, $to_email) {
                    $message->to($to_email, $to_name)
                        ->subject('Resetovanje lozinke');
                    $message->from('auditorne.php@gmail.com','Just Write...');
                });
                return Json::encode("Proverite email za nastavak procesa . . . . .");
            } catch (\Exception $e){
                Log::error("Greška pri slanju email-a: " . $e->getMessage());
                return Json::encode("Došlo je do greške, pokušajte kasnije");
            }

        } catch (QueryException $e){
            Log::error("Greška pri setovanju tokena korisniku koji zahteva resetovanje lozinke: " . $e->getMessage());
            return Json::encode("Došlo je do greške, pokušajte kasnije");
        }
    }

    public function resetLozinkeTokenProvera($token)
    {
        $this->model->reset_password = $token;
        try{
            $korisnik = $this->model->resetLozinkeTokenProvera();
            if($korisnik){
                return redirect(route('resetpasswordpage'))->with('reset_password', $token);
            } else{
                return redirect(route('errorpage'))->with('neuspesnaPoruka', 'Nevažeči zahtev za resetovanje lozinke');
            }
        } catch (QueryException $e){
            Log::error("Greška pri proveri da li postoji korisnik sa validnim tokenom za resetovanje lozinke: " . $e->getMessage());
            return redirect(route('errorpage'))->with('neuspesnaPoruka', 'Greška pri resetovanju lozinke, pokušajte kasnije');
        }
    }

    public function resetPassword(ResetLozinkeNovaLozinkaProveraRequest $request)
    {
        $this->model->reset_password = md5(sha1(time() . rand() . time() . rand() . time() . rand()));
        $this->model->token = $request->input('token');
        $this->model->lozinka = $request->input('novaLozinka');

        try{
            $korisnik = $this->model->resetPassword();

            try{
                $this->modelAktivnost->aktivnost = "Korisnik je resetovao lozinku";
                $this->modelAktivnost->aktivnost_created_at = time();
                $aktivnost = $this->modelAktivnost->dodajAktivnost();
            } catch (QueryException $e){
                Log::error("Greška pri dodavanju aktivnosti: " . $e->getMessage());
            }

            return Json::encode("Uspešno ste promenili lozinku!");
        } catch (QueryException $e){
            Log::error("Greška pri resetovanju lozinke: " . $e->getMessage());
            return Json::encode("Došlo je do greške, pokušajte kasnije");
        }
    }

    public function promenaLozinke(PromenaLozinkeProveraRequest $request)
    {
        $this->model->korisnikID = $request->input('korisnikID');
        $this->model->lozinka = $request->input('trenutnaLozinka');

        try{
            $korisnikProvera = $this->model->promenaLozinkeProvera();
            if($korisnikProvera){
                $this->model->lozinka = $request->input('novaLozinka');
                try{
                    $korisnik = $this->model->promenaLozinke();

                    try{
                        $this->modelAktivnost->aktivnost = "Korisnik je promenio lozinku";
                        $this->modelAktivnost->aktivnost_created_at = time();
                        $aktivnost = $this->modelAktivnost->dodajAktivnost();
                    } catch (QueryException $e){
                        Log::error("Greška pri dodavanju aktivnosti: " . $e->getMessage());
                    }

                    return Json::encode("Uspešno ste promenili lozinku!");

                } catch (QueryException $e){
                    Log::error("Greška pri promeni lozinke: " . $e->getMessage());
                    return Json::encode("Došlo je do greške, pokušajte kasnije");
                }
            } else{
                return Json::encode("Trenutna lozinka nije ispravna");
            }
        } catch (QueryException $e){
            Log::error("Greška pri pronalaženju korisnika koji menja lozinku: " . $e->getMessage());
            return Json::encode("Došlo je do greške, pokušajte kasnije");
        }
    }

}
