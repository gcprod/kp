<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Citizendatas;
use App\Models\Qrcitizendatas;
use Illuminate\Support\Facades\DB;
use Dompdf\Dompdf;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;

class CitizenController extends Controller
{
   /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function citizendata()
    {
        $data=Citizendatas::all();
        return view('citizendata',compact('data'));
    }
    public function selectdata()
    {
        return view('selectexport');
    }
    public function destroy($id){
        $data=Citizendatas::find($id);
        Citizendatas::where('id', $id)->delete();
        return redirect('citizendata')  ;
        
    }
    public function qrdestroy($id){
        $data=Qrcitizendatas::find($id);
        Qrcitizendatas::where('id', $id)->delete();
        return redirect('qrcitizendata')  ;

    }
    public function update($id){
        $data=Citizendatas::find($id);
       
        // dd($data);
        return view('updatedata',compact('data'));

    }
    public function qrupdate($id){
        $data=Qrcitizendatas::find($id);
       
        // dd($data);
        return view('qrupdatedata',compact('data'));

    }
    public function edit(request $request,$id){
        $data=Citizendatas::find($id);
        $data->update($request->all());
        //dd($data);
        return redirect('citizendata'   );

    }
    public function exportbydate(){
        $data=Citizendatas::all();
        return view('exportpdfbydate',compact('data'));

    }
    public function exportbyrtrw(){
        $data=Citizendatas::all();
        return view('exportpdfbyrtrw',compact('data'));

    }
    // public function exportPdf()
    // {
    //     $data = Citizendatas::all()->toArray();
    
    //     $pdf = PDF::loadView('pdf.export_pdf', ['data' => $data]);
    
    //     return $pdf->download('datawarga.pdf');
    // }



    
    public function scanqr(){
    return view('qrscanner')  ;
    }
    
    public function qrcitizendata()
    {
        $data=Qrcitizendatas::all();
        return view('qrcitizendata',compact('data'));
    }
    public function dataByDate(Request $request)
    {
        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalSelesai = $request->input('tanggal_selesai');
    
        // Memfilter data berdasarkan rentang tanggal
        $data = Citizendatas::whereDate('created_at', '>=', Carbon::parse($tanggalMulai)->startOfDay())
                            ->whereDate('created_at', '<=', Carbon::parse($tanggalSelesai)->endOfDay())
                            ->get();
    
        // Mengirim data ke view
        return view('citizendata', ['data' => $data]);
    }
    
 
}
