<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use App\Product;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;


class ProductIdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rowCount = DB::table('stock_level_xlsx_import')->count();
        echo $rowCount . ' records in stock_level_xlsx_import table' . PHP_EOL;

        $deleted = DB::delete('delete from stock_level_xlsx_import');
        echo $deleted . ' rows deleted from stock_level_xlsx_import table' . PHP_EOL;

        $this->importTimelyStocktakeFile();

        echo 'New file has been loaded to the stock_level_xlsx_import table' . PHP_EOL;
        $rowCount = DB::table('stock_level_xlsx_import')->count();
        echo $rowCount . ' records in stock_level_xlsx_import table' . PHP_EOL;

        $this->updateTimelyProductId();
    }

    protected function importTimelyStocktakeFile()
    // This function imports a Timely Stock Level Report that has been exported in Excel format
    // The file is imported to a one off staging table called stock_level_xlsx_import
    {
        //DB::table('stock_level_xlsx_import')->truncate();
        $reader = new Xlsx();
        $spreadsheet = $reader->load(storage_path('StockLevels.xlsx'));
        $worksheet = $spreadsheet->getActiveSheet();
        $productId = 0;

        foreach ($worksheet->getRowIterator(10) as $row) {

            //If column A contains a hyperlink this is a product record
            if ($worksheet->getCell('A'.$row->getRowIndex())->hasHyperlink()) {
                $productId = $this->getTimelyProductIndex($worksheet->getCell('A'.$row->getRowIndex())->getHyperlink()->GetURL());
                $productName = $worksheet->getCell('A'.$row->getRowIndex())->getValue();
                $skuHandle = $worksheet->getCell('B'.$row->getRowIndex())->getValue();
                $locationName = $worksheet->getCell('C'.$row->getRowIndex())->getValue();
                $stockAvailable = $worksheet->getCell('D'.$row->getRowIndex())->getValue();
                $alertPoint = $worksheet->getCell('E'.$row->getRowIndex())->getValue();
                $taxAmount = $worksheet->getCell('F'.$row->getRowIndex())->getValue();
                $costPrice = $worksheet->getCell('G'.$row->getRowIndex())->getValue();
                $retailPrice = $worksheet->getCell('H'.$row->getRowIndex())->getValue();
                $totalCostValue = $worksheet->getCell('I'.$row->getRowIndex())->getValue();
                $totalRetailValue = $worksheet->getCell('J'.$row->getRowIndex())->getValue();

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
                      'total_retail_value' => is_null($totalRetailValue) ? '' : $totalRetailValue
                    ]
                  );
            }
        }

    }


    protected function updateTimelyProductId() {
        $seeds = DB::select('SELECT * FROM stock_level_xlsx_import;');

        foreach ($seeds as $seed) {
            $product = Product::where('display_name', $seed->product_name)->first();

            if(is_null($product)) {
                echo $seed->product_name . ' not matched' . PHP_EOL;
            } else {
                echo 'updating ' . $seed->product_name . ' with ' . $seed->timely_product_id . PHP_EOL;
                $product->timely_product_id = $seed->timely_product_id;
                $product->save();
            }
        }
    }

    private function getTimelyProductIndex($url)
    {
        $array = explode('/', $url);

        return ($array[count($array)-1]);
    }
}
