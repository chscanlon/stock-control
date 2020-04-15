<div class="flex flex-col">
  <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">


    <table class="w-3/4 mx-auto shadow-md">
      <thead class="bg-gray-50 text-left text-xs leading-4 text-gray-500 uppercase tracking-wider">
        <tr>
          <th class="px-6 py-3 border-b border-gray-200 font-medium">
            Supplier
          </th>
          <th class="px-6 py-3 border-b border-gray-200 font-medium">
            Display Name
          </th>
          <th class="px-6 py-3 border-b border-gray-200 font-medium">
            Stock Available
          </th>
          <th class="px-6 py-3 border-b border-gray-200 font-medium">
            Restock Limit
          </th>
          <th class="px-6 py-3 border-b border-gray-200 font-medium">
            Order Amount
          </th>
          {{-- <th class="px-6 py-3 border-b border-gray-200 bg-gray-50"></th> --}}
        </tr>
      </thead>

      <tbody class="bg-white">
        @foreach ($orderItems as $orderItem)
        <tr>
          <td class="px-6 py-3 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">
            {{$orderItem->supplier}}
          </td>
          <td class="px-6 py-3 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">
            {{$orderItem->display_name}}
          </td>
          <td class="px-6 py-3 whitespace-no-wrap border-b border-gray-200 text-center text-sm leading-5 text-gray-500">
            {{$orderItem->available_stock}}
          </td>
          <td class="px-6 py-3 whitespace-no-wrap border-b border-gray-200 text-center text-sm leading-5 text-gray-500">
            {{$orderItem->max_stock}}
          </td>
          <td class="px-6 py-3 whitespace-no-wrap border-b border-gray-200 text-center text-sm leading-5 text-gray-500">
            {{$orderItem->order_amount}}
          </td>
        </tr>
        @endforeach


      </tbody>

      <tfoot class="bg-gray-50">
        <tr>
          <td class=" px-6 py-3 text-sm italic" colspan="5">Showing products {{ $orderItems->firstItem() }} to
            {{ $orderItems->lastItem() }} of the {{ $orderItems->total() }} products in the order</td>
        </tr>
      </tfoot>

    </table>

    <div class=" mt-6 mb-10">{{ $orderItems->links('vendor.pagination.livewire-default') }}</div>

  </div>

</div>