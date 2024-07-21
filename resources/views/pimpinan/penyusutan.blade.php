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

        .search {
            margin-left: 35%;
            margin-top: 0px !important;
        }
    </style>
@endsection

@section('content')
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.index') }}"><i class="fa fa-home"></i> Home</a></li>
            <li class="active">Data Penyusutan</li>
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
                        <h3 class="box-title" style="justify-content: center !important">Data Penyusutan</h3>
                        <div class="search">
                            <form action="{{ route('pimpinan.searchPenyusutan') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-xs-4">
                                        <input type="date" name="tahun" class="form-control">
                                    </div>
                                    <div class="col-xs-4">
                                        <button type="submit" class="btn btn-primary mt-3"><i class="fa fa-search"></i>
                                            Cari</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-warning btn-md" data-toggle="modal"
                                data-target="#modalPrintPenyusutan"><i class="fa fa-print"> Print
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
                                    <th>Harga Satuan</th>
                                    <th>Tipe Penyusutan</th>
                                    <th>Harga Perolehan</th>
                                    <th>Umur Ekonomis</th>
                                    <th>Nilai Residu</th>
                                    <th>Penyusutan Pertahun</th>
                                    <th>Sisa Nilai Penyusutan</th>
                                    <th>Sisa Umur Penyusutan</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="modalPrintPenyusutan" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Form Print Data Penyusutan</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('pdfPenyusutan') }}" method="post" enctype="multipart/form-data"
                        target="_blank">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js">
    </script>
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
    <script type="text/javascript">
        $(function() {
            $("#datepicker").datepicker({
                dateFormat: "yy-mm-dd"
            }).val()
        });
    </script>
@endsection
