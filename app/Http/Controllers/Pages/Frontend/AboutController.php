<?php

namespace App\Http\Controllers\Pages\Frontend;

use App\Http\Controllers\Controller;

class AboutController extends Controller
{
    public function index()
    {
        return inertia('Frontend/Pages/About/Index', [
            
        ]);
    }
}

