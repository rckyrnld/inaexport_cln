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
        background-color: #148de4
    }

    #export {
        background-color: #28bd4a;
        color: white;
        white-space: pre;
    }

    #export:hover {
        background-color: #08b32e
    }

    .backround-yoga {
        background-color: #87b94f;
        color: white;
        font-weight: bold;
    }
</style>
<!-- Page content -->
<div class="row">
    <div class="col">
        <h3 style="color:white;">Exportir Report</h3>
        <div id="accordion">
            <!-- product -->
            <div class="card" style="margin-top: 75px;">
                <div class="card-header" id="headingOne">
                    <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne" style="color: #000; font-size: 15px;">
                            <b>Product</b>
                        </button>
                    </h5>
                </div>

                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab" style="overflow-x: auto;">

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
                                        <th>
                                            <center>Color</center>
                                        </th>
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
                    </div>
                </div>
            </div>
            <!-- anual sales -->
            <div class="card">
                <div class="card-header" id="headingTwo">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" style="color: #000; font-size: 15px;">
                            <b>Annual Sales</b>
                        </button>
                    </h5>
                </div>
                <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion">
                    <div class="card-body">
                        <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab" style="overflow-x: auto;">

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
                    </div>
                </div>
            </div>
            <!-- brand  -->
            <div class="card">
                <div class="card-header" id="headingThree">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="flas" aria-controls="collapseThree" style="color: #000; font-size: 15px;">
                            <b>Brand</b>
                        </button>
                    </h5>
                </div>
                <div id="collapseThree" class="collapse show" aria-labelledby="headingThree" data-parent="#accordion">
                    <div class="card-body">
                        <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab" style="overflow-x: auto;">
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
                    </div>
                </div>
            </div>
            <!-- country  -->
            <div class="card">
                <div class="card-header" id="headingfour">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsefour" aria-expanded="flas" aria-controls="collapsefour" style="color: #000; font-size: 15px;">
                            <b>Country</b>
                        </button>
                    </h5>
                </div>
                <div id="collapsefour" class="collapse show" aria-labelledby="headingfour" data-parent="#accordion">
                    <div class="card-body">
                        <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab" style="overflow-x: auto;">
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
                    </div>
                </div>
            </div>
            <!-- Production Capacity -->
            <div class="card">
                <div class="card-header" id="headingfive">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsefive" aria-expanded="flas" aria-controls="collapsefive" style="color: #000; font-size: 15px;">
                            <b>Production Capacity</b>
                        </button>
                    </h5>
                </div>
                <div id="collapsefive" class="collapse show" aria-labelledby="headingfive" data-parent="#accordion">
                    <div class="card-body">
                        <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab" style="overflow-x: auto;">
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
                    </div>
                </div>
            </div>
            <!-- Export Destination -->
            <div class="card">
                <div class="card-header" id="headingsix">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsesix" aria-expanded="flas" aria-controls="collapsesix" style="color: #000; font-size: 15px;">
                            <b>Export Destination</b>
                        </button>
                    </h5>
                </div>
                <div id="collapsesix" class="collapse show" aria-labelledby="headingsix" data-parent="#accordion">
                    <div class="card-body">
                        <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab" style="overflow-x: auto;">
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
                    </div>
                </div>
            </div>
            <!-- Port of Loading -->
            <div class="card">
                <div class="card-header" id="headinseven">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseseven" aria-expanded="flas" aria-controls="collapseseven" style="color: #000; font-size: 15px;">
                            <b>Port of Loading</b>
                        </button>
                    </h5>
                </div>
                <div id="collapseseven" class="collapse show" aria-labelledby="headinseven" data-parent="#accordion">
                    <div class="card-body">
                        <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab" style="overflow-x: auto;">
                            <table id="tablelanding" class="table table-striped table-hover">
                                <thead class="text-white" style="background-color: #C4C4C4;">
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
                    </div>
                </div>
            </div>
            <!-- Exhibition -->
            <div class="card">
                <div class="card-header" id="headingeight">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseeight" aria-expanded="flas" aria-controls="collapseeight" style="color: #000; font-size: 15px;">
                            <b>Exhibition</b>
                        </button>
                    </h5>
                </div>
                <div id="collapseeight" class="collapse show" aria-labelledby="headingeight" data-parent="#accordion">
                    <div class="card-body">
                        <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab" style="overflow-x: auto;">
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
                    </div>
                </div>
            </div>
            <!-- Capacity Utilization -->
            <div class="card">
                <div class="card-header" id="headingnine">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseniine" aria-expanded="flas" aria-controls="collapseniine" style="color: #000; font-size: 15px;">
                            <b>Capacity Utilization</b>
                        </button>
                    </h5>
                </div>
                <div id="collapseniine" class="collapse show" aria-labelledby="headingnine" data-parent="#accordion">
                    <div class="card-body">
                        <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab" style="overflow-x: auto;">
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
                    </div>
                </div>
            </div>
            <!-- Raw Material -->
            <div class="card">
                <div class="card-header" id="headingten">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseten" aria-expanded="flas" aria-controls="collapseten" style="color: #000; font-size: 15px;">
                            <b>Raw Material</b>
                        </button>
                    </h5>
                </div>
                <div id="collapseten" class="collapse show" aria-labelledby="headingten" data-parent="#accordion">
                    <div class="card-body">
                        <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab" style="overflow-x: auto;">
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
                    </div>
                </div>
            </div>
            <!-- Labor -->
            <div class="card">
                <div class="card-header" id="headingeleven">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseeleven" aria-expanded="flas" aria-controls="collapseeleven" style="color: #000; font-size: 15px;">
                            <b>Labor</b>
                        </button>
                    </h5>
                </div>
                <div id="collapseeleven" class="collapse show" aria-labelledby="headingeleven" data-parent="#accordion">
                    <div class="card-body">
                        <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab" style="overflow-x: auto;">
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
                    </div>
                </div>
            </div>
            <!-- Consultant -->
            <div class="card">
                <div class="card-header" id="headingelev">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapselev" aria-expanded="flas" aria-controls="collapselev" style="color: #000; font-size: 15px;">
                            <b>Consultant</b>
                        </button>
                    </h5>
                </div>
                <div id="collapselev" class="collapse show" aria-labelledby="headingelev" data-parent="#accordion">
                    <div class="card-body">
                        <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab" style="overflow-x: auto;">
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
                    </div>
                </div>
            </div>
            <!-- Training -->
            <div class="card">
                <div class="card-header" id="headingtwel">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsetwel" aria-expanded="flas" aria-controls="collapsetwel" style="color: #000; font-size: 15px;">
                            <b>Training</b>
                        </button>
                    </h5>
                </div>
                <div id="collapsetwel" class="collapse show" aria-labelledby="headingtwel" data-parent="#accordion">
                    <div class="card-body">
                        <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab" style="overflow-x: auto;">
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
                    </div>
                </div>
            </div>
            <!-- Tax -->
            <div class="card">
                <div class="card-header" id="headingTax">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTax" aria-expanded="flas" aria-controls="collapseTax" style="color: #000; font-size: 15px;">
                        <b>Tax</b>
                        </button>
                    </h5>
                </div>
                <div id="collapseTax" class="collapse show" aria-labelledby="headingTax" data-parent="#accordion">
                    <div class="card-body">
                        <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab" style="overflow-x: auto;">
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
                    </div>
                </div>
            </div>
            <!-- Contact -->
            <div class="card">
                <div class="card-header" id="headingContact">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseContact" aria-expanded="flas" aria-controls="collapseContact" style="color: #000; font-size: 15px;">
                        <b>Contact</b>
                        </button>
                    </h5>
                </div>
                <div id="collapseContact" class="collapse show" aria-labelledby="headingContact" data-parent="#accordion">
                    <div class="card-body">
                        <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab" style="overflow-x: auto;">
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
                    </div>
                </div>
            </div>
            <!-- Service -->
            <div class="card">
                <div class="card-header" id="headingService">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseService" aria-expanded="flas" aria-controls="collapseService" style="color: #000; font-size: 15px;">
                        <b>Service</b>
                        </button>
                    </h5>
                </div>
                <div id="collapseService" class="collapse show" aria-labelledby="headingService" data-parent="#accordion">
                    <div class="card-body">
                        <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab" style="overflow-x: auto;">
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
</div>
<script type="text/javascript">
    $(function() {
        $(".alert").slideDown(300).delay(1000).slideUp(300);
        $('#table').DataTable({
            "ordering": false,
            processing: true,
            serverSide: true,
            ajax: "{{ route('service.getData', $id) }}",
            columns: [{
                    data: 'nama_en',
                    name: 'nama_en'
                },
                {
                    data: 'bidang_en',
                    name: 'bidang_en'
                },
                {
                    data: 'skill_en',
                    name: 'skill_en'
                },
                {
                    data: 'pengalaman_en',
                    name: 'pengalaman_en'
                },
                {
                    data: 'link',
                    name: 'link'
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
            ajax: "{{ url('front_end/data-brand/'.$id) }}",
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
            ajax: "{{ route('datatables.eksproduct_admin', $id) }}",
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
                {
                    data: 'color_en',
                    name: 'color_en'
                },
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
@include('footer')
@endsection