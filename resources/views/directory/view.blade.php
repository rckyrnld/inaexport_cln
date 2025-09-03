@include('header')
<style type="text/css">
  .button_form{width: 80px}
  input:read-only{ background-color:white !important}
  input:disabled{ background-color:white !important}
  input[type="text"], input[type="text"]:focus, input[type="file"], input[type="file"]:focus{
    border-color: #d6d9daad;
  }
</style>
<div class="padding">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
      	 <div class="box-divider m-0"></div>
      	 <div class="box-header bg-info">
      	 	<h4 class="text-white">Profile Company</h4>
         </div>
      	 <div class="box-body">
          <div class="col-md-12"><br>
             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3">Company Name</label>
                 <div class="col-md-7">
                     <input type="text" class="form-control" value="{{$data->company}}" readonly/ >
                 </div>
             </div>

             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3">Address</label>
                 <div class="col-md-7">
                     <input type="text" class="form-control" value="{{$data->addres}}" readonly/ >
                 </div>
             </div>

             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3">Country</label>
                 <div class="col-md-7">
                     <input type="text" class="form-control" value="{{rc_country($data->id_mst_country)}}" readonly/ >
                 </div>
             </div>

             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3">Post Code</label>
                 <div class="col-md-7">
                  <input type="text" class="form-control" value="{{$data->postcode}}" readonly/ >
                 </div>
             </div>

             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3">Telephone</label>
                 <div class="col-md-7">
                  <input type="text" class="form-control" value="{{$data->phone}}" readonly/ >
                 </div>
             </div>

             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3">Fax</label>
                 <div class="col-md-7">
                  <input type="text" class="form-control" value="{{$data->fax}}" readonly/ >
                 </div>
             </div>

             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3">Email</label>
                 <div class="col-md-7">
                  <input type="text" class="form-control" value="{{$data->email}}" readonly/ >
                 </div>
             </div>

             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3">Website</label>
                 <div class="col-md-7">
                  <input type="text" class="form-control" value="{{$data->website}}" readonly/ >
                 </div>
             </div>

             <div class="form-group row">
                <div class="col-md-11">
                  <div align="right">
                    <a href="{{route('directory.index')}}" class="btn btn-danger button_form">Back</a>
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