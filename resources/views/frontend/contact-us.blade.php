@include('frontend.layouts.header')
<style type="text/css">
    td span{
        font-size: 18px;font-weight: 400; padding-left: 8px;
    }
    .container .col-md-5{
        height: 60vh;
        background-size: cover;
        position: relative;
        justify-content: center;
        align-items: center;
    }
    .container .form-group {
		background-image: url('./assets/assets/versi 1/Asset 23 (1).png' );
        background-size: cover;
    }
</style>
<!-- Kontent 1-->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-12 col-12" style="padding-top: 20px; padding-bottom: 20px; height: 100%;">
            <div class="mapouter">
                <div class="gmap_canvas">
                    <iframe width="100%" height="400px" id="gmap_canvas" src="https://maps.google.com/maps?q=Ministry%20of%20Trade%20of%20The%20Republic%20of%20Indonesia&t=&z=17&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" ></iframe><a href="https://www.embedgooglemap.net/blog/torguard-promo-code/"></a>
                </div>
                <style>.mapouter{position:relative;text-align:right;width:100%;}.gmap_canvas {overflow:hidden;background:none!important;width:100%;}</style>
            </div>
        </div>
    </div>
</div>
<!-- Kontent 3 -->
<div class="container">
    <div class="row">
        <div class="col-md-12 col-lg-12 col-12" style="padding: 20px 20px; height: 100%;">
			<div class="form-group row">
                <div class="col-md-8 col-lg-8 col-12" style="padding-bottom: 30px;">
                <br>
                    <p><span style="font-size: 18px; text-transform: uppercase;"><b>@lang("frontend.cu-add-kontak")</b></span></p>
                    <!--<span style="font-size: 46px">@lang("frontend.cu-add-free")</span><br>
                    <span style="font-size: 20px;line-height:2px;">@lang("frontend.service-title")<br>@lang("footer.foot.directorate")</span><br><br>-->
                    <form action="{{url('/contact-us/send/')}}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-row pb-3">
                            <div class="col">
                                <label>@lang("frontend.cu-fullname")</label>
                                <input type="text" class="form-control" name="name" autocomplete="off" required style="border-radius: 5px;" />
                                <input type="hidden" name="urlnya" value="/contact-us/">
                            </div>
                            <div class="col">
                                <label>@lang("frontend.cu-email")</label>
                                <input type="email" class="form-control" name="email" autocomplete="off" required style="border-radius: 5px;" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label>@lang("frontend.cu-subyek")</label>
                            <input type="text" class="form-control" name="subyek" autocomplete="off" required style="border-radius: 5px;" />
                        </div>
                        <div class="form-group">
                            <label>@lang("frontend.cu-message")</label>
                            <textarea style="resize: none; border-radius: 0px;" name="message" autocomplete="off" required class="form-control" rows="5"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" style="border-radius: 5px;">@lang("button-name.submit")</button>
                    </form>
                </div>
                    <div class="col-md-5 col-lg-4 col-12">
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <p><span style="font-size: 18px;"><b>INAEXPORT</b></span><br>
                        <!--@lang("footer.foot.directorate")--></p>
                        <p>@lang("frontend.cu-add-email"):<br> mail@inaexport.id</p>
                        <p>@lang("frontend.cu-add-visit"):<br>
                        Jl. M.I. Ridwan Rais No.5, RT.7/RW.1, Gambir, Kecamatan Gambir, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10110, Indonesia
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- End -->
@include('frontend.layouts.footer')