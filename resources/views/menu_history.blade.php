<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
        <!-- Brand -->
        <div class="sidenav-header  align-items-center">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ url('/assets/assets/images/logonew.png') }}" class="navbar-brand-img">
            </a>
        </div>
        <div class="navbar-inner">
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <!-- Nav items -->
                <ul class="navbar-nav" style="user-select: none;">
                    <hr class="my-3">

                    <li class="pb-2 hidden-folded"></li>
                    @php
                    $menus = getMenu();
                    $array_styles = ['primary', 'orange', 'yellow', 'default', 'info', 'pink','danger'];
                    $k = array_rand($array_styles);
                    @endphp

                    @foreach ($menus as $k => $m)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url($m->url) }}">
                            <i class="{{ $m->icon }} text-{{ $array_styles[$k] }}"></i>
                            <span class="nav-link-text">{{ $m->menu_name }}</span>
                        </a>
                    </li>
                    @endforeach

                    {{-- <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">
                            <i class="ni ni-single-02 text-blue"></i>
                            <span class="nav-link-text">Home</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('profile') }}">
                            <i class="ni ni-single-02 text-yellow"></i>
                            <span class="nav-link-text">Profile</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('front_end/history') }}">
                            <i class="ni ni-planet text-orange"></i>
                            <span class="nav-link-text">History Inquiry</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('business_matching_list/') }}">
                            <i class="fa fa-calendar  text-green"></i>
                            <span class="nav-link-text">Business Matching</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('video_conference/list') }}">
                            <i class="fa fa-video-camera text-purple"></i>
                            <span class="nav-link-text">Video Conference</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://inaexport.id/front_end/ticketing_support/list">
                            <i class="fa fa fa-handshake-o text-primary"></i>
                            <span class="nav-link-text">Helpdesk</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('tutorial') }}">
                            <i class="fab fa-youtube"></i>
                            <span class="nav-link-text">Tutorial</span>
                        </a>
                    </li> --}}
                </ul>
            </div>
        </div>
    </div>
</nav>