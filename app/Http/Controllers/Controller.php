<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use \Illuminate\View\View;

class Controller extends BaseController {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected $templateDir;
    protected $baseClass;


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show(int $id, array $extraData = []): View {
        $thing = $this->baseClass::find($id);
        $showData = array_merge($extraData, array('thing' => $thing));
        return view($this->templateDir . '.show', $showData);
    }

}
