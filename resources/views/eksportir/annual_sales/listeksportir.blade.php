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
        padding: 4px 12px;
        border: 1px solid #ccc;
        border-top: none;
    }

    /* .nav-item a{
        width:150px;
    } */
</style>
{{-- <div class="container-fluid mt--6"> --}}
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header border-bottom">
                <h3 class="mb-0">List Eksportir</h3>
            </div>
            <div class="card-body">
                <div class="col" style="margin-top:-10px">
                    <div class="row" >
                        @foreach ($data as $eks)
                       
                            <a target="_blank" href="{{url('/front_end/listeksportir/cetakpdfnew/'.$eks->id)}}" class="btn btn-success" >
                                <i  class="fa fa-download"></i> Export PDF 
                            </a>
                      
                        @endforeach
                    </div>
                <br>

                <div class="nav-wrapper">
                    <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-icons-text-1-tab" data-toggle="tab" href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true">Product</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-2-tab" data-toggle="tab" href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">Annual Sales</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-3-tab" data-toggle="tab" href="#tabs-icons-text-3" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false">Brand</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-4-tab" data-toggle="tab" href="#tabs-icons-text-4" role="tab" aria-controls="tabs-icons-text-4" aria-selected="false">Country Patent Brand</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-5-tab" data-toggle="tab" href="#tabs-icons-text-5" role="tab" aria-controls="tabs-icons-text-5" aria-selected="false">Production Capacity</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-6-tab" data-toggle="tab" href="#tabs-icons-text-6" role="tab" aria-controls="tabs-icons-text-6" aria-selected="false">Export Destination</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-7-tab" data-toggle="tab" href="#tabs-icons-text-7" role="tab" aria-controls="tabs-icons-text-7" aria-selected="false">Port of Loading</a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-8-tab" data-toggle="tab" href="#tabs-icons-text-8" role="tab" aria-controls="tabs-icons-text-8" aria-selected="false">Exhibition</a>
                        </li>
                       
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-9-tab" data-toggle="tab" href="#tabs-icons-text-9" role="tab" aria-controls="tabs-icons-text-9" aria-selected="false">Capacity Utilization</a>
                        </li>
                        
                        <li class="nav-item  mt-2">
                            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-10-tab" data-toggle="tab" href="#tabs-icons-text-10" role="tab" aria-controls="tabs-icons-text-10" aria-selected="false">Raw Material</a>
                        </li>
                        <li class="nav-item  mt-2">
                            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-11-tab" data-toggle="tab" href="#tabs-icons-text-11" role="tab" aria-controls="tabs-icons-text-11" aria-selected="false">Labor</a>
                        </li>
                        <li class="nav-item  mt-2">
                            
                            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-12-tab" data-toggle="tab" href="#tabs-icons-text-12" role="tab" aria-controls="tabs-icons-text-12" aria-selected="false">Consultant</a>
                        </li>
                        <li class="nav-item  mt-2">
                            
                            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-13-tab" data-toggle="tab" href="#tabs-icons-text-13" role="tab" aria-controls="tabs-icons-text-13" aria-selected="false">Training</a>
                        </li>
                        <li class="nav-item  mt-2">
                            
                            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-14-tab" data-toggle="tab" href="#tabs-icons-text-14" role="tab" aria-controls="tabs-icons-text-14" aria-selected="false">Tax</a>
                        </li>
                        <li class="nav-item  mt-2">
                            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-15-tab" data-toggle="tab" href="#tabs-icons-text-15" role="tab" aria-controls="tabs-icons-text-15" aria-selected="false">Contact</a>
                        </li>
                        <li class="nav-item  mt-2">
                            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-16-tab" data-toggle="tab" href="#tabs-icons-text-16" role="tab" aria-controls="tabs-icons-text-16" aria-selected="false">Service</a>
                        </li>
                  
                    </ul>
               
                </div>

                <!--Product-->
                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab" style="overflow-x: auto;">
                            <h3>Product</h3>
                                <table id="table_product" class="table table-striped table-hover">
                                    <thead class="text-white" style="background-color: #C4C4C4;">
                                        <tr>
                                            <th>No</th>
                                            <th>
                                                <center>Code</center>
                                            </th>
                                            <th>
                                                <center>Product Name</center>
                                            </th>
                                            {{-- <th>
                                                <center>Color</center>
                                            </th> --}}
                                            <th>
                                                <center>Size</center>
                                            </th>
                                            <th>
                                                <center>Raw Material</center>
                                            </th>
                                            <th>
                                                <center>Capacity</center>
                                            </th>
                                            <th>
                                                <center>Price (USD)</center>
                                            </th>
                                            <th>
                                                <center>Description Product</center>
                                            </th>
                                            <th>
                                                <center>Status</center>
                                            </th>
                                            <th>
                                                <center>Information</center>
                                            </th>
                                            <th>
                                                <center>Action</center>
                                            </th>
                                        </tr>
                                    </thead>

                                </table>
                            </div>

                        <!-- Annual Sales -->
                            <div class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab" style="overflow-x: auto;">
                                <h3>Annual Sales</h3>
                                <table id="tableeksportir" class="table table-striped table-hover">
                                    <thead class="text-white" style="background-color: #C4C4C4;">
                                        <tr role="row">
                                            <th>No</th>
                                            <th>
                                                <center>Company</center>
                                            </th>
                                            <th>
                                                <center>Address</center>
                                            </th>
                                            <th>
                                                <center>Province</center>
                                            </th>
                                            <th>
                                                <center>Email</center>
                                            </th>
                                            <th>
                                                <center>PIC Name</center>
                                            </th>
                                            <th>
                                                <center>PIC Telephone</center>
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

                        <!--Brand-->
                            <div class="tab-pane fade" id="tabs-icons-text-3" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">
                            <h3>Brand</h3>
                                <table id="tablebrands" class="table table-striped table-hover">
                                    <thead class="text-white" style="background-color: #C4C4C4;">
                                        <tr>
                                            <th>No</th>
                                            <th>
                                                Brand
                                            </th>
                                            <th>
                                                <center>Meaning Of Brand</center>
                                            </th>
                                            <th>
                                                <center>Month</center>
                                            </th>
                                            <th>
                                                <center>Year</center>
                                            </th>
                                            <th>
                                                <center>Copyright Number</center>
                                            </th>
                                            <th>
                                                <center>Action</center>
                                            </th>
                                        </tr>
                                    </thead>

                                </table>
                            </div>

                        <!--Country Patent Brand-->
                            <div class="tab-pane fade" id="tabs-icons-text-4" role="tabpanel" aria-labelledby="tabs-icons-text-4-tab">
                                <h3>Country Patent Brand</h3>
                                <table id="tablecountry" class="table table-striped table-hover">
                                    <thead class="text-white" style="background-color: #C4C4C4;">
                                        <tr>
                                            <th>No</th>
                                            <th>
                                                Brand
                                            </th>
                                            <th>
                                                <center>Country</center>
                                            </th>
                                            <th>
                                                <center>Month</center>
                                            </th>
                                            <th>
                                                <center>Year</center>
                                            </th>
                                            <th>
                                                <center>Action</center>
                                            </th>
                                        </tr>
                                    </thead>

                                </table>
                            </div>

                        <!--Production Capacity-->
                            <div class="tab-pane fade" id="tabs-icons-text-5" role="tabpanel" aria-labelledby="tabs-icons-text-5-tab">
                                <h3>Production Capacity</h3>
                                <table id="tableprocap" class="table table-striped table-hover">
                                    <thead class="text-white" style="background-color: #C4C4C4;">
                                        <tr>
                                            <th>
                                                <center>No</center>
                                            </th>
                                            <th>
                                                <center>
                                                    Year
                                                </center>
                                            </th>
                                            <th>
                                                <center>Own Production (%)</center>
                                            </th>
                                            <th>
                                                <center>Outside Production (%)</center>
                                            </th>
                                            <th>
                                                <center>Action</center>
                                            </th>
                                        </tr>
                                    </thead>

                                </table>
                            </div>

                        <!--Export Destination-->
                            <div class="tab-pane fade" id="tabs-icons-text-6" role="tabpanel" aria-labelledby="tabs-icons-text-6-tab">
                                <h3>Export Destination</h3>
                                <table id="tableexdes" class="table table-striped table-hover">
                                    <thead class="text-white" style="background-color: #C4C4C4;">
                                        <tr>
                                            <th>No</th>
                                            <th>
                                                <center>Year</center>
                                            </th>
                                            <th>
                                                <center>Country</center>
                                            </th>
                                            <th>
                                                <center>Ratio Export</center>
                                            </th>
                                            <th>
                                                <center>Action</center>
                                            </th>
                                        </tr>
                                    </thead>

                                </table>
                            </div>

                        <!--Port of Loading-->
                            <div class="tab-pane fade" id="tabs-icons-text-7" role="tabpanel" aria-labelledby="tabs-icons-text-7-tab">
                                <h3>Port of Loading</h3>
                                <table id="tablelanding" class="table table-striped table-hover">
                                    <thead class="text-white" style="background-color: #c4C4C4;">
                                        <tr>
                                            <th>No</th>
                                            <th>
                                                <center>Port</center>
                                            </th>
                                            <th>
                                                <center>Action</center>
                                            </th>
                                        </tr>
                                    </thead>

                                </table>
                            </div>

                        <!--Exhibition-->
                            <div class="tab-pane fade" id="tabs-icons-text-8" role="tabpanel" aria-labelledby="tabs-icons-text-8-tab">
                                <h3>Exhibition</h3>
                                <table id="tableexhib" class="table table-striped table-hover">
                                    <thead class="text-white" style="background-color: #C4C4C4;">
                                        <tr>
                                            <th>
                                                <center>No</center>
                                            </th>
                                            <th>
                                                <center> Exhibition</center>
                                            </th>
                                            <th>
                                                <center>Booth Area</center>
                                            </th>
                                            <th>
                                                <center>Value Contract</center>
                                            </th>
                                            <th>
                                                <center>Subsidi Djpen</center>
                                            </th>
                                            <th>
                                                <center>Action</center>
                                            </th>
                                        </tr>
                                    </thead>

                                </table>
                            </div>

                        <!--Capacity Utilization-->
                            <div class="tab-pane fade" id="tabs-icons-text-9" role="tabpanel" aria-labelledby="tabs-icons-text-9-tab">
                                <h3>Capacity Utilization<h3>
                                <table id="tabelcapacity" class="table table-striped table-hover">
                                    <thead class="text-white" style="background-color: #C4C4C4;">
                                        <tr>
                                            <th>No</th>
                                            <th>
                                                <center>Year</center>
                                            </th>
                                            <th>
                                                <center>Used Capacity</center>
                                            </th>
                                            <th>
                                                <center>Action</center>
                                            </th>
                                        </tr>
                                    </thead>

                                </table>
                            </div>

                        <!--Raw Material-->
                            <div class="tab-pane fade" id="tabs-icons-text-10" role="tabpanel" aria-labelledby="tabs-icons-text-10-tab">
                                <h3>Raw Material</h3>
                                <table id="tableraw" class="table table-striped table-hover">
                                    <thead class="text-white" style="background-color: #C4C4C4;">
                                        <tr>
                                            <th>No</th>
                                            <th>
                                                <center>Year</center>
                                            </th>
                                            <th>
                                                <center>From Domestic</center>
                                            </th>
                                            <th>
                                                <center>Overseas</center>
                                            </th>
                                            <th>
                                                <center>Value From Domestic</center>
                                            </th>
                                            <th>
                                                <center>Action</center>
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>

                        <!--Labor-->
                            <div class="tab-pane fade" id="tabs-icons-text-11" role="tabpanel" aria-labelledby="tabs-icons-text-11-tab">
                                <h3>Labor</h3>
                                <table id="tablelabor" class="table table-striped table-hover">
                                    <thead class="text-white" style="background-color: #C4C4C4;">
                                        <tr>
                                            <th>No</th>
                                            <th>
                                                <center>Year</center>
                                            </th>
                                            <th>
                                                <center>Local Employee</center>
                                            </th>
                                            <th>
                                                <center>Foreign Worker</center>
                                            </th>
                                            <th>
                                                <center>Action</center>
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>

                        <!--Consultant-->
                            <div class="tab-pane fade" id="tabs-icons-text-12" role="tabpanel" aria-labelledby="tabs-icons-text-12-tab">
                                <h3>Consultant</h3>
                                <table id="tableconsultan" class="table table-striped table-hover">
                                    <thead class="text-white" style="background-color: #C4C4C4;">
                                        <tr>
                                            <th>No</th>
                                            <th>
                                                <center>Name</center>
                                            </th>
                                            <th>
                                                <center>Position</center>
                                            </th>
                                            <th>
                                                <center>Phone</center>
                                            </th>
                                            <th>
                                                <center>Problem</center>
                                            </th>
                                            <th>
                                                <center>Solution</center>
                                            </th>
                                            <th>
                                                <center>Action</center>
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>

                        <!--Training-->
                            <div class="tab-pane fade" id="tabs-icons-text-13" role="tabpanel" aria-labelledby="tabs-icons-text-13-tab">
                                <h3>Training</h3>
                                <table id="tabletraining" class="table table-striped table-hover">
                                    <thead class="text-white" style="background-color: #C4C4C4;">
                                        <tr>
                                            <th>No</th>
                                            <th>
                                                <center>Training</center>
                                            </th>
                                            <th>
                                                <center>Organizer</center>
                                            </th>
                                            <th>
                                                <center>Start Date</center>
                                            </th>
                                            <th>
                                                <center>Due Date</center>
                                            </th>
                                            <th>
                                                <center>Action</center>
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>

                        <!--Tax-->
                            <div class="tab-pane fade" id="tabs-icons-text-14" role="tabpanel" aria-labelledby="tabs-icons-text-14-tab">
                                <h3>Tax</h3>
                                <table id="tabletaxes" class="table table-striped table-hover">
                                    <thead class="text-white" style="background-color: #C4C4C4;">
                                        <tr>
                                            <th>No</th>
                                            <th>
                                                <center>Year</center>
                                            </th>
                                            <th>
                                                <center>Report PPH</center>
                                            </th>
                                            <th>
                                                <center>Report PPN</center>
                                            </th>
                                            <th>
                                                <center>Report Pasal 21</center>
                                            </th>
                                            <th>
                                                <center>Total PPH</center>
                                            </th>
                                            <th>
                                                <center>Action</center>
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>

                        <!--Contact-->
                            <div class="tab-pane fade" id="tabs-icons-text-15" role="tabpanel" aria-labelledby="tabs-icons-text-15-tab">
                                <h3>Contact</h3>
                                <table id="tablecontact" class="table table-striped table-hover">
                                    <thead class="text-white" style="background-color: #C4C4C4;">
                                        <tr>
                                            <th>
                                                <center>No</center>
                                            </th>
                                            <th>
                                                <center>
                                                    Name
                                                </center>
                                            </th>
                                            <th>
                                                <center>Position</center>
                                            </th>
                                            <th>
                                                <center>Phone</center>
                                            </th>
                                            <th>
                                                <center>Action</center>
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>

                        <!--Service-->
                            <div class="tab-pane fade" id="tabs-icons-text-16" role="tabpanel" aria-labelledby="tabs-icons-text-16-tab">
                                <h3>Service</h3>
                                <table id="table" class="table table-striped table-hover" data-plugin="dataTable">
                                    <thead class="text-white" style="background-color: #C4C4C4;">
                                        <tr>
                                            <th>Name</th>
                                            <th width="15%">Field of Works</th>
                                            <th width="15%">Skills</th>
                                            <th width="30%">Experiences (DN/LN)</th>
                                            <th width="10%">Links</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>

