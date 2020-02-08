<table id="ajax-products-datatable" class="display" style="width:100%">
    <thead>
        <tr>
            {{-- <th>Use</th>
            <th>Supplier</th> --}}
            <th>Supplier</th>
            <th>Product Usage</th>
            <th>Product Range</th>
            <th>Display Name</th>
            <th>Max Stock</th>
            <th>Current Stock</th>
            <th></th>
        </tr>
    </thead>
    <thead>
        <tr>
            <td>
                <select data-column="0" class="form-control filter-select">
                  <option value="">Supplier...</option>
                  @foreach ($suppliers as $supplier)
                    <option value="{{$supplier}}">{{$supplier}}</option>
                  @endforeach
                </select>
            </td>            <td>
                <select data-column="1" class="form-control filter-select">
                  <option value="">Usage...</option>
                  @foreach ($productUses as $productUse)
                    <option value="{{$productUse}}">{{$productUse}}</option>
                  @endforeach
                </select>
            </td>
            <td>
                <select data-column="2" class="form-control filter-select">
                  <option value="">Range...</option>
                  @foreach ($productRanges as $productRange)
                    <option value="{{$productRange}}">{{$productRange}}</option>
                  @endforeach
                </select>
            </td>
            <td>
                <input placeholder="Search..." , class="filter-input" , data-column="3">
            </td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </thead>
    <tbody></tbody>

</table>

@push('scripts')
<script>
    $(document).ready(function() {

        var table = $('#ajax-products-datatable').DataTable({
            serverSide: true,
            processing: true,
            ajax: "{{ route('api.products.index') }}",
            columns: [{
                    'data': 'supplier',
                    'orderable':false

                },
                {
                    'data': 'product_usage',
                    'orderable':false

                },
                {
                    'data': 'product_range',
                    'orderable':false

                },
                {
                    'data': 'display_name',
                    'orderable':false

                },
                {
                    'data': 'current_max_stock',
                },
                {
                    'data': 'current_stock_available',
                    'orderable':false
                },
                {
                    'data': '',
                    'orderable':false
                },
            ],
            columnDefs: [{
              render: function(data, type, row){
                return '<a class="btn btn-xs btn-info" href=/{{request()->segment(1)}}/' + row['id'] + '>Show</a>';
              },
              targets: 6
            }],
            dom: 'ltip',
            pageLength: 10,
            lengthMenu: [10, 20, 50, 100],
        });

        $('.filter-input').keyup(function() {
            table.column($(this).data('column'))
                .search($(this).val())
                .draw();
        });
        
        $('.filter-select').change(function() {
            table.column($(this).data('column'))
                .search($(this).val())
                .draw();
        });

    });
</script>
@endpush

</table>
