<?php
require_once('vendor/autoload.php');

use App\Models\Notif;
use Cocur\Slugify\Slugify;
use Stichoza\GoogleTranslate\GoogleTranslate;

if (!function_exists('getTanggalIndo')) {
  function getTanggalIndo($tanggal)
  {
    date_default_timezone_set("Asia/Bangkok");
    $bulan = array(
      1 =>   'Januari',
      2 => 'Februari',
      3 => 'Maret',
      4 => 'April',
      5 => 'Mei',
      6 => 'Juni',
      7 => 'Juli',
      8 => 'Agustus',
      9 => 'September',
      10 => 'Oktober',
      11 => 'November',
      12 => 'Desember'
    );
    $pecahkan = explode('-', $tanggal);

    return $pecahkan[2] . ' ' . $bulan[(int) $pecahkan[1]] . ' ' . $pecahkan[0];
  }
}

if (!function_exists('slugifyTitle')) {
  function slugifyTitle($title)
  {
    $slugify = new Slugify();
    return $slugify->slugify($title);
  }
}

if (!function_exists('rc_type')) {
  function rc_type($id, $lang)
  {
    $data = DB::table('csc_research_type')->where('id', $id)->first();
    if ($lang == 'in') {
      if ($data->nama_in != null || $data->nama_in != '') {
        return $data->nama_in;
      } else {
        return $data->nama_en;
      }
    } else {
      return $data->nama_en;
    }
  }
}

if (!function_exists('optionCategory')) {
  function optionCategory()
  {
    $option = '';
    $option .= '<option value="0">All Category</option>';
    $categori = DB::table('csc_product_single as a')->join('itdp_profil_eks as b', 'a.id_itdp_profil_eks', '=', 'b.id')->select('id_csc_product')->distinct('id_csc_product')->get();
    $level1 = DB::table('csc_product_single as a')->join('itdp_profil_eks as b', 'a.id_itdp_profil_eks', '=', 'b.id')->select('id_csc_product_level1')->where('id_csc_product_level1', '!=', null)->distinct('id_csc_product_level1')->get();
    $level2 = DB::table('csc_product_single as a')->join('itdp_profil_eks as b', 'a.id_itdp_profil_eks', '=', 'b.id')->select('id_csc_product_level2')->where('id_csc_product_level2', '!=', null)->distinct('id_csc_product_level2')->get();

    foreach ($categori as $data) {
      $category = DB::table('csc_product')->where('id', $data->id_csc_product)->first();
      if ($category) {
        $option .= '<option value="' . $category->id . '">' . $category->nama_kategori_en . '</option>';
      }
    }
    foreach ($level1 as $data) {
      $category = DB::table('csc_product')->where('id', $data->id_csc_product_level1)->first();
      if ($category) {
        $option .= '<option value="' . $category->id . '">' . $category->nama_kategori_en . '</option>';
      }
    }
    foreach ($level2 as $data) {
      $category = DB::table('csc_product')->where('id', $data->id_csc_product_level2)->first();
      if ($category) {
        $option .= '<option value="' . $category->id . '">' . $category->nama_kategori_en . '</option>';
      }
    }

    echo $option;
  }
}



if (!function_exists('rc_country')) {
  function rc_country($id)
  {
    $country = '-';
    $data = DB::table('mst_country')->where('id', $id)->first();
    if ($data) {
      $country = $data->country;
    }
    return $country;
  }
}

if (!function_exists('rc_hscodes')) {
  function rc_hscodes($id)
  {
    $data = DB::table('mst_hscodes')->where('id', $id)->first();

    return $data->fullhs . " - " . $data->desc_eng;
  }
}

if (!function_exists('getNameCategoryProduct')) {
  function getNameCategoryProduct($id, $jns)
  {

    $data = DB::table('csc_product')->where('id', $id)->first();
    $name = 'nama_kategori_' . $jns;
    // dd($data);
    if ($data != null) {
      return $data->$name;
    } else {
      return null;
    }
  }
}

if (!function_exists('getNameCompany')) {
  function getNameCompany($id)
  {
    $name = "";
    if ($id != NULL) {
      $companynya = DB::table('itdp_company_users')
        ->where('id', $id)
        ->first();
      if ($companynya) {
        $profiles = DB::table('itdp_profil_eks')->where('id', $companynya->id_profil)->first();
        if ($profiles) {
          $name = $profiles->company;
        }
      }
    }
    return $name;
  }
}

if (!function_exists('getEventComodity')) {
  function getEventComodity($id)
  {
    $data = DB::table('event_comodity')->where('id', $id)->first();
    return $data->comodity_en;
  }
}
if (!function_exists('getEventCom')) {
  function getEventCom($id, $lang)
  {
    $data = DB::table('event_comodity')->where('id', $id)->first();
    if ($lang == 'ch') {
      return $data->comodity_chn;
    } elseif ($lang == 'in') {
      return $data->comodity_in;
    } else {
      return $data->comodity_en;
    }
  }
}

if (!function_exists('getEventPlace')) {
  function getEventPlace($id)
  {
    $data = DB::table('event_place')->where('id', $id)->first();
    return $data->name_en;
  }
}

if (!function_exists('getEventStatus')) {
  function getEventStatus($id)
  {
    $data = DB::table('event_detail')->where('id', $id)->first();
    return $data->status_en;
  }
}

if (!function_exists('getKatagori')) {
  function getKatagori($id)
  {
    $data = DB::table('event_detail_kategori')->where('id_event_detail', $id)->get();
    foreach ($data as $key => $value) {
      $nama = DB::table('csc_product')->where('id', $value->id_prod_cat)->first();
      echo '<br> -' . $nama->nama_kategori_en;
    }
  }
}

if (!function_exists('checkJoin')) {
  function checkJoin($id_training_admin, $id_profil_eks)
  {
    $data = DB::table('training_join')
      ->where('id_training_admin', $id_training_admin)
      ->where('id_profil_eks', $id_profil_eks)
      ->first();
    if ($data) {
      return 1;
    } else {
      return 0;
    }
  }
}

if (!function_exists('checkJoinEvent')) {
  function checkJoinEvent($id_event, $id_user)
  {
    $cek = DB::table('notif')->where('url_terkait', 'event/show/read')->where(function ($param) use ($id_user, $id_event) {
      $param->where('untuk_id', $id_user)
        ->where('id_terkait', $id_event);
    })->first();

    $return = 0;
    if ($cek) {
      if ($cek->status == 2) {
        $return = 1;
      } elseif ($cek->status == 1) {
        $return = 2;
      } else {
        $return = 0;
      }
    } else {
      $cek = DB::table('event_company_add')->where('id_event_detail', $id_event)->where('id_itdp_profil_eks', $id_user)->first();
      if ($cek) {
        if ($cek->status == 2) {
          $return = 1;
        } else {
          $return = 2;
        }
      } else {
        $return = 0;
      }
    }

    return $return;
  }
}

if (!function_exists('EvenOrgZ')) {
  function EvenOrgZ($id, $lang)
  {
    $data = DB::table('event_organizer')->where('id', $id)->first();
    if ($lang == 'in') {
      return $data->name_in;
    } else if ($lang == 'en') {
      return $data->name_en;
    } else {
      return $data->name_chn;
    }
  }
}

if (!function_exists('EventPlaceZ')) {
  function EventPlaceZ($id, $lang)
  {
    $data = DB::table('event_place')->where('id', $id)->first();
    if ($lang == 'in') {
      return $data->name_in;
    } elseif ($lang == 'en') {
      return $data->name_en;
    } else {
      return $data->name_chn;
    }
  }
}

