<div x-data="{ open: false }">
    <table class="mx-auto table-auto border">
        <thead>
            <tr class="text-left">
                <th class="p-2 border-r uppercase tracking-wide text-sm font-bold text-gray-500">
                    <a wire:click.prevent.="sortBy('id')" role="button" href="#">
                        Id
                        @include('partials.sort-icon', ['field' => 'id'])
                </th>
                <th class="p-2 border-r uppercase tracking-wide text-sm font-bold text-gray-500">Supplier</th>
                <th class="p-2 border-r uppercase tracking-wide text-sm font-bold text-gray-500">Product Range</th>
                <th class="p-2 border-r uppercase tracking-wide text-sm font-bold text-gray-500">
                    <a wire:click.prevent.="sortBy('display_name')" role="button" href="#">
                        Display Name
                        @include('partials.sort-icon', ['field' => 'display_name'])
                    </a>

                </th>
                <th class="p-2 border-r uppercase tracking-wide text-sm font-bold text-gray-500 text-center">
                    <a wire:click.prevent.="sortBy('supplier_sequence')" role="button" href="#">
                        Supplier<br />Sequence
                        @include('partials.sort-icon', ['field' => 'supplier_sequence'])
                    </a>
                </th>
                <th class="p-2 border-r uppercase tracking-wide text-sm font-bold text-gray-500 text-center">
                    Stock<br />Available
                </th>
                <th class="p-2 border-r uppercase tracking-wide text-sm font-bold text-gray-500 text-center">
                    Restock<br />Limit</th>
                <th class="p-2 border-r"></th>
            </tr>
            <tr>
                <td class="border-r"></td>
                <td class="border-r">
                    <select name="supplierDropdown" wire:model="filterSupplier"
                        class="border shadow px-2 py-1 bg-white rounded text-sm">
                        @foreach($selectSupplier as $key => $value)
                        <option value={{ $key }}>{{ $value }}</option>
                        @endforeach
                    </select>
                </td>
                <td class="border-r">
                    <select name="rangeDropdown" wire:model="filterRange"
                        class="border shadow px-2 py-1 bg-white rounded text-sm">
                        @foreach($selectRange as $key => $value)
                        <option value={{ $key }}>{{ $value }}</option>
                        @endforeach
                    </select>
                </td>
                <td class="border-r"><input class="my-2 ml-1 mr-4 px-2 py-1 border rounded text-sm"
                        wire:model="searchName" type="text" placeholder="Search product name..." /></td>
                <td class="border-r"></td>
                <td class="border-r"></td>
                <td class="border-r"></td>
                <td class="border-r"></td>
            </tr>

        </thead>

        <tbody>

            @foreach($products as $product)
            @if ($product->discontinued)
            <tr class="bg-gray-200">
            @else
            <tr>
            @endif
                <td class="p-1 pl-2 border">{{ $product->id }}</td>
                <td class="p-1 pl-2 border">{{ $product->supplier }}</td>
                <td class="p-1 pl-2 border">{{ $product->product_range }}</td>
                <td class="p-1 pl-2 border">{{ $product->display_name }}</td>
                <td class="p-1 pl-2 border">
                    {{ $product->supplier_sequence }}
                </td>
                <td class="p-1 pl-2 border text-center">{{ $product->current_stock_available }}</td>
                <td class="p-1 border">
                    <div class="flex justify-around items-center">
                        <button class=" p-1 border border-green-900 bg-green-100 rounded"
                            wire:click="incrementRestockLimit('{{$product->id}}')">+</button>
                        {{ $product->current_max_stock }}
                        <button class=" p-1 border border-red-900 bg-red-100 rounded"
                            wire:click="decrementRestockLimit('{{$product->id}}')">-</button>
                    </div>

                </td>
                <td>
                    <button @click="open = true;" wire:click="$emit('loadProduct', '{{$product->id}}')" type="button"
                        class="inline-flex justify-center w-full rounded-md border border-transparent px-3 py-1
                                     bg-indigo-900 text-base font-medium text-white shadow-sm
                                    hover:bg-indigo-800
                                    focus:outline-none focus:border-gray-700 focus:shadow-outline-gray
                                    transition ease-in-out duration-150 sm:text-sm sm:leading-5">
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