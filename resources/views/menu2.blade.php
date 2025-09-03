<style>
    .modal-dialog iframe {
        margin: 0 auto;
        display: block;
    }
</style>
<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
        <!-- Brand -->
        <div class="sidenav-header  align-items-center">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ url('/assets/assets/images/logonew.png') }}" class="navbar-brand-img">
            </a>
        </div>
        @php
        // dd(Menu::get());
        @endphp
        <div class="navbar-inner">
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <!-- Nav items -->
                <ul class="navbar-nav" style="user-select: none;">
                    @if (isset(Auth::user()->id_group))
                    @if (Auth::user()->id_group == 1 && Auth::user()->id_helpdesk)
                    @php
                    $id_help = Auth::user()->id_helpdesk;
                    $session = checkingAccountHelpdesk($id_help);
                    $ses = $session['data']['session'];
                    $hash = $session['data']['idhash'];
                    $username = $session['data']['username'];
                    $password = $session['data']['password_real'];
                    $token = 'eyJhbGciOiJIUzM4NCIsInR5cCI6IkpXVCJ9';
                    $link = $ses == null ? config('constants.HELPDESK_URL') . 'operator/login_via_api.php?username=' .
                    urlencode($username) . '&password=' . urlencode($password) . '&token=' . $token :
                    config('constants.HELPDESK_URL') . 'operator/';
                    @endphp
                    <li class="nav-item">
                        <a class="nav-link" target="_blank" href="{{ $link }}">
                            <i class="fa fa-user-tie"></i>
                            <span class="nav-link-text">CS Admin</span>
                        </a>
                    </li>
                    @endif
                    <?php $menu = DB::select('select * from menu order by id_menu desc');
                        ?>
                    @foreach (Menu::get() as $res)
                    @php
                    $array_styles = ['primary', 'orange', 'yellow', 'default', 'info', 'pink'];
                    $k = array_rand($array_styles);
                    @endphp
                    @if ($res->parent == null && $res->url != null && $res->id_menu != 48)
                    @if ($res->id_menu == 94)
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
                            @if(str_contains($res->icon, 'fab'))
                            <i class="{{ $res->icon }} text-{{ $array_styles[$k] }}"></i>
                            @else
                            <i class="fa {{ $res->icon }} text-{{ $array_styles[$k] }}"></i>
                            @endif
                            <span class="nav-link-text">{{ $res->menu_name }}</span>
                        </a>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url($res->url) }}">
                            @if(str_contains($res->icon, 'fab'))
                            <i class="{{ $res->icon }} text-{{ $array_styles[$k] }}"></i>
                            @else
                            <i class="fa {{ $res->icon }} text-{{ $array_styles[$k] }}"></i>
                            @endif
                            <span class="nav-link-text">{{ $res->menu_name }}</span>
                        </a>
                    </li>
                    @endif
                    @elseif($res->parent == null && $res->url == null && $res->id_menu != 42 && $res->id_menu != 47 &&
                    $res->id_menu != 56)
                    <li class="nav-item nav-with-child">
                        <span class="nav-caret panah_bawah" style="margin-top: 0px; margin-right:10px;cursor:pointer;">
                            <i class="fa fa-caret-down"></i>
                        </span>
                        <a class="nav-link">
                            @if(str_contains($res->icon, 'fab'))
                            <i class="{{ $res->icon }} text-{{ $array_styles[$k] }}"></i>
                            @else
                            <i class="fa {{ $res->icon }} text-{{ $array_styles[$k] }}"></i>
                            @endif
                            {{ $res->menu_name }}
                        </a>
                        <ul class="nav-item-child pl-0">
                            @foreach (Menu::get() as $sub)
                            @php
                            $array_styles = ['primary', 'orange', 'yellow', 'default', 'info', 'pink'];
                            $k = array_rand($array_styles);
                            @endphp
                            @if ($sub->parent == $res->id_menu)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url($sub->url) }}">
                                    @if(str_contains($sub->icon, 'fab'))
                                    <i class="{{ $sub->icon }} text-{{ $array_styles[$k] }}"></i>
                                    @else
                                    <i class="fa {{ $sub->icon }} text-{{ $array_styles[$k] }}"></i>
                                    @endif
                                    {{ $sub->menu_name}}
                                </a>
                            </li>
                            @endif
                            @endforeach
                        </ul>
                    </li>
                    @endif
                    @endforeach
                    @else
                    @if (Auth::guard('eksmp')->user()->id_role == 2 && Auth::guard('eksmp')->user()->status != 1)
                    {{-- Hanya muncul Profil Perusahaan --}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('profil') }}">
                            <i class="fa fa fa-address-card text-default"></i>
                            <span class="nav-link-text">Profil Perusahaan</span>
                        </a>
                    </li>
                    @elseif (Auth::guard('eksmp')->user()->type == 'Luar Negeri' &&
                    (Auth::guard('eksmp')->user()->status == 0 || Auth::guard('eksmp')->user()->status == 3))
                    <?php
                            $menu = DB::table('menu')
                                ->where('show', '1')
                                ->get();
                            ?>
                    @foreach ($menu as $me)
                    @php
                    $array_styles = ['orange', 'primary', 'default', 'yellow', 'info', 'pink'];
                    $k = array_rand($array_styles);
                    @endphp
                    @if ($me->parent == null && $me->url != null)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url($me->url) }}">
                            @if(str_contains($me->icon, 'fab'))
                            <i class="{{ $me->icon }} text-{{ $array_styles[$k] }}"></i>
                            @else
                            <i class="fa {{ $me->icon }} text-{{ $array_styles[$k] }}"></i>
                            @endif
                            <span class="nav-link-text">{{ $me->menu_name }}</span>
                        </a>
                    </li>
                    @elseif($me->parent == null && $me->url == null)
                    <li class="nav-item nav-with-child">
                        <span class="nav-caret panah_bawah" style="margin-top: 0px; margin-right:10px;cursor:pointer;">
                            <i class="fa fa-caret-down"></i>
                        </span>
                        <a class="nav-link">
                            @if(str_contains($me->icon, 'fab'))
                            <i class="{{ $me->icon }} text-{{ $array_styles[$k] }}"></i>
                            @else
                            <i class="fa {{ $me->icon }} text-{{ $array_styles[$k] }}"></i>
                            @endif
                            {{ $me->menu_name }}
                        </a>
                        <ul class="nav-item-child pl-0">
                            @foreach (Menu::get() as $sub)
                            @php
                            $array_styles = ['orange', 'primary', 'default', 'yellow', 'info', 'pink'];
                            $k = array_rand($array_styles);
                            @endphp
                            @if ($sub->parent == $me->id_menu)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url($sub->url) }}">
                                    @if(str_contains($sub->icon, 'fab'))
                                    <i class="{{ $sub->icon }} text-{{ $array_styles[$k] }}"></i>
                                    @else
                                    <i class="fa {{ $sub->icon }} text-{{ $array_styles[$k] }}"></i>
                                    @endif
                                    {{ $sub->menu_name}}
                                </a>
                            </li>
                            @endif
                            @endforeach
                        </ul>
                    </li>
                    @endif
                    @endforeach
                    @else
                    <?php $menu = DB::select('select * from menu order by id_menu desc');
                            ?>
                    @foreach (Menu::get() as $res)
                    @php
                    $array_styles = ['yellow', 'orange', 'info', 'default', 'pink', 'primary'];
                    $k = array_rand($array_styles);
                    @endphp
                    @if ($res->parent == null && $res->url != null)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url($res->url) }}">
                            @if(str_contains($res->icon, 'fab'))
                            <i class="{{ $res->icon }} text-{{ $array_styles[$k] }}"></i>
                            @else
                            <i class="fa {{ $res->icon }} text-{{ $array_styles[$k] }}"></i>
                            @endif
                            <span class="nav-link-text">{!! $res->menu_name !!}</span>
                        </a>
                    </li>
                    @elseif($res->parent == null && $res->url == null)
                    <li class="nav-item nav-with-child">
                        <span class="nav-caret panah_bawah" style="margin-top: 0px; margin-right:10px;cursor:pointer;">
                            <i class="fa fa-caret-down"></i>
                        </span>
                        <a class="nav-link">
                            @if(str_contains($res->icon, 'fab'))
                            <i class="{{ $res->icon }} text-{{ $array_styles[$k] }}"></i>
                            @else
                            <i class="fa {{ $res->icon }} text-{{ $array_styles[$k] }}"></i>
                            @endif
                            {{ $res->menu_name }}
                        </a>
                        <ul class="nav-item-child pl-0">
                            @foreach (Menu::get() as $sub)
                            @php
                            $array_styles = ['yellow', 'orange', 'info', 'default', 'pink', 'primary'];
                            $k = array_rand($array_styles);
                            @endphp
                            @if ($sub->parent == $res->id_menu)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url($sub->url) }}">
                                    @if(str_contains($sub->icon, 'fab'))
                                    <i class="{{ $sub->icon }} text-{{ $array_styles[$k] }}"></i>
                                    @else
                                    <i class="fa {{ $sub->icon }} text-{{ $array_styles[$k] }}"></i>
                                    @endif
                                    {{ $sub->menu_name}}
                                </a>
                            </li>
                            @endif
                            @endforeach
                        </ul>
                    </li>
                    @endif
                    @endforeach
                    @endif
                    @endif

                    <hr class="my-3">

                    <?php if (empty(Auth::user()->id_group)) { ?>
                    @if (Auth::guard('eksmp')->user()->type == 'Luar Negeri' && (Auth::guard('eksmp')->user()->status ==
                    0 || Auth::guard('eksmp')->user()->status == 3))
                    @else
                    <li class="nav-item">
                        <!-- {{ userGuide('backend', Auth::guard('eksmp')->user()->id_role) }}
                            <i class="ni ni-pin-3 text-primary"></i>
                            <span class="nav-link-text">Panduan Pengguna</span>
                            <a class="nav-link">
                                {{-- <i class="ni ni-pin-3 text-primary"></i>
                                <span class="nav-link-text">Panduan Pengguna</span> --}}
                            </a> -->
                        {{-- <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
                            <i class="ni ni-pin-3 text-primary"></i>
                            <span class="nav-link-text">Panduan Pengguna</span>
                        </a> --}}
                        <a class="nav-link" target='_blank'
                            href="http://djpen.kemendag.go.id/appreport/importer_report">
                            <i class="fas fa-folder-open text-primary"></i>
                            <span class="nav-link-text">Direktori Buyer</span>
                        </a>
                    </li>
                    @endif
                    <?php } else { ?>
                    @if (Auth::user()->id_group == 1)

                    <li class="nav-header hidden-folded mt-2">
                        <span class="text-xs">Users Management</span>
                    </li>

                    <li>
                        <a href="{{ url('/group') }}">
                            <span class="nav-icon">
                                <i class="badge badge-xs badge-o md b-warning"></i>
                            </span>
                            <span class="nav-text">Group</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('/users') }}">
                            <span class="nav-icon">
                                <i class="badge badge-xs badge-o md b-primary"></i>
                            </span>
                            <span class="nav-text">User</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('/menus') }}">
                            <span class="nav-icon">
                                <i class="badge badge-xs badge-o md"></i>
                            </span>
                            <span class="nav-text">Menu</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('/permissions') }}">
                            <span class="nav-icon">
                                <i class="badge badge-xs badge-o md b-success"></i>
                            </span>
                            <span class="nav-text">Setting Menu</span>
                        </a>
                    </li>
                    @endif
                    <?php } ?>
                    <!-- Menu Notif Untuk Semua role -->
                    <?php
                    $count = countNotif(Auth::user() != '' ? Auth::user()->id : Auth::guard('eksmp')->user()->id);
                    ?>
                    <li class="nav-item">
                        @if (Auth::user() != null && Auth::user()->id_group == 11)
                        @else
                        <a class="nav-link" onclick="openModalNotif()">
                            <i class="ni ni-bell-55 text-primary"></i>
                            <span class="nav-link-text">Notifications&nbsp;<span
                                    class="badge badge-danger jumlah_notif">{{ $count }}</span></span>
                        </a>
                        @endif
                    </li>
                    <li class="pb-2 hidden-folded"></li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="examples/icons.html">
                            <i class="ni ni-planet text-orange"></i>
                            <span class="nav-link-text">Icons</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="examples/map.html">
                            <i class="ni ni-pin-3 text-primary"></i>
                            <span class="nav-link-text">Google</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="examples/profile.html">
                            <i class="ni ni-single-02 text-yellow"></i>
                            <span class="nav-link-text">Profile</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="examples/tables.html">
                            <i class="ni ni-bullet-list-67 text-default"></i>
                            <span class="nav-link-text">Tables</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="examples/login.html">
                            <i class="ni ni-key-25 text-info"></i>
                            <span class="nav-link-text">Login</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="examples/register.html">
                            <i class="ni ni-circle-08 text-pink"></i>
                            <span class="nav-link-text">Register</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="examples/upgrade.html">
                            <i class="ni ni-send text-dark"></i>
                            <span class="nav-link-text">Upgrade</span>
                        </a>
                    </li> --}}
                </ul>
            </div>
        </div>
        <!-- modal pdf perwadag -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog-centered modal-dialog modal-xl " role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div style="height: 500px;">
                            <iframe
                                src="https://inaexport.id/uploads/User%20Guide/Petunjuk_Pembuatan_Buying_Request%20_Perwadag.pdf"
                                style="position: absolute;border: none;margin: 0;padding: 0;overflow: hidden;z-index: 3;height: 100%;width:94%;padding-bottom: 18px;"></iframe>
                        </div>
                    </div>
                    <div class="modal-footer">
                        </br></br>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <!-- <a href="https://inaexport.id/uploads/User%20Guide/Petunjuk_Pembuatan_Buying_Request%20_Perwadag.pdf" class="btn btn-primary">Download Dokumen</a> -->
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                var jenis_auth = $('#jenis_auth').val();
                var a = ($('#id_admin').val() != undefined) ? $('#id_admin').val() : $('#id_admin_satu').val();
                var b = ($('#id_eks_imp').val() != undefined) ? $('#id_eks_imp').val() : $('#id_company_satu').val();
                var pusher = new Pusher('{{ env('MIX_PUSHER_APP_KEY') }}', {
                    cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
                    encrypted: true
                });

                if (jenis_auth == 'admin') {
                    var notif_chanel = pusher.subscribe('chat-notif-channel-admin-' + a);
                } else {
                    var notif_chanel = pusher.subscribe('chat-notif-channel-com-' + b);
                }
                notif_chanel.bind('App\\Events\\Notify', function(data) {
                    var jumlah_notif = $('#jumlah_notif').text();
                    $('.jumlah_notif').text(parseInt(jumlah_notif) + 1);
                })
            })

            function openModalNotif() {
                $("#tableNotif").dataTable().fnDestroy();
                $('#modal-view-notif').modal('show');
                getNotifModal();
                $('#tableNotif_wrapper').removeClass('container-fluid');
                updateCounterNotif();
            }

            function getNotifModal() {
                $('#tableNotif').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('home.get_notif_modal') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            width: 5,
                            className: "text-center"
                        },
                        {
                            data: 'dari_nama',
                            name: 'dari_nama',
                            width: 25
                        },
                        {
                            data: 'untuk_nama',
                            name: 'untuk_nama',
                            width: 25
                        },
                        {
                            data: 'keterangan',
                            name: 'keterangan',
                            width: 30
                        },
                        {
                            data: 'waktu',
                            name: 'waktu',
                            width: 10
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false,
                            width: 10,
                            className: "text-center"
                        }
                    ],
                    "scrollX": true,
                    columnDefs: [{
                        render: function(data, type, full, meta) {
                            return "<div class='text-wrap' style='width:100%'>" + data + "</div>";
                        },
                        targets: 1
                    }],
                    "language": {
                        "paginate": {
                            "previous": "<i class='fa fa-angle-left'/></>",
                            "next": "<i class='fa fa-angle-right'/></>"
                        }
                    },
                });
            }

            function updateCounterNotif(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    }
                });

                $.post('{{ url('markAsReadNotification') }}', function(response){ 
                    if(response.success != '200'){
                        console.log('error connection');
                    }
                });
            }
        </script>
        @include('auth.register.modal')
    </div>
</nav>