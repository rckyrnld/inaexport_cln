<div align="center" style="width: 100%">
    <div align="center" style="width: 580px;">
        <img height="100%" width="580px" src="{{url('assets')}}/assets/images/headeremail3.png" alt="." >
        <p style="text-align: left">Yth. {{$nama_perusahaan}},</P>
        <p style="text-align: left">Ini adalah email notifikasi adanya informasi trade inquiry terbaru di Inaexport.</p>
        <br>
        <table>
            <tr>
                <td>Tanggal Inqury</td>
                <td>:</td>
                <td>{{ date('d/m/Y', strtotime($tanggal_inquiry)) }}</td>
            </tr>
            <tr>
                <td>Negara Buyer</td>
                <td>:</td>
                <td>{{ $negara_buyer_or_perwadag }}</td>
            </tr>
            <tr>
                <td>Produk yang dicari</td>
                <td>:</td>
                <td>{{ $subyek }}</td>
            </tr>
            <tr>
                <td>Masa aktif inquiry</td>
                <td>:</td>
                <td>{{ $valid }} hari</td>
            </tr>
        </table>
        <br>

        <p style="text-align: left"> Anda dapat melihat detail inquiry dengan mengakses halaman <a href="{{url('front_end/ourinqueris/')}}">Trade Inquiry</a> di Inaexport</p>
        <br>
        <p style="text-align: left"><b>*Email ini dibuat secara otomatis. Mohon tidak mengirimkan balasan ke email ini.</b></p>
        <img height="100%" width="580px" src="{{url('assets')}}/assets/images/footeremail3.png" alt="." >
    </div>
</div>