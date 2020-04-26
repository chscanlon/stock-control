<?php

namespace App\Http\Livewire;

use App\Product;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

class ProductDetail extends Component
{
    public $productId;
    public $displayName;
    public $orderName;
    public $supplier;
    public $supplierSequence;
    public $barcode;
    public $discontinued;
    public $availableStock;
    public $restockLimit;
    public $timelyRestockLimit;
    public $productRange;

    public $productRangeArray;
    public $productDirty;

    protected $listeners = ['loadProduct'];

    public function mount()
    {
        //Log::info('in mount function');
        $this->productDirty = 'false';
        $this->productRangeArray = Product::pluck('product_range')->unique()->sort()->all();
        array_unshift($this->productRangeArray, 'Filter by product range...');
    }

    public function updated($name, $value)
    {
        $this->productDirty = 'true';
    }

    public function loadProduct($productId)
    {
        //Log::info('in loadProduct function');
        $product = Product::find($productId);
        $this->productId = $product->id;
        $this->displayName = $product->display_name;
        $this->orderName = $product->order_name;
        $this->supplier = $product->supplier;
        $this->productRange = $product->product_range;
        $this->supplierSequence = $product->supplier_sequence;
        $this->barcode = $product->barcode;
        $this->discontinued = $product->discontinued;
        $this->availableStock = $product->current_stock_available;
        $this->restockLimit = $product->current_max_stock;
        $this->timelyRestockLimit = $product->reorder_alert_threshold;
        $this->productDirty = 'false';
    }

    public function saveProduct()
    {
        Product::where('id', $this->productId)
                ->update([
                    'supplier' => $this->supplier,
                    'order_name' => $this->orderName,
                    'product_range' => $this->productRange,
                    'supplier_sequence' => $this->supplierSequence,
                    'discontinued' => $this->discontinued,
                    'current_max_stock' => $this->restockLimit,
                ]);
        $this->emitUp('productUpdated');
        $this->loadProduct($this->productId);
    }

    public function resetProduct()
    {
        $this->loadProduct($this->productId);
    }

    public function render()
    {
        Log::info('in render function');
        return view('livewire.product-detail');
    }
}
