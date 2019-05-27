<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Meni extends Model
{
    protected $table = "meni";
    protected $primaryKey = "meniID";

    public function dohvatiSve()
    {
        $meni = DB::table($this->table)->get();

        foreach ($meni as $m){
            $m->submenus = DB::table($this->table)->where('roditeljID', $m->meniID)->get();
        }

        return $meni;
    }
}
