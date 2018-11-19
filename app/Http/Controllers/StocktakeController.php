<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use App\Stocktake;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StocktakeController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stocktakes = Stocktake::all();
        return view('stocktake.index', compact('stocktakes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('stocktake.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $path = $request->file('stockLevelReport')->store('stocktakes');
      $importedRows = $this->importStocktakeFile($path);

      // ProductName (aka display_name) should be unique but this is not enforced in Timely so need check if the import file has any duplicates
      $productNames = DB::select('SELECT ProductName FROM stock_level_import GROUP BY ProductName HAVING Count(ProductName) > ?', [1]);
      if (count($productNames) > 1) {
          // need to implement a way to handle the times when duplicates are detected
          dd($productNames);
      }

      $stocktake = new Stocktake;
      $stocktake->stock_level_import_filename = $path;
      $stocktake->stocktake_date = Carbon::now();
      $stocktake->product_count = $importedRows;
      $stocktake->save();

      $this->stocktakeId = $stocktake->id;

      $productsNotInMaster = $this->productTableQA();

      if (count($productsNotInMaster) > 0) {
          dd($productsNotInMaster);
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Stocktake  $stocktake
     * @return \Illuminate\Http\Response
     */
    public function show(Stocktake $stocktake)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Stocktake  $stocktake
     * @return \Illuminate\Http\Response
     */
    public function edit(Stocktake $stocktake)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Stocktake  $stocktake
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stocktake $stocktake)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Stocktake  $stocktake
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stocktake $stocktake)
    {
        //
    }
}