@include('footer')

<div class="copyright text-center  text-lg-left  text-muted">
    <a style="float:right; margin-right:40px; margin-top:-45px" href="https://inaexport.id/" class="font-weight ml-1" target="_blank">inaexport.go.id</a>
</div>

<script type="text/javascript">
    $(function() {
        $(".alert").slideDown(300).delay(1000).slideUp(300);
        $('#table').DataTable({
            "ordering": false,
            processing: true,
            serverSide: true,
            ajax: "{{ route('service.getData', $id) }}",
            columns: [
                {data: 'nama_en', name: 'nama_en'},
                {data: 'bidang_en', name: 'bidang_en'},
                {data: 'skill_en', name: 'skill_en'},
                {data: 'pengalaman_en', name: 'pengalaman_en'},
                {data: 'link', name: 'link'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            "language": {
                "paginate": {
                    "previous": "<i class='fa fa-angle-left'/></>",
                    "next": "<i class='fa fa-angle-right'/></>"
                }
            }
        });
        $('#tablecontact').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('eksportir/contact_getdata_admin/'.$id) }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'job_title',
                    name: 'job_title'
                },
                {
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            "language": {
                "paginate": {
                    "previous": "<i class='fa fa-angle-left'/></>",
                    "next": "<i class='fa fa-angle-right'/></>"
                }
            }
        });
        $('#tabletaxes').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('eksportir/taxes_getdata_admin/'.$id) }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'tahun',
                    name: 'tahun'
                },
                {
                    data: 'laporan_pph',
                    name: 'laporan_pph'
                },
                {
                    data: 'laporan_ppn',
                    name: 'laporan_ppn'
                },
                {
                    data: 'laporan_psl21',
                    name: 'laporan_psl21'
                },
                {
                    data: 'setor_pph',
                    name: 'setor_pph'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            "language": {
                "paginate": {
                    "previous": "<i class='fa fa-angle-left'/></>",
                    "next": "<i class='fa fa-angle-right'/></>"
                }
            }
        });
        $('#tabletraining').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('eksportir/training_getdata_admin/'.$id) }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'nama_training',
                    name: 'nama_training'
                },
                {
                    data: 'penyelenggara',
                    name: 'penyelenggara'
                },
                {
                    data: 'tanggal_mulai',
                    name: 'tanggal_mulai'
                },
                {
                    data: 'tanggal_selesai',
                    name: 'tanggal_selesai'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            "language": {
                "paginate": {
                    "previous": "<i class='fa fa-angle-left'/></>",
                    "next": "<i class='fa fa-angle-right'/></>"
                }
            }
        });
        $('#tableconsultan').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('eksportir/consultan_getdata_admin/'.$id) }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'nama_pegawai',
                    name: 'nama_pegawai'
                },
                {
                    data: 'jabatan',
                    name: 'jabatan'
                },
                {
                    data: 'telepon',
                    name: 'telepon'
                },
                {
                    data: 'masalah',
                    name: 'masalah'
                },
                {
                    data: 'solusi',
                    name: 'solusi'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            "language": {
                "paginate": {
                    "previous": "<i class='fa fa-angle-left'/></>",
                    "next": "<i class='fa fa-angle-right'/></>"
                }
            }
        });
        $('#tablelabor').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('/eksportir/labor_getdata_admin/'.$id) }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'tahun',
                    name: 'tahun'
                },
                {
                    data: 'lokal_orang',
                    name: 'lokal_orang'
                },
                {
                    data: 'asing_orang',
                    name: 'asing_orang'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            "language": {
                "paginate": {
                    "previous": "<i class='fa fa-angle-left'/></>",
                    "next": "<i class='fa fa-angle-right'/></>"
                }
            }
        });
        $('#tableraw').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('eksportir/rawmaterial_getdata_admin/'.$id) }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'tahun',
                    name: 'tahun'
                },
                {
                    data: 'lokal_persen',
                    name: 'lokal_persen'
                },
                {
                    data: 'impor_persen',
                    name: 'impor_persen'
                },
                {
                    data: 'nilai_impor',
                    name: 'nilai_impor'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            "language": {
                "paginate": {
                    "previous": "<i class='fa fa-angle-left'/></>",
                    "next": "<i class='fa fa-angle-right'/></>"
                }
            }
        });
        $('#tabelcapacity').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('eksportir/capulti_getdata_admin/'.$id) }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'tahun',
                    name: 'tahun'
                },
                {
                    data: 'kapasitas_terpakai_persen',
                    name: 'kapasitas_terpakai_persen'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            "language": {
                "paginate": {
                    "previous": "<i class='fa fa-angle-left'/></>",
                    "next": "<i class='fa fa-angle-right'/></>"
                }
            }
        });
        $('#tableexhib').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('eksportir/exhibition_getdata_admin/'.$id) }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'id_itdp_eks_event_profil',
                    name: 'id_itdp_eks_event_profil'
                },
                {
                    data: 'luas_boot',
                    name: 'luas_boot'
                },
                {
                    data: 'nilai_kontrak',
                    name: 'nilai_kontrak'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            "language": {
                "paginate": {
                    "previous": "<i class='fa fa-angle-left'/></>",
                    "next": "<i class='fa fa-angle-right'/></>"
                }
            }
        });
        $('#tablelanding').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('eksportir/portland_getdata_admin/'.$id) }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'name_port',
                    name: 'name_port'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            "language": {
                "paginate": {
                    "previous": "<i class='fa fa-angle-left'/></>",
                    "next": "<i class='fa fa-angle-right'/></>"
                }
            }
        });
        $('#tableexdes').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('eksportir/export_destination_getdata_admin/'.$id) }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'tahun',
                    name: 'tahun'
                },
                {
                    data: 'country',
                    name: 'country'
                },
                {
                    data: 'rasio_persen',
                    name: 'rasio_persen'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            "language": {
                "paginate": {
                    "previous": "<i class='fa fa-angle-left'/></>",
                    "next": "<i class='fa fa-angle-right'/></>"
                }
            }
        });
        $('#tableprocap').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('eksportir/product_capacity_getdata_admin/'.$id) }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'tahun',
                    name: 'tahun'
                },
                {
                    data: 'sendiri_persen',
                    name: 'sendiri_persen'
                },
                {
                    data: 'outsourcing_persen',
                    name: 'outsourcing_persen'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            "language": {
                "paginate": {
                    "previous": "<i class='fa fa-angle-left'/></>",
                    "next": "<i class='fa fa-angle-right'/></>"
                }
            }
        });
        $('#tablecountry').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('eksportir/country_patern_brand_getdata_admin/'.$id) }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'merek',
                    name: 'merek'
                },
                {
                    data: 'country',
                    name: 'country'
                },
                {
                    data: 'bulan',
                    name: 'bulan'
                },
                {
                    data: 'tahun',
                    name: 'tahun'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            "language": {
                "paginate": {
                    "previous": "<i class='fa fa-angle-left'/></>",
                    "next": "<i class='fa fa-angle-right'/></>"
                }
            }
        });
        $('#tablebrands').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('eksportir/brand_getdata_admin/'.$id) }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'merek',
                    name: 'merek'
                },
                {
                    data: 'arti_merek',
                    name: 'arti_merek'
                },
                {
                    data: 'bulan_merek',
                    name: 'bulan_merek'
                },
                {
                    data: 'tahun_merek',
                    name: 'tahun_merek'
                },
                {
                    data: 'paten_merek',
                    name: 'paten_merek'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            "language": {
                "paginate": {
                    "previous": "<i class='fa fa-angle-left'/></>",
                    "next": "<i class='fa fa-angle-right'/></>"
                }
            }
        });
        $('#table_product').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('datatables.eksproduct_admin', $id_profil) }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'code_en',
                    name: 'code_en'
                },
                {
                    data: 'prodname_en',
                    name: 'prodname_en'
                },
                // {
                //     data: 'color_en',
                //     name: 'color_en'
                // },
                {
                    data: 'size_en',
                    name: 'size_en'
                },
                {
                    data: 'raw_material_en',
                    name: 'raw_material_en'
                },
                {
                    data: 'capacity',
                    name: 'capacity'
                },
                {
                    data: 'price_usd',
                    name: 'price_usd'
                },
                {
                    data: 'product_description',
                    name: 'product_description'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'information',
                    name: 'information'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            "language": {
                "paginate": {
                    "previous": "<i class='fa fa-angle-left'/></>",
                    "next": "<i class='fa fa-angle-right'/></>"
                }
            }
        });

        $('#tableeksportir').DataTable({
            processing: true,
            serverSide: true,
            // stateSave: true,
            // bAutoWidth: false, 
            ajax: "{{ route('datatables.reporteksportir') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    width: '10%',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'company',
                    name: 'itdp_profil_eks.company',
                    width: '10%',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'addres',
                    name: 'itdp_profil_eks.addres',
                    width: '10%',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'province',
                    name: 'mst_province.province_en',
                    width: '10%',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'email',
                    name: 'itdp_company_users.email',
                    width: '10%',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'pic_name',
                    name: 'pic_name',
                    width: '10%',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'pic_telp',
                    name: 'pic_telp',
                    width: '10%',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'verify_date',
                    name: 'itdp_company_users.verified_at',
                    width: '10%',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            columnDefs: [{
                render: function(data, type, full, meta) {
                    return "<div class='text-wrap' style='width:150px'>" + data + "</div>";
                },
                targets: 2
            }],
            "language": {
                "paginate": {
                    "previous": "<i class='fa fa-angle-left'/></>",
                    "next": "<i class='fa fa-angle-right'/></>"
                }
            }
            // {data: 'f3', name: 'f3'},
            // {data: 'f4', name: 'phone'},
            // {data: 'fax', name: 'fax'},
            // scrollX:        true,
            // scrollCollapse: true,
            // aoColumns : [
            //     { sWidth: '10%' },
            //     { sWidth: '10%' },
            //     { sWidth: '10%' },
            //     { sWidth: '10%' },
            //     { sWidth: '10%' },
            //     { sWidth: '10%' },
            //     { sWidth: '10%' },
            //     { sWidth: '10%' },
            //     { sWidth: '10%' },
            // ]
            // columnDefs: [
            //     { width: '10px', targets: 0 },
            //     { width: '100px', targets: 1 },
            //     { width: '50px', targets: 2 },
            //     { width: '50px', targets: 3 },
            //     { width: '50px', targets: 4 },
            //     { width: '50px', targets: 5 },
            //     { width: '50px', targets: 6 },
            //     { width: '50px', targets: 7 },
            //     { width: '50px', targets: 8 }
            // ],
            // fixedColumns: true
        });
        $('#users-table0').DataTable({
            processing: true,
            serverSide: true,
            scrollX: 200,
            scroller: {
                loadingIndicator: true
            },
            autoWidth: true,
            ajax: "{{ url('getcsc0') }}",
            columns: [{
                    data: 'row',
                    name: 'row'
                },
                {
                    data: 'f1',
                    name: 'f1'
                },
                {
                    data: 'f4',
                    name: 'f4'
                },
                {
                    data: 'f3',
                    name: 'f3'
                },
                {
                    data: 'f2',
                    name: 'f2'
                },
                {
                    data: 'f7',
                    name: 'f7',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            columnDefs: [{
                render: function(data, type, full, meta) {
                    return "<div class='text-wrap width-200'>" + data + "</div>";
                },
                targets: 1
            }],
            "language": {
                "paginate": {
                    "previous": "<i class='fa fa-angle-left'/></>",
                    "next": "<i class='fa fa-angle-right'/></>"
                }
            }
        });

        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            scrollX: 200,
            scroller: {
                loadingIndicator: true
            },
            autoWidth: true,
            ajax: "{{ url('getcsc') }}",
            columns: [{
                    data: 'row',
                    name: 'row'
                },
                {
                    data: 'f1',
                    name: 'f1'
                },
                {
                    data: 'f4',
                    name: 'f4'
                },
                {
                    data: 'f3',
                    name: 'f3'
                },
                {
                    data: 'f2',
                    name: 'f2'
                },
                {
                    data: 'f7',
                    name: 'f7',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            columnDefs: [{
                render: function(data, type, full, meta) {
                    return "<div class='text-wrap width-200'>" + data + "</div>";
                },
                targets: 1
            }],
            "language": {
                "paginate": {
                    "previous": "<i class='fa fa-angle-left'/></>",
                    "next": "<i class='fa fa-angle-right'/></>"
                }
            }
        });
        $('#users-table3').DataTable({
            processing: true,
            serverSide: true,
            scrollX: 200,
            scroller: {
                loadingIndicator: true
            },
            autoWidth: true,
            ajax: "{{ url('getcsc3') }}",
            columns: [{
                    data: 'row',
                    name: 'row'
                },
                {
                    data: 'f1',
                    name: 'f1'
                },
                {
                    data: 'f4',
                    name: 'f4'
                },
                {
                    data: 'f3',
                    name: 'f3'
                },
                {
                    data: 'f2',
                    name: 'f2'
                },
                {
                    data: 'f7',
                    name: 'f7',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            columnDefs: [{
                render: function(data, type, full, meta) {
                    return "<div class='text-wrap width-200'>" + data + "</div>";
                },
                targets: 1
            }],
            "language": {
                "paginate": {
                    "previous": "<i class='fa fa-angle-left'/></>",
                    "next": "<i class='fa fa-angle-right'/></>"
                }
            }
        });
        $("#tabelpiliheksportir").DataTable({
            processing: true,
            orderable: false,
            scrollX: 200,
            scroller: {
                loadingIndicator: true
            },
            language: {
                processing: "Sedang memproses...",
                lengthMenu: "Tampilkan MENU entri",
                zeroRecords: "Tidak ditemukan data yang sesuai",
                emptyTable: "Tidak ada data yang tersedia pada tabel ini",
                info: "Menampilkan START sampai END dari TOTAL entri",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
                infoFiltered: "(disaring dari MAX entri keseluruhan)",
                infoPostFix: "",
                search: "Cari:",
                url: "",
                infoThousands: ".",
                loadingRecords: "Sedang memproses...",
                paginate: {
                    first: "<<",
                    last: ">>",
                    next: "Selanjutnya",
                    previous: "Sebelum"
                },
                aria: {
                    sortAscending: ": Aktifkan untuk mengurutkan kolom naik",
                    sortDescending: ": Aktifkan untuk mengurutkan kolom menurun"
                }
            },
            columnDefs: [{
                render: function(data, type, full, meta) {
                    return "<div class='text-wrap width-200'>" + data + "</div>";
                },
                targets: 1
            }],
        });
    });
</script>

@endsection


