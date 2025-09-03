<div align="center" style="width: 100%">
    <div align="center" style="width: 580px;">
        <?php
        $valid_date = \Carbon\Carbon::parse($tanggal_inquiry)->addDays($valid);   
        ?>
        <img height="100%" width="580px" src="{{url('assets')}}/assets/images/headeremail3.png" alt="." >
        <p style="text-align: left">Yth. {{$nama_perusahaan}},</P>
        <p style="text-align: left">Ini adalah email reminder adanya trade inquiry pada tanggal {{ date('d/m/Y', strtotime($tanggal_inquiry)) }} dari negara {{ $negara_buyer_or_perwadag }} yang berminat atau mencari produk yang sesuai dengan produk yang Anda miliki yang akan berakhir pada tanggal {{ date('d/m/Y', strtotime($valid_date)) }}.</p>
        <br>
        
        <p style="text-align: left"> Untuk melihat informasi trade inquiry tersebut Anda dapat login terlebih dahulu di Inaexport dan mengakses menu <b>Inquiry/Buying Request.</b></p>
        <br>
        <p style="text-align: left"><b>*Email ini dibuat secara otomatis. Mohon tidak mengirimkan balasan ke email ini.</b></p>
        <img height="100%" width="580px" src="{{url('assets')}}/assets/images/footeremail3.png" alt="." >
    </div>
</div>