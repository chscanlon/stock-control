{{-- MODAL --}}
<div x-show="open" class="fixed bottom-0 inset-x-0 px-4 pb-4 sm:inset-0 sm:flex sm:items-center sm:justify-center">

  <div
    x-show="open"
    x-transition:enter="ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 transition-opacity"
  >

    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>

  </div>

  <div
    x-show="open"
    x-transition:enter="ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
    x-transition:leave="ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
    class=" rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">

    <div class="bg-gray-50 shadow overflow-hidden sm:rounded-lg">

      <div class="px-4 py-5 bg-indigo-900 border-b border-gray-200 sm:px-6">
        <div class="text-lg leading-6 font-medium text-gray-100">
          {{ $displayName }}
        </div>
      </div>

      <div class="m-4">

        <div class=" mt-4 flex justify-between">

          <div class="mr-2">
            <label for="supplier" class="pl-1 pb-1 block text-sm text-gray-500 font-medium">Supplier</label>
            <input
              aria-label="Supplier"
              id="supplier"
              class="form-input block w-full pl-2 sm:text-sm sm:leading-5"
              placeholder="supplier"
              wire:model.lazy="supplier"
              value="{{ $supplier }}"
            />
          </div>

          <div class="ml-2">
            <label for="orderName" class="pl-1 pb-1 block text-sm text-gray-500 font-medium">Order Name</label>
            <input 
                aria-label="Order Name"
                id="orderName"
                class="form-input block w-full pl-2 sm:text-sm sm:leading-5"
                placeholder="Order Name"
                wire:model.lazy="orderName"
                value="{{ $orderName }}"
            />
          </div>

        </div>

        <div class=" mt-4 flex justify-left items-center">

          <div class="mr-2">
            <label for="productRangeDropdown" class="pl-1 pb-1 block text-sm text-gray-500 font-medium">Product Range</label>
            <select
              aria-label="Product Range"
              id="productRangeDropdown"
              class="form-select block w-full pl-2 sm:text-sm sm:leading-5"
              wire:model="productRange"
            >
              @foreach ($productRangeArray as $key => $value)
                <option value="{{ $value }}">
                  {{ $value }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="ml-6">
            <label class="pl-2 inline-flex text-sm text-gray-500 font-medium">
              <input
                type="checkbox"
                class="form-checkbox pl-2 sm:text-sm sm:leading-5"
                wire:model="discontinued"
              />
              <span class="ml-2">Item Discontinued</span>
            </label>
          </div>

        </div>

        <div class=" mt-4 flex justify-between items-center">

          <div class="mr-2">
            <label for="supplierSequence" class="pl-1 pb-1 block text-sm text-gray-500 font-medium">Supplier Sort Sequence</label>
            <input
              aria-label="Supplier Sort Sequence"
              id="supplierSequence"
              class="form-input block w-full pl-2 sm:text-sm sm:leading-5"
              placeholder="Supplier Sort Sequence"
              wire:model.lazy="supplierSequence"
              value="{{ $supplierSequence }}"
            />
          </div>

          <div class="ml-2">
            <label for="barcode" class="pl-1 pb-1 block text-sm text-gray-500 font-medium">Barcode</label>
            <input
              aria-label="barcode"
              id="barcode"
              class="form-input block pl-2 bg-gray-100 sm:text-sm sm:leading-5"
              disabled
              value="{{ $barcode }}"
            />
          </div>

        </div>

        <div class=" mt-4 flex justify-between items-center">

          <div class="mr-2">
            <label for="availableStock" class="pl-1 pb-1 block text-sm text-gray-500 font-medium">Available
              Stock</label>
            <input
              aria-label="Available Stock"
              id="availableStock"
              class="form-input block pl-2 bg-gray-100 sm:text-sm sm:leading-5"
              disabled
              value="{{ $availableStock }}"
            />
          </div>

        </div>

        <div class=" mt-4 flex justify-between items-center">

          <div class="mr-2">
            <label for="restockLimit" class="pl-1 pb-1 block text-sm text-gray-500 font-medium">Restock Limit</label>
            <input
              aria-label="Restock Limit"
              id="restockLimit"
              class="form-input block w-full pl-2 sm:text-sm sm:leading-5"
              placeholder="Restock Limit"
              wire:model.lazy="restockLimit"
              value="{{ $restockLimit }}"
            />
          </div>

          <div class="ml-2">
            <label for="timelyRestockLimit" class="pl-1 pb-1 block text-sm text-gray-500 font-medium">Timely Restock Limit</label>
            <input
              aria-label="Timely Restock Limit"
              id="timelyRestockLimit"
              class="form-input block pl-2 bg-gray-100 sm:text-sm sm:leading-5"
              disabled
              value="{{ $timelyRestockLimit }}"
            />
          </div>

        </div>

      </div>

    </div>

    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">

      <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
        <button
          @click="open = false;"
          type="button"
          class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2
                    bg-indigo-900 text-base font-medium text-white shadow-sm
                    hover:bg-indigo-800
                    focus:outline-none focus:border-blue-500 focus:shadow-outline-blue
                    transition ease-in-out duration-150 sm:text-sm sm:leading-5"
        >
          Close
        </button>
      </span>

      @if ($productDirty === 'true')
      <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
        <button
          wire:click="saveProduct"
          type="button"
          class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2
                    bg-red-700 text-base font-medium text-white shadow-sm
                    hover:bg-red-500
                    focus:outline-none focus:border-blue-400 focus:shadow-outline-blue
                    transition ease-in-out duration-150 sm:text-sm sm:leading-5"
        >
          Save
        </button>
      </span>

      <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
        <button
        wire:click="resetProduct"
          type="button"
          class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2
                    bg-red-700 text-base font-medium text-white shadow-sm
                    hover:bg-red-500
                    focus:outline-none focus:border-blue-400 focus:shadow-outline-blue
                    transition ease-in-out duration-150 sm:text-sm sm:leading-5"
        >
          Reset
        </button>
      </span>
      @endif

    </div>
  </div>
</div>