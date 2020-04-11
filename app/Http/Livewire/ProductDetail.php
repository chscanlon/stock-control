<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Product;

class ProductDetail extends Component
{
    public $productId;
    public $displayName;
    public $supplier;
    public $productRange;
    public $supplierSequence;


    protected $listeners = ['editProduct'];

    public function editProduct($productId)
    {
        $product = Product::find($productId);
        $this->displayName = $product->display_name;
        $this->supplier = $product->supplier;
        $this->productRange = $product->product_range;
        $this->supplierSequence = $product->supplier_sequence;
    }

    public function render()
    {
        return view('livewire.product-detail')->with('displayName', $this->displayName);
    }
}
