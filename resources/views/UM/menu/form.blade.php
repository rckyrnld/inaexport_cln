{{-- @include('header') --}}
@extends('header2')
@section('content')

{{-- <div class="padding"> --}}
  <div class="row">
    <div class="col">
      <div class="card">
        <div class="card-header border-bottom">
            <h3 class="mb-0">Add Menu</h3>
        </div>
        <div class="card-body">

      	 {!! Form::open(['url' => $url, 'class' => 'form-horizontal', 'files' => true]) !!}
            <div class="form-group">
                <label class="control-label col-md-3">Nama Menu</label>
                <div class="col-md-7">
                    <input type="text" class="form-control" name="nama_menu" placeholder="Home"   @isset($res) value="{{ $res->menu_name }}"  @endisset>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3">Url</label>
                <div class="col-md-7">
                    <input type="text" class="form-control" name="url" placeholder="/Home" @isset($res) value="{{ $res->url }}"  @endisset>
                </div>
            </div>

            
            <div class="form-group">
                <label class="control-label col-md-3">Urutan</label>
                <div class="col-md-7">
                    <input type="number" class="form-control" name="urutan" min="0" placeholder="" @isset($res) value="{{ $res->order }}"  @endisset>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3">Icon</label>
                <div class="col-md-7">
                    <input type="text" class="form-control" name="icon"  placeholder="font-awesome - fa-home" @isset($res) value="{{ $res->icon }}"  @endisset>
                </div>
            </div>

        
            <div class="form-group">
                <label class="control-label col-md-3">Keterangan</label>
                <div class="col-md-7">
                    <textarea class="form-control" name="ket">@isset($res) {{ $res->ket }}  @endisset</textarea>
                </div>
            </div>

        
            <div class="form-group">
                <label class="control-label col-md-3"></label>
                <div class="col-md-7">
                    <button class="btn btn-primary" type="submit"> Simpan</button>
                    <a href="{{ url()->previous() }}" class="btn btn-md btn-danger">Cancel</a>
                </div>
            </div>
            {!! Form::close() !!}

      	 </div>
      </div>
     </div>
  </div>
</div>

@include('footer')
@endsection

