<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\FrontEndController;
use App\Models\Aktivnost;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class AktivnostController extends FrontEndController
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new Aktivnost();
    }

    public function index(Request $request)
    {
        try{
            $sort = $request->input('aktivnost_sort');
            if($sort){
                $this->data['sort'] = $sort;
            } else{
                $this->data['sort'] = 'desc';
            }
            $this->data['aktivnosti'] = $this->model->dohvatiSve($sort);

            return view('admin.aktivnost.index', $this->data);
        } catch (QueryException $e){
            Log::error("Greška pri dohvatanju svih aktivnosti: " . $e->getMessage());
            return redirect(route('adminhomepage'));
        }
    }
}
