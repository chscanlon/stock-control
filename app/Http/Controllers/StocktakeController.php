<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Stocktake;
use App\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        //dd($request);
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

        // Update the products table with data from the imported stock level report
        // Return a count of products in the stock level report that are not matched to records in the products table
        $newProducts = $this->updateProductWithStockLevelData();


        if (count($newProducts) > 0) {
            //dd($productsNotInMaster);
            return view('product.create-from-timely', compact('newProducts'));
        }

        $this->index();
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

    protected function importStocktakeFile($path)
    {
        $deleted = DB::delete('delete from stock_level_import');
        //echo "records deleted from stock_level_import : " . $deleted;

        $query = "LOAD DATA LOCAL INFILE '../storage/app/" . $path . "'
                  INTO TABLE stock_level_import
                  FIELDS TERMINATED BY ','
                  OPTIONALLY ENCLOSED BY '\"'
                  LINES TERMINATED BY '\r\n'
                  IGNORE 4 LINES";

        DB::connection()->getpdo()->exec($query);

        return DB::table('stock_level_import')->count();
    }

    protected function updateProductWithStockLevelData()
    {
        $imports = DB::select('SELECT * FROM stock_level_import;');

        $missingProducts = array();

        foreach ($imports as $import) {
            if (strlen(trim($import->ProductName)) > 0) {
                try {
                    $product = Product::where([
                          ['display_name', '=', trim($import->ProductName)],
                          ['timely_product_status', '=', 'active'],
                        ])->firstOrFail();

                    $product->timely_product_status = 'matched';
                    $product->barcode = $import->SkuHandle;
                    $product->current_stock_available = is_numeric($import->StockAvailable) ? $import->StockAvailable : null;
                    $product->reorder_alert_threshold = is_numeric($import->ReorderAlertThreshold) ? $import->ReorderAlertThreshold : null;
                    $product->save();
                } catch (ModelNotFoundException $e) {
                    array_push($missingProducts, [trim($import->ProductName), $import->SkuHandle, is_numeric($import->StockAvailable) ? $import->StockAvailable : null]);
                }
            }
        }

        $this->updateUnmatchedProductsToDeleted();

        return $missingProducts;
    }

    protected function updateUnmatchedProductsToDeleted()
    {
        // this function should be called after a stocktake import
        // products matched in the stocktake import will have timely_product_status = 'matched'
        // products not matched in the import will now have timely_product_status = 'active' or 'deleted'
        // this function updates timely_product_status from 'active' to 'deleted'
        // and then updates timely_product_status from 'matched' to 'active'

        DB::table('products')
            ->where('timely_product_status', 'active')
            ->update(['timely_product_status' => 'deleted']);

        DB::table('products')
                ->where('timely_product_status', 'matched')
                ->update(['timely_product_status' => 'active']);
    }
}
