@include('frontend.layouts.header')
<style type="text/css">
  .myImg {
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
    width: 20%;
  }

  .myImg:hover {opacity: 0.7;}

  /* The Modal (background) */
  .modal {
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
  }

  /* Modal Content (image) */
  .modal-content {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
  }

  /* Caption of Modal Image */
  #caption {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
    text-align: center;
    color: #ccc;
    padding: 10px 0;
    height: 150px;
  }

  /* Add Animation */
  .modal-content, #caption {  
    -webkit-animation-name: zoom;
    -webkit-animation-duration: 0.6s;
    animation-name: zoom;
    animation-duration: 0.6s;
  }

  @-webkit-keyframes zoom {
    from {-webkit-transform:scale(0)} 
    to {-webkit-transform:scale(1)}
  }

  @keyframes zoom {
    from {transform:scale(0)} 
    to {transform:scale(1)}
  }

  /* The Close Button */
  .close {
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
  }

  .close:hover,
  .close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
  }

  /* 100% Image Width on Smaller Screens */
  @media only screen and (max-width: 700px){
    .modal-content {
      width: 100%;
    }
  }
</style>
    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="{{url('/')}}">@lang('frontend.proddetail.home')</a></li>
                            <li>@lang('frontend.listtran')</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->

    <!--product details start-->
    <div class="product_details mt-20" style="background-color: #ddeffd; font-size: 13px; margin-bottom: 0px !important;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <br><br>
                    <h5><b>@lang('frontend.listtran')</b></h5>
                    <br>
                    <!-- <div class="table-responsive"> -->
                      <table id="tabletransaction" class="table table-bordered table-striped" style="width: 100%; text-transform: capitalize;">
                        <thead class="text-white" style="background-color: #2492EB; color: white;">
                          <tr>
                            <th width="5%">
                              <center>@lang('inquiry.number')</center>
                            </th>
                            <th width="20%">
                              <center>@lang('inquiry.prodname')</center>
                            </th>
                            <th width="15%">
                              <center>@lang('inquiry.list.exportir')</center>
                            </th>
                            <th width="15%">
                              <center>@lang('inquiry.list.date')</center>
                            </th>
                            <th>
                              <center>@lang('inquiry.list.origin')</center>
                            </th>
                            <th>
                              <center>@lang('inquiry.status')</center>
                            </th>
                            <th>
                              <center>@lang('inquiry.list.notrack')</center>
                            </th>
                          </tr>
                        </thead>
                      </table>
                    <!-- </div> -->
                    <br>
                </div>
            </div>
        </div>
    </div>
  </form>
  <!--product details end-->

  <!-- The Modal -->
  <!-- <div id="modalImage" class="modal">
    <button type="button" class="close" data-dismiss="modal">&times;</buttontype="button">
    <center>
      <img class="modal-content" id="img01">
    </center>
    <div id="caption"></div>
  </div> -->

  <div class="modal" id="modalImage">
    <div class="modal-dialog">
      <!-- <div class="modal-content"> -->
        <button type="button" class="close" data-dismiss="modal">&times;</button><br><br>
        <img class="modal-content" id="img01">
      <!-- </div> -->
    </div>
  </div>

@include('frontend.layouts.footer')
<script type="text/javascript">
    $(document).ready(function(){
        $('#tabletransaction').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('front.datatables.transaction') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'prodname', name: 'prodname'},
                {data: 'exportir', name: 'exportir'},
                {data: 'date', name: 'date'},
                {data: 'origin', name: 'origin'},
                {data: 'status', name: 'status'},
                {data: 'notrack', name: 'notrack'}
            ]
        });
    });

    function openImage(img) {
      var url = "{{url('/')}}/"+img;
      $('#modalImage').modal('show');
      $('#img01').attr("src", url);
    }
</script>