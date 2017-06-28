<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected $templateDir;
    protected $baseClass;
    //put your code here
    public function index($extraData = [])
    {        
      $things = $this->baseClass::all();
      return view($this->templateDir  .'.index', array_merge($extraData,  array('things' => $things)));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($extraData = [])
    {
      return view($this->templateDir  .'.create', $extraData);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, $extraData = [])
    {
      $thing = $this->baseClass::find($id);
      $showData = array_merge($extraData,  array('thing' => $thing));
      return view($this->templateDir.'.show', $showData);
    }
    
}
