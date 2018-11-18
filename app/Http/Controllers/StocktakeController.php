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

    protected $stocktakeId;

    public function index(Request $request)
    {
        return view('stocktake.stocktake-management');
    }


    public function process(Request $request)
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

    protected function getProductCountByRange()
    {
        $query =  Product::select(DB::raw('supplier, product_range, count(display_name) as product_count'))
                          ->groupBy('supplier', 'product_range')
                          ->get();
        return $query;
    }

    protected function getProductWithNoBarcodeCountByRange()
    {
        $query =  Product::select(DB::raw('supplier, product_range, barcode, count(display_name) as product_count'))
                          ->groupBy('supplier', 'product_range', 'barcode')
                          ->having('barcode', '=', '')
                          ->get();
        return $query;
    }

    protected function getProductWithNoMaxStockCountByRange()
    {
        $query =  Product::select(DB::raw('supplier, product_range, current_max_stock, count(display_name) as product_count'))
                          ->groupBy('supplier', 'product_range', 'current_max_stock')
                          ->having('current_max_stock', '=', null)
                          ->get();
        return $query;
    }

    protected function importStocktakeFile($path)
    {
        $deleted = DB::delete('delete from stock_level_import');
        //echo "records deleted from stock_level_import : " . $deleted;

        $qs = "LOAD DATA LOCAL INFILE '../storage/app/" . $path . "'
                  INTO TABLE stock_level_import
                  FIELDS TERMINATED BY ','
                  OPTIONALLY ENCLOSED BY '\"'
                  LINES TERMINATED BY '\r\n'
                  IGNORE 4 LINES";

        $query = $qs;

        DB::connection()->getpdo()->exec($query);

        return DB::table('stock_level_import')->count();
    }

    protected function productTableQA()
    {
        $imports = DB::select('SELECT * FROM stock_level_import;');

        $missingProducts = array();

        foreach ($imports as $import) {
            if (strlen(trim($import->ProductName)) > 0) {
                try {
                    $product = Product::where('display_name', '=', trim($import->ProductName))->firstOrFail();
                    $product->barcode = $import->SkuHandle;
                    $product->current_stock_available = is_numeric($import->StockAvailable) ? $import->StockAvailable : null;
                    $product->save();
                } catch (ModelNotFoundException $e) {
                    array_push($missingProducts, trim($import->ProductName));
                }
            }
        }

        return $missingProducts;
    }
}
