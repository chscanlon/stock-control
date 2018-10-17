<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Stocktake;
use App\Product;
use App\StocktakeEvent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StocktakeController extends Controller
{
    //

    protected $stocktakeEventId;

    public function upload(Request $request)
    {
        return view('file-upload');
    }


    public function process(Request $request)
    {
        $path = $request->file('stock')->store('stocktakes');
        $importedRows = $this->importStocktakeFile($path);

        // ProductName should be unique but this is not enforced in Timely so check if the import file has any duplicates
        $productNames = DB::select('SELECT ProductName FROM stock_level_import GROUP BY ProductName HAVING Count(ProductName) > ?', [1]);
        if (count($productNames) > 1) {
            // need to implement a way to handle the times when duplicates are detected
            dd($productNames);
        }

        $file = new StocktakeEvent;
        $file->file_path = $path;
        $file->save();

        $this->stocktakeEventId = $file->id;

        $productsNotInMaster = $this->productTableQA();

        if (count($productsNotInMaster) > 0) {
            dd($productsNotInMaster);
        }

        $lorealOrders = $this->createLorealOrder();

        //$this->seedProductTable();
        //$productRangeCounts = $this->getProductCountByRange();
        //$productNoBarcodeRangeCounts = $this->getProductWithNoBarcodeCountByRange();
        return view('loreal-order', compact('lorealOrders'));
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

        $qs = "LOAD DATA LOCAL INFILE '../storage/app/" . $path . "'  INTO TABLE stock_level_import  FIELDS TERMINATED BY ','  OPTIONALLY ENCLOSED BY '\"'  LINES TERMINATED BY '\r\n' IGNORE 4 LINES";
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



                // $productCount = Product::where('display_name', '=', trim($import->ProductName))->count();
                // if ($productCount = 0) {
                //     dd($import->ProductName);
                //     array_push($missingProducts, trim($import->ProductName));
                // } elseif ($productCount = 1) {
                //     $product = Product::firstOrNew(['display_name' => trim($import->ProductName)]);
                //     $product->barcode = $import->SkuHandle;
                //     $product->current_stock_available = is_numeric($import->StockAvailable) ? $import->StockAvailable : null;
                // }
            }
        }

        return $missingProducts;
    }

    protected function parseDisplayName($displayName)
    {
        if (substr($displayName, 0, 11) == 'Majirel Mix') {
            return ["L'Oreal", "Majirel Mix", "Professional", "03.07"];
        } elseif (substr($displayName, 0, 17) == 'Majirel High Lift') {
            return ["L'Oreal", "Majirel High Lift", "Professional", "03.03"];
        } elseif (substr($displayName, 0, 14) == 'Majirel Metals') {
            return ["L'Oreal", "Majirel Metals", "Professional", "03.05"];
        } elseif (substr($displayName, 0, 14) == 'Majirel Cool Cover') {
            return ["L'Oreal", "Majirel Cool Cover", "Professional", "03.02"];
        } elseif (substr($displayName, 0, 7) == 'Majirel') {
            return ["L'Oreal", "Majirel", "Professional", "03.01"];
        } elseif (substr($displayName, 0, 12) == 'Inoa Supreme') {
            return ["L'Oreal", "Inoa Supreme", "Professional", "02.03"];
        } elseif (substr($displayName, 0, 4) == 'Inoa') {
            return ["L'Oreal", "Inoa", "Professional", "02.01"];
        } elseif (substr($displayName, 0, 12) == 'Dia Richesse') {
            return ["L'Oreal", "Dia Richesse", "Professional", "04.01"];
        } elseif (substr($displayName, 0, 9) == 'Dia Light') {
            return ["L'Oreal", "Dia Light", "Professional", "04.02"];
        } elseif (substr($displayName, 0, 12) == 'Majicontrast') {
            return ["L'Oreal", "Majicontrast", "Professional", "03.08"];
        } elseif (substr($displayName, 0, 9) == 'Majirouge') {
            return ["L'Oreal", "Majirouge", "Professional", "03.04"];
        } elseif (substr($displayName, 0, 6) == 'LOR SX') {
            return ["L'Oreal", "Serioxyl", "Retail", ""];
        } elseif (substr($displayName, 0, 6) == 'LOR TA') {
            return ["L'Oreal", "Techni Art", "Retail", ""];
        } elseif (substr($displayName, 0, 6) == 'LOR SE') {
            return ["L'Oreal", "Serie Expert", "Retail", ""];
        } elseif (substr($displayName, 0, 6) == 'LOR PF') {
            return ["L'Oreal", "Profiber", "Retail", ""];
        } elseif (substr($displayName, 0, 3) == 'MOR') {
            return ["Haircare Australia", "Morrocan Oil", "", ""];
        } elseif (substr($displayName, 0, 3) == 'NAK') {
            return ["NAK", "NAK", "Retail", ""];
        } else {
            return ["Unknown", "Unknown", "", ""];
        }
    }

    protected function appendStocktake($product, $maxStock, $availableStock, $costPrice, $retailPrice)
    {
        $stocktake = new Stocktake;
        $stocktake->product()->associate($product);
        $stocktake->stocktake_event_id = $this->stocktakeEventId;
        $stocktake->max_stock = $maxStock;
        $stocktake->available_stock = $availableStock;
        $stocktake->cost_price = $costPrice;
        $stocktake->retail_price = $retailPrice;

        $stocktake->save();
    }


    protected function createLorealOrder()
    {
        $query =  Product::select(DB::raw('supplier, product_range, display_name, current_max_stock, current_stock_available, (current_max_stock - current_stock_available) AS ORDER_AMOUNT'))
                        ->where([['supplier', "L'Oreal"], ['discontinued', false]])
                        ->having('ORDER_AMOUNT', '>', 0)
                        ->orderBy('supplier_sequence')
                        ->get();
        return $query;
    }
}
