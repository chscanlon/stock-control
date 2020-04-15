{{-- MODAL --}}
<div x-show="open" class="fixed bottom-0 inset-x-0 px-4 pb-4 sm:inset-0 sm:flex sm:items-center sm:justify-center">
  <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity">
    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
  </div>

  <div x-show="open" x-transition:enter="ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
    class=" rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
    <div class="bg-gray-50  shadow overflow-hidden sm:rounded-lg">

      <div class="px-4 py-5 bg-gray-100 border-b border-gray-200 sm:px-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
          {{ $displayName }}
        </h3>
      </div>

      <div class="m-4">

        <div class=" mt-4 flex justify-between">

          <div class="mr-2">
            <label for="supplier" class="pl-2 block text-sm leading-5 text-gray-500 font-medium">Supplier</label>
            <input aria-label="Supplier" id="supplier" class="form-input block w-full pl-2 sm:text-sm sm:leading-5"
              placeholder="supplier" value="{{ $supplier }}" />
          </div>

          <div class="ml-2">
            <label for="Order Name" class="pl-2 block text-sm leading-5 text-gray-500 font-medium">Order Name</label>
            <input aria-label="Order Name" id="orderName" class="form-input block w-full pl-2 sm:text-sm sm:leading-5"
              placeholder="Order Name" value="{{ $orderName }}" />
          </div>

        </div>

        <div class=" mt-4 flex justify-left items-center">
          <div class="mr-2">
            <label for="productRange" class="pl-2 block text-sm leading-5 text-gray-500 font-medium">Product
              Range</label>
            <input aria-label="Product Range" id="productRange"
              class="form-input block w-full pl-2 sm:text-sm sm:leading-5" placeholder="Product Range"
              value="{{ $productRange }}" />
          </div>

          <div class="ml-6">
            <label class="pl-2 inline-flex text-sm text-gray-500 font-medium">
              <input type="checkbox" class="form-checkbox pl-2 sm:text-sm sm:leading-5" {{ $isDiscontinued }}>
              <span class="ml-2">Item Discontinued</span>
            </label>
          </div>

        </div>

        <div class=" mt-4 flex justify-between items-center">

          <div class="mr-2">
            <label for="supplierSequence" class="pl-2 block text-sm leading-5 text-gray-500 font-medium">Supplier Sort
              Sequence</label>
            <input aria-label="Supplier Sort Sequence" id="supplierSequence"
              class="form-input block w-full pl-2 sm:text-sm sm:leading-5" placeholder="Supplier Sort Sequence"
              value="{{ $supplierSequence }}" />
          </div>


          <div class="ml-2">
            <label for="barcode" class="pl-2 block text-sm leading-5 text-gray-500 font-medium">Barcode</label>
            <input aria-label="barcode" id="barcode" class="form-input block pl-2 bg-gray-100 sm:text-sm sm:leading-5"
              disabled value="{{ $barcode }}" />
          </div>

        </div>

      </div>


    </div>

    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
      <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
        <button @click="open = false;" type="button"
          class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-red-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red transition ease-in-out duration-150 sm:text-sm sm:leading-5">
          Deactivate
        </button>
      </span>
      <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
        <button @click="open = false;" type="button"
          class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline transition ease-in-out duration-150 sm:text-sm sm:leading-5">
          Cancel
        </button>
      </span>
    </div>
  </div>
</div>