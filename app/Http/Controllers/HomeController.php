<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Conversion;
use App\User;


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

      $id = Auth::id();

      $conversion = New Conversion;
      $conversion->userID = $id;
      $conversion->orgNumber = $request->input('numberVal');
      $conversion->romNumeral = $finalVal;
      $conversion->save();


      return $finalVal;
    }

    public function getStats(request $request)
    {
      $userCount = User::all()->count();
      $conversions = Conversion::all();
      $conversionCount = $conversions->count();

      $popNum = Conversion::select('orgNumber')
      ->groupBy('orgNumber')
      ->orderByRaw('COUNT(*) DESC')
      ->limit(1)
      ->get();

      $popNum = $popNum[0]->orgNumber;

      $userID = Conversion::select('userID')
      ->groupBy('userID')
      ->orderByRaw('COUNT(*) DESC')
      ->limit(1)
      ->get();

      $userID = $userID[0]->userID;

      $userName = User::findOrFail($userID)->name;


      $statsArray = array($userCount, $conversionCount, $popNum, $userName);
      return $statsArray;
    }

    public function getTable(request $request)
    {
      // $tableArray = Conversion::all();
      // $tableArray->sortBy('created_at');
      $tableArray = Conversion::select('id','userID','orgNumber','romNumeral','created_at')
      ->orderBy('id', 'DESC')
      ->limit(15)
      ->get();

      $tableArray = json_encode($tableArray);

      return $tableArray;
    }
}
