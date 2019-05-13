<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entry;

class EntryController extends Controller
{
    public function creates(Request $request)
    {
        if (0 < count($request->input('categories')))
        {
            foreach($request->input('categories') as $category)
            {
                if ('0' !== $category)
                {
                    $entry = new Entry;
                    $entry->category_id = (int)$category;
                    $entry->entrant_id = (int)$request->input('entrant');
                    $entry->year = (int) env('CURRENT_YEAR', 2018);
                    $entry->save();
                }
            }
        }
        return redirect()->route('entrants.show',(int)$request->input('entrant'));
    }
    

            
}
