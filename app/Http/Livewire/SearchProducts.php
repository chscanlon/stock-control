<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Product;

class SearchProducts extends Component
{
    public $searchRange = '';
    public $searchName = '';

    use WithPagination;

    public function increment($id)
    {
        Product::find($id)->increment('current_max_stock');
    }

    public function decrement($id)
    {
        Product::find($id)->decrement('current_max_stock');
    }

    public function render()
    {
        return view('livewire.search-products', [
            'products' => Product::where([
                            ['timely_product_status', 'active'],
                            ['product_range', 'LIKE', "{$this->searchRange}%"],
                            ['display_name', 'LIKE', "{$this->searchName}%"],
            ])->paginate(15),
        ]
    );
    }
}
