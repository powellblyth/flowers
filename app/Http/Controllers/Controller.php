<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use \Illuminate\View\View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected $templateDir;
    protected $baseClass;

    protected function getYearFromRequest(Request $request): int
    {
        if ($request->has = ('year') && is_numeric($request->year) && (int) $request->year > 2015 && (int) $request->year < (int) date('Y')) {
            return (int) $request->year;
        } else {
            return config('app.year');
        }
    }


}
