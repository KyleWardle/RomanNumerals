<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function convertNumeral(request $request)
    {
      $convertVal = $request->input('numberVal');

      $conversionArray = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
      $finalVal = '';
      while ($convertVal > 0) {
          foreach ($conversionArray as $roman => $int) {
              if($convertVal >= $int) {
                  $convertVal -= $int;
                  $finalVal .= $roman;
                  break;
              }
          }
      }
      return $finalVal;
    }
}
