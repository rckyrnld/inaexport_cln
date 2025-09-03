{{-- @include('header') --}}
@extends('header2')
@section('content')
<style type="text/css">
  th {
    text-align: center;
  }

  td {
    color: black;
  }

  #tambah {
    background-color: #1a9cf9;
    color: white;
    white-space: pre;
  }

  #tambah:hover {
    background-color: #148de4;
  }

  #export {
    background-color: #28bd4a;
    color: white;
    white-space: pre;
  }

  #export:hover {
    background-color: #08b32e;
  }
</style>
<!-- Page content -->
  <div class="row">
    <div class="col">
      <div class="card">
        <div class="card-header border-bottom">
          <h3 class="mb-0">List Annual Sales</h3>
        </div>
        <div class="card-body pl-0 pr-0">
          <div class="table-responsive">

            <table id="tablesales" class="table table-striped table-hover">
                <thead class="text-white" style="background-color: #C4C4C4;">
                <tr>
                    <th>No</th>
                    <th>
                        Year
                    </th>
                    <th>
                        <center>Value (USD)</center>
                    </th>
                    <th>
                        <center>Percent (%)</center>
                    </th>
                    <th>
                        <center>Export Value (USD)</center>
                    </th>
                    <th>
                        <center>Action</center>
                    </th>
                </tr>
                </thead>

            </table>
            <br>
            <a style="color: white" href="{{ url('eksportir/listeksportir/'.$id) }}"
               class="btn btn-danger pull-right"><i style="color: white"></i>
                Back
            </a>
        </div>
        </div>
      </div>
    </div>
  </div>
 @include('footer')
 <script>
    $(function () {
        $('#tablesales').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('eksportir/sales_getdata_admin/'.$id) }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'tahun', name: 'tahun'},
                {data: 'nilai', name: 'nilai'},
                {data: 'nilai_persen', name: 'nilai_persen'},
                {data: 'nilai_ekspor', name: 'nilai_ekspor'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            "language": {
              "paginate": {
                "previous": "<i class='fa fa-angle-left'/></>",
                "next": "<i class='fa fa-angle-right'/></>"
              }
            }
        });
    });
</script>
@endsection