if (!function_exists('optionCategoryZ')) {
  function optionCategoryZ($id)
  {
    $data = DB::table('event_detail_kategori')->where('id_event_detail', $id)->get();
    $arr = [];
    foreach ($data as $value) {
      array_push($arr, $value->id_prod_cat);
    }

    $option = '';
    $categori = DB::table('csc_product_single as a')->join('itdp_profil_eks as b', 'a.id_itdp_profil_eks', '=', 'b.id')->select('id_csc_product')->distinct('id_csc_product')->get();
    $level1 = DB::table('csc_product_single as a')->join('itdp_profil_eks as b', 'a.id_itdp_profil_eks', '=', 'b.id')->select('id_csc_product_level1')->where('id_csc_product_level1', '!=', null)->distinct('id_csc_product_level1')->get();
    $level2 = DB::table('csc_product_single as a')->join('itdp_profil_eks as b', 'a.id_itdp_profil_eks', '=', 'b.id')->select('id_csc_product_level2')->where('id_csc_product_level2', '!=', null)->distinct('id_csc_product_level2')->get();
    if (in_Array("0", $arr)) {
      $selec2 = "selected";
    } else {
      $selec2 = "";
    }
    $option .= '<option value="0" ' . $selec2 . '>All Category</option>';
    foreach ($categori as $data) {
      $category = DB::table('csc_product')->where('id', $data->id_csc_product)->first();

      if ($category) {
        if (in_array($category->id, $arr)) {
          $selec = "selected";
        } else {
          $selec = "";
        }
        $option .= '<option value="' . $category->id . '" ' . $selec . '>' . $category->nama_kategori_en . '</option>';
      }
    }
    foreach ($level1 as $data) {
      $category = DB::table('csc_product')->where('id', $data->id_csc_product_level1)->first();

      if ($category) {
        if (in_array($category->id, $arr)) {
          $selec = "selected";
        } else {
          $selec = "";
        }

        $option .= '<option value="' . $category->id . '" ' . $selec . '>' . $category->nama_kategori_en . '</option>';
      }
    }
    foreach ($level2 as $data) {
      $category = DB::table('csc_product')->where('id', $data->id_csc_product_level2)->first();

      if ($category) {
        if (in_array($category->id, $arr)) {
          $selec = "selected";
        } else {
          $selec = "";
        }

        $option .= '<option value="' . $category->id . '" ' . $selec . '>' . $category->nama_kategori_en . '</option>';
      }
    }

    echo $option;
  }
}

if (!function_exists('getProductAttr')) {
  function getProductAttr($id, $col, $lang)
  {
    $data = DB::table('csc_product_single')->where('id', $id)->first();
    $isi = NULL;
    if ($lang != "") {
      $dt = $col . '_' . $lang;
      if ($data->$dt != NULL) {
        $isi = $data->$dt;
      } else {
        $dt = $col . '_en';
        $isi = $data->$dt;
      }
    } else {
      if ($data->$col != NULL) {
        $isi = $data->$col;
      }
    }

    if ($isi == NULL) {
      $isi = "-";
    }

    return $isi;
  }
}

if (!function_exists('getCompanyName')) {
  function getCompanyName($id)
  {
    $nama = "-";
    $data = DB::table('itdp_company_users')->where('id', $id)->first();
    if ($data) {
      if ($data->id_profil != NULL) {
        $profil = DB::table('itdp_profil_eks')->where('id', $data->id_profil)->first();
        if ($profil) {
          $nama = $profil->company;
        }
      }
    }

    return $nama;
  }
}

if (!function_exists('getCategoryName')) {
  function getCategoryName($id, $loc)
  {
    $nama = "-";
    if ($id != NULL) {
      $col = "nama_kategori_" . $loc;
      $data = DB::table('csc_product')->where('id', $id)->first();
      if ($data) {
        if ($data->$col != NULL) {
          $nama = $data->$col;
        } else {
          $col = "nama_kategori_en";
          $nama = $data->$col;
        }
      }
    }

    return $nama;
  }
}

if (!function_exists('cekid')) {
  function cekid($id)
  {
    $id = DB::table('itdp_company_users as icu')
      ->selectRaw('ipe.id')
      ->leftJoin('itdp_profil_eks as ipe', 'icu.id_profil', '=', 'ipe.id')
      ->where('icu.id', $id)
      ->first();

    return $id;
  }
}
if (!function_exists('StatusJoin')) {
  function StatusJoin($id, $id_user)
  {
    $data = DB::table('notif')->where('untuk_id', $id_user)->where('id_terkait', $id)->first();
    if ($data) {
      return $data->status;
    } else {
      $data = DB::table('event_company_add')->where('id_itdp_profil_eks', $id_user)->where('id_event_detail', $id)->first();
      return $data->status;
    }
  }
}

if (!function_exists('CompanyZ')) {
  function CompanyZ($id)
  {
    $da = DB::table('itdp_company_users')->where('id', $id)->first();
    $dat = DB::table('itdp_profil_eks')->where('id', $da->id_profil)->first();
    return $dat->company;
  }
}

if (!function_exists('getCompanyNameImportir')) {
  function getCompanyNameImportir($id)
  {
    $nama = "-";
    $data = DB::table('itdp_company_users')->where('id', $id)->first();
    if ($data) {
      if ($data->id_profil != NULL) {
        $profil = DB::table('itdp_profil_imp')->where('id', $data->id_profil)->first();
        if ($profil) {
          $nama = $profil->company;
        }
      }
    }

    return $nama;
  }
}

if (!function_exists('getIdUserEks')) {
  function getIdUserEks($id)
  {
    $data = DB::table('itdp_company_users')->where('id_profil', $id)->first();
    return $data->id;
  }
}

if (!function_exists('getServiceAttr')) {
  function getServiceAttr($id, $col, $lang)
  {
    $data = DB::table('itdp_service_eks')->where('id', $id)->first();

    if ($lang != "") {
      $dt = $col . '_' . $lang;
      if ($data->$dt != NULL) {
        $isi = $data->$dt;
      } else {
        $dt = $col . '_en';
        $isi = $data->$dt;
      }
    } else {
      $isi = $data->$col;
    }

    echo $isi;
  }
}

if (!function_exists('getPerwakilanName')) {
  function getPerwakilanName($id)
  {
    $nama = "-";
    $data = DB::table('itdp_admin_users')->where('id', $id)->first();
    if ($data) {
      $nama = $data->name;
      // if($data->id_admin_dn || $data->id_admin_ln){
      //   if($data->id_admin_dn == 0){
      //     $ln = DB::table('itdp_admin_ln')->where('id', $data->id_admin_ln)->first();
      //     if($ln){
      //       $nama = $ln->nama;
      //     }
      //   }else if($data->id_admin_ln == 0){
      //     $dn = DB::table('itdp_admin_dn')->where('id', $data->id_admin_dn)->first();
      //     if($dn){
      //       $nama = $dn->nama;
      //     }
      //   }
      // }
    }

    return $nama;
  }
}

if (!function_exists('getAdminName')) {
  function getAdminName($id)
  {
    $nama = "-";
    $data = DB::table('itdp_admin_users')->where('id', $id)->first();
    if ($data) {
      if ($data->name != NULL) {
        $nama = $data->name;
      }
    }

    return $nama;
  }
}

