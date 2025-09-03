
    <div id="form_pembeli" style="display: none;">
        <div class="form-row">
            <div class="form-group col-sm-4" align="left">
                <label>
                    <font color="red">*</font> @lang("login.forms.ct")
                </label>
            </div>
            <div class="form-group col-sm-8" align="left">
                <select class="form-control" name="country" id="country">
                    <option value="">- Choose Country -</option>
                    <?php
                    $qc = DB::select("select id,country from mst_country where Upper(country) != 'INDONESIA' order by country asc");
                    foreach($qc as $cq){
                    ?>
                    <option value="<?php echo $cq->id; ?>"><?php echo $cq->country; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-sm-4" align="left">
                <label>
                    <font color="red">*</font> @lang("register.forms.email")
                </label>&nbsp;&nbsp;&nbsp;<span id="cekmail"></span>
            </div>
            <div class="form-group col-sm-8" align="left">
                <input type="text" name="email" id="email" class="form-control"
                    style=" color: black; " required onkeyup="cekmail()">

            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-sm-4" align="left">
                <label>
                    <font color="red">*</font> @lang("register.forms.password")
                </label>
            </div>
            <div class="form-group col-sm-8" align="left">
                <input type="password" name="password" id="password" class="form-control"
                    style=" color: black; " required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-sm-4" align="left">
                <label>
                    <font color="red">*</font> @lang("register.forms.re-password")
                </label>

            </div>
            <div class="form-group col-sm-8" align="left">
                <input type="password" name="kpassword" id="kpassword" class="form-control"
                    style=" color: black; ">

            </div>
        </div>
        <br>
        <p>
        <h6>Business Information</h6>
        </p>
        <hr>
        <div class="form-row">

            <div class="form-group col-sm-4" align="left">
                <label>
                    <font color="red">*</font> @lang("register.forms.company")
                </label>
            </div>
            <div class="form-group col-sm-8" align="left">
                <input style="text-transform:uppercase" type="text" name="company" id="company"
                    class="form-control" style=" color: black; " required>
            </div>
        </div>
        <div class="form-row">

            <div class="form-group col-sm-4" align="left">
                <label>
                    <font color="red">*</font>@lang("register.forms.username")
                </label>

            </div>

            <div class="form-group col-sm-8" align="left">
                <input type="text" name="username" id="username" class="form-control"
                    style=" color: black; " required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-sm-4" align="left">
                <label>
                    <font color="red">*</font> @lang("register.forms.phone")
                </label>
            </div>
            <div class="form-group col-sm-8" align="left">
                <input type="text" name="phone" id="phone" class="form-control"
                    style=" color: black; ">
            </div>
        </div>
    </div>