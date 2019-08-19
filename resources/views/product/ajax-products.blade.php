<table id="ajax-products-datatable" class="display" style="width:100%">
    <thead>
        <tr>
            {{-- <th>Use</th>
            <th>Supplier</th> --}}
            <th>Product Usage</th>
            <th>Product Range</th>
            <th>Display Name</th>
            <th>Supplier Sequence</th>
        </tr>
    </thead>
</table>

@push('scripts')
<script>
    $(document).ready(function() {

        $('#ajax-products-datatable').DataTable({
            serverSide: true,
            processing: true,
            ajax: "{{ route('api.products.index') }}",
            columns: [{
                    data: 'product_usage'
                },
                {
                    data: 'product_range'
                },
                {
                    data: 'display_name'
                },
                {
                    data: 'supplier_sequence'
                }
            ],
        });
    });
</script>
@endpush

</table>
