<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">

                <p>A confirmation email has been sent to your mailbox.<br>
                    Please check your spam folder if you are having trouble receiving email.
                </p>
                <p>To make inquiries and buying requests please wait for the verification process from our
                    representatives abroad</p>

            </div>
            <div class="modal-footer">
                <a href="http://inaexport.id" type="button" class="btn btn-danger">Close</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal_buyer" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">

                <p>A confirmation email has been sent to your mailbox.<br>
                Please check your spam folder if you are having trouble receiving email.
                </p>
                <p>To make inquiries and buying requests please wait for the verification process from our representatives abroad.</p>

            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> -->
                <a href="{{url('/login')}}" type="button" class="btn btn-danger">Close</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal_suplier" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">

                <p>
                    Silahkan login ke aplikasi untuk melengkapi data profile perusahaan anda agar<br>
                    dapat di diterima sebagai anggota di inaexport oleh admin.<br><br>
                    Data <b>NPWP</b> dan Data <b>NIB</b> adalah mandatory untuk dapat di terima sebagai anggota di inaexport.
                </p>

                {{-- <p>Silahkan periksa email Anda untuk mengaktifkan akun.<br>
                    Anda dapat login menggunakan akun anda pada aplikasi.
                </p>
                <p>Untuk mengunggah produk Anda, silakan login dan unggah beberapa dokumen yang diperlukan terlebih dahulu.</p>
                <h5 style="padding-left: 20;">
                    <ol>
                        <li>NPWP (Mandatory)</li>
                        <li>NIB (Mandatory)</li>
                    </ol>
                </h5>
                <p>Jika Anda tidak mendapat email dari Inaexport dalam beberapa menit, cek folder spam/junk Anda.</p> --}}

            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> -->
                <a href="{{url('/login')}}" type="button" class="btn btn-danger">Close</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal_error" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">

                <p>Error.<br>
                    Please make sure the email used for register has not been registered in Inaexport!
                </p>
                {{-- <p>To make inquiries and buying requests please wait for the verification process from our representatives abroad</p> --}}

            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> -->
                <a href="{{ url('createnewaccount') }}" type="button" class="btn btn-danger">Close</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal_error_seller" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">

                <p>Error.<br>
                    Pastikan email yang anda gunakan untuk daftar belum pernah terdaftar di aplikasi Inaexport!
                </p>
                {{-- <p>To make inquiries and buying requests please wait for the verification process from our representatives abroad</p> --}}

            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> -->
                <a href="{{ url('createnewaccount') }}" type="button" class="btn btn-danger">Close</a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-view-notif" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">View All Notifications</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-hover dataTable no-footer" id="tableNotif" data-plugin="dataTable">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Dari</th>
                            <th>Untuk</th>
                            <th>Isi Notifikasi</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>