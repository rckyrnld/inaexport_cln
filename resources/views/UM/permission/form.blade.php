@extends('header2')
@section('content')

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header border-bottom">
                    <h3 class="mb-0"><b>Hak Akses Menu</b></h3>
                </div>
                <div class="card-body">

                    {!! Form::open(['url' => '/permission_update/' . $id, 'class' => 'form-horizontal', 'files' => true]) !!}
                    <div class="col-md-12">
                        <div class="row">
                            <div class="table-responsive">
                                <table id="" class="table table-striped table-hover">
                                    <thead class="text-white" style="background-color:#6B7BD6">
                                        <tr>
                                            <th>
                                                <center>No</center>
                                            </th>
                                            <th>
                                                <center>Nama Menu</center>
                                            </th>
                                            <th>
                                                <center>Url</center>
                                            </th>
                                            <th>
                                                <center>Urutan</center>
                                            </th>
                                            <th>
                                                <center>Icon</center>
                                            </th>
                                            <th width="15%">
                                                <center>Read</center>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        @foreach ($menu as $res)
                                            @if ($res->parent == 0)
                                                <?php
                                                $chek = DB::table('permissions')
                                                    ->where('id_menu', $res->id_menu)
                                                    ->where('id_group', $id)
                                                    ->first();
                                                ?>
                                                <tr>
                                                    <td>
                                                        <center>{{ $no++ }}</center>
                                                    </td>
                                                    <td>
                                                        <div align="left"><b>{{ $res->menu_name }}</div></b>
                                                    </td>
                                                    <td>
                                                        <div class='text-wrap' style='width:200px'>{{ $res->url }}</div>
                                                    </td>
                                                    <td>
                                                        <center>{{ $res->order }}</center>
                                                    </td>
                                                    <td>
                                                        <div class='text-wrap' style='width:200px'>{{ $res->icon }}</div>
                                                    </td>
                                                    <td>
                                                        <center>
                                                            <input type="checkbox" name="id_menu[]"
                                                                value="{{ $res->id_menu }}" @isset($chek->id_menu)
                                                            @if ($res->id_menu == $chek->id_menu) checked="checked"  @endif @endisset>
                                                        </center>
                                                    </td>
                                                </tr>
                                            @endif

                                            @foreach ($menu as $restwo)
                                                @if ($res->id_menu == $restwo->parent)

                                                    <?php
                                                    $chek = DB::table('permissions')
                                                        ->where('id_menu', $restwo->id_menu)
                                                        ->where('id_group', $id)
                                                        ->first();
                                                    ?>

                                                    <tr>
                                                        <td>

                                                        </td>
                                                        <td>
                                                            <div align="left">{{ $restwo->menu_name }}</div>
                                                        </td>
                                                        <td>
                                                            <div class='text-wrap' style='width:200px'>{{ $restwo->url }}
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <center>{{ $restwo->order }} </center>
                                                        </td>
                                                        <td>
                                                            <div class='text-wrap' style='width:200px'>{{ $restwo->ket }}
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <center>
                                                                <input type="checkbox" name="id_menu[]"
                                                                    value="{{ $restwo->id_menu }}" @isset($chek->id_menu)
                                                                @if ($restwo->id_menu == $chek->id_menu) checked="checked"  @endif @endisset>
                                                            </center>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach

                                        @endforeach
                                    </tbody>
                                </table>

                                <br>
                                <button type="submit" class="btn btn-info"><i class="fa fa-save"></i> Simpan</button>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            @include('footer')
        @endsection
