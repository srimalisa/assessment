@extends('layouts.master')

@section('content')
<div class="d-flex mb-1">
    <div class="flex-shrink-0 me-3">
        <i class="bx bx-restaurant display-4 text-primary mt-1"></i>
    </div>
    <div class="flex-grow-1 my-0">
        <h1 class="mb-0">Order Management</h1>
        <p class="fs-4">Manage Order</p>
    </div>
</div>

<div class="w-100">
    <div class="card">
        <div class="card-body">

                <div class="table-responsive">
                    <table id="products" class="w-100 table align-middle table-striped table-nowrap table-hover mb-0">
                        <thead>
                            <tr>
                              <th scope="col">ID</th>
                              <th scope="col">Restaurant</th>
                              <th scope="col">Buyer</th>
                              <th scope="col">Delivery</th>
                              <th scope="col">Payment Status</th>
                              <th scope="col">Order Status</th>
                              <th scope="col"></th>
                            </tr>
                            <tr>
                                <th class="hasinput"><input type="text" class="form-control" placeholder="ID"></th>
                                <th class="hasinput"><input type="text" class="form-control" placeholder="Restaurant"></th>
                                <th class="hasinput"><input type="text" class="form-control" placeholder="Buyer"></th>
                                <th class="hasinput"><input type="text" class="form-control" placeholder="Delivery"></th>
                                <th class="hasinput"><input type="text" class="form-control" placeholder="Payment Status"></th>
                                <th class="hasinput"><input type="text" class="form-control" placeholder="Status"></th>
                                <th></th>
                            </tr>
                          </thead>
                        <tbody>
                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>
    <!-- end card -->
</div>


@endsection

@section('script')
<script>
$(document).ready(function() {

    $('select').select2();

    $('#products thead tr .hasinput').each(function(i)
    {
        $('input', this).on('keyup change', function()
        {
            if (table.column(i).search() !== this.value)
            {
                table
                    .column(i)
                    .search(this.value)
                    .draw();
            }
        });

        $('select', this).on('keyup change', function()
        {
            if (table.column(i).search() !== this.value)
            {
                table
                    .column(i)
                    .search(this.value)
                    .draw();
            }
        });
    });

    var table = $('#products').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: window.location.href,
        },
        columns: [
                { data: 'id', name: 'id'},
                { data: 'restaurant.name', name: 'restaurant.name'},
                { data: 'user.name', name: 'user.name'},
                { data: 'delivery_type.name', name: 'delivery_type.name'},
                { data: 'payment_stat', name: 'payment_stat'},
                { data: 'order_stat', name: 'order_stat'},
                { data: 'action'}
            ],
            orderCellsTop: true,
            "order": [[ 0, "asc" ]],
            "initComplete": function(settings, json) {

            }
    });

});

$('#products').on('click', '.btn-delete[data-remote]', function (e) {
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var url = $(this).data('remote');
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var token = localStorage.getItem('token');
            $.ajax({
            url: url,
            type: 'DELETE',
            dataType: 'json',
            headers: {
                'Authorization': 'Bearer ' + token
            },
            data: {method: '_DELETE', submit: true}
            }).always(function (data) {
                $('#products').DataTable().draw(false);
            });
        }
    })
});
</script>
@endsection