if (!function_exists('changeStatusInquiry')) {
  function changeStatusInquiry()
  {
    $data = DB::table('csc_inquiry_br')->get();
    $datenow = strtotime(date('Y-m-d H:i:s'));
    $different = [];
    foreach ($data as $key) {
      if ($key->status == 2) {
        $date = [];
        if ($key->type == "importir") {
          if ($key->due_date != NULL) {
            if ($datenow >= strtotime($key->due_date)) {
              $updstat = DB::table('csc_inquiry_br')->where('id', $key->id)->update([
                'status' => 5,
              ]);
            }
          }
        } else {
          $broadcast = DB::table('csc_inquiry_broadcast')->where('id_inquiry', $key->id)->get();
          $brostat = DB::table('csc_inquiry_broadcast')->where('id_inquiry', $key->id)->where('status', 5)->get();
          foreach ($broadcast as $key2) {
            if ($key2->status == 2) {
              if ($key2->due_date != NULL) {
                if ($datenow >= strtotime($key2->due_date)) {
                  // array_push($date, $key2->id);
                  $updstat = DB::table('csc_inquiry_broadcast')->where('id', $key2->id)->update([
                    'status' => 5,
                  ]);
                }
              }
            }
          }
          // array_push($different, $date);
          if (count($broadcast) == count($brostat)) {
            $updstat = DB::table('csc_inquiry_br')->where('id', $key->id)->update([
              'status' => 5,
            ]);
          }
        }
      }
    }
    return 1;
  }
}

if (!function_exists('getPerwakilanCountry')) {
  function getPerwakilanCountry($id)
  {
    $country = 0;
    $data = DB::table('itdp_admin_ln')->where('id', $id)->first();
    if ($data) {
      if ($data->id_country != NULL) {
        $country = $data->id_country;
      }
    }

    return $country;
  }
}


if (!function_exists('getCompanyNameRC')) {
  function getCompanyNameRC($id, $key, $param)
  {
    if ($param == 'null') {
      $data = DB::table('itdp_profil_eks')->where('id', $id)->first();
      if ($data) {
        return $data->company;
      } else {
        $number = $key + 1;
        return 'Company not Found ' . $number;
      }
    } else {
      $data = DB::table('itdp_company_users')->where('id', $id)->first();
      $data = DB::table('itdp_profil_eks')->where('id', $data->id_profil)->first();
      if ($data) {
        return $data->company;
      } else {
        $number = $key + 1;
        return 'Company not Found ' . $number;
      }
    }
  }
}

if (!function_exists('getRcName')) {
  function getRcName($id, $key)
  {
    $data = DB::table('csc_research_corner')->where('id', $id)->first();
    if ($data) {
      return $data->title_en . ' ( ' . rc_country($data->id_mst_country) . ' )';
    } else {
      $number = $key + 1;
      return 'Name not Found ' . $number;
    }
  }
}

if (!function_exists('getNameEvent')) {
  function getNameEvent($id, $key)
  {
    $data = DB::table('event_detail')->where('id', $id)->first();
    if ($data) {
      return $data->event_name_en;
    } else {
      $number = $key + 1;
      return 'Event not Found ' . $number;
    }
  }
}

if (!function_exists('getNameTraining')) {
  function getNameTraining($id, $key)
  {
    $data = DB::table('training_admin')->where('id', $id)->first();
    if ($data) {
      return $data->training_en;
    } else {
      $number = $key + 1;
      return 'Training not Found ' . $number;
    }
  }
}


if (!function_exists('getCategoryLevel')) {
  function getCategoryLevel($level, $idutama, $idcat1)
  {
    if ($level == 1) {
      $category = DB::table('csc_product')->where('level_1', $idutama)->where('level_2', 0)->orderby('nama_kategori_en', 'ASC')->get();
    } else {
      $category = DB::table('csc_product')->where('level_1', $idcat1)->where('level_2', $idutama)->orderby('nama_kategori_en', 'ASC')->get();
    }

    return $category;
  }
}

if (!function_exists('getSubCategoryPerusahaan')) {
  function getSubCategoryPerusahaan($id_perusahaan, $id_product)
  {
    $category = DB::table('csc_product')
      ->join('csc_product_single', 'csc_product.id', 'csc_product_single.id_csc_product_level1')
      ->select(
        'csc_product.id',
        'csc_product.level_1',
        'csc_product.level_2',
        'csc_product.nama_kategori_en',
        'csc_product.nama_kategori_in',
        'csc_product.nama_kategori_chn',
        'csc_product.created_at',
        'csc_product.updated_at',
        'csc_product.type',
        'csc_product.logo'
      )
      ->groupby(
        'csc_product.id',
        'csc_product.level_1',
        'csc_product.level_2',
        'csc_product.nama_kategori_en',
        'csc_product.nama_kategori_in',
        'csc_product.nama_kategori_chn',
        'csc_product.created_at',
        'csc_product.updated_at',
        'csc_product.type',
        'csc_product.logo'
      )
      // ->where('level_1', 0)
      // ->where('level_2', 0)
      ->where('id_itdp_company_user', $id_perusahaan)
      ->where('csc_product.level_1', $id_product)
      // ->whereNotIn('csc_product_single.id_csc_product_level1', [$id_product])
      ->orderBy('nama_kategori_en', 'ASC')
      // ->limit(10)
      ->get();

    return $category;
  }
}

