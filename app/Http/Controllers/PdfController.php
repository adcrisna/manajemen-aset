<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Auth;
use DB;
use App\Models\User;
use App\Models\Aset;
use Carbon\Carbon;

class PdfController extends Controller
{
    function pdfAset(Request $request)
    {
        $baseYear = date('Y', strtotime($request->tahun));
        $aset = Aset::where('status','Aktif')->whereYear('tanggal_pengadaan', $request->tahun)->get();
        $pdf = Pdf::loadView('pdf.aset', compact('aset','baseYear'));
        return $pdf->stream();
    }
    function pdfKondisi(Request $request)
    {
        $baseYear = date('Y', strtotime($request->tahun));
        $aset = Aset::where('status', '!=', 'Aktif')->whereYear('created_at', $request->tahun)->get();
        $pdf = Pdf::loadView('pdf.kondisi', compact('aset','baseYear'));
        return $pdf->stream();
    }
    function pdfPenyusutan(Request $request)
    {
        $baseYear = date('Y', strtotime($request->tahun));
        $tahun = date('d F Y', strtotime($request->tahun));
        $reqTahun = $request->tahun;
        $penyusutan = Aset::where('status','Aktif')->where('tipe_penyusutan','!=','Non Depresi')->get();
        $pdf = Pdf::loadView('pdf.penyusutan', compact('baseYear','penyusutan','tahun','reqTahun'));
        return $pdf->stream();
    }
}
