<?php

namespace App\Http\Controllers;

use App\Models\Notif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Auth;
use Illuminate\Support\Facades\Input;

class DashboardEksportirController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:eksmp');
    }

    public function index()
    {
        if (Auth::guard('eksmp')->user()->id_role == 2) {
            $pageTitle = "Dashboard";
            $query = DB::table('csc_product_single')
                ->where('status', '!=', 9)
                ->where('id_itdp_company_user', Auth::guard('eksmp')->user()->id);
            $jumlah = $query->count();
            $product = $query->paginate(8);
            $top_product = $this->getTopProduct();
            $incomes = $this->getIncomes();
            $interest = $this->getInterest();

            return view('Dashboard.Eksportir', ['product' => $product->appends(Input::except('page'))], compact('pageTitle', 'jumlah'))->with('top_product', json_decode($top_product, true))->with('incomes', json_decode($incomes, true))->with('interest', json_decode($interest, true));
        } else {
            return redirect('/');
        }
    }

    private function tahun()
    {
        $tahun = '';
        for ($year = intval(date('Y')); $year >= date('Y') - 4; $year--) {
            if ($year == date('Y') - 4) {
                $tahun .= $year;
            } else {
                $tahun .= $year . ',';
            }
        }
        return $tahun;
    }

    private function bulan($month)
    {
        $array = array(
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December'
        );
        return $array[$month];
    }

    private function getTopProduct()
    {
        $color = array(
            0 => '#855c9a',
            1 => '#e69419',
            2 => '#44c742',
            3 => '#c74242',
            4 => '#789ec5',
        );

        $product = DB::table('csc_transaksi')
            ->selectRaw('count(*) as jumlah, id_product')
            ->where('id_eksportir', Auth::guard('eksmp')->user()->id)
            ->groupby('id_product')->orderby('jumlah', 'desc')
            ->limit(5)->get();

        $return = null;
        if (count($product) > 0) {
            $fetch_data = '[{"name": "Selling", "data": [';

            foreach ($product as $key => $value) {
                $fetch_data .= '{"name": "' . getProductName($value->id_product) . '", "color": "' . $color[$key] . '", "y": ' . $value->jumlah . '},';
            }

            $fetch_data = rtrim($fetch_data, ", ");
            $fetch_data .= ']}]';

            $return = $fetch_data;
        }

        return $return;
    }

    private function getIncomes()
    {
        $fetch_data = '[';
        $fetch_sub_data = '[';
        $tahun = $this->tahun();

        $color = array(
            0 => '#7cc5fd',
            1 => '#ffad33',
            2 => '#44c742',
        );

        $income = DB::table('csc_transaksi')->selectRaw('extract(year from created_at) as year, sum(total) as jumlah, ntp')
            ->where('id_eksportir', Auth::guard('eksmp')->user()->id)
            ->whereRaw('extract(year from created_at) in (' . $tahun . ')')
            ->groupby('year')
            ->groupby('ntp')
            ->get();

        $max = $income->max('year');
        $min = $income->min('year');

        $return = null;
        if (count($income) > 0) {
            for ($i = 0; $i < 3; $i++) {
                if ($i == 0) {
                    $fetch_data .= '{"name": "IDR", "color": "' . $color[$i] . '", "data": [';
                    $param = "IDR";
                } else if ($i == 1) {
                    $fetch_data .= '{"name": "THB", "color": "' . $color[$i] . '", "data": [';
                    $param = "THB";
                } else {
                    $fetch_data .= '{"name": "USD", "color": "' . $color[$i] . '", "data": [';
                    $param = "USD";
                }
                foreach ($income as $key => $value) {
                    if ($value->ntp == $param) {
                        $fetch_data .= '{"name": "' . $value->year . '", "y": ' . $value->jumlah . ', "drilldown": "' . $value->year . '-' . $param . '"},';

                        // Data Drilldown
                        $fetch_sub_data .= '{"name": "' . $param . '", "id": "' . $value->year . '-' . $param . '", "data": [';

                        for ($m = 1; $m < 13; $m++) {
                            $fetch_sub_data .= $this->getDataSub($m, $value->year, 'income', $param);
                            if ($m != 12) {
                                $fetch_sub_data .= ',';
                            }
                        }
                        $fetch_sub_data .= ']},';
                    }
                }
                $fetch_data = rtrim($fetch_data, ", ");
                $fetch_data .= ']},';
            }

            $fetch_sub_data = rtrim($fetch_sub_data, ", ");
            $fetch_sub_data .= ']';
            $fetch_data = rtrim($fetch_data, ", ");
            $fetch_data .= ']';
            $return = '[' . $fetch_data . ',' . $fetch_sub_data . ']';
        }

        return $return;
    }

    private function getInterest()
    {
        $fetch_data = '[';
        $fetch_sub_data = '[';
        $tahun = $this->tahun();

        $color = array(
            0 => '#c138ef',
            1 => '#3ba7fb',
        );

        $event = DB::table('event_interest')->selectRaw('extract(year from created_at) as year, count(*) as jumlah')
            ->where('id_profile', Auth::guard('eksmp')->user()->id_profil)
            ->whereRaw('extract(year from created_at) in (' . $tahun . ')')
            ->groupby('year')
            ->get();

        $training = DB::table('training_interest')->selectRaw('extract(year from created_at) as year, count(*) as jumlah')
            ->where('id_profile', Auth::guard('eksmp')->user()->id_profil)
            ->whereRaw('extract(year from created_at) in (' . $tahun . ')')
            ->groupby('year')
            ->get();

        $return = null;
        if (count($event) > 0) {
            for ($i = 0; $i < 2; $i++) {
                if ($i == 0) {
                    $fetch_data .= '{"name": "Event", "color": "' . $color[$i] . '", "data": [';
                    $data = $event;
                    $param = 'Event';
                } else {
                    $fetch_data .= '{"name": "Training", "color": "' . $color[$i] . '", "data": [';
                    $data = $training;
                    $param = 'Training';
                }
                foreach ($data as $key => $value) {
                    $fetch_data .= '{"name": "' . $value->year . '", "y": ' . $value->jumlah . ', "drilldown": "' . $value->year . '-' . $param . '"},';

                    // Data Drilldown
                    $fetch_sub_data .= '{"name": "' . $param . '", "id": "' . $value->year . '-' . $param . '", "data": [';

                    for ($m = 1; $m < 13; $m++) {
                        $fetch_sub_data .= $this->getDataSub($m, $value->year, 'interest', $param);
                        if ($m != 12) {
                            $fetch_sub_data .= ',';
                        }
                    }
                    $fetch_sub_data .= ']},';
                }
                $fetch_data = rtrim($fetch_data, ", ");
                $fetch_data .= ']},';
            }
            $fetch_sub_data = rtrim($fetch_sub_data, ", ");
            $fetch_sub_data .= ']';
            $fetch_data = rtrim($fetch_data, ", ");
            $fetch_data .= ']';
            $return = '[' . $fetch_data . ',' . $fetch_sub_data . ']';
        }

        return $return;
    }
    private function getDataSub($month, $year, $jenis, $param)
    {
        if ($jenis == 'income') {
            $data = DB::table('csc_transaksi')->selectRaw('sum(total) as jumlah, ntp')
                ->where('id_eksportir', Auth::guard('eksmp')->user()->id)
                ->whereRaw('extract(year from created_at) = \'' . $year . '\'')
                ->whereRaw('extract(month from created_at) = \'' . $month . '\'')
                ->where('ntp', $param)
                ->groupby('ntp')
                ->first();
        } else if ($jenis == 'interest') {
            $param = strtolower($param);
            $data = DB::table('' . $param . '_interest')->selectRaw('count(*) as jumlah')
                ->where('id_profile', Auth::guard('eksmp')->user()->id_profil)
                ->whereRaw('extract(year from created_at) = \'' . $year . '\'')
                ->whereRaw('extract(month from created_at) = \'' . $month . '\'')
                ->first();
        }

        if ($data) {
            return '["' . $this->bulan($month) . '", ' . $data->jumlah . ']';
        } else {
            return '["' . $this->bulan($month) . '", 0]';
        }
    }

    public function markAsReadNotification(Request $request){
        $id = Auth::user() != '' ? Auth::user()->id : Auth::guard('eksmp')->user()->id;
        Notif::where('untuk_id', $id)->update(['status_baca' => '1']);

        return response()->json([
            'success' => '200'
        ]);
    }
}
