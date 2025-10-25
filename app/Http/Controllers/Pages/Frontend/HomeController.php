<?php

namespace App\Http\Controllers\Pages\Frontend;

use App\Models\Pages\Client;
use App\Models\Pages\Hosting;
use App\Models\Pages\Product;
use App\Models\Pages\Service;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return inertia('Frontend/Pages/Home/Index', [

        ]);
    }
}

