@extends('layouts.pimpinan')
@section('css')
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap.css') }}">
    <style>
        img.zoom {
            width: 130px;
            height: 100px;
            -webkit-transition: all .2s ease-in-out;
            -moz-transition: all .2s ease-in-out;
            -o-transition: all .2s ease-in-out;
            -ms-transition: all .2s ease-in-out;
        }

        .transisi {
            -webkit-transform: scale(1.8);
            -moz-transform: scale(1.8);
            -o-transform: scale(1.8);
            transform: scale(1.8);
        }
    </style>
@endsection

@section('content')
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.index') }}"><i class="fa fa-home"></i> Home</a></li>
            <li class="active">Data Aset</li>
        </ol>
        <br />
    </section>
    <section class="content">
        @if (\Session::has('msg_success'))
            <h5>
                <div class="alert alert-info">
                    {{ \Session::get('msg_success') }}
                </div>
            </h5>
        @endif
        @if (\Session::has('msg_error'))
            <h5>
                <div class="alert alert-danger">
                    {{ \Session::get('msg_error') }}
                </div>
            </h5>
        @endif
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-danger">
                    <div class="box-header">
                        <h3 class="box-title">Data Aset</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-warning btn-md" data-toggle="modal"
                                data-target="#modalPrintAset"><i class="fa fa-print"> Lap. Aset
                                </i></button>
                            <button type="button" class="btn btn-warning btn-md" data-toggle="modal"
                                data-target="#modalPrintKondisi"><i class="fa fa-print"> Lap. Kondisi Aset
                                </i></button>
                        </div>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-striped" id="data-aset">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Kode Aset</th>
                                    <th>Nama Aset</th>
                                    <th>Ketegori</th>
                                    <th>Lokasi</th>
                                    <th>Tanggal Pengadaan</th>
                                    <th>Jumlah</th>
                                    <th>Satuan</th>
                                    <th style="display: none">Harga Satuan</th>
                                    <th>Harga Satuan</th>
                                    <th>Tipe Penyusutan</th>
                                    <th>Harga Perolehan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (@$aset as $key => $value)
                                    <tr>
                                        <td>{{ @$value->id }}</td>
                                        <td>{{ @$value->kode_aset }}</td>
                                        <td>{{ @$value->nama_aset }}</td>
                                        <td>{{ @$value->kategori }}</td>
                                        <td>{{ @$value->lokasi }}</td>
                                        <td>{{ @$value->tanggal_pengadaan }}</td>
                                        <td>{{ @$value->jumlah }}</td>
                                        <td>{{ @$value->satuan }}</td>
                                        <td style="display: none">{{ @$value->harga_satuan }}</td>
                                        <td>Rp.{{ number_format($value->harga_satuan, 0, ',', '.') }}</td>
                                        <td>{{ @$value->tipe_penyusutan }}</td>
                                        <td>Rp.{{ number_format(@$value->harga_perolehan, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="modalPrintAset" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Form Print Laporan Aset</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('pdfAset') }}" method="post" enctype="multipart/form-data" target="_blank">
                        {{ csrf_field() }}
                        <div class="form-group has-feedback">
                            <label>Pilih Tanggal :</label>
                            <input type="date" name="tahun" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-xs-4 col-xs-offset-8">
                                <button type="submit" class="btn btn-primary btn-block btn-flat">Print</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalPrintKondisi" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Form Print Laporan Kondisi</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('pdfKondisi') }}" method="post" enctype="multipart/form-data" target="_blank">
                        {{ csrf_field() }}
                        <div class="form-group has-feedback">
                            <label>Pilih Tanggal :</label>
                            <input type="date" name="tahun" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-xs-4 col-xs-offset-8">
                                <button type="submit" class="btn btn-primary btn-block btn-flat">Print</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">
        var table = $('#data-aset').DataTable();

        $('#data-aset').on('click', '.btn-edit-aset', function() {
            row = table.row($(this).closest('tr')).data();
            console.log(row);
            $('input[name=id]').val(row[0]);
            $('input[name=kodeAset]').val(row[1]);
            $('input[name=namaAset]').val(row[2])
            $('input[name=kategori]').val(row[3])
            $('select[name=lokasi]').val(row[4])
            $('input[name=tanggalPengadaan]').val(row[5]);
            $('input[name=jumlah]').val(row[6]);
            $('select[name=satuan]').val(row[7]);
            $('input[name=hargaSatuan]').val(row[8]);
            $('select[name=tipePenyusutan]').val(row[10]);
            $('#modal-form-edit-aset').modal('show');
        });
        $('#modal-form-tambah-aset').on('show.bs.modal', function() {
            $('input[name=id]').val('');
            $('input[name=nama]').val('');
            $('textarea[name=deskripsi]').val('');
            $('textarea[name=alamat]').val('');
            $('input[name=telp]').val('');
            $('input[name=jadwal]').val('');
            $('input[name=hargaTiket]').val('');
            $('input[name=umpan]').val('');
            $('input[name=fasilitas]').val('');
        });

        $(document).ready(function() {
            $('.zoom').hover(function() {
                $(this).addClass('transisi');
            }, function() {
                $(this).removeClass('transisi');
            });
        });
    </script>
@endsection
