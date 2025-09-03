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
foreach($messages as $msg){
?>

<?php if($msg->sender == $id_user){?>
<li class="right clearfix">
    <span class="chat-img pull-right">
        <img src="https://place-hold.it/50x50/FA6F57/fff&text=ME&fontsize=13" alt="User Avatar" class="img-circle" />
    </span>
    <div class="chat-body clearfix pull-right">
        <div class="header">
            <strong class=" text-muted"><span class="pull-right primary-font"></span><b>You</b></strong>
            <small class="glyphicon glyphicon-time"> (<?php
$datenya = date('d-m-Y', strtotime($msg->created_at));
echo $datenya; ?>)</small>
        </div>
        <p>
            {{ $msg->messages }}

        </p>
        <p>
            <?php if(empty($msg->file)){}else{?>
            <br><a target="_BLANK" href="{{ url('/') . '/uploads/ChatFileInquiry/' . $msg->id }}/{{ $msg->file }}">
                <font color="green"><?php echo $msg->file; ?></font>
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
                    class="pull-right primary-font"></span><b>{{ getCompanyName($msg->sender) }}</b></strong>
            <small class="glyphicon glyphicon-time"> (<?php
$datenya = date('d-m-Y', strtotime($msg->created_at));
echo $datenya; ?>)</small>
        </div>
        <p>
            {{ $msg->messages }}

        </p>
        <p>
            <?php if(empty($msg->file)){}else{?>
            <br><a target="_BLANK" href="{{ url('/') . '/uploads/ChatFileInquiry/' . $msg->id }}/{{ $msg->file }}">
                <font color="green"><?php echo $msg->file; ?></font>
            </a>
            <?php } ?>
        </p>
    </div>
</li>
<?php } ?>


<?php }  ?>
