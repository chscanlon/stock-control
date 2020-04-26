<?php

namespace App\Http\Livewire;

use App\Product;
use Livewire\Component;
use Livewire\WithPagination;

class SearchProducts extends Component
{
    public $filterSupplier = 0;
    public $filterRange    = 0;
    public $searchName     = '';
    public $selectSupplier;
    public $selectRange;
    public $sortField = 'id';
    public $sortAsc   = true;
    private $products;

    protected $listeners = ['productUpdated'];


    public function mount()
    {
        $this->selectRange = Product::pluck('product_range')->unique()->sort()->all();
        array_unshift($this->selectRange, 'Filter by product range...');

        $this->selectSupplier = Product::pluck('supplier')->unique()->sort()->all();
        array_unshift($this->selectSupplier, 'Filter by supplier...');

    }

    use WithPagination;

    public function incrementRestockLimit($id)
    {
        Product::find($id)->increment('current_max_stock');
    }

    public function decrementRestockLimit($id)
    {
        Product::find($id)->decrement('current_max_stock');
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    public function productUpdated()
    {
        $this->render();
    }

    public function render()
    {
        return view('livewire.search-products', [
            'products' => Product::where([
                ['timely_product_status', 'active'],
                ['display_name', 'LIKE', "%{$this->searchName}%"],
            ])
                ->when($this->filterRange > 0, function ($query) {
                    return $query->where('product_range', $this->selectRange[$this->filterRange]);
                })
                ->when($this->filterSupplier > 0, function ($query) {
                    return $query->where('supplier', $this->selectSupplier[$this->filterSupplier]);
                })
                ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                ->paginate(10),
        ]);
    }
}
