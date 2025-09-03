@include('frontend.layouts.header')
<!-- Kontent 1-->
<style>
	ul.a {
		list-style-type: disc;
		/* list-style-position: inside; */
		}
</style>
<div class="container" style="padding-bottom: 30px;">
    <div class="row">
        <div class="col-lg-12 col-12" style="padding-top: 30px; padding-bottom: 10px; height: 100%;">
			<p><span style="font-size: 18px;"><b>@lang("frontend.about")</b></span></p>
			<p style="text-align : justify">@lang("frontend.about-det.1")</p>
			<p style="text-align : justify">@lang("frontend.about-det.2")</p>
			<!-- <table>
				<tr>
					<td style="vertical-align: text-top;"><p> 1. &nbsp;&nbsp;&nbsp;&nbsp;</p></td>
					<td><p style="text-align : justify">@lang("frontend.about-det.3")</p></td>
				</tr>
				<tr>
					<td style="vertical-align: text-top;"><p> 2. &nbsp;&nbsp;&nbsp;&nbsp;</p></td>
					<td><p style="text-align : justify">@lang("frontend.about-det.4")</p></td>
				</tr>
				<tr>
					<td style="vertical-align: text-top;"><p> 3. &nbsp;&nbsp;&nbsp;&nbsp;</p></td>
					<td><p style="text-align : justify">@lang("frontend.about-det.5")</p></td>
				</tr>
			</table> -->
			 <ul class="a" >
				<li>
					<p style="text-align : justify">
						@lang("frontend.about-det.4")
					</p>
				</li> 
				<li >
					<p style="text-align : justify">
					@lang("frontend.about-det.4")
					</p>
				</li>
				<li>
					<p style="text-align : justify">
				@lang("frontend.about-det.5")
					</p>
				</li>
			</ul> 
		</div>
	</div>
</div>
<!-- End -->
@include('frontend.layouts.footer')