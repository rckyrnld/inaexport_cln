@extends('header2')
@section('content')
    <?php
    if (!empty($res->group_name)) {
        $group_name = $res->group_name;
    } else {
        $group_name = '';
    }
    ?>
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
                    <h3 class="mb-0">List Group</h3>
                </div>
                <div class="card-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block" style="text-align: center">
                            {{-- <button type="button" class="close" data-dismiss="alert">×</button> --}}
                            <strong>{{ $message }}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-block" style="text-align: center">
                            {{-- <button type="button" class="close" data-dismiss="alert">×</button> --}}
                            <strong>{{ $message }}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    {{ Form::open(['url' => $url, 'method' => 'post']) }}
                    <div class="col-md-12">
                        <div class="form-group row">
                            {!! Form::label('group_name', $label, ['class' => 'col-sm-2 col-form-label ']) !!}
                            <div class="col-sm-4">
                                {{ csrf_field() }}

                                {!! Form::text('group_name', $group_name, ['class' => 'form-control']) !!}

                            </div>

                            <div class="col-md-1">
                                {!! Form::submit(' Save', ['class' => 'btn btn-dark']) !!}
                            </div>
                        </div>
                    </div>
                    {{ Form::close() }}
                    <div class="table-responsive">
                        <table id="example1" class="table table-striped table-hover" data-plugin="dataTable">
                            <thead class="text-white" style="background-color: #6B7BD6;">
                                <tr>
                                    <th width="25">No</th>
                                    <th>Group</th>
                                    <th width="50">
                                        <center>Action</center>
                                    </th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($group as $no => $res)
                                    <tr>
                                        <td>{{ $no + 1 }}</td>
                                        <td>{{ $res->group_name }}</td>
                                        <td>
                                            <center>
                                                <div class="btn-group">
                                                    <a class="btn btn-sm btn-warning open-dialog" data-toggle="modal"
                                                        data-target="#myModalGroup" data-id="{{ $res->id_group }}"
                                                        data-group-name="{{ $res->group_name }}"><i
                                                            class="fa fa-edit text-white"></i></a>

                                                    <a href="{{ url('/group_delete/' . $res->id_group) }}"
                                                        class="btn btn-sm btn-danger"><i
                                                            class="fa fa-trash text-white"></i></a>
                                                </div>
                                            </center>
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
    <div class="modal fade" id="myModalGroup" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="" id="form-update" method="post" name="newMail" class="form-horizontal">
                    {{ csrf_field() }}
                    <div class="modal-header" style="background-color:#2e899e; color:white;">
                        <h2>Update Group Name</h2>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body mb-0 pb-0">
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label">Group Name</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="group_name" id="group_name">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer pt-0 mt-0">
                        <div class="text-right pr-2">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary btn-md">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('footer')
    <script>
        $(document).on("click", ".open-dialog", function() {
            var id_group = $(this).data('id');
            var group_name = $(this).data('group-name');
            $('#form-update').attr('action', '{{ url('/') }}/group_update/' + id_group + '');
            $("#myModalGroup #group_name").val(group_name);
        });
    </script>
@endsection
