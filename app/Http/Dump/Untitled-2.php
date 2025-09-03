   <!-- Flex nav content -->

   <div class="flex hide-scroll" style="padding-top:15px; background-color:  white  ; color: #000000">

    <div class="scroll">
        <div class="nav-border b-primary" data-nav>
            <ul class="nav bg">
                {{-- tambahan untuk exportir yang statusnya 0 start --}}
                @if (isset(Auth::user()->id_group))
                    <?php $menu = DB::select('select * from menu order by id_menu desc');
                    ?>
                    @foreach (Menu::get() as $res)
                        @if ($res->parent == null && $res->url != null)

                            <li>
                                <a href="{{ url($res->url) }}">
                                    <span class="nav-icon">
                                        <i class="fa {{ $res->icon }}"></i>
                                    </span>
                                    <span class="nav-text"><b>{{ $res->menu_name }}</b></span>
                                </a>
                            </li>

                            {{-- independent menu --}}

                        @elseif($res->parent == NULL && $res->url == NULL)

                            <li>
                                <a>
                                    <span class="nav-caret">
                                        <i class="fa fa-caret-down"></i>
                                    </span>
                                    <span class="nav-icon">
                                        <i class="fa {{ $res->icon }}"></i>
                                    </span>
                                    <span class="nav-text"><b>{{ $res->menu_name }}</b></span>
                                </a>

                                <ul class="nav-sub">
                                    @foreach (Menu::get() as $sub)
                                        @if ($sub->parent == $res->id_menu)
                                            <li>
                                                <a href="{{ url($sub->url) }}"><i
                                                        class="fa {{ $sub->icon }}"></i>
                                                    <?php if(empty($sub->icon)){} else{ ?>&nbsp;&nbsp;
                                                    <!-- <span class="nav-icon"><i class="fa {{ $sub->icon }}"></i>-->
                                                    </span>
                                                    <?php } ?>
                                                    {{ $sub->menu_name }}
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>

                            </li>

                        @endif


                    @endforeach
                @else
                    @if (Auth::guard('eksmp')->user()->type == 'Luar Negeri' && (Auth::guard('eksmp')->user()->status == 0 || Auth::guard('eksmp')->user()->status == 3))
                        {{-- untuk eksportir yang belum aktif, tapi udah bisa login --}}
                        <?php
                        $menu = DB::table('menu')
                            ->where('show', '1')
                            ->get();
                        ?>
                        @foreach ($menu as $me)
                            @if ($me->parent == null && $me->url != null)
                                <li>
                                    <a href="{{ url($me->url) }}">
                                        <span class="nav-icon">
                                            <i class="fa {{ $me->icon }}"></i>
                                        </span>
                                        <span class="nav-text"><b>{{ $me->menu_name }}</b></span>
                                    </a>
                                </li>
                                {{-- independent menu --}}
                            @elseif($me->parent == NULL && $me->url == NULL)
                                <li>
                                    <a>
                                        <span class="nav-caret">
                                            <i class="fa fa-caret-down"></i>
                                        </span>
                                        <span class="nav-icon">
                                            <i class="fa {{ $me->icon }}"></i>
                                        </span>
                                        <span class="nav-text"><b>{{ $me->menu_name }}</b></span>
                                    </a>
                                    <ul class="nav-sub">
                                        @foreach (Menu::get() as $sub)
                                            @if ($sub->parent == $me->id_menu)
                                                <li>
                                                    <a href="{{ url($sub->url) }}"><i
                                                            class="fa {{ $sub->icon }}"></i>
                                                        <?php if(empty($sub->icon)){} else{ ?>&nbsp;&nbsp;
                                                        <!-- <span class="nav-icon">
                                                   <i class="fa {{ $sub->icon }}"></i>
                                                   </span>-->
                                                        <?php } ?>
                                                        {{ $sub->menu_name }}
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                            @endif
                        @endforeach
                    @else
                        {{-- tambahan untuk exportir yang statusnya 0 end --}}
                        <?php $menu = DB::select('select * from menu order by id_menu desc');
                        ?>
                        @foreach (Menu::get() as $res)
                            @if ($res->parent == null && $res->url != null)

                                <li>
                                    <a href="{{ url($res->url) }}">
                                        <span class="nav-icon">
                                            <i class="fa {{ $res->icon }}"></i>
                                        </span>
                                        <span class="nav-text"><b>{{ $res->menu_name }}</b></span>
                                    </a>
                                </li>

                                {{-- independent menu --}}

                            @elseif($res->parent == NULL && $res->url == NULL)

                                <li>
                                    <a>
                                        <span class="nav-caret">
                                            <i class="fa fa-caret-down"></i>
                                        </span>
                                        <span class="nav-icon">
                                            <i class="fa {{ $res->icon }}"></i>
                                        </span>
                                        <span class="nav-text"><b>{{ $res->menu_name }}</b></span>
                                    </a>

                                    <ul class="nav-sub">
                                        @foreach (Menu::get() as $sub)
                                            @if ($sub->parent == $res->id_menu)
                                                <li>
                                                    <a href="{{ url($sub->url) }}"><i
                                                            class="fa {{ $sub->icon }}"></i>
                                                        <?php if(empty($sub->icon)){} else{ ?>&nbsp;&nbsp;
                                                        <!-- <span class="nav-icon"><i class="fa {{ $sub->icon }}"></i>-->
                                                        </span>
                                                        <?php } ?>
                                                        {{ $sub->menu_name }}
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>

                                </li>

                            @endif


                        @endforeach
                        {{-- endif tambahan untuk exportir yang statusnya 0 --}}
                    @endif
                @endif


                <?php if(empty(Auth::user()->id_group)){ ?>
                </li>
                @if (Auth::guard('eksmp')->user()->type == 'Luar Negeri' && (Auth::guard('eksmp')->user()->status == 0 || Auth::guard('eksmp')->user()->status == 3))
                @else
                    <li>
                        {{ userGuide('backend', Auth::guard('eksmp')->user()->id_role) }}
                        <span class="nav-icon">
                            <i class="fa fa-book"></i>
                        </span>
                        <span class="nav-text"><b>Panduan Pengguna</b></span>
                        </a>
                    </li>
                @endif

                <?php }else { ?>
                <li>
                    {{ userGuide('backend', Auth::user()->id_group) }}
                    <span class="nav-icon">
                        <i class="fa fa-book"></i>
                    </span>
                    <span class="nav-text"><b>Panduan Pengguna</b></span>
                    </a>
                </li>

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

            </ul>

        </div>
    </div>
</div>
