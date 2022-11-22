@extends('admin.layouts.app')
@section('title')
    dashboard
@endsection
@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
@endpush
@push('style')
    <style>
#form-check-radio-default {
  margin-left: 5px;
}
    </style>
@endpush
@section('page_name')
    Category
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <button class="btn btn-rounded btn-md btn-success show-modal float-right veiwbutton "
                            data-url="{{ route('attendance.create') }}">Create New Attendance</button>
                    </div>

                    <div class="card-body">
                        <table id="example" class="table table-bordered table-responsive">
                            <thead>

                                <tr>
                                    <th style="width: 2%"><input type="checkbox" class="main_checkbox" name="main_checkbox">
                                    </th>
                                    <th>Employee Name</th>
                                    <th>Date</th>
                                    <th>Clock In</th>
                                    <th>Clock Out</th>
                                    <th>Action
                                        <button type="button" class="btn btn-sm btn-danger d-none deleteAllbtn">Delete All</button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src=" https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
@endpush
@push('scripts')
    <script>
        let datatable = $('#example').DataTable({
            "autoWidth": false,
            processing: true,
            serverSide: true,
            ajax: @json(route('attendance.index')),
            columns: [{
                    data: 'checkbox',
                    name: 'checkbox',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'employee_id',
                    name: 'employee_id'
                },
                {
                    data: 'date',
                    name: 'date'
                },
                {
                    data: 'clock_in',
                    name: 'clock_in'
                },
                {
                    data: 'clock_out',
                    name: 'clock_out'
                },

                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });



        $(document).on('click', '.deleteAllbtn', function() {
            var checked_id = [];
            $('input[name="checkbox"]:checked').each(function() {
                checked_id.push($(this).data('id'));
            });
            $.ajax({
                type: "get",
                url: @json(route('attendance.delete_all')),
                data: {
                    checked_id: checked_id
                },
                dataType: "html",
                success: function(response) {
                    console.log(response);
                    $('.view-modal').html(response).modal('show');
                }
            });
        });
    </script>
@endpush
