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
                    <h3 class="mb-0">Suplier Report</h3>
                </div>
                
                <div class="card-body">
                    <div class="card-body">
                        <a class="btn btn-success" href="annual_sales/cetak"
                            style="color: white; margin-top:-20px; margin-left:-10px"><i class="fa fa-download"></i>&nbsp; Export Excel
                        </a>
                        <div class="col-md-3" style="float: right; margin-top:-20px">
                            <form action="{{url('/')}}/eksportir/admin/search" method="POST" role="search">
                                {{ csrf_field() }}
                                <div class="input-group">
                                    <input style="border-top-left-radius: 15px; border-bottom-left-radius:15px;" type="text" class="form-control" name="q"
                                        placeholder="Search Company..." autocomplete="off">
                                        <button style="font-weight:bold; background-color: #ffe300; color: #1d7bff; border-top-right-radius: 15px; border-bottom-right-radius:15px; margin-right:-20px"  type="submit" class="btn btn-default">
                                            <span class="glyphicon glyphicon-search"></span>
                                            Search
                                        </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!--exporter report start -->
                    <div class="row shop_wrapper">
                        @foreach($pesan as $eks)
                            <div class="col-lg-4 col-md-6 col-12 ">
                                <div class="single_product mt-3 cardreport" style="padding-bottom: 0px; margin-bottom: 10px;">
                                    <div class="product_content grid_content" style="margin-top: 0px;">
                                        <div style="height: 70px; margin-top:20px; margin-left:15px; margin-right:15px">
                                            <center>
                                                <b>{{$eks->company}},{{$eks->nmbadanusaha}}</b>
                                            </center>
                                            <hr>
                                        </div>
                                        <div class="eksporter-product" style="overflow-y: auto;">
                                            <div class="list-group" style="font-size: 12px;height: 180px;">
                                                <table border="0" style="width: 100%;">
                                                    <tr valign="top">
                                                        <td >
                                                            Alamat
                                                        </td>
                                                        <td style="padding-left: 15px;">
                                                            {{$eks->addres}}
                                                        </td>
                                                        
                                                    </tr>
                                                    {{-- <tr>
                                                        <td>
                                                            Provinsi
                                                        </td>
                                                        <td style="padding-left: 15px;">
                                                            {{$eks->province_en}}
                                                        </td>
                                                    </tr> --}}
                                                    <tr>
                                                        <td>
                                                            E-mail
                                                        </td>
                                                        <td style="padding-left: 15px;">
                                                            {{$eks->email}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            PIC Name
                                                        </td>
                                                        <td style="padding-left: 15px;">
                                                            <?php 
                                                            $namapicnya = '';
                                                            $no = 0;
                                                            $datapic = DB::table('itdp_contact_eks')->where('id_itdp_profil_eks' , $eks->id)->get();
                                                            if(count($datapic) > 0  ){
                                                                foreach($datapic as $namapic){
                                                                    if($no == 0){
                                                                        $namapicnya .=  $namapic->name;
                                                                        }else{
                                                                        $namapicnya .= ', ' . $namapic->name;
                                                                    }
                                                                    $no++;
                                                                }
                                                            }
                                                            ?>
                                                            {{$namapicnya}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            PIC Telephone
                                                        </td>
                                                        <td style="padding-left: 15px;">
                                                            <?php 
                                                            $telppicnya = '';
                                                            $no2 = 0;

                                                            $datapic2 = DB::table('itdp_contact_eks')->where('id_itdp_profil_eks' , $eks->id)->get();
                                                            if(count($datapic2) > 0  ){
                                                                foreach($datapic2 as $telppic){
                                                                    if($no2 == 0){
                                                                        $telppicnya .=  $telppic->phone;
                                                                    }else{
                                                                        $telppicnya .= ', ' . $telppic->phone;
                                                                    }
                                                                    $no2++;
                                                                }
                                                            }
                                                            ?>
                                                            {{$telppicnya}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Verify Date
                                                        </td>
                                                        <td style="padding-left: 15px;">
                                                            {{$eks->verified_at}}
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="eksporter-detail " style="border-top: 1px solid #DDEFFD; padding: 4%;">
                                            <center>
                                                {{-- <a href="{{url('front_end/list_perusahaan/view/' . $param = $eks->id_user . '-' . getCompanyName($eks->id_user))}}" class="btn btneksportir cardreport"  target="_blank"
                                                    style="border-radius: 15px; background-color: #ffe300; color:#1d7bff; font-size : 14px; font-weight : bold;
                                                    width : 150 px;">View Profile</a>
                                                </a> --}}
                                               
                                                <a href="{{url('eksportir/listeksportir/' . $eks->id)}}" class="btn cardreport" 
                                                    style="border-radius: 10px; background-color: #ffe300; color:#1d7bff; font-size : 13px; font-weight : bold;
                                                    width : 80 px;">Detail</a>
                                                </a>
                                                 
                                                <a href="{{url('br_importir_add/suplaier/' . $eks->id_user)}}" class="btn cardreport" 
                                                    style="border-radius: 10px; background-color: #ffe300; color:#1d7bff; font-size : 13px; font-weight : bold;
                                                    width : 80 px;">Add Inquiry</a>
                                                </a>

                                                <a target="_blank" href="{{url('/front_end/listeksportir/cetakpdf/'.$eks->id)}}" class="btn btn-success" >
                                                    <i  class="fa fa-download"></i>
                                                </a>
                                               
                                            </center>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!--exporter report end -->
                </div>

                @if($copesan > 12)
                    <div class="pagination justify-content-center">
                        {{ $pesan->links('vendor.pagination.bootstrap-4') }}
                        {{ $pesan->total() == 0 ? Lang::get('frontend.event_zoom.no_result') : '' }}
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