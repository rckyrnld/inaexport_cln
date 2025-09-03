@extends('header2')
@section('content')
<style>
    body {
        font-family: Arial;
    }

    /* Style the tab */
</style>
{{-- <div class="container-fluid mt--6"> --}}
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header border-bottom">
                    <h3 class="mb-0">{{ $pageTitle }}</h3>
                </div>
                <div class="card-body pl-9 pr-9 pt-0">
                    <div class="col-md-12">
                        <br>
                        <div class="table-responsive">
                            @if($data != '')
                            @php
                            $link_url = explode('%#%', $data->link);
                            $link_title = explode('%#%', $data->title);
                            @endphp
                            @foreach ($link_url as $key => $d)
                            <h3>{{ $key + 1 }}.{{ $link_title[$key] }}</h3>
                            <div class="embed-responsive embed-responsive-16by9 mb-4">
                                <iframe class="embed-responsive-item" width="560" height="315" src="{{ $d }}"
                                    title="YouTube video player" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">

    </script>

    @include('footer')
    @endsection