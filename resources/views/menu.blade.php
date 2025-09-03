<div class="navbar-inner">
    <!-- Collapse -->
    <div class="collapse navbar-collapse" id="sidenav-collapse-main">
        <!-- Nav items -->
        <ul class="navbar-nav">
            @if (isset(Auth::user()->id_group))
            <?php $menu = DB::select('select * from menu order by id_menu desc');
                        ?>
            @foreach (Menu::get() as $res)
            @if ($res->parent == null && $res->url != null)
            <li class="nav-item">
                <a class="nav-link" href="{{ url($res->url) }}">
                    @if(str_contains($res->icon, 'fab'))
                    <i class="{{ $res->icon }}"></i>
                    @else
                    <i class="fa {{ $res->icon }}"></i>
                    @endif
                    <span class="nav-link-text">{{ $res->menu_name }}</span>
                </a>
            </li>
            @elseif($res->parent == NULL && $res->url == NULL && $res->id_menu != 42 &&
            $res->id_menu != 47 && $res->id_menu != 56)
            <li class="nav-item nav-with-child">
                <span class="nav-caret panah_bawah" style="margin-top: 10px; margin-right:10px;cursor:pointer;">
                    <i class="fa fa-caret-down"></i>
                </span>
                <a class="nav-link">
                    @if(str_contains($res->icon, 'fab'))
                    <i class="{{ $res->icon }}"></i> {{ $res->menu_name }}
                    @else
                    <i class="fa {{ $res->icon }}"></i> {{ $res->menu_name }}
                    @endif
                </a>
                <ul class="nav-item-child">
                    @foreach (Menu::get() as $sub)
                    @if ($sub->parent == $res->id_menu)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url($sub->url) }}">
                            @if(str_contains($sub->icon, 'fab'))
                            <i class="{{ $sub->icon }}"></i>{{ $sub->menu_name }}
                            @else
                            <i class="fa {{ $sub->icon }}"></i>{{ $sub->menu_name }}
                            @endif
                        </a>
                    </li>
                    @endif
                    @endforeach
                </ul>
            </li>
            @endif
            @endforeach
            @else
            @if (Auth::guard('eksmp')->user()->type == 'Luar Negeri' && (Auth::guard('eksmp')->user()->status == 0 ||
            Auth::guard('eksmp')->user()->status == 3))
            <?php
                            $menu = DB::table('menu')
                                ->where('show', '1')
                                ->get();
                            ?>
            @foreach ($menu as $me)
            @if ($me->parent == null && $me->url != null)
            <li class="nav-item">
                <a class="nav-link" href="{{ url($me->url) }}">
                    @if(str_contains($me->icon, 'fab'))
                    <i class="{{ $me->icon }} text-primary"></i>
                    @else
                    <i class="fa {{ $me->icon }} text-primary"></i>
                    @endif
                    <span class="nav-link-text">{{ $me->menu_name }}</span>
                </a>
            </li>
            @elseif($me->parent == NULL && $me->url == NULL)
            <li class="nav-item nav-with-child">
                <span class="nav-caret panah_bawah" style="margin-top: 10px; margin-right:10px;cursor:pointer;">
                    <i class="fa fa-caret-down"></i>
                </span>
                <a class="nav-link">
                    @if(str_contains($res->icon, 'fab'))
                    <i class="{{ $res->icon }}"></i> {{ $res->menu_name }}
                    @else
                    <i class="fa {{ $res->icon }}"></i> {{ $res->menu_name }}
                    @endif
                </a>
                <ul class="nav-item-child">
                    @foreach (Menu::get() as $sub)
                    @if ($sub->parent == $res->id_menu)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url($sub->url) }}">
                            @if(str_contains($sub->icon, 'fab'))
                            <i class="{{ $sub->icon }}"></i>{{ $sub->menu_name }}
                            @else
                            <i class="fa {{ $sub->icon }}"></i>{{ $sub->menu_name }}
                            @endif
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
            @if ($res->parent == null && $res->url != null)
            <li class="nav-item">
                <a class="nav-link" href="{{ url($res->url) }}">
                    @if(str_contains($res->icon, 'fab'))
                    <i class="{{ $res->icon }} text-primary"></i>
                    @else
                    <i class="fa {{ $res->icon }} text-primary"></i>
                    @endif
                    <span class="nav-link-text">{{ $res->menu_name }}</span>
                </a>
            </li>
            @elseif($res->parent == NULL && $res->url == NULL)
            <li class="nav-item nav-with-child">
                <span class="nav-caret panah_bawah" style="margin-top: 10px; margin-right:10px;cursor:pointer;">
                    <i class="fa fa-caret-down"></i>
                </span>
                <a class="nav-link">
                    @if(str_contains($res->icon, 'fab'))
                    <i class="{{ $res->icon }}"></i> {{ $res->menu_name }}
                    @else
                    <i class="fa {{ $res->icon }}"></i> {{ $res->menu_name }}
                    @endif
                </a>
                <ul class="nav-item-child">
                    @foreach (Menu::get() as $sub)
                    @if ($sub->parent == $res->id_menu)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url($sub->url) }}">
                            @if(str_contains($sub->icon, 'fab'))
                            <i class="{{ $sub->icon }}"></i>{{ $sub->menu_name }}
                            @else
                            <i class="fa {{ $sub->icon }}"></i>{{ $sub->menu_name }}
                            @endif
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

            <?php if(empty(Auth::user()->id_group)){ ?>
            @if (Auth::guard('eksmp')->user()->type == 'Luar Negeri' && (Auth::guard('eksmp')->user()->status == 0 ||
            Auth::guard('eksmp')->user()->status == 3))
            @else
            <li class="nav-item">
                {{ userGuide('backend', Auth::guard('eksmp')->user()->id_role) }}
                <i class="ni ni-pin-3 text-primary"></i>
                <span class="nav-link-text">Panduan Pengguna</span>
                <a class="nav-link">
                    {{-- <i class="ni ni-pin-3 text-primary"></i>
                    <span class="nav-link-text">Panduan Pengguna</span> --}}
                </a>
            </li>
            @endif
            <?php }else { ?>
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
</div>
</nav>
<div class="main-content" id="panel">
    <nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Search form -->
                <!-- <form class="navbar-search navbar-search-light form-inline mr-sm-3" id="navbar-search-main">
                            <div class="form-group mb-0">
                                <div class="input-group input-group-alternative input-group-merge">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    </div>
                                    <input class="form-control" placeholder="Search" type="text">
                                </div>
                            </div>
                            <button type="button" class="close" data-action="search-close"
                                data-target="#navbar-search-main" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </form> -->
                <!-- Navbar links -->
                <ul class="navbar-nav align-items-center  ml-md-auto "></ul>

                <ul class="navbar-nav align-items-center  ml-auto ml-md-0 ">
                    <li class="nav-item dropdown">
                        <a class="nav-link pr-0" id="toggle" href="#" role="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <div class="media align-items-center">
                                <span class="avatar avatar-sm rounded-circle">
                                    <img alt="Image placeholder" src="{{ url('/assets/assets/images/team-1.jpg') }}">
                                </span>
                                <div class="media-body  ml-2  d-none d-lg-block">
                                    @php
                                    if (Auth::guard('eksmp')->user()) {
                                    if (Auth::guard('eksmp')->user()->id_role == 3) {
                                    $u = 'buyer';
                                    $user = getCompanyNameImportir(Auth::guard('eksmp')->user()->id);
                                    } elseif (Auth::guard('eksmp')->user()->id_role == 2) {
                                    $u = 'eksportir';
                                    $user = getCompanyName(Auth::guard('eksmp')->user()->id);
                                    }
                                    }
                                    @endphp
                                    <span class="mb-0 text-sm  font-weight-bold">
                                        @if (Auth::user() != null)
                                        {{ Auth::user()->name }}
                                        @else
                                        {{ $user }}
                                        @endif
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu  dropdown-menu-right " id="drop">
                            <div class="dropdown-header noti-title">
                                <h6 class="text-overflow m-0">Welcome!</h6>
                            </div>
                            {{-- <a href="#!" class="dropdown-item">
                                <i class="ni ni-single-02"></i>
                                <span>My profile</span>
                            </a>
                            <a href="#!" class="dropdown-item">
                                <i class="ni ni-settings-gear-65"></i>
                                <span>Settings</span>
                            </a>
                            <a href="#!" class="dropdown-item">
                                <i class="ni ni-calendar-grid-58"></i>
                                <span>Activity</span>
                            </a>
                            <a href="#!" class="dropdown-item">
                                <i class="ni ni-support-16"></i>
                                <span>Support</span>
                            </a> --}}
                            <div class="dropdown-divider"></div>
                            @if (Auth::guard('eksmp')->user() != null)
                            <a href="{{ url('front_end/ticketing_support/list') }}" class="dropdown-item"
                                target="_blank">
                                <i class="ni ni-user-run"></i>
                                <span>Support</span>
                            </a>
                            <a href="{{ url('perusahaan/' . Auth::guard('eksmp')->user()->id) }}" class="dropdown-item"
                                target="_blank">
                                <i class="ni ni-circle-08"></i>
                                <span>View Profile</span>
                            </a>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="dropdown-item">
                                <i class="ni ni-button-power"></i>
                                <span>Logout</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                            @elseif(Auth::user() != null)
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="dropdown-item">
                                <i class="ni ni-button-power"></i>
                                <span>Logout</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                            @endif
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-md-9 col-sm-9 col-xs-9">
                        <h6 class="h2 text-white d-inline-block mb-0">{!! Request::segment(1) !!}</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">Dashboards</a></li>
                                @if (Request::segment(2) != null)
                                <li class="breadcrumb-item active" aria-current="page">
                                    {!! Request::segment(1) !!} / {!! Request::segment(2) !!}</li>
                                @else
                                <li class="breadcrumb-item active" aria-current="page">
                                    {!! Request::segment(1) !!}</li>
                                @endif
                            </ol>
                        </nav>
                    </div>
                </div>