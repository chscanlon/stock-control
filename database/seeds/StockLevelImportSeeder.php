<?php

use Illuminate\Database\Seeder;

class StockLevelImportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->loadData();
    }

    protected function loadData()
    {
        $rowCount = DB::table('stock_level_import')->count();
        echo $rowCount . ' records in stock_level_import table' . PHP_EOL;

        $deleted = DB::delete('delete from stock_level_import');
        echo $deleted . ' rows deleted from stock_level_import table' . PHP_EOL;

        $query = "LOAD DATA LOCAL INFILE 'E:/Dev/laravel-stock/database/StockLevels.csv'
              INTO TABLE stock_level_import
              FIELDS TERMINATED BY ','
              OPTIONALLY ENCLOSED BY '\"'
              LINES TERMINATED BY '\\n'
              IGNORE 4 LINES";

        DB::connection()->getpdo()->exec($query);

        echo 'New file has been loaded to the stock_level_import table' . PHP_EOL;
        $rowCount = DB::table('stock_level_import')->count();
        echo $rowCount . ' records in stock_level_import table' . PHP_EOL;
    }
}
