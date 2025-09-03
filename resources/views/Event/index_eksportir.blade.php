@extends('header2')
@section('content')
    <style>
        body {
            font-family: Arial;
        }

        /* Style the tab */
        .tab {
            overflow: hidden;
            border: 1px solid #ccc;
            background-color: #f1f1f1;
        }

        /* Style the buttons inside the tab */
        .tab button {
            background-color: inherit;
            float: left;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 8px 10px;
            transition: 0.3s;
            font-size: 17px;
        }

        /* Change background color of buttons on hover */
        .tab button:hover {
            background-color: #ddd;
        }

        /* Create an active/current tablink class */
        .tab button.active {
            background-color: #ccc;
        }

        /* Style the tab content */
        .tabcontent {
            display: none;
            padding: 6px 12px;
            border: 1px solid #ccc;
            border-top: none;
        }

        .table th {
            color: white;
            text-align: center;
        }

    </style>
    {{-- <div class="container-fluid mt--6"> --}}
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header border-bottom">
                    <h3 class="mb-0">List Event Exporter</h3>
                </div>
                <div class="card-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block" style="text-align: center">
                            {{-- <button type="button" class="close" data-dismiss="alert">×</button> --}}
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-block" style="text-align: center">
                            {{-- <button type="button" class="close" data-dismiss="alert">×</button> --}}
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table id="tableexd" class="table table-striped table-hover">
                            <thead class="text-white" style="background-color: #6B7BD6;">
                                <th width="5">No</th>
                                <th>Event Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                {{-- <th>Event Comodity</th> --}}
                                <th width="50">Action</th>
                            </thead>
                            <tbody>
                                @foreach ($e_detail as $key => $ed)
                                    <?php $status = StatusJoin($ed->id, $id_user); ?>
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $ed->event_name_en }}</td>
                                        <td>{{ getTanggalIndo($ed->start_date) }}</td>
                                        <td>{{ getTanggalIndo($ed->end_date) }}</td>
                                        {{-- <td>{{getEventComodity($ed->event_comodity)}}</td> --}}
                                        <td>
                                            <a href="{{ url('/') }}/event/show_detail/{{ $ed->id }}"
                                                class="btn btn-primary" title="Join"><i class="fa fa-plus"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#tableexd').DataTable( {
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