@extends('header2')
@section('content')
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,300" rel="stylesheet" type="text/css">
    <style>
        body {
            font-family: 'Open Sans';
            font-style: normal;
        }

        .table th {
            color: white;
            text-align: center;
        }

    </style>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header border-bottom">
                    <h3 class="mb-0">Event Place</h3>
                </div>

                <div class="card-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block fade show" role="alert">
                            <strong>{{ $message }}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-block fade show" role="alert">
                            <strong>{{ $message }}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <a href="{{ route('master.event_place.create') }}" class="btn btn-primary ml-5"><i
                            class="fa fa-plus-circle"></i>&nbsp;Add</a><br /><br />

                    <table id="table" class="table table-striped table-hover" data-plugin="dataTable">
                        <thead class="text-white" style="background-color: #6B7BD6">
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>Website</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            $('.alert').slideDown(300).delay(1000).slideUp(300);
            $('#table').DataTable({
                "ordering": false,
                processing: true,
                serverSide: true,
                scrollX: true,
                ajax: {
                    "url": '{!! route('master.event_place.getData') !!}',
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        _token: '{{ csrf_token() }}'
                    }
                },
                "columns": [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        width: 5,
                        className: "text-center"
                    }, {
                        data: 'name_en',
                    },
                    {
                        data: 'address_en'
                    },
                    {
                        data: 'phone'
                    },
                    {
                        data: 'mobile'
                    },
                    {
                        data: 'email_en'
                    },
                    {
                        data: 'website'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        width: 40,
                        className: "text-center"
                    }
                ],
                "language": {
                    "paginate": {
                        "previous": "<i class='fa fa-angle-left'/></>",
                        "next": "<i class='fa fa-angle-right'/></>"
                    }
                }
            });
        })
    </script>

    @include('footer')
@endsection
