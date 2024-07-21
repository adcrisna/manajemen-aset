<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Auth;
use DB;
use App\Models\User;
use App\Models\Aset;
use App\Models\Pemeliharaan;
use Carbon\Carbon;

class PimpinanController extends Controller
{
    public function index() {
        $title = "Home";
        $notif = Pemeliharaan::where('notification',1)->get();
        return view('pimpinan.index', compact('title','notif'));
    }

    public function profile()
    {
        $title = 'Profile';
        $notif = Pemeliharaan::where('notification',1)->get();
        $pimpinan = User::find(Auth::user()->id);
        return view('pimpinan.profile', compact('title','pimpinan','notif'));
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
            return Redirect::route('pimpinan.profile');

        } catch (Exception $e) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
            return Redirect::route('pimpinan.profile');
        }
    }
    public function aset()
    {
        $title = 'Data Aset';
        $aset = Aset::all();
        $notif = Pemeliharaan::where('notification',1)->get();
        return view('pimpinan.aset', compact('title','aset','notif'));
    }
    public function penyusutan()
    {
        $title = 'Data Penyusutan';
        $notif = Pemeliharaan::where('notification',1)->get();
        return view('pimpinan.penyusutan', compact('title','notif'));
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
        return view('pimpinan.search_penyusutan', compact('title','penyusutan','baseYear','notif','reqTahun'));
    }
    public function pemeliharaan()
    {
        $title = 'Data Pemeliharaan Aset';
        $pemeliharaan = Pemeliharaan::all();
        $aset = Aset::all();
        $notif = Pemeliharaan::where('notification',1)->get();
        return view('pimpinan.pemeliharaan', compact('title','pemeliharaan','aset','notif'));
    }
}
