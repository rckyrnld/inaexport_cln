<style>

    .list-group-item{
        background-color: #e9e9ff; 
        border: none;
    }

    .eksporter-product{
        padding: 5% 1% 5% 1%;
    }

    .eksporter-product .list-group-item{
        background-color: white;
    }

    .a-eksporter{
        text-decoration: none;
        color: black;
        height: auto;
    }

    @media only screen and (max-width: 767px) {
        .a-eksporter{
            height: auto;
        }
    }

    .a-eksporter:hover{
        text-decoration: none;
    }

    .eksporter_img{
        width: 50%;
    }

    .name-eksporter{
        font-size: 13px;
    }

    .single_product {
        padding: 10px 8px 18px 18px;
        border: 1px solid #ddd;
        border-radius: 10px;
        margin: 1px;
    }

    .btneksportir:hover{
        text-decoration: none;
        box-shadow: 0 0 15px rgba(194, 216, 255, 1)
    }


    .eksporter-product .list-group a:hover{
        background-color: #e9e9ff;
    }

    .caption-btn{
        float: right;
        margin-right: 0px;
    }

    table, th, tr, td {
        text-align: left !important;
    }
    .cardreport:hover {
        text-decoration: none;
        box-shadow: 0 0 15px rgba(194, 216, 255, 1)
    }
    .cardreport button.active {
        color: white;
    }

</style>

@extends('header2')
@section('content')

<div class="row">
    <div class="col">
            <div class="card">
                <div class="card-header border-bottom">
                    <h3 class="mb-0">Buyer Report</h3>
                </div>
                
                <div class="card-body">
                    <div class="card-body">
                        <div class="col-md-5" style="float: right; margin-top:-20px;margin-right:30px;">
                            <form action="{{url('/')}}/eksportir/buyer/admin/search" method="POST" role="search">
                                {{ csrf_field() }}
                                <div class="input-group">
                                    <input style="border-top-left-radius: 15px; border-bottom-left-radius:15px;" type="text" class="form-control" name="q"
                                        placeholder="Search buyer..." autocomplete="off" value="{{ $q }}">
                                        <button style="font-weight:bold; background-color: #ffe300; color: #1d7bff; border-top-right-radius: 15px; border-bottom-right-radius:15px; margin-right:-20px"  type="submit" class="btn btn-default">
                                            <span class="glyphicon glyphicon-search"></span>
                                            Search
                                        </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!--exporter report start -->
                    <div class="row col-lg-12">
                        @foreach($co_datanya_buyer as $buy)
                            <div class="col-lg-4 col-md-6 col-12 ">
                                <div class="single_product mt-3 cardreport" style="padding-bottom: 0px; margin-bottom: 10px;height:270px;overflow:auto;">
                                    <div class="product_content grid_content" style="margin-top: 0px;">
                                        <div style="height: 50px; margin-top:20px; margin-left:15px; margin-right:15px">
                                            <center>
                                                <b>{{$buy->company}}</b>
                                            </center>
                                            <hr>
                                        </div>
                                        <div class="eksporter-product" style="overflow-y: auto;">
                                            <div class="list-group" style="font-size: 14px;">
                                                <table border="0" style="width: 100%;">
                                                <tr valign="top">
                                                        <td >
                                                            Negara
                                                        </td>
                                                        <td style="padding-left: 15px;">
                                                            {{(isset($data_perwakilan)) ? $data_perwakilan->cn : rc_country($buy->id_mst_country)}}
                                                        </td>
                                                        
                                                    </tr>
                                                    <tr valign="top">
                                                        <td >
                                                            Alamat
                                                        </td>
                                                        <td style="padding-left: 15px;">
                                                            {{$buy->addres}}
                                                        </td>
                                                        
                                                    </tr>
                                                    {{-- <tr>
                                                        <td>
                                                            Provinsi
                                                        </td>
                                                        <td style="padding-left: 15px;">
                                                            {{$buy->province_en}}
                                                        </td>
                                                    </tr> --}}
                                                    <tr>
                                                        <td>
                                                            E-mail
                                                        </td>
                                                        <td style="padding-left: 15px;">
                                                            {{$buy->email}}
                                                        </td>
                                                    </tr>
                                                   
                                                
                                                    <tr>
                                                        <td>
                                                            Status
                                                        </td>
                                                        <td style="padding-left: 15px;">
                                                            @if($buy->status == 0)
                                                            Tidak Aktif
                                                            @else
                                                            Aktif
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!--exporter report end -->
                </div>

                @if($datanya_buyer > 12)
                    <div class="pagination justify-content-center">
                        {{ $co_datanya_buyer->links('vendor.pagination.bootstrap-4') }}
                        {{ $co_datanya_buyer->total() == 0 ? Lang::get('frontend.event_zoom.no_result') : '' }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>    
                {{-- <div class="table-responsive pt-4 pl-0 pr-0">
                    <table id="tableeksportir" class="table align-items-center table-flush" data-plugin="dataTable">
                        <thead class="thead-light">
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
    </div>
</div> --}}
<script type="text/javascript">

    // $(function () {
    //     $('#tableeksportir').DataTable({
    //         processing: true,
    //         serverSide: true,
    //         ajax: "{{ route('datatables.reporteksportir') }}",
    //         columns: [
    //             {data: 'DT_RowIndex', name: 'DT_RowIndex',width: '10%',orderable: false, searchable: false},
    //             {data: 'company', name: 'itdp_profil_eks.company',width: '10%',orderable: true, searchable: true},
    //             {data: 'addres', name: 'itdp_profil_eks.addres',width: '10%',orderable: true, searchable: true},
    //             {data: 'province', name: 'mst_province.province_en',width: '10%',orderable: true, searchable: true},
    //             {data: 'email', name: 'itdp_company_users.email',width: '10%',orderable: true, searchable: true},
    //             {data: 'pic_name', name: 'pic_name',width: '10%',orderable: false, searchable: false},
    //             {data: 'pic_telp', name: 'pic_telp',width: '10%',orderable: false, searchable: false},
    //             {data: 'verify_date', name: 'itdp_company_users.verified_at',width: '10%',orderable: true, searchable: true},  
    //             {
    //                 data: 'action', name: 'action', orderable: false, searchable: false
    //             }
    //         ],
    //         "language": {
    //                 "paginate": {
    //                     "previous": "<i class='fa fa-angle-left'/></>",
    //                     "next": "<i class='fa fa-angle-right'/></>"
    //                 }
    //             }
            
    //     });
    // });

</script>

@include('footer')
@endsection