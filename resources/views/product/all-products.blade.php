<table id="all-products-datatable" class="display" style="width:100%">
    <thead>
        <tr>
            <th>Use</th>
            <th>Supplier</th>
            <th>Product Range</th>
            <th>Display Name</th>
            <th>Max Stock</th>
            <th>Available Stock</th>
        </tr>
    </thead>
</table>

@push('scripts')
<script>
    $(document).ready(function() {

        $('#all-products-datatable').DataTable({
            serverSide: true,
            processing: true,
            responsive: true,
            ajax: "{{ route('all_products_data') }}",
            columns: [{
                    name: 'product_usage'
                },
                {
                    name: 'supplier'
                },
                {
                    name: 'product_range'
                },
                {
                    name: 'display_name'
                },
                {
                    name: 'current_max_stock',
                    searchable: false
                },
                {
                    name: 'current_stock_available',
                    searchable: false
                }
            ],
        });
    });
</script>
@endpush

</table>
