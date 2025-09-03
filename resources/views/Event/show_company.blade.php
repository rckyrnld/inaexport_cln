@include('header')
<div class="padding">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-divider m-0"></div>
                <div class="box-header bg-light">
                    <h5><i></i> List Company</h5>
                </div>
                <div class="box-body bg-light">
                <a class="btn btn-danger" href="{{url('/event')}}"><i class="fa fa-arrow-left"></i> Kembali</a><br><br>
                    <div class="container"><br>
                         <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a href="#link_1" data-toggle="tab" class="nav-link active">With Notification</a>
                            </li>
                            <li class="nav-item">
                                <a href="#link_2" data-toggle="tab" class="nav-link">Not With Notification</a>
                            </li>
                        </ul><br><br>

                        <div id="myTabContent1" class="tab-content">
                            <!-- link 1 -->
                            <div class="tab-pane active" id="link_1">
                                <div class="table-responsive">
                                    <table id="tableexdes" class="table  table-bordered table-striped">
                                        <thead class="text-white" style="background-color: #1089ff;">
                                        <tr>
                                            <th>No</th>
                                            <th>Company</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($list as $key => $li )
                                                <tr>
                                                    <td>{{$key+1}}</td>
                                                    <td>{{$li->untuk_nama}}</td>
                                                    <td>{{$li->waktu}}</td>
                                                    <?php $a = StatusJoin($li->id_terkait, $li->untuk_id); ?>
                                                    <td>
                                                        @if($a==1)
                                                            <form action="{{url('/')}}/event/update_status_ver" method="post">
                                                                {{ csrf_field() }}
                                                                <input type="hidden" name="id" value="{{$li->id_terkait}}">
                                                                <input type="hidden" name="untuk_id" value="{{$li->untuk_id}}">
                                                                <button class="btn btn-success">Verified</button>
                                                            </form>
                                                        @elseif($a==2)
                                                            <img src="{{url('/')}}/image/event/ceklis.png">
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- link 2 -->
                            <div class="tab-pane fade in" id="link_2">
                                <div class="table-responsive">
                                    <table id="tableexdes2" class="table  table-bordered table-striped">
                                        <thead class="text-white" style="background-color: #1089ff;">
                                        <tr>
                                            <th>No</th>
                                            <th>Company</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($listnono as $key => $lino )
                                                <tr>
                                                    <td>{{$key+1}}</td>
                                                    <td>{{CompanyZ($lino->id_itdp_profil_eks)}}</td>
                                                    <td>{{$lino->waktu}}</td>
                                                    <?php $a = $lino->status; ?>
                                                    <td>
                                                        @if($a==1)
                                                            <form action="{{url('/')}}/event/update_status_company" method="post">
                                                                {{ csrf_field() }}
                                                                <input type="hidden" name="id" value="{{$lino->id_event_detail}}">
                                                                <input type="hidden" name="id_itdp_profil_eks" value="{{$lino->id_itdp_profil_eks}}">
                                                                <button class="btn btn-success">Verified</button>
                                                            </form>
                                                        @elseif($a==2)
                                                            <img src="{{url('/')}}/image/event/ceklis.png">
                                                        @endif
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

            </div>

        </div>
    </div>
</div>

@include('footer')

<script>
    $(document).ready(function () {
        $('#tableexdes').DataTable();
        $('#tableexdes2').DataTable();
    });
</script>