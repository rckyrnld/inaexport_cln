
    <div id="form_penjual" style="display: block;">
        <div class="form-row">
            <div class="form-group col-sm-4" align="left">
                <label>
                    <font color="red">*</font> @lang("login.forms.prov")
                </label>
            </div>
            <div class="form-group col-sm-8" align="left">
                <select class="form-control" name="prov_penjual" id="prov_seller">
                    <option value="">- Choose Province -</option>
                    <?php
                    $qc = DB::select("select id,province_en from mst_province order by province_en asc");
                    foreach($qc as $cq){
                    ?>
                    <option value="<?php echo $cq->id; ?>"><?php echo $cq->province_en; ?></option>

                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-sm-4" align="left">
                <label>
                    <font color="red">*</font> @lang("register2.forms.email")
                </label>
                &nbsp;&nbsp;&nbsp;<span id="cekmail_seller"></span>
            </div>
            <div class="form-group col-sm-8" align="left">
                <input type="text" onkeyup="cekmail_seller()" name="email_penjual" id="email_seller"
                    class="form-control" style=" color: black; " required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-sm-4" align="left">
                <label>
                    <font color="red">*</font> @lang("register2.forms.password")
                </label>

            </div>
            <div class="form-group col-sm-8" align="left">
                <input type="password" name="password_penjual" id="password_seller" class="form-control"
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
                <input type="password" name="kpassword_penjual" id="kpassword_seller" class="form-control"
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
                    <font color="red">*</font> @lang("register2.forms.company")
                </label>


            </div>
            <div class="form-group col-sm-2" align="left">
                <select id="badanusaha_seller" name="badanusaha_penjual" class="form-control" required>
                    <option>-</option>
                    <?php
                        $bns = DB::select("select * from eks_business_entity");
                        foreach($bns as $val){
                        ?>
                        <option value="<?php echo $val->nmbadanusaha; ?>"><?php echo $val->nmbadanusaha; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group col-sm-6" align="left">
                <input style="text-transform:uppercase" type="text" name="company_penjual" id="company_seller"
                    class="form-control" style=" color: black; " required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-sm-4" align="left">
                <label>
                    <font color="red">*</font> PIC (Name)
                </label>
            </div>
            <div class="form-group col-sm-8" align="left">
                <input type="text" name="pic_penjual" id="pic_seller" class="form-control"
                    style=" color: black; ">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-sm-4" align="left">
                <label>
                    <font color="red">*</font> @lang("register2.forms.phone")
                </label>
            </div>
            <div class="form-group col-sm-8" align="left">
                <div class="row">
                    <div class="col-md-2">
                        <input type="text" value="+62" class="form-control" disabled
                            style="padding: .105rem .20rem; ">
                    </div>
                    <div class="col-md-10"><input type="text" name="phone_penjual" id="phone_seller"
                            class="form-control " style=" color: black;"></div>
                </div>
            </div>
        </div>
    </div>