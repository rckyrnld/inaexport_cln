@extends('header2')
@section('content')
  <div class="row">
    <div class="col">
      <div class="card">
        <div class="card-header border-bottom">
            <h3 class="mb-0">Form Submenu</h3>
        </div>
      	 <div class="card-body">
      	 	{!! Form::open(['url' => $url, 'class' => 'form-horizontal', 'files' => true]) !!}
                <div class="form-group">
                    <label class="control-label col-md-3">Parent Menu</label>
                    <br>
                    <div class="col-md-7">
                       <select class="form-control" name="menu_induk" id="menu_induk" style="height: auto;">
                        @foreach($menu as $val)
                           <option value="{{$val->id_menu}}" @if($val->id_menu == $res->parent) selected @endif>{{$val->menu_name}}</option>
                           @endforeach
                       </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Sub Menu</label>
                    <div class="col-md-7">

                        <input type="text" class="form-control" name="nama_submenu" placeholder="Submenu"  @isset($res)  @if($res->parent > 0) value="{{ $res->menu_name }}" @endif  @endisset>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Url</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" name="url" placeholder="/menu/submenu" @isset($res)  @if($res->parent > 0) value="{{ $res->url }}" @endif @endisset>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3">Urutan</label>
                    <div class="col-md-7">
                        <input type="number" class="form-control" name="urutan" min="0" placeholder="" @isset($res)  @if($res->parent > 0) value="{{ $res->order }}" @endif @endisset>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3">Icon</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" name="icon"  placeholder="font-awesome - fa-home"  @isset($res)  @if($res->parent > 0) value="{{ $res->icon }}" @endif @endisset>
                    </div>
                </div>
            
                <div class="form-group">
                    <label class="control-label col-md-3">Keterangan</label>
                    <div class="col-md-7">
                        <textarea class="form-control" name="ket">@isset($res)  @if($res->parent > 0) {{ $res->ket }} @endif @endisset</textarea>
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