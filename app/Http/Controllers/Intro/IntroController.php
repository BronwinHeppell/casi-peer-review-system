<?php

namespace App\Http\Controllers\Intro;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class IntroController extends Controller
{
    public function index()
    {
        return Inertia::render('Intro/Index');
    }
}
