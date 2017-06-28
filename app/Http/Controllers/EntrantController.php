<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Input;
use App\Entrant;
use App\Entry;
use App\Payment;
use App\Category;

class EntrantController extends Controller
{
    protected $templateDir = 'entrants';
    protected $baseClass = 'App\Entrant';
    protected $paymentTypes = array('cash' => 'cash'
        ,'cheque' => 'cheque'
        ,'online' => 'online'
        ,'debit' => 'debit'
        ,'refund_cash' => 'refund_cash'
        ,'refund_online' => 'refund_online'
        ,'refund_cheque' => 'refund_cheque');

    public function index($extraData = [])
    {
        $query = $this->baseClass::orderBy('familyname', 'asc');
        
      $things = $query->get();
      return view($this->templateDir  .'.index', array_merge($extraData,  array('things' => $things)));
    }
    
    public function search(Request $request)
    {
        $searchterm = $request->input('searchterm');
        $things = $this->baseClass::where('entrants.firstname', 'LIKE', "%$searchterm%")
                      ->orWhere('entrants.familyname', 'LIKE', "%$searchterm%")
                      ->get();
        return view($this->templateDir  .'.index', array('things' => $things, 'searchterm' => $searchterm));
    }
    public function store(Request $request)
    {
        // Validate the request...

        $thing = new $this->baseClass();

        $thing->firstname = $request->firstname;
        $thing->familyname = $request->familyname;
        $thing->membernumber = $request->membernumber;
        $thing->email = $request->email;
        $thing->address = $request->address;
        $thing->address2 = $request->address2;
        $thing->addresstown = $request->addresstown;
        $thing->postcode = $request->postcode;
        $thing->age = $request->age;
        $thing->save();
        return view($this->templateDir  .'.saved', array('thing' => $thing));
    }    
    
    public function update(Request $request)
    {
        // Validate the request...
        $thing = $this->baseClass::find($request->id);

        $thing->firstname = $request->firstname;
        $thing->familyname = $request->familyname;
        $thing->membernumber = $request->membernumber;
        $thing->email = $request->email;
        $thing->address = $request->address;
        $thing->address2 = $request->address2;
        $thing->addresstown = $request->addresstown;
        $thing->postcode = $request->postcode;
        $thing->age = $request->age;
        $thing->save();
        return view($this->templateDir  .'.saved', array('thing' => $thing));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, $showData = [])
    {
        $categoriesAry = [0=>'Select...'];
        $categories = Category::orderBy('sortorder')->get()    ;
        foreach ($categories as $category)
        {
            $categoriesAry[$category->id] = $category->number . ': ' .$category->name; 
        }
        $payments = Payment::where('entrant', (int)$id)->get();
        $totalPaid = 0;
        foreach ($payments as $payment)
        {
            $totalPaid += $payment->amount;
        }
        
        
        $entries = Entry::where('entrant', (int)$id)->get();
        $categoryData = [];
        $totalPrice = 0;
        $totalPrizes = 0;
        foreach ($entries as $entry)
        {
            if ($entry->category)
            {
                $categoryData[$entry->category] = Category::find($entry->category);
//                var_dump($entry->created_at);
                $created = new \DateTime($entry->created_at);
                $cutoffDate = new \DateTime('5 July 2017 23:59:59');

                if ($created < $cutoffDate )
                {
                    $totalPrice += $categoryData[$entry->category]->price;
                }
                else
                {
                    $totalPrice += $categoryData[$entry->category]->late_price;
                }
                
                if ('' !== trim($entry->winningplace))
                {
                    $totalPrizes += $categoryData[$entry->category]->getWinningAmount($entry->winningplace);
                }
            }
        }
        return parent::show($id, array_merge($showData,
                array('entries' => $entries, 
                    'category_data' => $categoryData, 
                    'categories' => $categoriesAry,
                    'payments' => $payments,
                    'entry_fee' => $totalPrice,
                    'paid' => $totalPaid,
                    'payment_types' => $this->paymentTypes,
                    'total_prizes' => $totalPrizes)));
    }
    
    function printcards($id)
    {
        $categoryData = [];
        $entrant = $this->baseClass::find($id);
        $entries = Entry::where('entrant', (int)$id)->get();
        $cardFronts = [];
        $cardBacks = [];
        
        foreach ($entries as $entry)
        {
            if ($entry->category)
            {
                $categoryData[$entry->category] = Category::find($entry->category);
                $cardFronts[] = [
                    'class_number'=>$entry->category, 
                    'entrant_number'=>(int)$id,
                    'entrant_age'=>(($entrant->age && 18 > (int)$entrant->age)?$entrant->age:'')
                 ];
                $cardBacks[] = ['class_number'=>$entry->category, 
                    'class_name'=>$categoryData[$entry->category]->name, 
                    'entrant_name'=>$entrant->firstname . ' ' . $entrant->familyname
                        ];
            }
        }

        return view($this->templateDir.'.printcards', ['entrant'=>$entrant,
            'card_fronts' => $cardFronts,
            'card_backs' => $cardBacks,
            'category_data' => $categoryData,
            'entries'=>$entries]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
      $thing = $this->baseClass::find($id);
//      $showData = array_merge($extraData,  array('thing' => $thing));
//      return view($this->templateDir.'.show', $showData);
        
      return view($this->templateDir  .'.edit', array('thing' => $thing));
    }
}
