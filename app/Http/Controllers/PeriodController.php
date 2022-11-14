<?php

namespace App\Http\Controllers;

use App\Models\Period;
use Illuminate\Http\Request;

class PeriodController extends Controller
{
    public function show(){
        $period = Period::all();

        return view("period.manage", compact('period'));
    }
}
