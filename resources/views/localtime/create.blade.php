{{-- @include('header') --}}
<style type="text/css">
    .button_form {
        width: 120px
    }

    input[type="text"],
    input[type="text"]:focus {
        border-color: #dce5e8;
    }

    .form-group input[type="checkbox"] {
        display: none;
    }

    .form-group input[type="checkbox"]+.btn-group>label span {
        width: 20px;
    }

    .form-group input[type="checkbox"]+.btn-group>label span:first-child {
        display: none;
    }

    .form-group input[type="checkbox"]+.btn-group>label span:last-child {
        display: inline-block;
    }

    .form-group input[type="checkbox"]:checked+.btn-group>label span:first-child {
        display: inline-block;
    }

    .form-group input[type="checkbox"]:checked+.btn-group>label span:last-child {
        display: none;
    }

</style>

@extends('header2')
@section('content')

    <?php
    $view = '';
    if ($page == 'view') {
        $view = 'disabled';
    }
    ?>
    {{-- <div class="padding"> --}}
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header border-bottom ">
                    <h3 class="mb-0">Change Local Time</h3>
                </div>

                <div class="col-md-12">
                    @if ($page != 'view')
                        {!! Form::open(['url' => $url, 'class' => 'form-horizontal', 'files' => true]) !!}
                        <input type="hidden" name="id_country" required
                                @isset($data) value="{{ $data->id }}" @endisset style="border-color: #d1d1d1;">
                    @endif<br>
                    <div class="form-group row">
                        <div class="col-md-1"></div>
                        <label class="control-label col-md-2">Country</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="country" disabled
                                @isset($data) value="{{ $data->country }}" @endisset style="border-color: #d1d1d1;">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-1"></div>
                        <label class="control-label col-md-2">Time difference (Hours) : </label>
                        <div class="col-md-2">
                            <input type="number" class="form-control" name="selisih_waktu" required {{ $view }}
                                @isset($data) value="{{ $data->selisih_waktu }}" @endisset style="border-color: #d1d1d1;">
                        </div>
                    </div>
                    
                    <br>
                    <div class="form-group row">
                        <div class="col-md-3"></div>
                        <div class="col-md-7">
                            @if ($page != 'view')
                                <button class="btn btn-primary button_form" type="submit"
                                    style="margin-right: 20px">Submit</button>
                            @endif
                            <a href="{{ route('localtime.index') }}"
                                class="btn btn-danger button_form">@if ($page != 'view') Cancel @else Back @endif</a>
                        </div>
                    </div>
                    @if ($page != 'view')
                        {!! Form::close() !!}
                    @endif
            </div>
        </div>
    </div>
</div>

@include('footer')
@endsection
