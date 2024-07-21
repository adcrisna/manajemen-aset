<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Auth;
use DB;
use App\Models\User;
use App\Models\Aset;
use Carbon\Carbon;
use App\Models\Pemeliharaan;


class AdminController extends Controller
{
    public function index() {
        $title = "Home";
        $aset = Aset::where('status','!=','Dihapus')->get();
        $notif = Pemeliharaan::where('notification',1)->get();
        return view('admin.index', compact('title','aset','notif'));
    }
    public function profile()
    {
        $title = 'Profile';
        $notif = Pemeliharaan::where('notification',1)->get();
        $admin = User::find(Auth::user()->id);
        return view('admin.profile', compact('title','admin','notif'));
    }
    public function updateProfile(Request $request){
        DB::beginTransaction();
        try {
            if (empty($request->foto)) {
                if (empty($request->password)) {
                    $user = User::find($request->id);
                    $user->name = $request->name;
                    $user->email = $request->email;
                    $user->telepon = $request->no_hp;
                    $user->save();
                }else {
                    $user = User::find($request->id);
                    $user->name = $request->name;
                    $user->email = $request->email;
                    $user->telepon = $request->no_hp;
                    $user->password = bcrypt($request->password);
                    $user->save();
                }
            }else {
                if (empty($request->password)) {
                    $user = User::find($request->id);

                    \File::delete(public_path('foto/'.$user->foto));

                    $namafoto = "Foto"."  ".$request->name." ".date("Y-m-d H-i-s");
                    $extention = $request->file('foto')->extension();
                    $photo = sprintf('%s.%0.8s', $namafoto, $extention);
                    $destination = base_path() .'/public/foto';
                    $request->file('foto')->move($destination,$photo);

                    $user->name = $request->name;
                    $user->email = $request->email;
                    $user->telepon = $request->no_hp;
                    $user->foto = $photo;
                    $user->save();
                }else {
                    $user = User::find($request->id);

                    \File::delete(public_path('foto/'.$user->foto));

                    $namafoto = "Foto"."  ".$request->name." ".date("Y-m-d H-i-s");
                    $extention = $request->file('foto')->extension();
                    $photo = sprintf('%s.%0.8s', $namafoto, $extention);
                    $destination = base_path() .'/public/foto';
                    $request->file('foto')->move($destination,$photo);

                    $user->name = $request->name;
                    $user->email = $request->email;
                    $user->telepon = $request->no_hp;
                    $user->foto = $photo;
                    $user->password = bcrypt($request->password);
                    $user->save();
                }
            }
             DB::commit();
            \Session::flash('msg_success','Profile Berhasil Diubah!');
            return Redirect::route('admin.profile');

        } catch (Exception $e) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
            return Redirect::route('admin.profile');
        }
    }
    public function aset()
    {
        $title = 'Data Aset';
        $aset = Aset::where('status','!=','Dihapus')->get();
        $notif = Pemeliharaan::where('notification',1)->get();
        return view('admin.aset', compact('title','aset','notif'));
    }
    public function addAset(Request $request) {
        DB::beginTransaction();
        try {
            $aset = new Aset;
            $aset->kode_aset = $request->kodeAset;
            $aset->nama_aset = $request->namaAset;
            $aset->kategori = $request->kategori;
            $aset->lokasi = $request->lokasi;
            $aset->tanggal_pengadaan = $request->tanggalPengadaan;
            $aset->jumlah = $request->jumlah;
            $aset->satuan = $request->satuan;
            $aset->harga_satuan = $request->hargaSatuan;
            $aset->tipe_penyusutan = $request->tipePenyusutan;

            $hargaPerolehan = $request->hargaSatuan * $request->jumlah;

            $aset->harga_perolehan = $hargaPerolehan;

            if ($request->tipePenyusutan == 'I') {
                $umurEkonomis = 4;
            }elseif ($request->tipePenyusutan == 'II') {
                $umurEkonomis = 8;
            }elseif ($request->tipePenyusutan == 'III') {
                $umurEkonomis = 16;
            }elseif ($request->tipePenyusutan == 'IV') {
                $umurEkonomis = 20;
            }elseif ($request->tipePenyusutan == 'Non Depresi') {
                $umurEkonomis = 0;
            }
            $aset->umur_ekonomis = $umurEkonomis;

            if ($umurEkonomis == 0) {
                $nilaiResidu = 0;
            } else {
                $nilaiResidu = $hargaPerolehan / $umurEkonomis;
            }

            if ($umurEkonomis == 0) {
                $penyusutanPertahun = 0;
            } else {
                $penyusutanPertahun = ($hargaPerolehan - $nilaiResidu) / $umurEkonomis;
            }


            $aset->nilai_residu = $nilaiResidu;
            $aset->penyusutan_pertahun = $penyusutanPertahun;

            $baseYear = date('Y', strtotime($request->tanggalPengadaan));

            $tahun1 = $baseYear;
            $tahun2 = $baseYear + 1;
            $tahun3 = $baseYear + 2;
            $tahun4 = $baseYear + 3;
            $tahun5 = $baseYear + 4;
            $tahun6 = $baseYear + 5;
            $tahun7 = $baseYear + 6;
            $tahun8 = $baseYear + 7;
            $tahun9 = $baseYear + 8;
            $tahun10 = $baseYear + 9;
            $tahun11 = $baseYear + 10;
            $tahun12 = $baseYear + 11;
            $tahun13 = $baseYear + 12;
            $tahun14 = $baseYear + 13;
            $tahun15 = $baseYear + 14;
            $tahun16 = $baseYear + 15;
            $tahun17 = $baseYear + 16;
            $tahun18 = $baseYear + 17;
            $tahun19 = $baseYear + 18;
            $tahun20 = $baseYear + 19;

             if ($umurEkonomis == 4) {
                $sisaNilaiPenyusutan = array(
                    $tahun1 => $hargaPerolehan - $penyusutanPertahun,
                    $tahun2 => $hargaPerolehan - ($penyusutanPertahun * 2),
                    $tahun3 => $hargaPerolehan - ($penyusutanPertahun * 3),
                    $tahun4 => $hargaPerolehan - ($penyusutanPertahun * 4),
                );
            }elseif ($umurEkonomis == 8) {
                $sisaNilaiPenyusutan = array(
                    $tahun1 => $hargaPerolehan - $penyusutanPertahun,
                    $tahun2 => $hargaPerolehan - ($penyusutanPertahun * 2),
                    $tahun3 => $hargaPerolehan - ($penyusutanPertahun * 3),
                    $tahun4 => $hargaPerolehan - ($penyusutanPertahun * 4),
                    $tahun5 => $hargaPerolehan - ($penyusutanPertahun * 5),
                    $tahun6 => $hargaPerolehan - ($penyusutanPertahun * 6),
                    $tahun7 => $hargaPerolehan - ($penyusutanPertahun * 7),
                    $tahun8 => $hargaPerolehan - ($penyusutanPertahun * 8),
                );
            }elseif ($umurEkonomis == 16) {
                $sisaNilaiPenyusutan = array(
                    $tahun1 => $hargaPerolehan - $penyusutanPertahun,
                    $tahun2 => $hargaPerolehan - ($penyusutanPertahun * 2),
                    $tahun3 => $hargaPerolehan - ($penyusutanPertahun * 3),
                    $tahun4 => $hargaPerolehan - ($penyusutanPertahun * 4),
                    $tahun5 => $hargaPerolehan - ($penyusutanPertahun * 5),
                    $tahun6 => $hargaPerolehan - ($penyusutanPertahun * 6),
                    $tahun7 => $hargaPerolehan - ($penyusutanPertahun * 7),
                    $tahun8 => $hargaPerolehan - ($penyusutanPertahun * 8),
                    $tahun9 => $hargaPerolehan - ($penyusutanPertahun * 9),
                    $tahun10 => $hargaPerolehan - ($penyusutanPertahun * 10),
                    $tahun11 => $hargaPerolehan - ($penyusutanPertahun * 11),
                    $tahun12 => $hargaPerolehan - ($penyusutanPertahun * 12),
                    $tahun13 => $hargaPerolehan - ($penyusutanPertahun * 13),
                    $tahun14 => $hargaPerolehan - ($penyusutanPertahun * 14),
                    $tahun15 => $hargaPerolehan - ($penyusutanPertahun * 15),
                    $tahun16 => $hargaPerolehan - ($penyusutanPertahun * 16),
                );
            }elseif ($umurEkonomis == 20) {
                $sisaNilaiPenyusutan = array(
                    $tahun1 => $hargaPerolehan - $penyusutanPertahun,
                    $tahun2 => $hargaPerolehan - ($penyusutanPertahun * 2),
                    $tahun3 => $hargaPerolehan - ($penyusutanPertahun * 3),
                    $tahun4 => $hargaPerolehan - ($penyusutanPertahun * 4),
                    $tahun5 => $hargaPerolehan - ($penyusutanPertahun * 5),
                    $tahun6 => $hargaPerolehan - ($penyusutanPertahun * 6),
                    $tahun7 => $hargaPerolehan - ($penyusutanPertahun * 7),
                    $tahun8 => $hargaPerolehan - ($penyusutanPertahun * 8),
                    $tahun9 => $hargaPerolehan - ($penyusutanPertahun * 9),
                    $tahun10 => $hargaPerolehan - ($penyusutanPertahun * 10),
                    $tahun11 => $hargaPerolehan - ($penyusutanPertahun * 11),
                    $tahun12 => $hargaPerolehan - ($penyusutanPertahun * 12),
                    $tahun13 => $hargaPerolehan - ($penyusutanPertahun * 13),
                    $tahun14 => $hargaPerolehan - ($penyusutanPertahun * 14),
                    $tahun15 => $hargaPerolehan - ($penyusutanPertahun * 15),
                    $tahun16 => $hargaPerolehan - ($penyusutanPertahun * 16),
                    $tahun17 => $hargaPerolehan - ($penyusutanPertahun * 17),
                    $tahun18 => $hargaPerolehan - ($penyusutanPertahun * 18),
                    $tahun19 => $hargaPerolehan - ($penyusutanPertahun * 19),
                    $tahun20 => $hargaPerolehan - ($penyusutanPertahun * 20),
                );
            }elseif ($umurEkonomis == 0) {
                $sisaNilaiPenyusutan = null;
            }
            $aset->sisa_nilai_penyusutan = $sisaNilaiPenyusutan;
            $aset->status = 'Aktif';
            $aset->save();

             DB::commit();
            \Session::flash('msg_success','Aset Berhasil Ditambah!');
            return Redirect::route('admin.aset');

        } catch (Exception $e) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
            return Redirect::route('admin.aset');
        }
    }
    public function updateAset(Request $request) {
        DB::beginTransaction();
        try {
            $aset = Aset::find($request->id);
            $aset->kode_aset = $request->kodeAset;
            $aset->nama_aset = $request->namaAset;
            $aset->kategori = $request->kategori;
            $aset->lokasi = $request->lokasi;
            $aset->tanggal_pengadaan = $request->tanggalPengadaan;
            $aset->jumlah = $request->jumlah;
            $aset->satuan = $request->satuan;
            $aset->harga_satuan = $request->hargaSatuan;
            $aset->tipe_penyusutan = $request->tipePenyusutan;

            $hargaPerolehan = $request->hargaSatuan * $request->jumlah;

            $aset->harga_perolehan = $hargaPerolehan;

            if ($request->tipePenyusutan == 'I') {
                $umurEkonomis = 4;
            }elseif ($request->tipePenyusutan == 'II') {
                $umurEkonomis = 8;
            }elseif ($request->tipePenyusutan == 'III') {
                $umurEkonomis = 16;
            }elseif ($request->tipePenyusutan == 'IV') {
                $umurEkonomis = 20;
            }elseif ($request->tipePenyusutan == 'Non Depresi') {
                $umurEkonomis = 0;
            }
            $aset->umur_ekonomis = $umurEkonomis;

            if ($umurEkonomis == 0) {
                $nilaiResidu = 0;
            } else {
                $nilaiResidu = $hargaPerolehan / $umurEkonomis;
            }

            if ($umurEkonomis == 0) {
                $penyusutanPertahun = 0;
            } else {
                $penyusutanPertahun = ($hargaPerolehan - $nilaiResidu) / $umurEkonomis;
            }


            $aset->nilai_residu = $nilaiResidu;
            $aset->penyusutan_pertahun = $penyusutanPertahun;

            $baseYear = date('Y', strtotime($request->tanggalPengadaan));

            $tahun1 = $baseYear;
            $tahun2 = $baseYear + 1;
            $tahun3 = $baseYear + 2;
            $tahun4 = $baseYear + 3;
            $tahun5 = $baseYear + 4;
            $tahun6 = $baseYear + 5;
            $tahun7 = $baseYear + 6;
            $tahun8 = $baseYear + 7;
            $tahun9 = $baseYear + 8;
            $tahun10 = $baseYear + 9;
            $tahun11 = $baseYear + 10;
            $tahun12 = $baseYear + 11;
            $tahun13 = $baseYear + 12;
            $tahun14 = $baseYear + 13;
            $tahun15 = $baseYear + 14;
            $tahun16 = $baseYear + 15;
            $tahun17 = $baseYear + 16;
            $tahun18 = $baseYear + 17;
            $tahun19 = $baseYear + 18;
            $tahun20 = $baseYear + 19;

             if ($umurEkonomis == 4) {
                $sisaNilaiPenyusutan = array(
                    $tahun1 => $hargaPerolehan - $penyusutanPertahun,
                    $tahun2 => $hargaPerolehan - ($penyusutanPertahun * 2),
                    $tahun3 => $hargaPerolehan - ($penyusutanPertahun * 3),
                    $tahun4 => $hargaPerolehan - ($penyusutanPertahun * 4),
                );
            }elseif ($umurEkonomis == 8) {
                $sisaNilaiPenyusutan = array(
                    $tahun1 => $hargaPerolehan - $penyusutanPertahun,
                    $tahun2 => $hargaPerolehan - ($penyusutanPertahun * 2),
                    $tahun3 => $hargaPerolehan - ($penyusutanPertahun * 3),
                    $tahun4 => $hargaPerolehan - ($penyusutanPertahun * 4),
                    $tahun5 => $hargaPerolehan - ($penyusutanPertahun * 5),
                    $tahun6 => $hargaPerolehan - ($penyusutanPertahun * 6),
                    $tahun7 => $hargaPerolehan - ($penyusutanPertahun * 7),
                    $tahun8 => $hargaPerolehan - ($penyusutanPertahun * 8),
                );
            }elseif ($umurEkonomis == 16) {
                $sisaNilaiPenyusutan = array(
                    $tahun1 => $hargaPerolehan - $penyusutanPertahun,
                    $tahun2 => $hargaPerolehan - ($penyusutanPertahun * 2),
                    $tahun3 => $hargaPerolehan - ($penyusutanPertahun * 3),
                    $tahun4 => $hargaPerolehan - ($penyusutanPertahun * 4),
                    $tahun5 => $hargaPerolehan - ($penyusutanPertahun * 5),
                    $tahun6 => $hargaPerolehan - ($penyusutanPertahun * 6),
                    $tahun7 => $hargaPerolehan - ($penyusutanPertahun * 7),
                    $tahun8 => $hargaPerolehan - ($penyusutanPertahun * 8),
                    $tahun9 => $hargaPerolehan - ($penyusutanPertahun * 9),
                    $tahun10 => $hargaPerolehan - ($penyusutanPertahun * 10),
                    $tahun11 => $hargaPerolehan - ($penyusutanPertahun * 11),
                    $tahun12 => $hargaPerolehan - ($penyusutanPertahun * 12),
                    $tahun13 => $hargaPerolehan - ($penyusutanPertahun * 13),
                    $tahun14 => $hargaPerolehan - ($penyusutanPertahun * 14),
                    $tahun15 => $hargaPerolehan - ($penyusutanPertahun * 15),
                    $tahun16 => $hargaPerolehan - ($penyusutanPertahun * 16),
                );
            }elseif ($umurEkonomis == 20) {
                $sisaNilaiPenyusutan = array(
                    $tahun1 => $hargaPerolehan - $penyusutanPertahun,
                    $tahun2 => $hargaPerolehan - ($penyusutanPertahun * 2),
                    $tahun3 => $hargaPerolehan - ($penyusutanPertahun * 3),
                    $tahun4 => $hargaPerolehan - ($penyusutanPertahun * 4),
                    $tahun5 => $hargaPerolehan - ($penyusutanPertahun * 5),
                    $tahun6 => $hargaPerolehan - ($penyusutanPertahun * 6),
                    $tahun7 => $hargaPerolehan - ($penyusutanPertahun * 7),
                    $tahun8 => $hargaPerolehan - ($penyusutanPertahun * 8),
                    $tahun9 => $hargaPerolehan - ($penyusutanPertahun * 9),
                    $tahun10 => $hargaPerolehan - ($penyusutanPertahun * 10),
                    $tahun11 => $hargaPerolehan - ($penyusutanPertahun * 11),
                    $tahun12 => $hargaPerolehan - ($penyusutanPertahun * 12),
                    $tahun13 => $hargaPerolehan - ($penyusutanPertahun * 13),
                    $tahun14 => $hargaPerolehan - ($penyusutanPertahun * 14),
                    $tahun15 => $hargaPerolehan - ($penyusutanPertahun * 15),
                    $tahun16 => $hargaPerolehan - ($penyusutanPertahun * 16),
                    $tahun17 => $hargaPerolehan - ($penyusutanPertahun * 17),
                    $tahun18 => $hargaPerolehan - ($penyusutanPertahun * 18),
                    $tahun19 => $hargaPerolehan - ($penyusutanPertahun * 19),
                    $tahun20 => $hargaPerolehan - ($penyusutanPertahun * 20),
                );
            }elseif ($umurEkonomis == 0) {
                $sisaNilaiPenyusutan = null;
            }
            $aset->sisa_nilai_penyusutan = $sisaNilaiPenyusutan;
            $aset->status = 'Aktif';
            $aset->save();

             DB::commit();
            \Session::flash('msg_success','Aset Berhasil Ditambah!');
            return Redirect::route('admin.aset');

        } catch (Exception $e) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
            return Redirect::route('admin.aset');
        }
    }
    public function deleteAset($id)
    {
        DB::beginTransaction();
        try {
            $aset = Aset::where('id',$id)->delete();
            DB::commit();
            \Session::flash('msg_success','Data Aset Berhasil Dihapus!');
            return Redirect::route('admin.aset');

        } catch (Exception $e) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
            return Redirect::route('admin.aset');
        }
    }
    public function penyusutan()
    {
        $title = 'Data Penyusutan';
        $notif = Pemeliharaan::where('notification',1)->get();
        return view('admin.penyusutan', compact('title','notif'));
    }
    public function searchPenyusutan(Request $request) {
        if (empty($request->tahun)) {
            return Redirect::route('admin.penyusutan');
        }

        $reqTahun = $request->tahun;
        $baseYear = date('Y', strtotime($request->tahun));
        $title = 'Data Penyusutan';
        $penyusutan = Aset::where('status','Aktif')->where('tipe_penyusutan','!=','Non Depresi')->get();
        $notif = Pemeliharaan::where('notification',1)->get();
        return view('admin.search_penyusutan', compact('title','penyusutan','baseYear','notif','reqTahun'));
    }

    public function pemeliharaan()
    {
        $title = 'Data Pemeliharaan Aset';
        $pemeliharaan = Pemeliharaan::all();
        $aset = Aset::where('status','Aktif')->get();
        $notif = Pemeliharaan::where('notification',1)->get();
        return view('admin.pemeliharaan', compact('title','pemeliharaan','aset','notif'));
    }

    public function addPemeliharaan(Request $request)
    {
       DB::beginTransaction();
        try {
            $pemeliharaan = new Pemeliharaan;
            $pemeliharaan->aset_id = $request->aset_id;
            $pemeliharaan->jadwal = $request->jadwal;
            $pemeliharaan->status = 'Menunggu';
            $pemeliharaan->notification = 0;
            $pemeliharaan->save();

             DB::commit();
            \Session::flash('msg_success','Pemeliharaan Berhasil Ditambah!');
            return Redirect::route('admin.pemeliharaan');

        } catch (Exception $e) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
            return Redirect::route('admin.pemeliharaan');
        }
    }
    public function updatePemeliharaan(Request $request)
    {
       DB::beginTransaction();
        try {
            $pemeliharaan = Pemeliharaan::find($request->id);
            $pemeliharaan->aset_id = $request->aset_id;
            $pemeliharaan->jadwal = $request->jadwal;
            $pemeliharaan->status = 'Menunggu';
            $pemeliharaan->notification = 0;
            $pemeliharaan->save();

             DB::commit();
            \Session::flash('msg_success','Pemeliharaan Berhasil Diubah!');
            return Redirect::route('admin.pemeliharaan');

        } catch (Exception $e) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
            return Redirect::route('admin.pemeliharaan');
        }
    }
    public function deletePemeliharaan($id)
    {
        DB::beginTransaction();
        try {
            $pemeliharaan = Pemeliharaan::where('id',$id)->delete();
            DB::commit();
            \Session::flash('msg_success','Data Pemeliharaan Berhasil Dihapus!');
            return Redirect::route('admin.pemeliharaan');

        } catch (Exception $e) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
            return Redirect::route('admin.pemeliharaan');
        }
    }
    public function selesaiPemeliharaan($id) {
        DB::beginTransaction();
        try {
            $pemeliharaan = Pemeliharaan::find($id);
            $aset = Aset::find($pemeliharaan->aset_id);
            $nowYear = date('Y', strtotime($pemeliharaan->jadwal));
            $baseYear = date('Y', strtotime($aset->tanggal_pengadaan));

            // return count($aset->sisa_nilai_penyusutan);
            $checkData = $aset->sisa_nilai_penyusutan[$nowYear] ?? null;
            if (empty($checkData)) {
                \Session::flash('msg_error','Tahun Pemeliharaan Tidak ada!');
                return Redirect::route('admin.pemeliharaan');
            }
            $data = [];
            if ($aset->umur_ekonomis == 4) {
                for ($i=0; $i <= 4 ; $i++) {
                    if ($baseYear+$i != $nowYear) {
                        if ($baseYear+$i == $baseYear) {
                            $data[$baseYear+$i] = $aset->harga_perolehan - $aset->penyusutan_pertahun;
                        }
                        elseif ($baseYear+$i == $baseYear+1) {
                            $data[$baseYear+$i] = $data[$baseYear] - $aset->penyusutan_pertahun;
                        }
                        elseif ($baseYear+$i == $nowYear+1) {
                           $data[$baseYear+$i] = $aset->harga_perolehan - ($aset->penyusutan_pertahun * $i);
                        }
                        else {
                            $data[$baseYear+$i] = $aset->harga_perolehan - ($aset->penyusutan_pertahun * $i);
                        }
                    }
                }
            }elseif ($aset->umur_ekonomis == 8) {
                for ($i=0; $i <= 8 ; $i++) {
                    if ($baseYear+$i != $nowYear) {
                        if ($baseYear+$i == $baseYear) {
                            $data[$baseYear+$i] = $aset->harga_perolehan - $aset->penyusutan_pertahun;
                        }
                        elseif ($baseYear+$i == $baseYear+1) {
                            $data[$baseYear+$i] = $data[$baseYear] - $aset->penyusutan_pertahun;
                        }
                        elseif ($baseYear+$i == $nowYear+1) {
                           $data[$baseYear+$i] = $aset->harga_perolehan - ($aset->penyusutan_pertahun * $i);
                        }
                        else {
                            $data[$baseYear+$i] = $aset->harga_perolehan - ($aset->penyusutan_pertahun * $i);
                        }
                    }
                }
            }elseif ($aset->umur_ekonomis == 16) {
                for ($i=0; $i <= 16 ; $i++) {
                    if ($baseYear+$i != $nowYear) {
                        if ($baseYear+$i == $baseYear) {
                            $data[$baseYear+$i] = $aset->harga_perolehan - $aset->penyusutan_pertahun;
                        }
                        elseif ($baseYear+$i == $baseYear+1) {
                            $data[$baseYear+$i] = $data[$baseYear] - $aset->penyusutan_pertahun;
                        }
                        elseif ($baseYear+$i == $nowYear+1) {
                           $data[$baseYear+$i] = $aset->harga_perolehan - ($aset->penyusutan_pertahun * $i);
                        }
                        else {
                            $data[$baseYear+$i] = $aset->harga_perolehan - ($aset->penyusutan_pertahun * $i);
                        }
                    }
                }
            }elseif ($aset->umur_ekonomis == 20) {
                for ($i=0; $i <= 20 ; $i++) {
                    if ($baseYear+$i == $baseYear) {
                            $data[$baseYear+$i] = $aset->harga_perolehan - $aset->penyusutan_pertahun;
                        }
                        elseif ($baseYear+$i == $baseYear+1) {
                            $data[$baseYear+$i] = $data[$baseYear] - $aset->penyusutan_pertahun;
                        }
                        elseif ($baseYear+$i == $nowYear+1) {
                           $data[$baseYear+$i] = $aset->harga_perolehan - ($aset->penyusutan_pertahun * $i);
                        }
                        else {
                            $data[$baseYear+$i] = $aset->harga_perolehan - ($aset->penyusutan_pertahun * $i);
                        }
                }
            }elseif ($aset->umur_ekonomis == 0) {
                $data[] = null;
            }
            // return $data;
            $aset->sisa_nilai_penyusutan = $data;
            $pemeliharaan->status = 'Selesai';
            $pemeliharaan->notification = 0;
            $aset->save();
            $pemeliharaan->save();

            $getTahun = date('Y', strtotime($pemeliharaan->jadwal));
            $getTanggal = date('m-d', strtotime($pemeliharaan->jadwal));
            $newJadwal = ($getTahun+1).'-'.$getTanggal;
            // return $newJadwal;

            $newPemeliharaan = new Pemeliharaan;
            $newPemeliharaan->aset_id = $pemeliharaan->aset_id;
            $newPemeliharaan->jadwal = $newJadwal;
            $newPemeliharaan->status = 'Menunggu';
            $newPemeliharaan->notification = 0;
            $newPemeliharaan->save();

             DB::commit();
            \Session::flash('msg_success','Pemeliharaan Selesai!');
            return Redirect::route('admin.pemeliharaan');
        } catch (Exception $e) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
            return Redirect::route('admin.pemeliharaan');
        }
    }

    function updateStatus(Request $request) {
        DB::beginTransaction();
        try {
            $dataAset = Aset::find($request->id);
            if ($dataAset->jumlah < $request->jumlah) {
                \Session::flash('msg_error','Jumlah Aset Keluar Tidak Boleh Lebih Dari Jumlah Aset Sekarang!');
                return Redirect::route('admin.aset');
            }
            $cekJumlah = $dataAset->jumlah - $request->jumlah;

            $aset = Aset::find($request->id);
            if ($cekJumlah == 0) {
                $aset->status = 'Dihapus';
            } else {
                $aset->kode_aset = $dataAset->kode_aset;
                $aset->nama_aset = $dataAset->nama_aset;
                $aset->kategori = $dataAset->kategori;
                $aset->lokasi = $dataAset->lokasi;
                $aset->tanggal_pengadaan = $dataAset->tanggal_pengadaan;
                $aset->jumlah = ($dataAset->jumlah - $request->jumlah);
                $aset->satuan = $dataAset->satuan;
                $aset->harga_satuan = $dataAset->harga_satuan;
                $aset->tipe_penyusutan = $dataAset->tipe_penyusutan;

                $hargaPerolehan = $dataAset->harga_satuan * ($dataAset->jumlah - $request->jumlah);

                $aset->harga_perolehan = $hargaPerolehan;
                $aset->umur_ekonomis = $dataAset->umur_ekonomis;

                if ($dataAset->umur_ekonomis == 0) {
                    $nilaiResidu = 0;
                } else {
                    $nilaiResidu = $hargaPerolehan / $dataAset->umur_ekonomis;
                }

                if ($dataAset->umur_ekonomis == 0) {
                    $penyusutanPertahun = 0;
                } else {
                    $penyusutanPertahun = ($hargaPerolehan - $nilaiResidu) / $dataAset->umur_ekonomis;
                }
                $aset->nilai_residu = $nilaiResidu;
                $aset->penyusutan_pertahun = $penyusutanPertahun;

                $baseYear = date('Y', strtotime($dataAset->tanggal_pengadaan));

                $tahun1 = $baseYear;
                $tahun2 = $baseYear + 1;
                $tahun3 = $baseYear + 2;
                $tahun4 = $baseYear + 3;
                $tahun5 = $baseYear + 4;
                $tahun6 = $baseYear + 5;
                $tahun7 = $baseYear + 6;
                $tahun8 = $baseYear + 7;
                $tahun9 = $baseYear + 8;
                $tahun10 = $baseYear + 9;
                $tahun11 = $baseYear + 10;
                $tahun12 = $baseYear + 11;
                $tahun13 = $baseYear + 12;
                $tahun14 = $baseYear + 13;
                $tahun15 = $baseYear + 14;
                $tahun16 = $baseYear + 15;
                $tahun17 = $baseYear + 16;
                $tahun18 = $baseYear + 17;
                $tahun19 = $baseYear + 18;
                $tahun20 = $baseYear + 19;

                if ($dataAset->umur_ekonomis == 4) {
                    $sisaNilaiPenyusutan = array(
                        $tahun1 => $hargaPerolehan - $penyusutanPertahun,
                        $tahun2 => $hargaPerolehan - ($penyusutanPertahun * 2),
                        $tahun3 => $hargaPerolehan - ($penyusutanPertahun * 3),
                        $tahun4 => $hargaPerolehan - ($penyusutanPertahun * 4),
                    );
                }elseif ($dataAset->umur_ekonomis == 8) {
                    $sisaNilaiPenyusutan = array(
                        $tahun1 => $hargaPerolehan - $penyusutanPertahun,
                        $tahun2 => $hargaPerolehan - ($penyusutanPertahun * 2),
                        $tahun3 => $hargaPerolehan - ($penyusutanPertahun * 3),
                        $tahun4 => $hargaPerolehan - ($penyusutanPertahun * 4),
                        $tahun5 => $hargaPerolehan - ($penyusutanPertahun * 5),
                        $tahun6 => $hargaPerolehan - ($penyusutanPertahun * 6),
                        $tahun7 => $hargaPerolehan - ($penyusutanPertahun * 7),
                        $tahun8 => $hargaPerolehan - ($penyusutanPertahun * 8),
                    );
                }elseif ($dataAset->umur_ekonomis == 16) {
                    $sisaNilaiPenyusutan = array(
                        $tahun1 => $hargaPerolehan - $penyusutanPertahun,
                        $tahun2 => $hargaPerolehan - ($penyusutanPertahun * 2),
                        $tahun3 => $hargaPerolehan - ($penyusutanPertahun * 3),
                        $tahun4 => $hargaPerolehan - ($penyusutanPertahun * 4),
                        $tahun5 => $hargaPerolehan - ($penyusutanPertahun * 5),
                        $tahun6 => $hargaPerolehan - ($penyusutanPertahun * 6),
                        $tahun7 => $hargaPerolehan - ($penyusutanPertahun * 7),
                        $tahun8 => $hargaPerolehan - ($penyusutanPertahun * 8),
                        $tahun9 => $hargaPerolehan - ($penyusutanPertahun * 9),
                        $tahun10 => $hargaPerolehan - ($penyusutanPertahun * 10),
                        $tahun11 => $hargaPerolehan - ($penyusutanPertahun * 11),
                        $tahun12 => $hargaPerolehan - ($penyusutanPertahun * 12),
                        $tahun13 => $hargaPerolehan - ($penyusutanPertahun * 13),
                        $tahun14 => $hargaPerolehan - ($penyusutanPertahun * 14),
                        $tahun15 => $hargaPerolehan - ($penyusutanPertahun * 15),
                        $tahun16 => $hargaPerolehan - ($penyusutanPertahun * 16),
                    );
                }elseif ($dataAset->umur_ekonomis == 20) {
                    $sisaNilaiPenyusutan = array(
                        $tahun1 => $hargaPerolehan,
                        $tahun2 => $hargaPerolehan - ($penyusutanPertahun * 2),
                        $tahun3 => $hargaPerolehan - ($penyusutanPertahun * 3),
                        $tahun4 => $hargaPerolehan - ($penyusutanPertahun * 4),
                        $tahun5 => $hargaPerolehan - ($penyusutanPertahun * 5),
                        $tahun6 => $hargaPerolehan - ($penyusutanPertahun * 6),
                        $tahun7 => $hargaPerolehan - ($penyusutanPertahun * 7),
                        $tahun8 => $hargaPerolehan - ($penyusutanPertahun * 8),
                        $tahun9 => $hargaPerolehan - ($penyusutanPertahun * 9),
                        $tahun10 => $hargaPerolehan - ($penyusutanPertahun * 10),
                        $tahun11 => $hargaPerolehan - ($penyusutanPertahun * 11),
                        $tahun12 => $hargaPerolehan - ($penyusutanPertahun * 12),
                        $tahun13 => $hargaPerolehan - ($penyusutanPertahun * 13),
                        $tahun14 => $hargaPerolehan - ($penyusutanPertahun * 14),
                        $tahun15 => $hargaPerolehan - ($penyusutanPertahun * 15),
                        $tahun16 => $hargaPerolehan - ($penyusutanPertahun * 16),
                        $tahun17 => $hargaPerolehan - ($penyusutanPertahun * 17),
                        $tahun18 => $hargaPerolehan - ($penyusutanPertahun * 18),
                        $tahun19 => $hargaPerolehan - ($penyusutanPertahun * 19),
                        $tahun20 => $hargaPerolehan - ($penyusutanPertahun * 20),
                    );
                }elseif ($dataAset->umur_ekonomis == 0) {
                    $sisaNilaiPenyusutan = null;
                }

                $aset->sisa_nilai_penyusutan = $sisaNilaiPenyusutan;
                $aset->status = 'Aktif';
            }

            $newAset = new Aset;
            $newAset->kode_aset = $dataAset->kode_aset;
            $newAset->nama_aset = $dataAset->nama_aset;
            $newAset->kategori = $dataAset->kategori;
            $newAset->lokasi = $dataAset->lokasi;
            $newAset->tanggal_pengadaan = $dataAset->tanggal_pengadaan;
            $newAset->jumlah = $request->jumlah;
            $newAset->satuan = $dataAset->satuan;
            $newAset->harga_satuan = $dataAset->harga_satuan;
            $newAset->tipe_penyusutan = $dataAset->tipe_penyusutan;
            $newAset->status = $request->status;
            $newAset->harga_perolehan = ($dataAset->harga_satuan * $request->jumlah);

            $newAset->save();
            $aset->save();
            DB::commit();
            \Session::flash('msg_success','Data Pemeliharaan Berhasil Dihapus!');
            return Redirect::route('admin.aset');

        } catch (Exception $e) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
            return Redirect::route('admin.aset');
        }
    }
}
