@include('header')
<style type="text/css">
  .button_form{width: 80px}
</style>
<?php 
  if($page == 'create'){
    $level2 = '|-|';
    $level1 = '';
    $id_data = '0';
  } else {
    $id_data = $data->id;
    if($data->level_1 != '0'){
      $level1 = $data->level_1;
      if($data->level_2 != '0'){
        $level1 = $data->level_2;
        $level2 = $data->level_1;
      } else {
        $level2 = '';
      }
    } else {
      $level1 = '';
      $level2 = '|-|';
    }
  }

  if($page == 'view'){
    $view = 'disabled';
    if($data->level_2 == '0'){
      $level2 = '|-|';
    }
  } else {
    $view = '';
  }
?>
<div class="padding">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
      	 <div class="box-divider m-0"></div>
      	 <div class="box-header bg-info">
      	 	<h4 class="text-white">Form </h4>
      	 </div>
      	 <div class="box-body">
          <div class="col-md-12">
          @if($page != 'view')
        	 {!! Form::open(['url' => $url, 'class' => 'form-horizontal', 'files' => true]) !!}
          @endif<br>
             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3">Hierarchy</label>
                 <div class="col-md-7">
                     <select class="form-control select2" style="width: 100%" id="level_1" name="level_1" {{$view}}>
                       <option value="0" @isset($data) @if($data->level_1 == '0') selected @endif @endisset>- Main Category -</option>
                       @foreach($level_1 as $val)
                       <option value="{{$val->id}}" 
                        @isset($data) 
                          @if($data->level_2 == 0)
                            @if($data->level_1 == $val->id) selected @endif  
                          @else
                            @if($data->level_2 == $val->id) selected @endif  
                          @endif
                        @endisset>{{$val->nama_kategori_en}}</option>
                       @endforeach
                     </select>
                 </div>
             </div>

             <div id="input_level_2">
               <div class="form-group row">
                <div class="col-md-1"></div>
                   <label class="control-label col-md-3">Sub Hierarchy</label>
                   <div class="col-md-7">
                       <select class="form-control select2" style="width: 100%" id="level_2" name="level_2" {{$view}}>
                       </select>
                   </div>
               </div>
             </div>

             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3">Category Product (EN)</label>
                 <div class="col-md-7">
                     <input type="text" class="form-control" name="product_en" autocomplete="off" required placeholder="Input" {{$view}}  @isset($data) value="{{ $data->nama_kategori_en }}" @endisset>
                 </div>
             </div>

             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3">Category Product (IN)</label>
                 <div class="col-md-7">
                     <input type="text" class="form-control" name="product_in" autocomplete="off" required placeholder="Input" {{$view}}  @isset($data) value="{{ $data->nama_kategori_in }}" @endisset>
                 </div>
             </div>

             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3">Category Product (CHN)</label>
                 <div class="col-md-7">
                     <input type="text" class="form-control" name="product_chn" autocomplete="off" placeholder="Input" {{$view}}  @isset($data) value="{{ $data->nama_kategori_chn }}" @endisset>
                 </div>
             </div>

             <div class="form-group row">
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3">Type</label>
                 <div class="col-md-7">
                     <select class="form-control" name="type" required {{$view}}>
                       <option value="" style="display: none;">- Select Type -</option>
                       <option value="-" @isset($data) @if($data->type == '-') selected @endif @endisset>-</option>
                       <option value="Main Products" @isset($data) @if($data->type == 'Main Products') selected @endif @endisset>Main Products</option>
                       <option value="Prespective Products" @isset($data) @if($data->type == 'Prespective Products') selected @endif @endisset>Prespective Products</option>
                     </select>
                 </div>
             </div>

             <div class="form-group row" id="icon" @isset($data) @if($data->level_1 != '0') style="display:none;" @endif @endisset>
              <div class="col-md-1"></div>
                 <label class="control-label col-md-3">Icon</label>
                 <div class="col-md-7">
                     <input type="file" class="form-control" name="icon" accept="image/*">
                     @isset($data)
                     <input type="hidden" name="lastest_icon" value="{{$data->logo}}">
                     @endisset
                 </div>
             </div>
        
             <div class="form-group row">
                <div class="col-md-11">
                  <div align="right">
                    <a href="{{route('management.category-product.index')}}" class="btn btn-danger button_form">@if($page != 'view') Cancel @else Back @endif</a>
                      @if($page != 'view')
                          <button class="btn btn-primary button_form" type="submit">Submit</button>
                      @endif
                  </div>
                </div>
             </div>
          @if($page != 'view')
            {!! Form::close() !!}
          @endif
          </div>
      	 </div>
      </div>
     </div>
  </div>
</div>

@include('footer')
<script type="text/javascript">
  $(document).ready(function () {
    var level2 = "{{$level2}}";
    var update = "{{$id_data}}";

    if(level2 == '|-|'){
      $('#input_level_2').css('display','none');
    } else {
      var id = "{{$level1}}";
       $.ajax({
          url: "{{route('management.category-product.level2')}}",
          type: 'get',
          data: {
            id:id,
            except:update
          },
          dataType: 'json',
          success:function(response){
            $('#level_2').append(response);
            if(level2 != 0){
              $('#level_2').val(level2);
            } else {
              $('#level_2').val(0);
            }
              $('#level_2').trigger('change');
          }
        });
    }

    $('#level_1').on('change', function(){
      var data = this.value;
      $('#level_2').empty().trigger("change");;
      $("#first").prop("disabled", true);
      if(data != '0'){
        $.ajax({
            url: "{{route('management.category-product.level2')}}",
            type: 'get',
            data: {id:data,except:update},
            dataType: 'json',
            success:function(response){
              $('#level_2').append(response);
            }
        });
        $('#input_level_2').show('fast');
        $('#icon').hide('fast');
      } else {
        $('#icon').show('fast');
        $('#input_level_2').hide('fast');
      }
    });
  });
</script>