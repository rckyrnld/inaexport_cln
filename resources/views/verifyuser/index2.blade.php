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
        /* .card {
            background: radial-gradient(circle at top left, #E0F1F3 10%, #BDF1DA);
        }
        .card-header {
            background: radial-gradient(circle at top left, #E0F1F3 10%, #BDF1DA);
        } */
    </style>
    {{-- <div class="container-fluid mt--6"> --}}
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header border-bottom">
                    <h3 class="mb-0">List Buyer</h3>
                </div>
                <div class="card-body pl-0 pr-0">
                    <div class="table-responsive">
                        <table id="users-table" class="table table-striped table-hover">
                            <thead class="text-white" style="background-color: #6B7BD6;">
                            <tr>
                                <th>No</th>
                                <th>
                                    <center>Company</center>
                                </th>
                                <th>
                                    <center>Email</center>
                                </th>
                                {{-- <th>
                                    <center>Zip Code</center>
                                </th> --}}
                                {{-- <th>
                                    <center>Telephone</center>
                                </th> --}}
                                <!-- <th>
                                    <center>Last Activity</center>
                                </th> -->
                                <th>
                                    <center>Email Confirmation</center>
                                </th>
                                <th>
                                    <center>Country</center>
                                </th>
                                <th>
                                    <center>Verify By Admin</center>
                                </th>
                                <th>
                                    <center>Verify Date</center>
                                </th>
                                <th>
                                    <center>Action</center>
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
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#2e899e; color:white;">
                    <h6>Broadcast Buying Request</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>
                <div id="isibroadcast"></div>
                <!--<div class="modal-body">
                                                                      1
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                    </div> -->
            </div>
        </div>
    </div>
    
    <script type="text/javascript">
 function ConfirmDelete()
    {
      var x = confirm("Are you sure you want to delete?");
      if (x)
          return true;
      else
        return false;
    }
    $(function () {
        $(".alert").slideDown(300).delay(1000).slideUp(300);
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('getimportir') }}",
            columns: [
                {data: 'row', name: 'row'},
                {data: 'f1', name: 'f1'},
                {data: 'f2', name: 'f2'},
                // {data: 'f3', name: 'f3'},
                // {data: 'f4', name: 'f4'},
                // {data: 'f5', name: 'f5'},
                {
					data: 'f6', name: 'f6', orderable: false, searchable: false
				},
                {
                    data: 'country', name: 'country', orderable: false
                },
				{
					data: 'f7', name: 'f7', orderable: false, searchable: false
				},
                {
                    data: 'f8', name: 'f8', orderable: false, searchable: false
                },
                {
                    data: 'action', name: 'action', orderable: false, searchable: false
                }
            ],
            
            columnDefs: [{
                render: function(data, type, full, meta) {
                    return "<div class='text-wrap width-200'>" + data + "</div>";
                },
                targets: 1
            }, { 
                        render: function(data, type, full, meta) {
                            return "<div class='text-wrap' style='width:180px'>" + data + "</div>";
                        },
                        targets: 3
            }],
            "language": {
                "paginate": {
                    "previous": "<i class='fa fa-angle-left'/></>",
                    "next": "<i class='fa fa-angle-right'/></>"
                }
            }
        });
    });
</script>
    @include('footer')

@endsection
