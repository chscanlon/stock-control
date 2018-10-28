<?php

use Illuminate\Database\Seeder;

class TestProductsSeeder extends Seeder
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
        $rowCount = DB::table('test_products')->count();
        echo $rowCount . ' records in test_products table' . PHP_EOL;

        $deleted = DB::delete('delete from test_products');
        echo $deleted . ' rows deleted from test_products table' . PHP_EOL;

        $query = "LOAD DATA LOCAL INFILE 'E:/Dev/laravel-stock/database/product_table.csv'
              INTO TABLE test_products
              FIELDS TERMINATED BY ','
              OPTIONALLY ENCLOSED BY '\"'
              LINES TERMINATED BY '\r\n'";

        DB::connection()->getpdo()->exec($query);

        echo 'New file has been loaded to the test_products table' . PHP_EOL;
        $rowCount = DB::table('test_products')->count();
        echo $rowCount . ' records in test_products table' . PHP_EOL;
    }

}