if (!function_exists('getCategoryLevelNew')) {
  //beda sama yang sebelumnya itu, yang ini hanya untuk yang exist di table csc_product_single
  function getCategoryLevelNew($level, $idutama, $idcat1)
  {
    if ($level == 1) {
      // $category = DB::table('csc_product')
      //               ->join('csc_product_single','csc_product.id','csc_product_single.id_csc_product')
      //               ->select('csc_product.id', 'csc_product.level_1', 'csc_product.level_2', 'csc_product.nama_kategori_en', 'csc_product.nama_kategori_in', 'csc_product.nama_kategori_chn', 'csc_product.created_at', 'csc_product.updated_at',
      //               'csc_product.type', 'csc_product.logo')
      //               ->groupby('csc_product.id', 'csc_product.level_1', 'csc_product.level_2', 'csc_product.nama_kategori_en', 'csc_product.nama_kategori_in', 'csc_product.nama_kategori_chn', 'csc_product.created_at', 'csc_product.updated_at',
      //               'csc_product.type', 'csc_product.logo')
      //               ->where('level_1', $idutama)
      //               ->where('level_2', 0)
      //               ->orderby('nama_kategori_en', 'ASC')
      //               ->get();
      $category = DB::select('SELECT
      "csc_product"."id",
      "csc_product"."level_1",
      "csc_product"."level_2",
      "csc_product"."nama_kategori_en",
      "csc_product"."nama_kategori_in",
      "csc_product"."nama_kategori_chn",
      "csc_product"."created_at",
      "csc_product"."updated_at",
      "csc_product"."type",
      "csc_product"."logo"
    FROM
      "csc_product"
      INNER JOIN "csc_product_single" ON "csc_product"."id" = "csc_product_single"."id_csc_product_level1"
    WHERE
      "level_1" =' . $idutama . '
      AND "level_2" = 0
    GROUP BY
      "csc_product"."id",
      "csc_product"."level_1",
      "csc_product"."level_2",
      "csc_product"."nama_kategori_en",
      "csc_product"."nama_kategori_in",
      "csc_product"."nama_kategori_chn",
      "csc_product"."created_at",
      "csc_product"."updated_at",
      "csc_product"."type",
      "csc_product"."logo"
    ORDER BY
      "nama_kategori_en" ASC
      ');
    } else {
      // $category = DB::table('csc_product')
      //           ->where('level_1', $idcat1)
      //           ->where('level_2', $idutama)
      //           ->orderby('nama_kategori_en', 'ASC')
      //           ->get();
      $category = DB::select('SELECT
      "csc_product"."id",
      "csc_product"."level_1",
      "csc_product"."level_2",
      "csc_product"."nama_kategori_en",
      "csc_product"."nama_kategori_in",
      "csc_product"."nama_kategori_chn",
      "csc_product"."created_at",
      "csc_product"."updated_at",
      "csc_product"."type",
      "csc_product"."logo"
    FROM
      "csc_product"
      INNER JOIN "csc_product_single" ON "csc_product"."id" = "csc_product_single"."id_csc_product_level2"
    WHERE
      "level_1" =' . $idcat1 . '
      AND "level_2" = ' . $idutama . '
    GROUP BY
      "csc_product"."id",
      "csc_product"."level_1",
      "csc_product"."level_2",
      "csc_product"."nama_kategori_en",
      "csc_product"."nama_kategori_in",
      "csc_product"."nama_kategori_chn",
      "csc_product"."created_at",
      "csc_product"."updated_at",
      "csc_product"."type",
      "csc_product"."logo"
    ORDER BY
      "nama_kategori_en" ASC
      ');
    }

    return $category;
  }
}


if (!function_exists('getCountProduct')) {
  function getCountProduct($jenis, $ideksportir)
  {
    if ($jenis == "company") {
      $product = DB::table('csc_product_single')
        ->join('itdp_company_users', 'itdp_company_users.id', '=', 'csc_product_single.id_itdp_company_user')
        ->select('csc_product_single.*', 'itdp_company_users.id as id_company', 'itdp_company_users.status as status_company')
        ->where('itdp_company_users.status', 1)
        ->where('csc_product_single.status', 2)
        ->where('csc_product_single.show', 1)
        ->where('csc_product_single.id_itdp_company_user', $ideksportir)
        ->count();
    }

    return $product;
  }
}

if (!function_exists('getCountData')) {
  function getCountData($tbl)
  {
    if ($tbl == "event_detail") {
      $data = DB::table($tbl)
        ->whereDate('end_date', '>=', date('Y-m-d'))
        ->count();
    } else if ($tbl == "csc_product_single") {
      $data = DB::table($tbl)
        ->join('itdp_company_users', 'itdp_company_users.id', '=', $tbl . '.id_itdp_company_user')
        ->select($tbl . '.*', 'itdp_company_users.id as id_company', 'itdp_company_users.status as status_company')
        ->where('itdp_company_users.status', 1)
        ->where($tbl . '.status', 2)
        ->count();
    } else if ($tbl == "itdp_company_users") {
      $data = DB::table($tbl)
        ->join('itdp_profil_eks', 'itdp_company_users.id_profil', '=', 'itdp_profil_eks.id')
        ->where('itdp_company_users.id_role', 2)
        ->count();
    } else if ($tbl == 'itdp_admin_users') {
      $data = DB::table($tbl)
        ->join('itdp_admin_ln', 'itdp_admin_ln.id', 'itdp_admin_users.id_admin_ln')
        ->where('itdp_admin_users.id_group', 4)
        ->whereNotNull('itdp_admin_users.id_admin_ln')
        ->where('itdp_admin_ln.status', 1)
        ->count();
    } else if ($tbl == 'csc_research_corner') {
      $data = DB::table($tbl)
        ->count();
    }

    return $data;
  }
}

if (!function_exists('getProductByCategory')) {
  function getProductByCategory($category)
  {
    $product = DB::table('csc_product_single')
      ->join('itdp_company_users', 'itdp_company_users.id', '=', 'csc_product_single.id_itdp_company_user')
      ->select('csc_product_single.*', 'itdp_company_users.id as id_company', 'itdp_company_users.status as status_company')
      ->where('itdp_company_users.status', 1)
      ->where('csc_product_single.status', 2)
      ->where('csc_product_single.show', 1)
      ->where('csc_product_single.id_csc_product', $category)
      ->inRandomOrder()
      ->limit(6)
      ->get();

    return $product;
  }
}

if (!function_exists('getProductByCategory2')) {
  function getProductByCategory2($category)
  {
    $product = DB::table('csc_product_single')
      ->join('itdp_company_users', 'itdp_company_users.id', '=', 'csc_product_single.id_itdp_company_user')
      ->select('csc_product_single.*', 'itdp_company_users.id as id_company', 'itdp_company_users.status as status_company')
      ->where('itdp_company_users.status', 1)
      ->where('csc_product_single.status', 2)
      ->where('csc_product_single.show', 1)
      ->where('csc_product_single.id_csc_product', $category)
      ->orderByRaw('csc_product_single.hot DESC NULLS LAST')
      //            ->orderBy(DB::raw('csc_product_single.hot IS NULL, csc_product_single.hot'), 'asc')
      //            ->whereNotNull('hot')
      //            ->orderByRaw('ISNULL(csc_product_single.hot), csc_product_single.hot ASC')
      //            ->orderByRaw('csc_product_single.hot desc')
      ->limit(6)
      ->get();

    return $product;
  }
}

if (!function_exists('getPerwakilanCountry2')) {
  function getPerwakilanCountry2($id)
  {
    $nama = "-";
    $data = DB::table('itdp_admin_users')->where('id', $id)->first();
    if ($data) {
      if ($data->id_admin_dn || $data->id_admin_ln) {
        if ($data->id_admin_dn == 0) {
          $ln = DB::table('itdp_admin_ln')->where('id', $data->id_admin_ln)->first();
          $country = DB::table('mst_country')->where('id', $ln->id_country)->first();
          if ($country) {
            $nama = $country->country;
          }
        } else if ($data->id_admin_ln == 0) {
          $dn = DB::table('itdp_admin_dn')->where('id', $data->id_admin_dn)->first();
          $country = DB::table('mst_country')->where('id', $dn->id_country)->first();
          if ($country) {
            $nama = $country->country;
          }
        }
      }
    }

    return $nama;
  }
}
if (!function_exists('getTableNotif')) {
  function getTableNotif($id)
  {

    $data = Notif::where('untuk_id', $id)
      ->where(function ($d) {
        $d->orWhere('url_terkait', 'chat_admin_eks_imp');
        $d->orWhere('url_terkait', 'br_pw_chat');
        $d->orWhere('url_terkait', 'br_chat');
        $d->orWhere('url_terkait', 'br_importir_chat');
        $d->orWhere('url_terkait', 'front_end/chat_inquiry');
        $d->orWhere('url_terkait', 'inquiry/chatting');
        $d->orWhere('url_terkait', 'inquiry_admin/chatting');
        $d->orWhere('url_terkait', 'inquiry_perwakilan/chatting');
      })
      ->where('status_baca', 0)
      ->with('admin', 'company.profile', 'company.profile_buyer')
      ->orderBy('waktu', 'DESC')
      ->get();
    return $data;
  }
}

if (!function_exists('getTableNotifModal')) {
  function getTableNotifModal($id)
  {

    $data = Notif::where('untuk_id', $id)
      ->where(function ($d) {
        $d->orWhere('url_terkait', 'chat_admin_eks_imp');
        $d->orWhere('url_terkait', 'br_pw_chat');
        $d->orWhere('url_terkait', 'br_chat');
        $d->orWhere('url_terkait', 'br_importir_chat');
        $d->orWhere('url_terkait', 'front_end/chat_inquiry');
        $d->orWhere('url_terkait', 'inquiry/chatting');
        $d->orWhere('url_terkait', 'inquiry_admin/chatting');
        $d->orWhere('url_terkait', 'inquiry_perwakilan/chatting');
      })
      ->where('status_baca', 0)
      ->with('admin', 'company.profile', 'company.profile_buyer')
      ->orderBy('waktu', 'DESC')
      ->get();
    return $data;
  }
}

if (!function_exists('countNotif')) {
  function countNotif($id)
  {

    $data = Notif::where('untuk_id', $id)
      ->where(function ($d) {
        $d->orWhere('url_terkait', 'chat_admin_eks_imp');
        $d->orWhere('url_terkait', 'br_pw_chat');
        $d->orWhere('url_terkait', 'br_chat');
        $d->orWhere('url_terkait', 'br_importir_chat');
        $d->orWhere('url_terkait', 'front_end/chat_inquiry');
        $d->orWhere('url_terkait', 'inquiry/chatting');
        $d->orWhere('url_terkait', 'inquiry_admin/chatting');
        $d->orWhere('url_terkait', 'inquiry_perwakilan/chatting');
      })
      ->where('status_baca', 0)
      ->with('admin', 'company.profile', 'company.profile_buyer')
      ->count();
    return $data;
  }
}

if (!function_exists('getProductbyEksportir')) {
  function getProductbyEksportir($user, $limit, $order, $lct)
  {
    if ($order == NULL) {
      if ($limit == NULL) {
        $product = DB::table('csc_product_single')
          ->where('status', 2)
          ->where('show', 1)
          ->where('id_itdp_company_user', $user)
          ->inRandomOrder()
          ->get();
      } else {
        $product = DB::table('csc_product_single')
          ->where('status', 2)
          ->where('show', 1)
          ->where('id_itdp_company_user', $user)
          ->inRandomOrder()
          ->paginate($limit);
      }
    } else {
      if ($order == "") {
        if ($limit == NULL) {
          $product = DB::table('csc_product_single')
            ->where('status', 2)
            ->where('show', 1)
            ->where('id_itdp_company_user', $user)
            ->inRandomOrder()
            ->get();
        } else {
          $product = DB::table('csc_product_single')
            ->where('status', 2)
            ->where('show', 1)
            ->where('id_itdp_company_user', $user)
            ->inRandomOrder()
            ->paginate($limit);
        }
      } else {
        if ($order == "new") {
          $col = "created_at";
          $urut = "DESC";
        } else if ($order == "asc") {
          $col = "prodname_" . $lct;
          $urut = "ASC";
        }
        if ($limit == NULL) {
          $product = DB::table('csc_product_single')
            ->where('status', 2)
            ->where('show', 1)
            ->where('id_itdp_company_user', $user)
            ->orderBy($col, $urut)
            ->get();
        } else {
          $product = DB::table('csc_product_single')
            ->where('status', 2)
            ->where('show', 1)
            ->where('id_itdp_company_user', $user)
            ->orderBy($col, $urut)
            ->paginate($limit);
        }
      }
    }

    return $product;
  }
}

if (!function_exists('getProductbyEksportirCat')) {
  function getProductbyEksportirCat($user, $limit, $order, $lct, $cat)
  {
    if ($order == NULL) {
      if ($limit == NULL) {
        $product = DB::table('csc_product_single')
          ->where('status', 2)
          ->where('show', 1)
          ->where('id_itdp_company_user', $user)
          ->where('id_csc_product_level1', $cat)
          ->inRandomOrder()
          ->get();
      } else {
        $product = DB::table('csc_product_single')
          ->where('status', 2)
          ->where('show', 1)
          ->where('id_itdp_company_user', $user)
          ->where('id_csc_product_level1', $cat)
          ->inRandomOrder()
          ->paginate($limit);
      }
    } else {
      if ($order == "") {
        if ($limit == NULL) {
          $product = DB::table('csc_product_single')
            ->where('status', 2)
            ->where('show', 1)
            ->where('id_itdp_company_user', $user)
            ->where('id_csc_product_level1', $cat)
            ->inRandomOrder()
            ->get();
        } else {
          $product = DB::table('csc_product_single')
            ->where('status', 2)
            ->where('show', 1)
            ->where('id_itdp_company_user', $user)
            ->where('id_csc_product_level1', $cat)
            ->inRandomOrder()
            ->paginate($limit);
        }
      } else {
        if ($order == "new") {
          $col = "created_at";
          $urut = "DESC";
        } else if ($order == "asc") {
          $col = "prodname_" . $lct;
          $urut = "ASC";
        }
        if ($limit == NULL) {
          $product = DB::table('csc_product_single')
            ->where('status', 2)
            ->where('show', 1)
            ->where('id_itdp_company_user', $user)
            ->where('id_csc_product_level1', $cat)
            ->orderBy($col, $urut)
            ->get();
        } else {
          $product = DB::table('csc_product_single')
            ->where('status', 2)
            ->where('show', 1)
            ->where('id_itdp_company_user', $user)
            ->where('id_csc_product_level1', $cat)
            ->orderBy($col, $urut)
            ->paginate($limit);
        }
      }
    }

    return $product;
  }
}

if (!function_exists('getProvinceName')) {
  function getProvinceName($id, $loc)
  {
    $nama = "-";
    $product = DB::table('mst_province')
      ->where('id', $id)
      ->first();

    if ($product != NULL) {
      $nbhs = "province_" . $loc;
      $nama = $product->$nbhs;
    }

    return $nama;
  }
}

if (!function_exists('getProduk')) {
  function getProduk($id)
  {
    $int = (int) $id;
    $product = DB::table('csc_product')
      ->where('id', $int)
      ->first();


    return $product;
  }
}

if (!function_exists('getContactPerson')) {
  function getContactPerson($id, $param)
  {
    $return = '-';
    $cp = DB::table('contact_person')
      ->where('id_type', $id)
      ->where('type', $param)
      ->first();

    if ($cp != NULL) {
      $return = $cp->name . '|' . $cp->phone . '|' . $cp->email;
      if ($param == 'event') {
        $event = DB::table('event_detail')->where('id', $id)->first();
        if ($event->reg_date) {
          $date = explode(' ~ ', $event->reg_date);
          if (date('Y-m-d', strtotime($date[0])) == date('Y-m-d', strtotime($date[1]))) {
            $tanggal = date('d F Y', strtotime($date[0]));
          } else if (date('Y-m', strtotime($date[0])) == date('Y-m', strtotime($date[1]))) {
            $tanggal = date('d F', strtotime($date[0])) . ' - ' . date('d F Y', strtotime($date[1]));
          } else {
            $tanggal = date('d F Y', strtotime($date[0])) . ' - ' . date('d F Y', strtotime($date[1]));
          }
          $return .= '|' . $tanggal;
        } else {
          $return .= '|Not Specified';
        }
      }
    }

    return $return;
  }
}

if (!function_exists('getDataDownload')) {
  function getDataDownload($id)
  {
    $download = DB::table('csc_download_research_corner')
      ->where('id_research_corner', $id)
      ->select('id_itdp_profil_eks')
      ->groupby('id_itdp_profil_eks')
      ->get();

    $return = count($download);

    return $return;
  }
}

if (!function_exists('getServiceAttribute')) {
  function getServiceAttribute($id, $col, $lang)
  {
    $data = DB::table('itdp_service_eks')->where('id', $id)->first();

    if ($lang != "") {
      $dt = $col . '_' . $lang;
      if ($data->$dt != NULL) {
        $isi = $data->$dt;
      } else {
        $dt = $col . '_en';
        $isi = $data->$dt;
      }
    } else {
      $isi = $data->$col;
    }

    return $isi;
  }
}

if (!function_exists('EventPlaceName')) {
  function EventPlaceName($id, $lang)
  {
    $data = DB::table('event_place')->where('id', $id)->first();
    $place = $data->name_en;
    if ($lang == 'in') {
      if ($data->name_in != null) {
        $place = $data->name_in;
      }
    } else if ($lang == 'ch') {
      if ($data->name_chn != null) {
        $place = $data->name_chn;
      }
    }
    return $place;
  }
}

if (!function_exists('EventComodityName')) {
  function EventComodityName($id, $lang)
  {
    $data = DB::table('event_comodity')->where('id', $id)->first();
    $comodity = $data->comodity_en;
    if ($lang == 'in') {
      if ($data->comodity_in != null) {
        $comodity = $data->comodity_in;
      }
    } else if ($lang == 'ch') {
      if ($data->comodity_chn != null) {
        $comodity = $data->comodity_chn;
      }
    }
    return $comodity;
  }
}

if (!function_exists('EventOrganizerName')) {
  function EventOrganizerName($id, $lang)
  {
    $data = DB::table('event_organizer')->where('id', $id)->first();
    $organizer = $data->name_en;
    if ($lang == 'in') {
      if ($data->name_in != null) {
        $organizer = $data->name_in;
      }
    } else if ($lang == 'ch') {
      if ($data->name_chn != null) {
        $organizer = $data->name_chn;
      }
    }
    return $organizer;
  }
}

if (!function_exists('getProductCategoryInquiry')) {
  function getProductCategoryInquiry($id)
  {
    $data = DB::table('csc_inquiry_category')->where('id_inquiry', $id)->get();
    $return = '';
    foreach ($data as $key => $value) {
      $category = DB::table('csc_product')->where('id', $value->id_cat_prod)->first();
      $return .= '- ' . $category->nama_kategori_en;
      if ($key != (count($data) - 1)) {
        $return .= '<br>';
      }
    }
    return $return;
  }
}

if (!function_exists('cat_prod_home')) {
  function cat_prod_home($param)
  {
    $data = DB::table('csc_product_home')->where('number', $param)->whereNull('id_parent')->first();
    return $data->id_product;
  }
}


if (!function_exists('cat_prod_sub_home')) {
  function cat_prod_sub_home($param, $num)
  {
    $sub = [];
    $dat = DB::table('csc_product_home')->where('number', $num)->whereNull('id_parent')->first();
    $data = DB::table('csc_product_home')->where('id_parent', $dat->id)->orderBy('number')->get();
    foreach ($data as $key => $value) {
      array_push($sub, $value->id_product);
    }
    return $sub;
  }
}

if (!function_exists('hotProduct')) {
  function hotProduct()
  {
    $hot = [];
    $data = DB::table('csc_product_single')->where('show', 1)->where('status', 2)->whereNotNull('hot')->orderByRaw('hot desc')->get();
    foreach ($data as $key => $value) {
      array_push($hot, $value->id);
    }
    return $hot;
  }
}


if (!function_exists('userGuide')) {
  function userGuide($lang, $param)
  {
    $language = ['en' => 'User Guide', 'in' => 'Panduan Pengguna', 'ch' => '用户指南'];
    $check = DB::table('user_guide')->where('group_user', $param)->orderBy('created_at', 'desc')->first();

    if ($check) {
      $url = url('/') . '/uploads/User Guide/' . $check->name_version;
      $donlod = 'download';
    } else {
      $url = '#';
      $donlod = '';
    }
    if ($lang == 'backend') {
      if ($param == 1) {
        $return = '<a href="' . route('user-guide.index') . '">';
      } else {
        $return = '<a class="nav-link" href="' . $url . '" ' . $donlod . '>';
      }
    } else {
      $return = '<li><a href="' . $url . '" ' . $donlod . '  class="third-child">' . $language[$lang] . '</a></li>';
    }
    echo $return;
  }
}

if (!function_exists('getDataInterest')) {
  function getDataInterest($id)
  {
    $data = DB::table('event_interest')
      ->where('id_event', $id)
      ->select('id_profile')
      ->groupby('id_profile')
      ->get();

    return count($data);
  }
}

if (!function_exists('getProfileCompany')) {
  function getProfileCompany($id)
  {
    $data = DB::table('itdp_company_users')->where('id_profil', $id)->first();
    $return = 'Company Not Found';
    if ($data) {
      if ($data->id_role == 2) {
        $data = DB::table('itdp_profil_eks')->where('id', $id)->first();
        if ($data) {
          $return = $data->company;
        }
      } else {
        $data = DB::table('itdp_profil_imp')->where('id', $id)->first();
        if ($data) {
          $return = $data->company;
        }
      }
    }

    return $return;
  }
}

if (!function_exists('getProductName')) {
  function getProductName($id)
  {
    $data = DB::table('csc_product_single')->where('id', $id)->first();
    $return = 'Unknown Product';
    if ($data) {
      $return = $data->prodname_en;
    }

    return $return;
  }
}

// Function for Advance Search
if (!function_exists('getAdvListEksportir')) {
  function getAdvListEksportir($nama)
  {
    $nama = trim($nama);
    $data = DB::table('itdp_company_users as a')->selectRaw('DISTINCT a.id, b.company')->join('itdp_profil_eks as b', 'a.id_profil', 'b.id')->join('csc_product_single as c', 'a.id', 'c.id_itdp_company_user')->where('a.status', 1)->where('b.company', 'ILIKE', '%' . $nama . '%')->get();
    $return = '';
    if ($data) {
      foreach ($data as $key => $value) {
        $return .= $value->id . '|';
      }
      $return = rtrim($return, '|');
    } else {
      $return = '0';
    }

    return $return;
  }
}

if (!function_exists('getCollectionManufacture')) {
  function getCollectionManufacture($id, $search, $lct)
  {
    $data = DB::table('itdp_company_users as a')->selectRaw('a.id, b.company')
      ->join('itdp_profil_eks as b', 'a.id_profil', 'b.id')
      ->where('a.id', $id)
      ->first();
    $banyak_data = DB::table('csc_product_single')->selectRaw('count(*)')
      ->where('id_itdp_company_user', $id)
      ->where(function ($query) use ($search, $lct) {
        $query->where('prodname_en', 'ILIKE', '%' . $search . '%');
        $query->orwhere('prodname_' . $lct, 'ILIKE', '%' . $search . '%');
      })
      ->first();
    $collection = [];
    $collection = (object) array("id" => $data->id, "company" => $data->company, "jml_produk" => $banyak_data->count);

    return $collection;
  }
}


if (!function_exists('getCategorySearch')) {
  function getCategorySearch($nama, $lct)
  {
    $nama = trim($nama);
    $return = '';
    $data = DB::table('csc_product')->whereRaw('UPPER(nama_kategori_' . $lct . ') = UPPER(\'' . $nama . '\')')->first();
    if (!$data) {
      $data = DB::table('csc_product')->whereRaw('UPPER(nama_kategori_en) = UPPER(\'' . $nama . '\')')->first();
    }
    if ($data) {
      $return = $data->id;
      if ($data->level_2 != '0' || $data->level_2 != null) {
        $return = $data->level_2 . '|' . $data->level_1 . '|' . $return;
      }
      if ($data->level_1 != '0' && $data->level_2 == '0' || $data->level_1 != null && $data->level_2 == '0') {
        $return = $data->level_1 . '|' . $return;
      }
    }

    return $return;
  }
}

if (!function_exists('getExBadan')) {
  function getExBadan($id)
  {
    $badanusaha = "";
    $data = DB::table('itdp_company_users')->where('id', $id)->first();
    if ($data) {
      if ($data->id_profil != NULL) {
        $badanusaha = DB::table('itdp_profil_eks')->where('id', $data->id_profil)->first();
        if ($badanusaha) {
          if ($badanusaha->badanusaha == "-") {
            $badanusaha = "";
          } else {
            $badanusaha = $badanusaha->badanusaha . " ";
          }
        }
      }
    }

    return $badanusaha;
  }
}

if (!function_exists('getExBadanImportir')) {
  function getExBadanImportir($id)
  {
    $badanusaha = "";
    $data = DB::table('itdp_company_users')->where('id', $id)->first();
    if ($data) {
      if ($data->id_profil != NULL) {
        $badanusaha = DB::table('itdp_profil_imp')->where('id', $data->id_profil)->first();
        if ($badanusaha) {
          if ($badanusaha->badanusaha == "-") {
            $badanusaha = "";
          } else {
            $badanusaha = $badanusaha->badanusaha . " ";
          }
        }
      }
    }

    return $badanusaha;
  }
}

if (!function_exists('getImpCountry')) {
  function getImpCountry($id)
  {
    $country = "";
    $data = DB::table('itdp_company_users')
      ->leftjoin('itdp_profil_imp', 'itdp_company_users.id_profil', '=', 'itdp_profil_imp.id')
      ->leftjoin('mst_country', 'mst_country.id', '=', 'itdp_profil_imp.id_mst_country')
      ->select('itdp_profil_imp.*', 'mst_country.country')
      ->where('itdp_company_users.id', $id)->first();
    if ($data) {
      $country = $data->country;
    }

    return $country;
  }
}

if (!function_exists('getAdminMail')) {
  function getAdminMail($id)
  {
    $mail = "-";
    $data = DB::table('itdp_admin_users')->where('id', $id)->first();
    if ($data) {
      if ($data->name != NULL) {
        $mail = $data->email;
      }
    }

    return $mail;
  }
}

if (!function_exists('getUserMail')) {
  function getUserMail($id)
  {
    $email = "";
    $data = DB::table('itdp_company_users')->where('id', $id)->first();
    if ($data) {
      $email = $data->email;
    }
    return $email;
  }
}


if (!function_exists('getPerwakilanCountry3')) {
  function getPerwakilanCountry3($id)
  {
    $nama = "-";
    $data = DB::table('itdp_admin_users')->where('id', $id)->first();
    if ($data) {
      if ($data->id_admin_dn || $data->id_admin_ln) {
        if ($data->id_admin_dn == 0) {
          $ln = DB::table('itdp_admin_ln')->where('id', $data->id_admin_ln)->first();
          $country = DB::table('mst_country')->where('id', $ln->country)->first();
          if ($country) {
            $nama = $country->country;
            /*
                $nama = $country->country;
                $group = DB::table('mst_group_country')->where('id', $country->mst_country_group_id)->first();
                if($group)
                  $nama = $group->group_country;
				*/
          }
        } else if ($data->id_admin_ln == 0) {
          $dn = DB::table('itdp_admin_dn')->where('id', $data->id_admin_dn)->first();
          $country = DB::table('mst_country')->where('id', $dn->id_country)->first();
          if ($country) {
            $nama = $country->country;
          }
        }
      }
    }

    return $nama;
  }
}

// End of Function Search

if (!function_exists('getOptionProvince')) {
  function getOptionProvince()
  {
    $return = "";
    $data = DB::table('mst_province')->orderBy('province_en', 'asc')->get();
    foreach ($data as $key => $value) {
      $return .= '<option value="' . $value->id . '">' . $value->province_en . '</option>';
    }
    echo $return;
  }
}


if (!function_exists('getOptionProvinceNewsletter')) {
  function getOptionProvinceNewsletter($id)
  {
    $array = [];
    $province = DB::table('newsletter_province')->where('id_newsletter', $id)->get();
    foreach ($province as $key => $value) {
      array_push($array, $value->id_province);
    }

    $data = DB::table('mst_province')->orderBy('province_en', 'asc')->get();
    $return = "";
    foreach ($data as $key => $value) {
      $select = '';
      if (in_array($value->id, $array)) {
        $select = 'selected';
      }
      $return .= '<option value="' . $value->id . '" ' . $select . '>' . $value->province_en . '</option>';
    }
    echo $return;
  }
}


if (!function_exists('optionCategoryNewsletter')) {
  function optionCategoryNewsletter($id)
  {
    $array = [];
    $category = DB::table('newsletter_category')->where('id_newsletter', $id)->get();
    foreach ($category as $key => $value) {
      array_push($array, $value->id_category);
    }

    $categori = DB::table('csc_product_single as a')->join('itdp_profil_eks as b', 'a.id_itdp_profil_eks', '=', 'b.id')->select('id_csc_product')->distinct('id_csc_product')->get();
    $level1 = DB::table('csc_product_single as a')->join('itdp_profil_eks as b', 'a.id_itdp_profil_eks', '=', 'b.id')->select('id_csc_product_level1')->where('id_csc_product_level1', '!=', null)->distinct('id_csc_product_level1')->get();
    $level2 = DB::table('csc_product_single as a')->join('itdp_profil_eks as b', 'a.id_itdp_profil_eks', '=', 'b.id')->select('id_csc_product_level2')->where('id_csc_product_level2', '!=', null)->distinct('id_csc_product_level2')->get();

    $option = '';
    foreach ($categori as $data) {
      $category = DB::table('csc_product')->where('id', $data->id_csc_product)->first();
      if ($category) {
        if (in_array($category->id, $array)) {
          $select = 'selected';
        } else {
          $select = '';
        }
        $option .= '<option value="' . $category->id . '" ' . $select . '>' . $category->nama_kategori_en . '</option>';
      }
    }
    foreach ($level1 as $data) {
      $category = DB::table('csc_product')->where('id', $data->id_csc_product_level1)->first();
      if ($category) {
        if (in_array($category->id, $array)) {
          $select = 'selected';
        } else {
          $select = '';
        }
        $option .= '<option value="' . $category->id . '" ' . $select . '>' . $category->nama_kategori_en . '</option>';
      }
    }
    foreach ($level2 as $data) {
      $category = DB::table('csc_product')->where('id', $data->id_csc_product_level2)->first();
      if ($category) {
        if (in_array($category->id, $array)) {
          $select = 'selected';
        } else {
          $select = '';
        }
        $option .= '<option value="' . $category->id . '" ' . $select . '>' . $category->nama_kategori_en . '</option>';
      }
    }

    echo $option;
  }
}


if (!function_exists('SOB')) {
  function SOB($id)
  {
    $datanya = "-";
    $data = DB::table('eks_business_size')->where('id', $id)->get();
    if (count($data) > 0) {
      $datanya = $data[0]->nmsize_ind;
      return $datanya;
    } else {
      return $datanya;
    }
  }
}
if (!function_exists('SOB_EN')) {
  function SOB_EN($id)
  {
    $datanya = "-";
    $data = DB::table('eks_business_size')->where('id', $id)->get();
    if (count($data) > 0) {
      $datanya = $data[0]->nmsize;
      return $datanya;
    } else {
      return $datanya;
    }
  }
}
if (!function_exists('TOB')) {
  function TOB($id)
  {
    $datanya = "-";
    $data = DB::table('eks_business_role')->where('id', $id)->get();
    if (count($data) > 0) {
      $datanya = $data[0]->nmtype_ind;
      return $datanya;
    } else {
      return $datanya;
    }
  }
}
if (!function_exists('TOB_EN')) {
  function TOB_EN($id)
  {
    $datanya = "-";
    $data = DB::table('eks_business_role')->where('id', $id)->get();
    if (count($data) > 0) {
      $datanya = $data[0]->nmtype;
      return $datanya;
    } else {
      return $datanya;
    }
  }
}
if (!function_exists('checkticketingcreator')) {
  function checkticketingcreator($id)
  {
    $cari1 = DB::select("select * from ticketing_support where id='" . $id . "'");
    foreach ($cari1 as $v1) {
      $id_company = $v1->id_pembuat;
    }
    $cari2 = DB::select("select * from itdp_company_users where id='" . $id_company . "'");
    if (count($cari2) != 0) {

      return true;
    } else {
      return false;
    }
  }
}

if (!function_exists('checkingAccountHelpdesk')) {
  function checkingAccountHelpdesk($id)
  {

    $url = config("constants.HELPDESK_API_URL") . 'operator/session/' . $id;
    $ch = curl_init();
    $username = config("constants.HELPDESK_API_USERNAME");
    $password = config("constants.HELPDESK_API_PASSWORD");
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

    $hasil = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    if ($hasil != null) {
      $JSONdata = json_decode($hasil, true);
      return $JSONdata;
    } else
      return array();
  }
}

if (!function_exists('logoutHelpdesk')) {
  function logoutHelpdesk($id)
  {

    $url = config("constants.HELPDESK_API_URL") . 'operator/logout/' . $id;
    $ch = curl_init();
    $username = config("constants.HELPDESK_API_USERNAME");
    $password = config("constants.HELPDESK_API_PASSWORD");
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

    $hasil = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    if ($hasil != null) {
      $JSONdata = json_decode($hasil, true);
      return $JSONdata;
    } else
      return array();
  }
}

if (!function_exists('translateToEn')) {
  function translateToEn($string)
  {
    try {
      $tr = new GoogleTranslate('en');
      $desc_en = $tr->translate($string);
      return $desc_en;
    } catch (\Throwable $th) {
      return $string;
    }
  }
}

if (!function_exists('translateToIn')) {
  function translateToIn($string)
  {
    try {
      $tr = new GoogleTranslate('id');
      $desc_en = $tr->translate($string);
      return $desc_en;
    } catch (\Throwable $th) {
      return $string;
    }
  }
}

if (!function_exists('translateToChn')) {
  function translateToChn($string)
  {
    try {
      $tr = new GoogleTranslate('zh');
      $desc_en = $tr->translate($string);
      return $desc_en;
    } catch (\Throwable $th) {
      return $string;
    }
  }
}

if (!function_exists('getKategoriDetail')) {
  function getKategoriDetail($id)
  {
    try {
      $categoryutama = DB::table('csc_product')
        ->join('csc_product_single', 'csc_product.id', 'csc_product_single.id_csc_product')
        ->select(
          'csc_product.nama_kategori_en',
          'csc_product.nama_kategori_in',
          'csc_product.nama_kategori_chn'
        )
        ->groupby(
          'csc_product.nama_kategori_en',
          'csc_product.nama_kategori_in',
          'csc_product.nama_kategori_chn'
        )
        ->where('id_itdp_company_user', $id)
        ->where('csc_product_single.status', 2)
        ->orderBy('nama_kategori_en', 'ASC')
        ->get();
      return $categoryutama;
    } catch (\Throwable $th) {

      return array();
    }
  }
}


if (!function_exists('getKategoriLevel2')) {
  function getKategoriLevel2($id, $except, $select = null)
  {
    try {
      $checking = DB::table('csc_product')
        ->where('level_1', $id)
        ->where('level_2', 0)
        ->whereNotIn('id', [$except])
        ->orderby('nama_kategori_en', 'asc')->get();

      $data = '';
      if ($checking) {
        foreach ($checking as $val) {
          $s = '';
          if ($select == $val->id) {
            $s = 'selected';
          }
          $data .= '<option value="' . $val->id . '" ' . $s . '>' . $val->nama_kategori_en . '</option>';
        }
      }
      echo $data;
    } catch (\Throwable $th) {

      return array();
    }
  }
}

if (!function_exists('getDetailProduct')) {
  function getDetailProduct($id_product)
  {
    $detail = DB::table('csc_product_home as a')
      ->join('csc_product as b', 'a.id_product', '=', 'b.id')
      ->select('b.*', 'a.id_product_parent')
      ->orderBy('a.number', 'ASC')
      ->where('id_product_parent', $id_product)
      ->get();

    return $detail;
  }
}

if (!function_exists('getBadanUsahaEksportir')) {
  function getBadanUsahaEksportir($id)
  {
    $badanusaha = "";
    $data = DB::table('itdp_company_users')->where('id', $id)->first();
    if ($data) {
      if ($data->id_profil != NULL) {
        $badanusaha = DB::table('itdp_profil_eks')
          ->select('itdp_profil_eks.*', 'eks_business_entity.nmbadanusaha')
          ->leftjoin('eks_business_entity', 'eks_business_entity.id', '=', 'itdp_profil_eks.id_itdp_eks_business_entity')
          ->where('itdp_profil_eks.id', $data->id_profil)->first();
        if ($badanusaha) {
          if ($badanusaha->nmbadanusaha == "-") {
            $badanusaha = "";
          } else {
            $badanusaha = $badanusaha->badanusaha;
          }
        }
      }
    }
    return $badanusaha;
  }
}

if (!function_exists('getProductExpByCat')) {
  function getProductExpByCat($user, $limit, $order, $lct, $cat)
  {
    if ($order == NULL) {
      if ($limit == NULL) {
        $product = DB::table('csc_product_single')
          ->where('status', 2)
          ->where('show', 1)
          ->where('id_itdp_company_user', $user)
          ->where('id_csc_product', $cat)
          ->inRandomOrder()
          ->get();
      } else {
        $product = DB::table('csc_product_single')
          ->where('status', 2)
          ->where('show', 1)
          ->where('id_itdp_company_user', $user)
          ->where('id_csc_product', $cat)
          ->inRandomOrder()
          ->paginate($limit);
      }
    } else {
      if ($order == "") {
        if ($limit == NULL) {
          $product = DB::table('csc_product_single')
            ->where('status', 2)
            ->where('show', 1)
            ->where('id_itdp_company_user', $user)
            ->where('id_csc_product', $cat)
            ->inRandomOrder()
            ->get();
        } else {
          $product = DB::table('csc_product_single')
            ->where('status', 2)
            ->where('show', 1)
            ->where('id_itdp_company_user', $user)
            ->where('id_csc_product', $cat)
            ->inRandomOrder()
            ->paginate($limit);
        }
      } else {
        if ($order == "new") {
          $col = "created_at";
          $urut = "DESC";
        } else if ($order == "asc") {
          $col = "prodname_" . $lct;
          $urut = "ASC";
        }
        if ($limit == NULL) {
          $product = DB::table('csc_product_single')
            ->where('status', 2)
            ->where('show', 1)
            ->where('id_itdp_company_user', $user)
            ->where('id_csc_product', $cat)
            ->orderBy($col, $urut)
            ->get();
        } else {
          $product = DB::table('csc_product_single')
            ->where('status', 2)
            ->where('show', 1)
            ->where('id_itdp_company_user', $user)
            ->where('id_csc_product', $cat)
            ->orderBy($col, $urut)
            ->paginate($limit);
        }
      }
    }

    return $product;
  }
}

if (!function_exists('getMenu')) {
  function getMenu()
  {

    if (empty(Auth::user()->id_group) && empty(Auth::guard('eksmp')->user()->id_role)) {
      // return redirect()->route('front_end_goh');
    } else {
      if (empty(Auth::user()->id_group)) {
        $id_group = Auth::guard('eksmp')->user()->id_role;
      } else {
        $id_group = Auth::user()->id_group;
      }
      $menu = DB::select("select a.*,b.* from permissions a, menu b where a.id_group = '" . $id_group . "' and a.id_menu = b.id_menu order by b.order asc");
      return $menu;
    }
  }
}
