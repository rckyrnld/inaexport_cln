{{-- @include('header') --}}
@extends('header2')
@section('content')
<style type="text/css">
  .button_form{width: 80px}
</style>

{{-- <div class="padding"> --}}
  <div class="row">
    <div class="col">
      <div class="card">
        <div class="card-header border-bottom">
          <h3 class="mb-0"><b>Message</b></h3>
      </div>
      <div class="card-body">
             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3"><b>Full Name</b></label>
                 <div class="col-md-7">
                     <input type="text" id="id" class="form-control integer" name="name" autocomplete="off" required placeholder="Input" disabled value="{{ $data->fullname }}">
                 </div>
             </div>

             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3"><b>Email</b></label>
                 <div class="col-md-7">
                     <input type="email" class="form-control" name="email" autocomplete="off" required placeholder="Input" disabled value="{{ $data->email }}">
                 </div>
             </div>

             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3"><b>Subject</b></label>
                 <div class="col-md-7">
                     <input type="text" class="form-control" name="subyek" autocomplete="off" required placeholder="Input" disabled value="{{ $data->subyek }}">
                 </div>
             </div>

             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3"><b>Messages</b></label>
                 <div class="col-md-7">
                     <textarea class="form-control" name="message" rows="16" disabled/>{{ $data->message }}</textarea>
                 </div>
             </div>
        
             <div class="form-group row">
                <div class="col-md-11">
                  <div align="right">
                    <a href="{{route('management.contact-us.index')}}" class="btn btn-danger button_form"><i class="fas fa-arrow-circle-left"></i> Back</a>
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
@endsection