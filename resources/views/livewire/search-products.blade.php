<div x-data="{ open: false }" >
    <table class="mx-auto table-auto border">
        <thead>
            <tr class="text-left">
                <th class="p-2 border-r">Range</th>
                <th class="p-2 border-r">Name</th>
                <th class="p-2 border-r">Max Stock</th>
                <th class="p-2 border-r">Stock Available</th>
                <th class="p-2 border-r"></th>
            </tr>
            <tr>
                <td class="border-r"><input class="my-2 ml-1 mr-4 p-2 border" wire:model="searchRange" type="text" placeholder="Search product range..."/></td>
                <td class="border-r"><input class="my-2 ml-1 mr-4 p-2 border" wire:model="searchName" type="text" placeholder="Search product name..."/></td>
                <td class="border-r"></td>
                <td class="border-r"></td>
                <td class="border-r"></td>
            </tr>

        </thead>

        <tbody>

            @foreach($products as $product)
            <tr>
                <td class="p-1 pl-2 border">{{ $product->product_range }}</td>
                <td class="p-1 pl-2 border">{{ $product->display_name }}</td>
                <td class="p-1 pl-2 border">
                    <button class=" mr-2 px-2 py-1 border bg-green-200" wire:click="increment('{{$product->id}}')">+</button>
                    {{ $product->current_max_stock }}
                    <button class=" ml-2 px-2 py-1 border bg-red-200" wire:click="decrement('{{$product->id}}')">-</button>
                </td>
                <td class="p-1 pl-2 border">{{ $product->current_stock_available }}</td>
                <td>
                    <button @click="open = true;" wire:click="$emit('editProduct', '{{$product->id}}')" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-red-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                    Edit
                    </button>
                </td>
            </tr>
            @endforeach

        </tbody>
        <tfoot>
            <tr>
                <td class="p-2 text-sm italic" colspan="5">{{ $products->total() }} records returned</td>
            </tr>
        </tfoot>
    </table>

    <div class="mt-4">{{ $products->links('vendor.pagination.livewire-default') }}</div>

    @livewire('product-detail')

   
</div>
