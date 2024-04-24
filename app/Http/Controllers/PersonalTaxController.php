<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class PersonalTaxController extends Controller
{
    //

    public function year_page()
    {
        return Inertia::render('Personal Tax/Year');
    }
}
