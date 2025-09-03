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
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header border-bottom ">
                <h3 class="mb-0">View Detail Activity Supplier</h3>
            </div>
            <br><br>
            <div class="col-md-6">
                <div class="form-group row">
                    <div class="col-md-1"></div>
                    <label class="control-label col-md-4">Nama Perusahaan</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" value="{{ $data->company }}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-1"></div>
                    <label class="control-label col-md-4">Telepon</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" value="{{ $data->phone }}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-1"></div>
                    <label class="control-label col-md-4">Fax</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" value="{{ $data->fax }}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-1"></div>
                    <label class="control-label col-md-4">Kota</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" value="{{ $data->city }}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-1"></div>
                    <label class="control-label col-md-4">Alamat</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" value="{{ $data->addres }}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-1"></div>
                    <label class="control-label col-md-4">Website</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" value="{{ $data->website }}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-5"></div>
                    <div class="col-md-7">
                        <a href="{{route('activity.index')}}" class="btn btn-danger button_form"> Back </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
    });
</script>
@include('footer')
@endsection
