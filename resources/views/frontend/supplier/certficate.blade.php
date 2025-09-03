@foreach ($certificate as $certif)
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" style="text-transform: Capitalize;">{{ $certif->name }}</h4>
                                            <button type="button" class="close"
                                                data-dismiss="modal">&times;</button>
                                        </div> <a style="color:#205871; text-transform: Capitalize;"><b>
                                            <center>{{ $certif->name }}</center>
                                        </b></a>
                                        <div class="modal-body">
                                            <center><img
                                                    src="{{ asset('uploads/Certificate/' . $certif->id_itdp_profil_eks . '/' . $certif->image) }}"
                                                    style="border-radius:7px"></center>
                                            
                                            <div class="card-body">
                                                <table class="table table-bordered table-light table1">
                                                    <tbody>
                                                        <tr>
                                                            <td width="20%" class="table-active">
                                                                <b> Reference No </b>
                                                            </td>
                                                            <td width="30%">
                                                                {{-- <span id="no_ref"></span> --}}
                                                                {{ $certif->no_ref }}
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td width="20%" class="table-active">
                                                                <b> Category </b>
                                                            </td>
                                                            <td width="30%">
                                                                {{-- <span id="category"></span> --}}
                                                                {{ $certif->category }}
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td width="20%" class="table-active">
                                                                <b> Type of Certificate </b>
                                                            </td>
                                                            <td width="30%">
                                                                {{-- <span id="type"></span> --}}
                                                                {{ $certif->type }}
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td width="20%" class="table-active">
                                                                <b> This Certificate Valid From </b>
                                                            </td>
                                                            <td width="50%">
                                                                {{-- <span id="date"></span> --}}
                                                                <b>{{ date('d M Y', strtotime($certif->start_date)) }}</b>
                                                                Until
                                                                <b>{{ date('d M Y', strtotime($certif->end_date)) }}
                                                            </td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach