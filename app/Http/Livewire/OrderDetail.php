<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Order;
use App\OrderItem;

class OrderDetail extends Component
{
    public $order;

    use WithPagination;


    public function mount(Order $order)
    {
        $this->order = $order;
    }


    public function render()
    {
        return view('livewire.order-detail', [
            'orderItems' => OrderItem::where('order_id', $this->order->id)->paginate(10)
        ]);
    }
}
