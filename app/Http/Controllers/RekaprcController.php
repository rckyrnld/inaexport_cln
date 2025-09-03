<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class RekaprcController extends Controller
{
    public function index(){
        $pageTitle = 'Market Research Recapitulation';
        return view('management.rekap-rc.index', compact('pageTitle'));
    }

    public function getData1(Request $request){
        //semua harus disesuaikan dengan field di db

        $columns = array(
            0 => 'id',
            1 => 'title_en',
            2 => 'download',
        );

        $totalData= DB::table('csc_research_corner')
            ->select('id','title_en','download')
            ->count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $posts = DB::table('csc_research_corner')
                ->select('id','title_en','download')
//                ->orderby('id', 'desc')
                ->orderby('download', 'desc')
                ->limit($limit)
                ->offset($start)
                ->get();

            $totalFiltered = DB::table('csc_research_corner')
                ->select('id','title_en','download')
//                ->orderby('id', 'desc')
                ->orderby('download', 'desc')
                ->get()
                ->count();
        } else {
            $search = $request->input('search.value');
            $posts = DB::table('csc_research_corner')
                ->select('id','title_en','download')
                ->where(function ($query) use ($search) {
                    $query->where('title_en', 'ilike', '%' . $search . '%');
//                        $query->where('itdp_company_users.created_at', 'ilike', '%' . $search . '%');
//                        $query->where('itdp_company_users.verified_at', 'ilike', '%' . $search . '%');
                })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered =  DB::table('csc_research_corner')
                ->select('id','title_en','download')
                ->where(function ($query) use ($search) {
                    $query->where('title_en', 'ilike', '%' . $search . '%');
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
                $nestedData['rc'] = '<left>' . $d->title_en . '</left>';
                $nestedData['download'] = '<center>' . $d->download . '</center>';
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

        echo json_encode($json_data);

    }

    public function getData2(Request $request){
        //semua harus disesuaikan dengan field di db

            $columns = array(
                0 => 'itdp_profil_eks.id',
                1 => 'company',
                2 => 'download',
            );

            $totalData= DB::table('csc_download_research_corner')
                ->join('itdp_profil_eks','itdp_profil_eks.id','csc_download_research_corner.id_itdp_profil_eks')
                ->select('itdp_profil_eks.id','itdp_profil_eks.company','csc_download_research_corner.id_itdp_profil_eks', DB::raw('COUNT(csc_download_research_corner.id_itdp_profil_eks) as download'))
                ->Groupby('itdp_profil_eks.id')
                ->Groupby('csc_download_research_corner.id_itdp_profil_eks')
                ->count();

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');

            if (empty($request->input('search.value'))) {
                $posts = DB::table('csc_download_research_corner')
                    ->join('itdp_profil_eks','itdp_profil_eks.id','csc_download_research_corner.id_itdp_profil_eks')
                    ->select('itdp_profil_eks.id','itdp_profil_eks.company','csc_download_research_corner.id_itdp_profil_eks', DB::raw('COUNT(csc_download_research_corner.id_itdp_profil_eks) as download'))
                    ->Groupby('itdp_profil_eks.id')
                    ->Groupby('csc_download_research_corner.id_itdp_profil_eks')
//                    ->orderby('itdp_profil_eks.id', 'desc')
                    ->orderby('download', 'desc')
                    ->limit($limit)
                    ->offset($start)
                    ->get();

                $totalFiltered = DB::table('csc_download_research_corner')
                    ->join('itdp_profil_eks','itdp_profil_eks.id','csc_download_research_corner.id_itdp_profil_eks')
                    ->select('itdp_profil_eks.id','itdp_profil_eks.company','csc_download_research_corner.id_itdp_profil_eks', DB::raw('COUNT(csc_download_research_corner.id_itdp_profil_eks) as download'))
                    ->Groupby('itdp_profil_eks.id')
                    ->Groupby('csc_download_research_corner.id_itdp_profil_eks')
//                    ->orderby('itdp_profil_eks.id', 'desc')
                    ->orderby('download', 'desc')
//                    ->limit($limit)
//                    ->offset($start)
                    ->get()
                    ->count();
            } else {
                $search = $request->input('search.value');
                $posts = DB::table('csc_download_research_corner')
                    ->join('itdp_profil_eks','itdp_profil_eks.id','csc_download_research_corner.id_itdp_profil_eks')
                    ->select('itdp_profil_eks.id','itdp_profil_eks.company','csc_download_research_corner.id_itdp_profil_eks', DB::raw('COUNT(csc_download_research_corner.id_itdp_profil_eks) as download'))
                    ->Groupby('itdp_profil_eks.id')
                    ->Groupby('csc_download_research_corner.id_itdp_profil_eks')
                    ->where(function ($query) use ($search) {
                        $query->where('itdp_profil_eks.company', 'ilike', '%' . $search . '%');
//                        $query->where('itdp_company_users.created_at', 'ilike', '%' . $search . '%');
//                        $query->where('itdp_company_users.verified_at', 'ilike', '%' . $search . '%');
                    })
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();

                $totalFiltered =  DB::table('csc_download_research_corner')
                    ->join('itdp_profil_eks','itdp_profil_eks.id','csc_download_research_corner.id_itdp_profil_eks')
                    ->Groupby('itdp_profil_eks.id')
                    ->Groupby('csc_download_research_corner.id_itdp_profil_eks')
                    ->select('itdp_profil_eks.id','itdp_profil_eks.company','csc_download_research_corner.id_itdp_profil_eks', DB::raw('COUNT(csc_download_research_corner.id_itdp_profil_eks) as download'))
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
                    $nestedData['company'] = '<left>' . $d->company . '</left>';
                    $nestedData['download'] = '<center>' . $d->download . '</center>';
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

//        dd($data);

        echo json_encode($json_data);

    }

    public function cetakcsv1(Request $request){
        $data = DB::table('csc_research_corner')
            ->select('id','title_en','download')
            ->orderby('download', 'desc')
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
        $sheet->getStyle('A1:C'.$length)->applyFromArray($styleArray);

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(50);
        $sheet->getColumnDimension('C')->setWidth(10);

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Research Corner Title');
        $sheet->setCellValue('C1', 'Download');
        $rows = 2;
        foreach($data as $detail){
            $no = $start +1;
            $sheet->setCellValue('A' . $rows, $no);
            $sheet->setCellValue('B' . $rows, $detail->title_en);
            $sheet->setCellValue('C' . $rows, $detail->download);

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
        $file_name = public_path()."/excel/List Research Corner From Title.xlsx";
        $writer->save( $file_name);

//        $headers = array('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        return response()->download($file_name);
    }

    public function cetakcsv2(Request $request){
        $data = DB::table('csc_download_research_corner')
            ->join('itdp_profil_eks','itdp_profil_eks.id','csc_download_research_corner.id_itdp_profil_eks')
            ->select('itdp_profil_eks.id','itdp_profil_eks.company','csc_download_research_corner.id_itdp_profil_eks', DB::raw('COUNT(csc_download_research_corner.id_itdp_profil_eks) as download'))
            ->Groupby('itdp_profil_eks.id')
            ->Groupby('csc_download_research_corner.id_itdp_profil_eks')
            ->orderby('download', 'desc')
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
        $sheet->getStyle('A1:C'.$length)->applyFromArray($styleArray);

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(50);
        $sheet->getColumnDimension('C')->setWidth(10);

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Company Name');
        $sheet->setCellValue('C1', 'Download');
        $rows = 2;
        foreach($data as $detail){
            $no = $start +1;
            $sheet->setCellValue('A' . $rows, $no);
            $sheet->setCellValue('B' . $rows, $detail->company);
            $sheet->setCellValue('C' . $rows, $detail->download);

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
        $file_name = public_path()."/excel/List Market Research From Company.xlsx";
        $writer->save( $file_name);

//        $headers = array('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        return response()->download($file_name);
    }

}
