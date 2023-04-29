<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class MarketingController extends Controller
{
    public function membership(Request $request): Factory|View|Application
    {
        return view('marketing.membership', []);
    }
}
