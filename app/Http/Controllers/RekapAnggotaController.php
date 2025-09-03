<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class RekapAnggotaController extends Controller
{
    public function index(){
        $pageTitle = 'Member Recapitulation';
        return view('management.rekap-anggota.index', compact('pageTitle'));
    }

    public function getData(Request $request){
        //semua harus disesuaikan dengan field di db

        if($request->tipe == 0 || $request->tanggalawal == null || $request->tanggalakhir == null){

            $json_data = array(
                'draw' => intval($request->input('draw')),
                'recordsTotal' => intval(0),
                'recordsFiltered' => intval(0),
                'data' => 0
            );
        }
        else{
            $columns = array(
                0 => 'id',
                1 => 'company',
                2 => 'created_at',
                3 => 'verified_at',
            );

            $totalData= DB::table('itdp_company_users')
                ->join('itdp_profil_eks','itdp_profil_eks.id','itdp_company_users.id_profil')
                ->where('itdp_company_users.id_role',$request->tipe)
                ->where('itdp_company_users.created_at','>',$request->tanggalawal)
                ->where('itdp_company_users.created_at','<',$request->tanggalakhir)
//                ->where('deleted_at',null)
                ->count();

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');

            if (empty($request->input('search.value'))) {
                $posts = DB::table('itdp_company_users')
                    ->join('itdp_profil_eks','itdp_profil_eks.id','itdp_company_users.id_profil')
//                    ->where('deleted_at', null)
                    ->where('itdp_company_users.id_role',$request->tipe)
                    ->where('itdp_company_users.created_at','>',$request->tanggalawal)
                    ->where('itdp_company_users.created_at','<',$request->tanggalakhir)
                    ->select('itdp_profil_eks.company','itdp_company_users.created_at','itdp_company_users.verified_at')
                    ->orderby('itdp_company_users.id', 'desc')
                    ->limit($limit)
                    ->offset($start)
                    ->get();

                $totalFiltered = DB::table('itdp_company_users')
                    ->join('itdp_profil_eks','itdp_profil_eks.id','itdp_company_users.id_profil')
//                    ->where('deleted_at', null)
                    ->where('itdp_company_users.id_role',$request->tipe)
                    ->where('itdp_company_users.created_at','>',$request->tanggalawal)
                    ->where('itdp_company_users.created_at','<',$request->tanggalakhir)
                    ->select('itdp_profil_eks.company','itdp_company_users.created_at','itdp_company_users.verified_at')
                    ->orderby('itdp_company_users.id', 'desc')
//                    ->limit($limit)
//                    ->offset($start)
                    ->get()
                    ->count();
            } else {
                $search = $request->input('search.value');
                $posts = DB::table('itdp_company_users')
                    ->join('itdp_profil_eks','itdp_profil_eks.id','itdp_company_users.id_profil')
//                    ->where('deleted_at', null)
                    ->where('itdp_company_users.id_role',$request->tipe)
                    ->where('itdp_company_users.created_at','>',$request->tanggalawal)
                    ->where('itdp_company_users.created_at','<',$request->tanggalakhir)
                    ->select('itdp_profil_eks.company','itdp_company_users.created_at as created_at', 'itdp_company_users.id as id','itdp_profil_eks.id as id_profil' ,'itdp_company_users.verified_at as verified_at')
                    ->where(function ($query) use ($search) {
                        $query->where('itdp_profil_eks.company', 'ilike', '%' . $search . '%');
//                        $query->where('itdp_company_users.created_at', 'ilike', '%' . $search . '%');
//                        $query->where('itdp_company_users.verified_at', 'ilike', '%' . $search . '%');
                    })
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();

                $totalFiltered =  DB::table('itdp_company_users')
                    ->join('itdp_profil_eks','itdp_profil_eks.id','itdp_company_users.id_profil')
//                    ->where('deleted_at', null)
                    ->where('itdp_company_users.id_role',$request->tipe)
                    ->where('itdp_company_users.created_at','>',$request->tanggalawal)
                    ->where('itdp_company_users.created_at','<',$request->tanggalakhir)
                    ->select('itdp_profil_eks.company','itdp_company_users.created_at as created_at','itdp_company_users.verified_at as verified_at')
                    ->where(function ($query) use ($search) {
                        $query->where('itdp_profil_eks.company', 'ilike', '%' . $search . '%');
//                        $query->where('itdp_company_users.created_at', 'ilike', '%' . $search . '%');
//                        $query->where('itdp_company_users.verified_at', 'ilike', '%' . $search . '%');
                    })
                    ->offset($start)
                    ->limit($limit)
                    ->orderby($order,$dir)
                    ->count();
            }

            $data = array();
            if (count($posts) > 0) {
                $count = $start + 1;
                foreach ($posts as $d) {
                    $token = csrf_token();
                    $nestedData['no'] = '<center>' .$count . '</center>';
                    $nestedData['nama_perusahaan'] = '<center>' . $d->company . '</center>';
                    $time = strtotime($d->created_at);
                    $newformat = date('d-m-Y',$time);
                    $time2 = strtotime($d->verified_at);
                    $newformat2 = date('d-m-Y',$time2);
                    $nestedData['tanggal_register'] = '<center>' . $newformat . '</center>';
                    $nestedData['tanggal_verifikasi'] = '<center>' . $newformat2 . '</center>';
                    $data[] = $nestedData;
                    $count++;
                }
            }

            $json_data = array(
                'draw' => intval($request->input('draw')),
                'recordsTotal' => intval($totalData),
                'recordsFiltered' => intval($totalFiltered),
                'data' => $data
            );
        }

//        dd($data);

        echo json_encode($json_data);

    }

    public function cetakcsv(Request $request){
        $data = DB::table('itdp_company_users')
            ->join('itdp_profil_eks','itdp_profil_eks.id','itdp_company_users.id_profil')
            ->where('itdp_company_users.id_role',$request->tipe)
            ->where('itdp_company_users.created_at','>',$request->start)
            ->where('itdp_company_users.created_at','<',$request->end)
            ->select('itdp_profil_eks.company','itdp_company_users.created_at as created_at','itdp_company_users.verified_at as verified_at')
            ->orderby('itdp_company_users.id', 'desc')
            ->get();

        $start = 0;

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];
        $length = count($data) + 1;
        $sheet->getStyle('A1:D'.$length)->applyFromArray($styleArray);

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(35);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Company Name');
        $sheet->setCellValue('C1', 'Register Date');
        $sheet->setCellValue('D1', 'Verification Date');
        $rows = 2;
        foreach($data as $detail){
            $time = strtotime($detail->created_at);
            $created_at = date('d-m-Y',$time);
            $time2 = strtotime($detail->verified_at);
            $verified_at= date('d-m-Y',$time2);
            $no = $start +1;
            $sheet->setCellValue('A' . $rows, $no);
            $sheet->setCellValue('B' . $rows, $detail->company);
            $sheet->setCellValue('C' . $rows, $created_at);
            $sheet->setCellValue('D' . $rows, $verified_at);

            $rows++;
        }
//        dd($spreadsheet);
//        dd($spreadsheet);

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
//        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//        header('Content-Disposition: attachment; filename="file.xlsx"');
//        $writer->save("php://output");
//        $writer = new Xlsx($spreadsheet);
//        public_path(). "/download/info.pdf"
        $file_name = public_path()."/excel/Member Recapitulation.xlsx";
        $writer->save( $file_name);

//        $headers = array('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        return response()->download($file_name);
    }

}
