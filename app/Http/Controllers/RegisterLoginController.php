<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginProveraRequest;
use App\Http\Requests\RegisterProveraRequest;
use App\Models\Korisnik;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class RegisterLoginController extends FrontEndController
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new Korisnik();
    }

    public function registracija(RegisterProveraRequest $request)
    {
        $this->model->ime = $request->input('regIme');
        $this->model->prezime = $request->input('regPrezime');
        $this->model->email = $request->input('regEmail');
        $this->model->korisnicko_ime = $request->input('regKorIme');
        $this->model->lozinka = $request->input('regLozinka');
        $this->model->token = md5(sha1($request->input('regEmail') . $request->input('regKorIme') . time()));
        $this->model->aktivan = 0;
        $this->model->reset_password = md5(sha1($request->input('regIme') . $request->input('regEmail') . time() . rand()));
        $this->model->datum_registracije = time();

        $slika = $request->file('regSlika');
        $nazivSlike = time() . "_" . $slika->getClientOriginalName();

        $this->model->src = $nazivSlike;
        $this->model->alt = $request->input('regIme') . " " . $request->input('regPrezime');

        try{
            $korisnik = $this->model->registracija();

            try{
                $slika->move(public_path() . '/images/profile/', $nazivSlike);

                $to_name = $this->model->ime ." ". $this->model->prezime;
                $to_email = $this->model->email;
                $data = array('name' => $to_name, "token" => $this->model->token);

                try{
                    Mail::send('email.register', $data, function($message) use ($to_name, $to_email) {
                        $message->to($to_email, $to_name)
                            ->subject('Aktivacija naloga');
                        $message->from('auditorne.php@gmail.com','Just Write...');
                    });

                    try{
                        $this->modelAktivnost->aktivnost = "Korisnik se registrovao";
                        $this->modelAktivnost->aktivnost_created_at = time();
                        $aktivnost = $this->modelAktivnost->dodajAktivnost();
                    } catch (QueryException $e){
                        Log::error("Greška pri dodavanju aktivnosti: " . $e->getMessage());
                    }

                    return back()->with("uspesnaPoruka", "Uspešno ste se registrovali! Proverite email i aktivirajte nalog");

                } catch (\Exception $e){
                    Log::error("Greška pri slanju email-a: " . $e->getMessage());
                    return back()->with("neuspesnaPoruka", "Došlo je do greške, obratite se administratoru kako bi Vam aktivirao nalog");
                }

            } catch (FileException $e){
                Log::error("Greška pri prebacivanju slike: " . $e->getMessage());
                return back()->with("neuspesnaPoruka", "Došlo je do greške, obratite se administratoru kako bi Vam aktivirao nalog");
            }

        } catch (QueryException $e) {
            Log::error("Greška pri registraciji korisnika: " . $e->getMessage());
            return back()->with("neuspesnaPoruka", "Greška pri registraciji, pokušajte kasnije");
        }
    }

    public function prijava(LoginProveraRequest $request)
    {
        $this->model->korisnicko_ime = $request->input('loginKorIme');
        $this->model->lozinka = $request->input('loginLozinka');
        $this->model->aktivan = 1;

        try{
            $korisnik = $this->model->prijava();
            if($korisnik){
                $request->session()->put('korisnik', $korisnik);

                try{
                    $this->modelAktivnost->aktivnost = "Korisnik se prijavio";
                    $this->modelAktivnost->aktivnost_created_at = time();
                    $aktivnost = $this->modelAktivnost->dodajAktivnost();
                } catch (QueryException $e){
                    Log::error("Greška pri dodavanju aktivnosti: " . $e->getMessage());
                }
                if($korisnik->uloga == "Admin"){
                    return redirect(route('adminhomepage'));
                } else{
                    return redirect(route('home'));
                }
            } else{
                return back()->with('loginGreskaPoruka', 'Pogrešno korisničko ime ili lozinka');
            }

        } catch (QueryException $e){
            Log::error("Greška pri prijavi korisnika: " . $e->getMessage());
            return back()->with('neuspesnaPoruka', 'Greška pri prijavi, pokušajte kasnije');
        }
    }

    public function odjava(Request $request)
    {
        $request->session()->forget('korisnik');
        $request->session()->flush();

        try{
            $this->modelAktivnost->aktivnost = "Korisnik se odjavio";
            $this->modelAktivnost->aktivnost_created_at = time();
            $aktivnost = $this->modelAktivnost->dodajAktivnost();
        } catch (QueryException $e){
            Log::error("Greška pri dodavanju aktivnosti: " . $e->getMessage());
        }

        return redirect(route('home'));
    }

    public function activate($token)
    {
        $this->model->token = $token;

        try{
            $korisnik = $this->model->activateProvera();
            if($korisnik){
                if($korisnik->aktivan == 1){
                    return redirect(route('loginpage'))->with('uspesnaPoruka', 'Nalog je već aktiviran, možete se prijaviti');
                } else{
                    try{
                        $korisnikActivate = $this->model->activate();

                        try{
                            $this->modelAktivnost->aktivnost = "Korisnik je aktivirao nalog";
                            $this->modelAktivnost->aktivnost_created_at = time();
                            $aktivnost = $this->modelAktivnost->dodajAktivnost();
                        } catch (QueryException $e){
                            Log::error("Greška pri dodavanju aktivnosti: " . $e->getMessage());
                        }

                        return redirect(route('loginpage'))->with('uspesnaPoruka', 'Uspešna aktivacija naloga! Možete se prijaviti');

                    } catch (QueryException $e){
                        Log::error("Greška pri aktivaciji naloga: " . $e->getMessage());
                        return redirect(route('errorpage'))->with('neuspesnaPoruka', 'Greška pri aktivaciji, pokušajte kasnije');
                    }
                }
            } else{
                return redirect(route('registerpage'))->with("neuspesnaPoruka", "Niste registrovani");
            }
        } catch (QueryException $e){
            Log::error("Greška pri pronalaženju korisnika čiji nalog treba da se aktivira naloga: " . $e->getMessage());
            return redirect(route('errorpage'))->with('neuspesnaPoruka', 'Greška pri aktivaciji, pokušajte kasnije');
        }
    }

}
