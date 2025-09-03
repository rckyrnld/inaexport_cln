<style>
    .img-circle {
        background-color: #FFFFFF;
        margin-bottom: 10px;
        padding: 4px;
        border-radius: 50% !important;
        max-width: 100%;
    }

</style>
<?php 
					$qwr = DB::select("select * from csc_buying_request_chat where id_br='".$id."' and id_join='".$id2."'");
					foreach($qwr as $r){
					?>

<?php if($r->id_pengirim == Auth::guard('eksmp')->user()->id){?>
<li class="right clearfix"><span class="chat-img pull-right">
        <img src="https://place-hold.it/50x50/FA6F57/fff&text=ME&fontsize=13" alt="User Avatar" class="img-circle" />
    </span>
    <div class="chat-body clearfix pull-right">
        <div class="header">
            <strong class=" text-muted"><span
                    class="pull-right primary-font"></span><b><?php echo $r->username_pengirim; ?></b></strong>
            <small class="glyphicon glyphicon-time"> (<?php echo $r->tanggal; ?>)</small>
        </div>
        <p>
            <?php echo $r->pesan; ?>

        </p>
        <p>
            <?php if(empty($r->files)){}else{?>
            <br><a target="_BLANK" href="{{ asset('uploads/pop/' . $r->files) }}">
                <font color="green"><?php echo $r->files; ?></font>
            </a>
            <?php } ?>
        </p>
    </div>
</li>
<?php }else{ ?>
<li class="left clearfix"><span class="chat-img pull-left">
        <img src="https://place-hold.it/50x50/55C1E7/fff&text=H&fontsize=13" alt="User Avatar" class="img-circle" />
    </span>
    <div class="chat-body clearfix">
        <div class="header">
            <strong class=" text-muted"><span
                    class="pull-right primary-font"></span><b><?php echo $r->username_pengirim; ?></b></strong>
            <small class="glyphicon glyphicon-time"> (<?php echo $r->tanggal; ?>)</small>
        </div>
        <p>
            <?php echo $r->pesan; ?>

        </p>
        <p>
            <?php if(empty($r->files)){}else{?>
            <br><a target="_BLANK" href="{{ asset('uploads/pop/' . $r->files) }}">
                <font color="green"><?php echo $r->files; ?></font>
            </a>
            <?php } ?>
        </p>
    </div>
</li>
<?php } ?>


<?php } ?>
