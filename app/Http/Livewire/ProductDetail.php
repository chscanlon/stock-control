<?php

namespace App\Http\Livewire;

use App\Product;
use Livewire\Component;

class ProductDetail extends Component
{
    public $productId;
    public $displayName;
    public $orderName;
    public $supplier;
    public $productRange;
    public $supplierSequence;
    public $barcode;
    public $isDiscontinued;

    protected $listeners = ['editProduct'];

    public function editProduct($productId)
    {
        $product                = Product::find($productId);
        $this->displayName      = $product->display_name;
        $this->orderName        = $product->order_name;
        $this->supplier         = $product->supplier;
        $this->productRange     = $product->product_range;
        $this->supplierSequence = $product->supplier_sequence;
        $this->barcode          = $product->barcode;
        if ($product->discontinued) {
            $this->isDiscontinued = "checked";
        }
    }

    public function render()
    {
        return view('livewire.product-detail')->with('displayName', $this->displayName);
    }
}
