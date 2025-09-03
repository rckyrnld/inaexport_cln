<?php // echo bcrypt('abc');die();
?>
<!-- kalo ada yang gak bisa dipencet, coba liat sharethis ini, ada settingan gdpr di nonactive aja -->
<script
src="https://platform-api.sharethis.com/js/sharethis.js#property=5e40ad0fac2cac001a00d45a&product=inline-share-buttons">
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
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

        .st-custom-button[data-network] {
            /*background-color: #9EEC46;*/
            display: inline-block;
            padding: 5px 10px;
            cursor: pointer;
            font-weight: bold;
            color: #fff;
        }

        .negara {
            display: inline;
            list-style: none;
        }

        .negara li {
            display: inline;
        }

        .negara li:after {
            content: ", ";
        }

        .negara li:last-child::after {
            content: "";
        }

        .link-email {
            text-decoration: none;
            color: #525f7f;
        }

        .cardzoom:hover {
            text-decoration: none;
            background-color: #f4f4f5;
            box-shadow: 0 0 15px rgba(194, 216, 255, 1)
        }

    </style>
    {{-- <div class="container-fluid mt--6"> --}}
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header border-bottom">
                    <h3 class="mb-0">Daftar
                        {{ $tipe == 'ln'? 'Perwakilan Perdagangan (Atdag, ITPC, KDEI, Konsuldag), KBRI dan KJRI di Luar Negeri': 'Disperindag' }}
                    </h3>
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
                    <div class="card-body">
                        <div class="col-md-4" style="float: right; margin-top:-20px">
                            <form method="GET"
                                action="{{ $tipe == 'ln' ? url('/list_perwadag', 'ln') : url('/list_perwadag', 'dn') }}"
                                id="formcari">
                                <div class="input-group flex-nowrap" style="margin-left: -20px;">
                                    <input style="border-top-left-radius: 15px; border-bottom-left-radius:15px" type="text"
                                        class="form-control"
                                        placeholder="Search {{ $tipe == 'ln' ? 'Perwadag' : 'Disperindag' }}"
                                        style="border-radius: 0px;" name="nama" value="" id="cari_perwadag">
                                    <button
                                        style="font-weight:bold; background-color: #ffe300; color: #1d7bff; border-top-right-radius: 15px; border-bottom-right-radius:15px"
                                        class="btn" type="submit" id="search">Search</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row justify-content-center col-lg-12 px-0">
                        @foreach ($perwadags as $rep)
                            <div class="col-lg-3 col-sm-6 " style="padding: 4px; margin: 16px 35px 16px 35px;">
                                <div class="card cardzoom mb--1" style="width:120%">
                                    <div class="h-25">
                                        <center>
                                            <br>
                                            <span style="font-size:1.1em;margin-top:5px"><b>
                                                    @if ($rep->name == ' ' || $rep->name == null)
                                                        )
                                                        -
                                                    @else
                                                        {{ $rep->name }}
                                                    @endif
                                                </b></span>
                                        </center>
                                    </div>
                                    <hr style="margin: .8rem" />
                                    <ul style="list-style-type:none">
                                        @if ($tipe == 'dn')
                                            <li> <i class="fa fa-flag"></i>&nbsp; {{ $rep->province_en }}
                                                {{-- - {{ $rep->city }} --}}
                                            </li>
                                        @endif
                                        <li> <i class="fas fa-building"></i> &nbsp; {{ $rep->type }}</li>
                                        @if ($tipe == 'ln')
                                            <li> <i class="fas fa-flag"></i>
                                                @php
                                                    if ($rep->country_tambahan != '') {
                                                        $countries = explode(',', $rep->country_tambahan);
                                                    } else {
                                                        $countries = [];
                                                    }
                                                    
                                                    if ($rep->country != '') {
                                                        $main_countries = explode(',', $rep->country);
                                                    } else {
                                                        $main_countries = [];
                                                    }
                                                    
                                                    $unique_countries = array_unique(array_merge($countries, $main_countries));
                                                    $merge_countries = array_filter($unique_countries, function ($value) {
                                                        return !is_null($value) && $value !== '';
                                                    });
                                                @endphp
                                                <?php
                                                ?>
                                                <ul class="negara" style="padding: 0;">
                                                    &nbsp;
                                                    @if (count($merge_countries) > 0)
                                                        @foreach ($merge_countries as $c)
                                                            <li>{{ rc_country($c) }}</li>
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </li>
                                        @endif
                                        <li> <i class="fa fa-group"></i>&nbsp; {{ $rep->nama }}</li>
                                        <li> <i class="fas fa-user-tie"></i>&nbsp; {{ $rep->kepala }}</li>
                                        <li> <i class="fas fa-phone-alt"></i>&nbsp; {{ $rep->telp }}</li>
                                        <li> <i class="fas fa-envelope"></i>&nbsp; <a href="mailto:{{ $rep->email }}"
                                                class="link-email">{{ $rep->email }}</a></li>
                                        <li> <i class="fas fa-globe"></i>&nbsp; {{ $rep->website }}</li>
                                        @if ($tipe == 'ln')
                                            <li> <i class="fa fa-clock"></i>&nbsp;
                                                <?php
                                                $localtime = '';
                                                $data = DB::table('mst_localtime')
                                                    ->where('id_country', $rep->country)
                                                    ->get();
                                                foreach ($data as $time) {
                                                    $localtime .= $time->selisih_waktu;
                                                }
                                                ?>
                                                @if ($localtime != null)
                                                    {{ date('H:i:s', strtotime("$localtime hours", time())) }}
                                                @else
                                                    -
                                                @endif
                                            </li>
                                        @endif
                                        {{-- <li> <i class="fa fa-wifi" style="color: @if (Cache::has('user-is-online-' . $rep->id)) green @else red @endif;"></i>&nbsp;
                                            @if (Cache::has('user-is-online-' . $rep->id))
                                                <span class="text-success">Online</span>
                                            @else
                                                <span class="text-danger">Offline</span>
                                            @endif
                                        </li> --}}
                                        <br>

                                    </ul>
                                    @if (!empty(Auth::user()))
                                        {{-- Perwadag dengan Dinas --}}
                                        @if (Auth::user()->id_group != 11)
                                            <div class="eksporter-detail "
                                                style="border-top: 1px solid #DDEFFD; padding: 4%;">
                                                <center>
                                                    @if (Auth::user()->id_group != 5)
                                                        {{-- Hide chat when signin as dinas --}}
                                                        <a href="{{ url('/chat_admin_eks_imp/admin/' . encrypt($rep->id) . '/' . encrypt(Auth::user()->id)) }}"
                                                            class="btn btn-success">
                                                            <i class="fa fa-comments"></i>
                                                        </a>
                                                    @endif
                                                </center>
                                            </div>
                                        @endif
                                    @else
                                        {{-- Perwadag dengan Company --}}
                                        <div class="eksporter-detail " style="border-top: 1px solid #DDEFFD; padding: 4%;">
                                            <center>
                                                <a href="{{ url('/chat_admin_eks_imp/' . encrypt($rep->id) . '/' . encrypt(Auth::guard('eksmp')->user()->id)) }}"
                                                    class="btn btn-success">
                                                    <i class="fa fa-comments"></i>
                                                </a>

                                            </center>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        <br>
                        @if ($coperwadag > 12)
                            <div class="pagination justify-content-center w-100 mt-5" style="float: center;">
                                {{ $perwadags->links('pagination::bootstrap-4') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('footer')

@endsection
