<?php

namespace App\Http\Controllers;

use App\Product;
use App\Stocktake;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

//use PhpOffice\PhpSpreadsheet\IOFactory;
//use App\ExcelHelper;

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

        $stocktake = new Stocktake;
        $stocktake->stock_level_import_filename = $path;
        $stocktake->stocktake_date = Carbon::now();
        $stocktake->product_count = $importedRows;
        $stocktake->save();

        $this->stocktakeId = $stocktake->id;

        // Update the products table with data from the imported stock level report
        $this->updateProductWithStockLevelData();

        $newProducts = Product::where('created_in_stocktake_id', $this->stocktakeId)->get();
        $deletedProducts = Product::where('deleted_in_stocktake_id', $this->stocktakeId)->get();

        return view('stocktake.show', compact('stocktake', 'newProducts', 'deletedProducts'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Stocktake  $stocktake
     * @return \Illuminate\Http\Response
     */
    public function show(Stocktake $stocktake)
    {
        $newProducts = Product::where('created_in_stocktake_id', $stocktake->id)->get();
        $deletedProducts = Product::where('deleted_in_stocktake_id', $stocktake->id)->get();

        return view('stocktake.show', ['stocktake' => $stocktake, 'newProducts' => $newProducts, 'deletedProducts' => $deletedProducts]);
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

    // Refactor in progress to import data from the Timely excel format rather than the csv NumberFormat
    // Will use phpspreadsheet

    protected function importStocktakeFile($path)
    // This function imports a Timely Stock Level Report that has been exported in Excel format
    // The file is imported to a one off staging table called stock_level_xlsx_import
    {
        DB::table('stock_level_xlsx_import')->truncate();
        $reader = new Xlsx();
        $spreadsheet = $reader->load(storage_path('app/' . $path));
        $worksheet = $spreadsheet->getActiveSheet();
        $productId = 0;

        foreach ($worksheet->getRowIterator(10) as $row) {

            //If column A contains a hyperlink this is a product record
            if ($worksheet->getCell('A' . $row->getRowIndex())->hasHyperlink()) {
                $productId = $this->getTimelyProductIndex($worksheet->getCell('A' . $row->getRowIndex())->getHyperlink()->GetURL());
                $productName = $worksheet->getCell('A' . $row->getRowIndex())->getValue();
                $skuHandle = $worksheet->getCell('B' . $row->getRowIndex())->getValue();
                $locationName = $worksheet->getCell('C' . $row->getRowIndex())->getValue();
                $stockAvailable = $worksheet->getCell('D' . $row->getRowIndex())->getValue();
                $alertPoint = $worksheet->getCell('E' . $row->getRowIndex())->getValue();
                $taxAmount = $worksheet->getCell('F' . $row->getRowIndex())->getValue();
                $costPrice = $worksheet->getCell('G' . $row->getRowIndex())->getValue();
                $retailPrice = $worksheet->getCell('H' . $row->getRowIndex())->getValue();
                $totalCostValue = $worksheet->getCell('I' . $row->getRowIndex())->getValue();
                $totalRetailValue = $worksheet->getCell('J' . $row->getRowIndex())->getValue();

                DB::table('stock_level_xlsx_import')->insert(
                    [
                        'timely_product_id' => $productId,
                        'product_name' => $productName,
                        'sku_handle' => is_null($skuHandle) ? '' : $skuHandle,
                        'product_location' => is_null($locationName) ? '' : $locationName,
                        'stock_available' => is_null($stockAvailable) ? '' : $stockAvailable,
                        'reorder_alert_threshold' => is_null($alertPoint) ? '' : $alertPoint,
                        'tax_amount' => is_null($taxAmount) ? '' : $taxAmount,
                        'unit_cost_price' => is_null($costPrice) ? '' : $costPrice,
                        'unit_retail_price' => is_null($retailPrice) ? '' : $retailPrice,
                        'total_cost_value' => is_null($totalCostValue) ? '' : $totalCostValue,
                        'total_retail_value' => is_null($totalRetailValue) ? '' : $totalRetailValue,
                    ]
                );
            }
        }

        return DB::table('stock_level_xlsx_import')->count();
    }

    // Refactor in progress to update with data from the table stock_level_xlsx_import
    // Records in the products table that are matched by timely_product_id are updated and the field timely_product_status is set to 'matched'
    // If a match is not found a new record is created in the products table
    protected function updateProductWithStockLevelData()
    {
        $imports = DB::select('SELECT * FROM stock_level_xlsx_import;');

        foreach ($imports as $import) {

            $product = Product::where('timely_product_id', $import->timely_product_id)->first();

            if (is_null($product)) {
                // record not found so create a new product instance
                $product = new Product;
                $product->timely_product_id = $import->timely_product_id;
                $product->display_name = $import->product_name;
                $product->barcode = $import->sku_handle;
                $product->current_max_stock = is_numeric($import->reorder_alert_threshold) ? $import->reorder_alert_threshold : 0;
                $product->current_stock_available = is_numeric($import->stock_available) ? $import->stock_available : 0;
                $product->current_cost_price = is_numeric($import->unit_cost_price) ? $import->unit_cost_price : 0;
                $product->current_retail_price = is_numeric($import->unit_retail_price) ? $import->unit_retail_price : 0;
                $product->reorder_alert_threshold = is_numeric($import->reorder_alert_threshold) ? $import->reorder_alert_threshold : 0;
                $product->timely_product_status = 'matched';
                $product->created_in_stocktake_id = $this->stocktakeId;
                $product->save();
            } else {
                // record was found so update the returned product instance
                $product->display_name = $import->product_name;
                $product->barcode = $import->sku_handle;
                $product->current_stock_available = is_numeric($import->stock_available) ? $import->stock_available : 0;
                $product->current_cost_price = is_numeric($import->unit_cost_price) ? $import->unit_cost_price : 0;
                $product->current_retail_price = is_numeric($import->unit_retail_price) ? $import->unit_retail_price : 0;
                $product->reorder_alert_threshold = is_numeric($import->reorder_alert_threshold) ? $import->reorder_alert_threshold : 0;
                $product->timely_product_status = 'matched';
                $product->save();
            }
        }
        $this->updateUnmatchedProductsToDeleted();
    }

    protected function updateUnmatchedProductsToDeleted()
    {
        // this function should be called after a stocktake import
        // products created or updated in the stocktake import will have timely_product_status = 'matched'
        // products not matched in the import will now have timely_product_status = 'active' or 'deleted'
        // this function updates timely_product_status from 'active' to 'deleted' and records the stocktake_id
        // and then updates timely_product_status from 'matched' to 'active'

        DB::table('products')
            ->where('timely_product_status', 'active')
            ->update(['timely_product_status' => 'deleted', 'deleted_in_stocktake_id' => $this->stocktakeId]);

        DB::table('products')
            ->where('timely_product_status', 'matched')
            ->update(['timely_product_status' => 'active']);
    }

    private function getTimelyProductIndex($url)
    {
        $array = explode('/', $url);

        return ($array[count($array) - 1]);
    }
}
