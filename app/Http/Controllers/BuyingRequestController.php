<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Mail;
use Carbon\Carbon;
use App\buying_and_inqueri;
use App\BuyingRequest;
use Pusher\Pusher;

class BuyingRequestController extends Controller
{
    public function index()
    {
        if (!empty(Auth::guard('eksmp')->user()->id) || !empty(Auth::user()->id)) {
            if (!empty(Auth::guard('eksmp')->user()->id)) {
                if (Auth::guard('eksmp')->user()->id_role == 2) {
                    $pageTitle = "Buying Request Indonesian Exporter";
                    $data = DB::select("select a.*,a.id as ida,a.status as statusa,b.*,b.id as idb from csc_buying_request
                                        a, csc_buying_request_join
                                         b where a.id = b.id_br and b.id_eks='" . Auth::guard('eksmp')->user()->id . "' order by b.id desc ");
                    return view('buying-request.index_eks', compact('pageTitle', 'data'));
                }
            } else {
                if (Auth::user()->id_group == 4) {
                    $pageTitle = "Buying Request Representative";
                    $data = DB::select("select a.*,a.id as ida,a.status as status_a,b.*,b.id as idb from itdp_company_users a, itdp_profil_eks b where a.id_profil = b.id and id_role='2' order by a.id desc ");
                    return view('buying-request.index', compact('pageTitle', 'data'));
                } else {
                    $pageTitle = "Buying Request Admin";
                    // $data = DB::select("select a.*,a.id as ida,a.status as status_a,b.* from itdp_company_users a, itdp_profil_eks b where a.id_profil = b.id and id_role='2' order by a.id desc ");
                    return view('buying-request.indexadmin', compact('pageTitle'));
                }
            }
        } else {
            return redirect('login');
        }
    }

    public function message()
    {
        return redirect('\br_list')->with('success', 'Success Broadcast Data');
    }

    public function show_all_notif()
    {
        if (!empty(Auth::guard('eksmp')->user()->id)) {
            $pageTitle = "All Notif For Representative";
            return view('notif.indexeksmp', compact('pageTitle'));
        } else {
            if (Auth::user()->id_group == 4) {
                $pageTitle = "All Notif For Representative";
                return view('notif.indexperwakilan', compact('pageTitle'));
            } else {
                $pageTitle = "All Notif For Admin";
                return view('notif.indexadmin', compact('pageTitle'));
            }
        }
    }

    public function unread_all_notif()
    {
        if (!empty(Auth::guard('eksmp')->user()->id)) {
            $update = DB::select("update notif set status_baca='1' where untuk_id='" . Auth::guard('eksmp')->user()->id . "' and to_role='" . Auth::guard('eksmp')->user()->id_role . "'");
            $pageTitle = "All Notif For Representative";
            return view('notif.indexeksmp', compact('pageTitle'));
        } else {
            if (Auth::user()->id_group == 4) {
                $update = DB::select("update notif set status_baca='1' where untuk_id='" . Auth::user()->id . "' and to_role='" . Auth::user()->id_group . "'");
                $pageTitle = "All Notif For Representative";
                return view('notif.indexperwakilan', compact('pageTitle'));
            } else {
                $update = DB::select("update notif set status_baca='1' where to_role='" . Auth::user()->id_group . "'");
                $pageTitle = "All Notif For Admin";
                return view('notif.indexadmin', compact('pageTitle'));
            }
        }
    }

    public function getcscperwakilan()
    {
        $pesan = DB::select("select ROW_NUMBER() OVER (ORDER BY id DESC) AS Row, * from csc_buying_request where id_pembuat='" . Auth::user()->id . "' and  by_role='4' and deleted_at ISNULL order by date desc ");
        return DataTables::of($pesan)
            ->addColumn('f1', function ($pesan) {
                return '<div align="left">' . $pesan->subyek . '</div>';
            })
            ->addColumn('f2', function ($pesan) {
                if ($pesan->valid == 0) {
                    return "Selesai";
                } else {
                    return "Valid until " . $pesan->valid . " days";
                }
            })
            ->addColumn('f6', function ($pesan) {
                if ($pesan->by_role == 4) {
                    return "Perwakilan";
                } else if ($pesan->by_role == 3) {
                    $usre = DB::select("select b.company from itdp_company_users a, itdp_profil_imp b where a.id_profil = b.id and a.id='" . $pesan->id_pembuat . "'");
                    foreach ($usre as $imp) {
                        $impz = $imp->company;
                    }
                    return "Importir - " . $impz;
                }
            })
            ->addColumn('f3', function ($pesan) {
                return $pesan->date;
            })
            // ->addColumn('f4', function ($pesan) {
            //     $cr = explode(',', $pesan->id_csc_prod);
            //     $hitung = count($cr);
            //     $semuacat = "";
            //     for ($a = 0; $a < ($hitung - 1); $a++) {
            //         $namaprod = DB::select("select * from csc_product where id='" . $cr[$a] . "' ");
            //         foreach ($namaprod as $prod) {
            //             $napro = $prod->nama_kategori_en;
            //         }
            //         $semuacat = $semuacat . "- " . $napro . "<br>";
            //     }
            //     return $semuacat;
            // })
            ->addColumn('f7', function ($pesan) {
                $buying_requests = DB::select("select a.*,b.*,c.*,a.email as oemail,b.id as idb,a.id as id_user from itdp_company_users a, csc_buying_request_join b, itdp_profil_eks c where a.id=b.id_eks and a.id_profil = c.id and id_br='" . $pesan->id . "'order by date DESC");
                $return_value = '';
                $lb = '';
                if (count($buying_requests) > 0) {
                    $lb .= '<br>';
                    foreach ($buying_requests as $br) {
                        $status_join = '';
                        if ($br->status_join == null) {
                            $status_join = 'pending';
                        } elseif ($br->status_join == '1') {
                            $status_join = 'Waiting for your repply';
                        } elseif ($br->status_join == '2') {
                            $status_join = 'Negosiation';
                        } elseif ($br->status_join == '4') {
                            $status_join = 'Deal';
                        } else {
                            $status_join = '-';
                        }
                        $return_value .= "<a class='link-company' href=" . url('front_end/list_perusahaan/view', $br->id_user . "-" . $br->company) . " target='_blank'>" . $br->company . ' (' . $status_join . ')</a>' . $lb;
                    }
                } else {
                    $return_value .= "Haven't found a supplier yet";
                }

                return $return_value;
            })
            ->addColumn('action', function ($pesan) {
                //				if($pesan->status == 1){
                //					return '<a href="'.url('br_pw_lc/'.$pesan->id).'" class="btn btn-sm btn-primary"><i class="fa fa-comment"></i> List Chat</a>';
                //				}else if($pesan->status == 4){
                //					return '<a href="'.url('br_pw_lc/'.$pesan->id).'" class="btn btn-sm btn-success"><i class="fa fa-list"></i> List Chat</a>';
                //				}else{
                //					return '<a title="Broadcast" style="background-color: #d5b824ed!Important;border:#d5b824ed!important;" onclick="xy('.$pesan->id.')" data-toggle="modal" data-target="#myModal" class="btn btn-warning"><font color="white"><i class="fa fa-wifi"></i> Broadcast</i></a>
                //					<a href="'.url('br_pw_dt/'.$pesan->id).'" class="btn btn-sm btn-info"><i class="fa fa-pencil"></i> Detail</a>';
                //				}

                if ($pesan->status == 1) {
                    return '<a href="' . url('br_pw_lc/' . encrypt($pesan->id)) . '" class="btn btn-sm btn-primary" data-toggle="tooltip" title="List Chat"><i class="fa fa-comment"></i></a>';
                } else if ($pesan->status == 4) {
                    return '<a href="' . url('br_pw_lc/' . encrypt($pesan->id)) . '" class="btn btn-sm btn-success" data-toggle="tooltip" title="List Chat"><i class="fa fa-list"></i></a>';
                } else {
                    // return '<a title="Broadcast" style="background-color: #d5b824ed!Important;border:#d5b824ed!important;display:none;" onclick="xy(' . $pesan->id . ')" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-warning"><font color="white"><i class="fa fa-bullhorn"></i></i></a>
                    // <a href="' . url('br_pw_dt/' . encrypt($pesan->id)) . '" class="btn btn-sm btn-info" data-toggle="tooltip" title="Detail"><i class="fa fa-eye"></i></a>
                    // <a onclick="return confirm(\'Are You Sure ?\')"  href="' . url('/') . '/buyingrequest/delete/' . $pesan->id . '" class="btn btn-sm btn-danger" title="Delete">&nbsp;<i class="fa fa-trash"></i></a>';
                    return '
                    <a href="' . url('br_pw_dt/' . encrypt($pesan->id)) . '" class="btn btn-sm btn-info" data-toggle="tooltip" title="Detail"><i class="fa fa-eye"></i></a>
                    <a onclick="return confirm(\'Are You Sure ?\')"  href="' . url('/') . '/buyingrequest/delete/' . $pesan->id . '" class="btn btn-sm btn-danger" title="Delete">&nbsp;<i class="fa fa-trash"></i></a>';
                }
                // href="'.url('/').'/buyingrequest/delete/'.$pesan->id.'}}'."


            })
            ->rawColumns(['action', 'f6', 'f7', 'f3', 'f4', 'f1'])
            ->make(true);
    }

    public function getcsc()
    {
        $pesan = DB::select("select ROW_NUMBER() OVER (ORDER BY id DESC) AS Row, * from csc_buying_request where by_role='4' and deleted_at ISNULL order by id desc ");
        return DataTables::of($pesan)
            ->addColumn('f1', function ($pesan) {
                return '<div align="left">' . $pesan->subyek . '</div>';
            })
            ->addColumn('f2', function ($pesan) {
                if ($pesan->valid == 0) {
                    return "Selesai";
                } else {
                    return "Valid until " . $pesan->valid . " days";
                }
            })
            ->addColumn('f6', function ($pesan) {
                if ($pesan->by_role == 4) {
                    return "Perwakilan";
                } else if ($pesan->by_role == 3) {
                    $usre = DB::select("select b.company from itdp_company_users a, itdp_profil_imp b where a.id_profil = b.id and a.id='" . $pesan->id_pembuat . "'");
                    foreach ($usre as $imp) {
                        $impz = $imp->company;
                    }
                    return "Importir - " . $impz;
                }
            })
            ->addColumn('f3', function ($pesan) {
                return $pesan->date;
            })
            ->addColumn('f4', function ($pesan) {
                $cr = explode(',', $pesan->id_csc_prod);
                $hitung = count($cr);
                $semuacat = "";
                for ($a = 0; $a < ($hitung - 1); $a++) {
                    if ($cr[$a] != '') {
                        $namaprod = DB::select("select * from csc_product where id='" . $cr[$a] . "' ");
                        if (count($namaprod) != 0) {
                            foreach ($namaprod as $prod) {
                                $napro = $prod->nama_kategori_en;
                            }
                            $semuacat = $semuacat . "- " . $napro . "<br>";
                        }
                    }
                }
                return $semuacat;
            })
            ->addColumn('f7', function ($pesan) {
                if ($pesan->status == 1) {
                    return "Negosiation";
                } else if ($pesan->status == 4) {
                    return "Deal";
                } else {
                    return "-";
                }
            })
            ->addColumn('action', function ($pesan) {
                //				if($pesan->status == 1){
                //					return '<a href="'.url('br_pw_lc/'.$pesan->id).'" class="btn btn-sm btn-primary"><i class="fa fa-comment"></i> List Chat</a>';
                //				}else if($pesan->status == 4){
                //					return '<a href="'.url('br_pw_lc/'.$pesan->id).'" class="btn btn-sm btn-success"><i class="fa fa-list"></i> List Chat</a>';
                //				}else{
                //					return '<a title="Broadcast" style="background-color: #d5b824ed!Important;border:#d5b824ed!important;" onclick="xy('.$pesan->id.')" data-toggle="modal" data-target="#myModal" class="btn btn-warning"><font color="white"><i class="fa fa-wifi"></i> Broadcast</i></a>
                //					<a href="'.url('br_pw_dt/'.$pesan->id).'" class="btn btn-sm btn-info"><i class="fa fa-pencil"></i> Detail</a>';
                //				}

                if ($pesan->status == 1) {
                    return '<a href="' . url('br_pw_lc/' . encrypt($pesan->id)) . '" class="btn btn-sm btn-primary" data-toggle="tooltip" title="List Chat"><i class="fa fa-comment"></i></a>';
                } else if ($pesan->status == 4) {
                    return '<a href="' . url('br_pw_lc/' . encrypt($pesan->id)) . '" class="btn btn-sm btn-success" data-toggle="tooltip" title="List Chat"><i class="fa fa-list"></i></a>';
                } else {
                    // return '<a title="Broadcast" style="background-color: #d5b824ed!Important;border:#d5b824ed!important;" onclick="xy(' . $pesan->id . ')" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-warning"><font color="white"><i class="fa fa-bullhorn"></i></i></a>
                    // <a href="' . url('br_pw_dt/' . encrypt($pesan->id)) . '" class="btn btn-sm btn-info" data-toggle="tooltip" title="Detail"><i class="fa fa-eye"></i></a>
                    // <a href="' . url('br_dele/' . $pesan->id) . '" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></a>';
                    return '
					<a href="' . url('br_pw_dt/' . encrypt($pesan->id)) . '" class="btn btn-sm btn-info" data-toggle="tooltip" title="Detail"><i class="fa fa-eye"></i></a>
					<a href="' . url('br_dele/' . $pesan->id) . '" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></a>';
                }
                // href="'.url('/').'/buyingrequest/delete/'.$pesan->id.'}}'."
            })
            ->rawColumns(['action', 'f6', 'f7', 'f3', 'f4', 'f1'])
            ->make(true);
    }

    public function getcsc0()
    {
        // $pesan = DB::select("select ROW_NUMBER() OVER (ORDER BY id DESC) AS Row, * from csc_buying_request where by_role='1' and deleted_at ISNULL order by id desc ");
        $pesan = DB::select("select * from v_csc_all_inquiry_br order by date desc");

        return DataTables::of($pesan)
            ->addIndexColumn()

            ->addColumn('f1', function ($pesan) {
                return '<div align="left">' . $pesan->subyek . '</div>';
            })
            // ->addColumn('f2', function ($pesan) {
            //     if ($pesan->valid == 0) {
            //         return "No Limit";
            //     } else {
            //         return "Valid until " . $pesan->valid . " days";
            //     }
            // })

            ->addColumn('f2', function ($pesan) {
                date_default_timezone_set('Asia/Jakarta');
                $now = Carbon::now()->startOfDay();
                $compare = Carbon::parse($pesan->date)->startOfDay()->addDays($pesan->valid);
                if ($compare->gt($now)) {
                    $valid_days = (int) $compare->diffInDays($now);
                } else {
                    $valid_days = '-' . $compare->diffInDays($now);
                }

                if ($pesan->valid == 0) {
                    return "Selesai";
                } else if ($valid_days == 1) {
                    return $valid_days . " day remaining";
                } else if ($valid_days > 1) {
                    return $valid_days . " days remaining";
                } else if ($valid_days < 1) {
                    return "expired";
                }
            })

            // ->addColumn('f3', function ($pesan) {
            //     return $pesan->date;
            // })
            ->addColumn('f6', function ($pesan) {
                // dd($pesan->by_role);
                if ($pesan->by_role == 3) {
                    $namacompany = DB::select("SELECT
						c.company
					FROM
                        csc_buying_request A 
					JOIN 
                        itdp_company_users b ON A.id_pembuat = b.id
					JOIN
                        itdp_profil_imp C ON b.id_profil = c.id
					WHERE A.id_pembuat = '$pesan->id_pembuat' ");
                    // dd($namacompany);
                    foreach ($namacompany as $comp) {
                        return $comp->company;
                    }
                } else if ($pesan->by_role == 4) {
                    $namacompany = DB::select("SELECT
						b.name
					FROM
                        csc_buying_request A  
					JOIN 
                        itdp_admin_users b ON A.id_pembuat = b.id
					WHERE A.id_pembuat = '$pesan->id_pembuat' ");

                    foreach ($namacompany as $comp) {
                        return $comp->name;
                    }
                } else {
                    $namacompany = DB::select("SELECT
                    	A.name
                    FROM
                        itdp_admin_users A  
                    WHERE A.id = '$pesan->id_pembuat' ");

                    foreach ($namacompany as $comp) {
                        return $comp->name;
                    }
                }
            })

            // ->addColumn('f4', function ($pesan) {
            //     $cr = explode(',', $pesan->id_csc_prod);
            //     $hitung = count($cr);
            //     $semuacat = "";
            //     for ($a = 0; $a < ($hitung - 1); $a++) {
            //         if ($cr[$a] != '') {
            //             if ($cr[$a] == "null"){
            //                 $semuacat = "";
            //             }
            //             else {
            //                 $namaprod = DB::select("select * from csc_product where id='" . $cr[$a] . "' ");
            //                 if (count($namaprod) != 0) {
            //                     foreach ($namaprod as $prod) {
            //                         $napro = $prod->nama_kategori_en;
            //                     }
            //                     $semuacat = $semuacat . "- " . $napro . "<br>";
            //                 }
            //             }
            //         }

            //     }
            //     return $semuacat;
            // })

            ->addColumn('f3', function ($pesan) {
                $namacompany = DB::select(
                    "SELECT b.country
                    FROM csc_buying_request A
                    JOIN mst_country b ON A.id_mst_country = b.id
                    WHERE A.id_pembuat = '$pesan->id_pembuat'"

                );
                // $namacompany = DB::select("SELECT
                // 		A.email,
                // 		A.id_role,
                // 		A.agree,
                // 		A.ID AS ida,
                // 		A.status AS status_a,
                // 		A.verified_at AS verified_at,
                // 		C.country 
                // 	FROM
                // 		itdp_company_users A 
                // 	JOIN 
                // 		csc_buying_request b ON B.id_pembuat = A.id
                // 	LEFT JOIN
                // 		mst_country C ON b.id_mst_country = c.id
                // 	WHERE
                // 	a.id = '$pesan->id_pembuat' 
                // 	");
                // dd($namacompany);
                foreach ($namacompany as $comp) {
                    return $comp->country;
                }
            })

            // ->addColumn('f6', function ($pesan) {
            //     if ($pesan->tipe == "br") {
            //         if ($pesan->created_by_br == 4) {
            //             return "Perwakilan";
            //         } else if ($pesan->created_by_br == 3) {
            //             return "Importir";
            //         } else if ($pesan->created_by_br == 1) {
            //             return "Admin";
            //         }
            //     } else {
            //         if ($pesan->created_by_inquiry == "perwakilan") {
            //             return "Perwakilan";
            //         } else if ($pesan->created_by_inquiry == "importir") {
            //             return "Importir";
            //         } else if ($pesan->created_by_inquiry == "admin") {
            //             return "Admin";
            //         }
            //     }

            // })
            ->addColumn('f7', function ($pesan) {
                if ($pesan->status == 1) {
                    return "Negosiation";
                } else if ($pesan->status == 4) {
                    return "Deal";
                } else {
                    return "-";
                }
            })
            ->addColumn('action', function ($pesan) {
                if ($pesan->tipe == "br") {
                    $id = $pesan->id_csc_buying_request;
                    if ($pesan->status == 1) {
                        return '<center>
                                <a href="javascript:void(0)" class="btn btn-sm btn-default btn-send-mail" onclick="sendMailToSupplier(\'' . encrypt($id) . '\', \'' . $pesan->tipe . '\')" data-toggle="tooltip" title="Email to Supplier"><i class="fa fa-envelope"></i></a>
                                <a href="' . url('br_pw_lc/' . encrypt($id)) . '" class="btn btn-sm btn-primary" data-toggle="tooltip" title="List Chat"><i class="fa fa-comment"></i></a>
                            </center>';
                    } else if ($pesan->status == 4) {
                        return '<center>
                                <a href="javascript:void(0)" class="btn btn-sm btn-default btn-send-mail" onclick="sendMailToSupplier(\'' . encrypt($id) . '\', \'' . $pesan->tipe . '\')" data-toggle="tooltip" title="Email to Supplier"><i class="fa fa-envelope"></i></a>
                                <a href="' . url('br_pw_lc/' . encrypt($id)) . '" class="btn btn-sm btn-success" data-toggle="tooltip" title="List Chat"><i class="fa fa-list"></i></a>
                            </center>';
                    } else {
                        // return '
                        // <center><a title="Broadcast" style="width:29px; height:27px; background-color: #d5b824ed!Important;border:#d5b824ed!important;" onclick="xy(' . $id . ')" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-default btn-send-mail" onclick="sendMailToSupplier("'.encrypt($id).'");"><font color="white"><i class="fa fa-bullhorn"></i></a>
                        // <a href="' . url('br_pw_dt/' . encrypt($id)) . '" class="btn btn-sm btn-info" data-toggle="tooltip" title="Detail"><i class="fa fa-eye"></i></a>
                        // <a href="' . url('br_dele/' . $id) . '" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></a></center>';
                        return '<center>
                                <a href="javascript:void(0)" class="btn btn-sm btn-default btn-send-mail" onclick="sendMailToSupplier(\'' . encrypt($id) . '\', \'' . $pesan->tipe . '\')" data-toggle="tooltip" title="Email to Supplier"><i class="fa fa-envelope"></i></a>
                                <a href="' . url('br_pw_dt/' . encrypt($id)) . '" class="btn btn-sm btn-info" data-toggle="tooltip" title="Detail"><i class="fa fa-eye"></i></a>
                                <a href="javascript:void(0)" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Hapus" onclick="deleteBR(\'' . $id . '\',\'' . 'br_dele' . '\')"><i class="fa fa-trash"></i></a>
                            </center>';
                    }
                } else {
                    $id = $pesan->id_csc_inquiry_br;
                    if ($pesan->status == 1) {
                        return '<center>
                            <a href="javascript:void(0)" class="btn btn-sm btn-default btn-send-mail" onclick="sendMailToSupplier(\'' . encrypt($id) . '\', \'' . $pesan->tipe . '\')" data-toggle="tooltip" title="Email to Supplier"><i class="fa fa-envelope"></i></a>
                            <a href="' . url('br_pw_lc_new/' . $id) . '" class="btn btn-sm btn-primary" data-toggle="tooltip" title="List Chat"><i class="fa fa-comment"></i></a>
                            </center>';
                    } else if ($pesan->status == 4) {
                        return '<center>
                                <a href="javascript:void(0)" class="btn btn-sm btn-default btn-send-mail" onclick="sendMailToSupplier(\'' . encrypt($id) . '\', \'' . $pesan->tipe . '\')" data-toggle="tooltip" title="Email to Supplier"><i class="fa fa-envelope"></i></a>
                                <a href="' . url('br_pw_lc_new/' . $id) . '" class="btn btn-sm btn-success" data-toggle="tooltip" title="List Chat"><i class="fa fa-list"></i></a>
                            </center>';
                    } else {
                        // return '
                        // <center><a title="Broadcast" style="width:29px; height:27px; background-color: #d5b824ed!Important;border:#d5b824ed!important;" onclick="xy(' . $id . ')" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-default btn-send-mail" onclick="sendMailToSupplier("'.encrypt($id).'");"><font color="white"><i class="fa fa-bullhorn"></i></a>
                        // <a href="' . url('br_pw_dt_new/' . $id) . '" class="btn btn-sm btn-info" data-toggle="tooltip" title="Detail"><i class="fa fa-eye"></i></a>
                        // <a href="' . url('br_dele_new/' . $id) . '" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></a></center>';
                        return '<center>
                                <a href="javascript:void(0)" class="btn btn-sm btn-default btn-send-mail" onclick="sendMailToSupplier(\'' . encrypt($id) . '\', \'' . $pesan->tipe . '\')" data-toggle="tooltip" title="Email to Supplier"><i class="fa fa-envelope"></i></a>
                                <a href="' . url('br_pw_dt_new/' . $id) . '" class="btn btn-sm btn-info" data-toggle="tooltip" title="Detail"><i class="fa fa-eye"></i></a>
                                <a href="javascript:void(0)" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Hapus" onclick="deleteBR(\'' . $id . '\',\'' . 'br_dele_new' . '\')"><i class="fa fa-trash"></i></a>
                            </center>';
                    }
                }
            })

            ->rawColumns(['action', 'f2', 'f7', 'f3', 'f1'])
            ->make(true);
    }

    public function getcsc3()
    {
        $pesan = DB::select("select ROW_NUMBER() OVER (ORDER BY id DESC) AS Row, * from csc_buying_request where by_role='3' and deleted_at ISNULL order by id desc ");
        return DataTables::of($pesan)
            ->addColumn('f1', function ($pesan) {
                return '<div align="left">' . $pesan->subyek . '</div>';
            })
            ->addColumn('f2', function ($pesan) {
                return "Valid until " . $pesan->valid . " days";
            })
            ->addColumn('f3', function ($pesan) {
                return $pesan->date;
            })
            ->addColumn('f4', function ($pesan) {
                $cr = explode(',', $pesan->id_csc_prod);
                $hitung = count($cr);
                $semuacat = "";
                for ($a = 0; $a < ($hitung - 1); $a++) {
                    if ($cr[$a] != '') {
                        $namaprod = DB::select("select * from csc_product where id='" . $cr[$a] . "' ");
                        if (count($namaprod) != 0) {
                            foreach ($namaprod as $prod) {
                                $napro = $prod->nama_kategori_en;
                            }
                            $semuacat = $semuacat . "- " . $napro . "<br>";
                        }
                    }
                }
                return $semuacat;
            })
            // ->addColumn('f6', function ($pesan) {
            //     if ($pesan->by_role == 4) {
            //         return "Perwakilan";
            //     } else if ($pesan->by_role == 3) {
            //         return "Importir";
            //     }
            // })
            ->addColumn('f7', function ($pesan) {
                if ($pesan->status == 1) {
                    return "Negosiation";
                } else if ($pesan->status == 4) {
                    return "Deal";
                } else {
                    return "-";
                }
            })
            ->addColumn('action', function ($pesan) {
                //				if($pesan->status == 1){
                //					return '<a href="'.url('br_pw_lc/'.$pesan->id).'" class="btn btn-sm btn-primary"><i class="fa fa-comment"></i> List Chat</a>';
                //				}else if($pesan->status == 4){
                //					return '<a href="'.url('br_pw_lc/'.$pesan->id).'" class="btn btn-sm btn-success"><i class="fa fa-list"></i> List Chat</a>';
                //				}else{
                //					return '<a title="Broadcast" style="background-color: #d5b824ed!Important;border:#d5b824ed!important;" onclick="xy('.$pesan->id.')" data-toggle="modal" data-target="#myModal" class="btn btn-warning"><font color="white"><i class="fa fa-wifi"></i> Broadcast</i></a>
                //					<a href="'.url('br_pw_dt/'.$pesan->id).'" class="btn btn-sm btn-info"><i class="fa fa-pencil"></i> Detail</a>';
                //				}

                if ($pesan->status == 1) {
                    return '<a href="' . url('br_pw_lc/' . encrypt($pesan->id)) . '" class="btn btn-sm btn-primary" data-toggle="tooltip" title="List Chat"><i class="fa fa-comment"></i></a>';
                } else if ($pesan->status == 4) {
                    return '<a href="' . url('br_pw_lc/' . encrypt($pesan->id)) . '" class="btn btn-sm btn-success" data-toggle="tooltip" title="List Chat"><i class="fa fa-list"></i></a>';
                } else {
                    // return '<a title="Broadcast" style="background-color: #d5b824ed!Important;border:#d5b824ed!important;" onclick="xy(' . $pesan->id . ')" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-warning"><font color="white"><i class="fa fa-bullhorn"></i></i></a>
                    // <a href="' . url('br_pw_dt/' . encrypt($pesan->id)) . '" class="btn btn-sm btn-info" data-toggle="tooltip" title="Detail"><i class="fa fa-eye"></i></a>
                    // <a href="' . url('br_dele/' . $pesan->id) . '" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></a>';
                    return '
					<a href="' . url('br_pw_dt/' . encrypt($pesan->id)) . '" class="btn btn-sm btn-info" data-toggle="tooltip" title="Detail"><i class="fa fa-eye"></i></a>
					<a href="' . url('br_dele/' . $pesan->id) . '" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></a>';
                }
            })
            ->rawColumns(['action', 'f7', 'f3', 'f4', 'f1'])
            ->make(true);
    }

    public function add()
    {
        $pageTitle = "Add Buying Request Admin";
        return view('buying-request.add', compact('pageTitle'));
    }

    public function br_pw_lc($id)
    {
        $pageTitle = "List Chat Buying Request ";
        $id = decrypt($id);
        return view('buying-request.lc', compact('id', 'pageTitle'));
    }

    public function br_pw_lc_new($id)
    {
        $pageTitle = "List Chat Buying Request ";
        return view('buying-request.lc_new', compact('id', 'pageTitle'));
    }

    public function br_pw_dt($id)
    {
        $pageTitle = "List Chat Buying Request Request";
        $id = decrypt($id);
        return view('buying-request.dt', compact('id', 'pageTitle'));
    }

    public function br_pw_dt_new($id)
    {
        $pageTitle = "List Chat Buying Request Request";
        return view('buying-request.dt_new', compact('id', 'pageTitle'));
    }

    public function br_join($id)
    {
        $pageTitle = "Join Buying Request Exporter";
        $public = false;
        return view('buying-request.join', compact('id', 'pageTitle', 'public'));
    }

    public function br_join_public($id)
    {
        $pageTitle = "Trade Inquiry";
        $public = true;
        return view('buying-request.join', compact('id', 'pageTitle', 'public'));
    }

    public function simpanchatbr($id, $id2, $id3, $id4, $id5, $id6)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d H:i:s');
        $a = $_GET['a'];
        $insert = DB::select("
			insert into csc_buying_request_chat (id_br,pesan,tanggal,id_pengirim,id_role,username_pengirim,id_join) values
			('" . $id2 . "','" . $a . "','" . $date . "','" . $id4 . "','" . $id3 . "','" . $id5 . "','" . $id6 . "')");
        $cari = DB::select("select * from csc_buying_request where id='" . $id2 . "'");
        //        dd($cari);
        foreach ($cari as $aja) {
            $data1 = $aja->id_pembuat;
        }
        //di representative gak dipake, gak tau di importer
        //        $cari2 = DB::select("select * from itdp_company_users where id='" . $data1 . "'");
        //        foreach ($cari2 as $aja2) {
        //            $data2 = $aja2->email;
        //        }
        $cari3 = DB::select("select * from itdp_admin_users where id='" . $data1 . "'");
        if ($cari3) {
            foreach ($cari3 as $aja3) {
                $data3 = $aja3->email;
                $data4 = $aja3->name;
                $data5 = $aja3->id_group;
            }
        } else {
            $data5 = null;
        }

        if (empty(Auth::user()->name)) {
            //importir to exportir kesini
            if (Auth::guard('eksmp')->user()->id_profil) {
                if (Auth::guard('eksmp')->user()->id_role == 2) {
                    //exporter to importer kesini 1 , exporter to admin kesini 1 , exporter to representative kesini 1
                    if ($data5) {
                        if ($data5 == 1) {
                            //pembuat buying requestnya admin
                            $ket = "Exporter " . getExBadan(Auth::guard('eksmp')->user()->id) . getCompanyName(Auth::guard('eksmp')->user()->id) . " Respond Chat Buying Request";
                            //  $it = $id2 . "/" . $id6;
                            //notif app untuk pembuat buying request
                            $ket2 = "Exporter " . getExBadan(Auth::guard('eksmp')->user()->id) . getCompanyName(Auth::guard('eksmp')->user()->id) . " Respond Chat Buying Request";
                            $insertnotif2 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
                                ('1','" . getCompanyName(Auth::guard('eksmp')->user()->id) . "','" . Auth::guard('eksmp')->user()->id . "','" . getAdminName($data1) . "','" . $data1 . "','" . $ket2 . "','br_pw_chat','" . $id6 . "','" . $date . "','0')
                                ");
                            //notif email untuk pembuat buying request.
                            $data = [
                                'email' => "",
                                'email1' => getAdminMail($data1),
                                'username' => getCompanyName(Auth::guard('eksmp')->user()->id),
                                'main_messages' => "",
                                'receiver' => $data4,
                                'bu' => getExBadan(Auth::guard('eksmp')->user()->id),
                                //                    'id' => $it
                                'id' => $id6,
                            ];
                            Mail::send('UM.user.sendbrchateks', $data, function ($mail) use ($data) {
                                $mail->to($data['email1'], $data['username']);
                                $mail->subject('Exporter Respond Chat On Buying Request');
                            });
                        } else if ($data5 == 4) {
                            //pembuat buying requestnya representative
                            $ket = "Exporter " . getExBadan(Auth::guard('eksmp')->user()->id) . getCompanyName(Auth::guard('eksmp')->user()->id)  . " Respond Chat Buying Request";
                            //                $it = $id2 . "/" . $id6;
                            //notif app untuk pembuat buying request
                            $insertnotif = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values	
                                ('4','" . getCompanyName(Auth::guard('eksmp')->user()->id) . "','" . Auth::guard('eksmp')->user()->id . "','" . getAdminName($data1) . "','" . $data1 . "','" . $ket . "','br_pw_chat','" . $id6 . "','" . $date . "','0')
                                ");
                            //notif email untuk pembuat buying request.
                            $data = [
                                'email' => "",
                                'email1' => getAdminMail($data1),
                                'username' => getCompanyName(Auth::guard('eksmp')->user()->id),
                                'main_messages' => "",
                                'receiver' => getAdminName($data1),
                                'bu' => getExBadan(Auth::guard('eksmp')->user()->id),
                                //                    'id' => $it
                                'id' => $id6,
                            ];
                            Mail::send('UM.user.sendbrchateks', $data, function ($mail) use ($data) {
                                $mail->to($data['email1'], $data['username']);
                                $mail->subject('Exporter Respond Chat On Buying Request');
                            });
                        }
                    } else {
                        //                            dd($id2." ".$id3." ".$id4." ".$id5." ".$id6);
                        //exporter to importer kesini 2
                        $getimpdt = DB::table('itdp_company_users')->where('id', $data1)->first();
                        //pembuat buying requestnya importer
                        $ket = "Exporter " . getExBadan(Auth::guard('eksmp')->user()->id) . getCompanyName(Auth::guard('eksmp')->user()->id) . " Respond Chat Buying Request";
                        $it = $id2 . "/" . $id6;
                        //notif app untuk pembuat buying request
                        $ket2 = "Exporter " . getExBadan(Auth::guard('eksmp')->user()->id) . getCompanyName(Auth::guard('eksmp')->user()->id)  . " Respond Chat Buying Request";
                        $insertnotif2 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
                            ('3','" . getCompanyName(Auth::guard('eksmp')->user()->id) . "','" . Auth::guard('eksmp')->user()->id . "','" . getCompanyNameImportir($data1) . "','" . $data1 . "','" . $ket2 . "','br_importir_chat','" . $it . "','" . $date . "','0')
                            ");
                        //notif email untuk pembuat buying request.
                        $data = [
                            'email' => "",
                            'email1' => $getimpdt->email,
                            'username' => getCompanyName(Auth::guard('eksmp')->user()->id),
                            'main_messages' => "",
                            'receiver' => getCompanyNameImportir($data1),
                            'id' => $id6,
                            'ida' => $id2,
                            'bu' => getExBadan(Auth::guard('eksmp')->user()->id),
                            'bur' => getExBadanImportir($data1),
                        ];
                        Mail::send('UM.user.sendbrchattoimp', $data, function ($mail) use ($data) {
                            $mail->to($data['email1'], $data['username']);
                            $mail->subject('Exporter Respond Chat On Buying Request');
                        });
                    }

                    //                $data22 = [
                    //                    'email' => "",
                    //                    'email1' => Auth::guard('eksmp')->user()->email,
                    //                    'username' => Auth::guard('eksmp')->user()->username,
                    //                    'main_messages' => "",
                    //                    'id' => $id6
                    //                ];
                    //                Mail::send('UM.user.sendbrchateks2', $data22, function ($mail) use ($data22) {
                    //                    $mail->to($data22['email1'], $data22['username']);
                    //                    $mail->subject('You Was Respond Chat On Buying Request');
                    //                });

                    //                $data33 = [
                    //                    'email' => "",
                    //                    'email1' => env('MAIL_USERNAME','admin@inaexport.id'),
                    //                    'username' => Auth::guard('eksmp')->user()->username,
                    //                    'main_messages' => "",
                    //                    'id' => $id6
                    //                ];
                    //                Mail::send('UM.user.sendbrchateks3', $data33, function ($mail) use ($data33) {
                    //                    $mail->to($data33['email1'], $data33['username']);
                    //                    $mail->subject('Ekportir Respond Chat On Buying Request');
                    //                });

                    //                $data33 = [
                    //                    'email' => "",
                    //                    'email1' => env('MAIL_USERNAME','no-reply@inaexport.id'),
                    //                    'username' => Auth::guard('eksmp')->user()->username,
                    //                    'main_messages' => "",
                    //                    'id' => $id6
                    //                ];
                    //                Mail::send('UM.user.sendbrchateks3', $data33, function ($mail) use ($data33) {
                    //                    $mail->to($data33['email1'], $data33['username']);
                    //                    $mail->subject('Ekportir Respond Chat On Buying Request');
                    //                });
                } else if (Auth::guard('eksmp')->user()->id_role == 3) {
                    //importir to exportir kesini 2
                    $cari3 = DB::select("select * from csc_buying_request_join where id='" . $id6 . "'");
                    foreach ($cari3 as $aja3) {
                        $data3 = $aja3->id_eks;
                    }
                    $cari4 = DB::select("select * from itdp_company_users where id='" . $data3 . "'");
                    foreach ($cari4 as $aja4) {
                        $data4 = $aja4->email;
                    }
                    $ket = "Importer " . getExBadanImportir(Auth::guard('eksmp')->user()->id) . getCompanyNameImportir(Auth::guard('eksmp')->user()->id)  . " Respond Chat Buying Request";
                    $it = $id2 . "/" . $id6;
                    $insertnotif = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values	
                        ('2','" . getCompanyNameImportir(Auth::guard('eksmp')->user()->id) . "','" . Auth::guard('eksmp')->user()->id . "','" . getCompanyName($data3) . "','" . $data3 . "','" . $ket . "','br_chat','" . $id6 . "','" . $date . "','0')
                        ");

                    //                        $ket2 = "Importer " . getExBadanImportir(Auth::guard('eksmp')->user()->id). getCompanyNameImportir(Auth::guard('eksmp')->user()->id) . " Respond Chat Buying Request";
                    //                        $insertnotif2 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
                    //                        ('1','".getCompanyNameImportir(Auth::guard('eksmp')->user()->id) ."','" . Auth::guard('eksmp')->user()->id . "','Super Admin','1','" . $ket2 . "','br_pw_chat','" . $id6 . "','" . Date('Y-m-d H:m:s') . "','0')
                    //                        ");
                    $data = [
                        'email' => "",
                        'email1' => getUserMail($data3),
                        'username' => getCompanyNameImportir(Auth::guard('eksmp')->user()->id),
                        'main_messages' => "",
                        'id' => $id6,
                        'bu' => getExBadanImportir(Auth::guard('eksmp')->user()->id),
                        'bur' => getExBadan($data3),
                        'receiver' => getCompanyName($data3),
                    ];
                    Mail::send('UM.user.sendbrchatimp', $data, function ($mail) use ($data) {
                        $mail->to($data['email1'], $data['username']);
                        $mail->subject('Importer Respond Chat On Buying Request');
                    });

                    //cuma chatting biasa
                    //                        $data22 = [
                    //                            'email' => "",
                    //                            'email1' => Auth::guard('eksmp')->user()->email,
                    //                            'username' => getCompanyNameImportir(Auth::guard('eksmp')->user()->id) ,
                    //                            'main_messages' => "",
                    //                            'id' => $it
                    //                        ];
                    //                        Mail::send('UM.user.sendbrchatimp2', $data22, function ($mail) use ($data22) {
                    //                            $mail->to($data22['email1'], $data22['username']);
                    //                            $mail->subject('You Was Respond Chat On Buying Request');
                    //                        });
                    //
                    //                        $data33 = [
                    //                            'email' => "",
                    //                            'email1' => env('MAIL_USERNAME','no-reply@inaexport.id'),
                    //                            'username' => getCompanyNameImportir(Auth::guard('eksmp')->user()->id) ,
                    //                            'main_messages' => "",
                    //                            'id' => $id6,
                    //                            'bu' => getExBadanImportir(Auth::guard('eksmp')->user()->id),
                    //                        ];
                    //                        Mail::send('UM.user.sendbrchateks3', $data33, function ($mail) use ($data33) {
                    //                            $mail->to($data33['email1'], $data33['username']);
                    //                            $mail->subject('Importir Respond Chat On Buying Request');
                    //                        });

                }
            }
        } else {
            if (Auth::user()->id_group == 1) {
                //dari admin ke indonesian Exporter
                $cari3 = DB::select("select * from csc_buying_request_join where id='" . $id6 . "'");
                foreach ($cari3 as $aja3) {
                    $data3 = $aja3->id_eks;
                }

                $cari4 = DB::select("select * from itdp_company_users where id='" . $data3 . "'");
                foreach ($cari4 as $aja4) {
                    $data4 = $aja4->email;
                    $data5 = $aja4->id_profil;
                }

                $ket = Auth::user()->name . " Respond Chat Buying Request";
                $it = $id2 . "/" . $id6;
                $insertnotif = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values	
				('2','" . auth::user()->name . "','1','Eksportir','" . $data3 . "','" . $ket . "','br_chat','" . $id6 . "','" . $date . "','0')
				");

                //                $ket2 = "You Had Respond Chat Buying Request !";
                //                $insertnotif2 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
                //				('1','Super Admin','1','Super Admin','1','" . $ket2 . "','br_pw_chat','" . $id6 . "','" . Date('Y-m-d H:m:s') . "','0')
                //				");

                $data = [
                    'email' => "",
                    'email1' => getUserMail($data3),
                    'username' => auth::user()->name,
                    'main_messages' => "",
                    'receiver' => getNameCompany($data3),
                    'id' => $id6,
                    'bu' => "-",
                    'bur' => getExBadan($data3),
                ];

                Mail::send('UM.user.sendbrchatimp', $data, function ($mail) use ($data) {
                    $mail->to($data['email1'], $data['username']);
                    $mail->subject('Admin Respond Chat On Buying Request');
                });


                //                $data33 = [
                //                    'email' => "",
                //                    'email1' => env('MAIL_USERNAME','admin@inaexport.id'),
                //                    'username' => "",
                //                    'main_messages' => "",
                //                    'id' => $id6
                //                ];
                //                Mail::send('UM.user.sendbrchateks3', $data33, function ($mail) use ($data33) {
                //                    $mail->to($data33['email1'], $data33['username']);
                //                    $mail->subject('You Respond Chat On Buying Request');
                //                });


            } elseif (Auth::user()->id_group == 4) {
                // dari representative ke seller(Indonesian Exporter)
                $cari3 = DB::select("select * from csc_buying_request_join where id='" . $id6 . "'");
                foreach ($cari3 as $aja3) {
                    $data3 = $aja3->id_eks;
                }

                $cari4 = DB::select("select * from itdp_company_users where id='" . $data3 . "'");
                //                dd($cari4);
                foreach ($cari4 as $aja4) {
                    $data4 = $aja4->email;
                    $data5 = $aja4->id_profil;
                }
                $company = DB::table('itdp_profil_eks')->where('id', $data5)->first();

                $ket = Auth::user()->name . " Respond Chat Buying Request";
                $it = $id2 . "/" . $id6;
                $insertnotif = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values	
				('2','" . auth::user()->name . "','" . auth::user()->id . "','" . getNameCompany($data3) . "','" . $data3 . "','" . $ket . "','br_chat','" . $id6 . "','" . $date . "','0')
				");

                //                $ket2 = "You Had Respond Chat Buying Request !";
                //                $insertnotif2 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
                //				('1','Super Admin','1','Super Admin','1','" . $ket2 . "','br_pw_chat','" . $id6 . "','" . Date('Y-m-d H:m:s') . "','0')
                //				");
                //                dd();
                $data = [
                    'email' => "",
                    'email1' => getUserMail($data3),
                    'username' => auth::user()->name,
                    'main_messages' => "",
                    'receiver' => getNameCompany($data3),
                    'id' => $id6,
                    'bu' => "-",
                    'bur' => getExBadan($data3),
                ];

                Mail::send('UM.user.sendbrchatimp', $data, function ($mail) use ($data) {
                    $mail->to($data['email1'], $data['username']);
                    $mail->subject('Representative Respond Chat On Buying Request');
                });
            }
        }
    }

    public function br_trx($id, $id2)
    {
        $pageTitle = "Buying Request Transaction";
        return view('buying-request.trx', compact('id', 'pageTitle', 'id2'));
    }

    public function br_trx2($id)
    {
        $pageTitle = "Transaction Detail";
        return view('trx.trx', compact('id', 'pageTitle'));
    }

    public function br_deal($id, $id2, $id3)
    {
        //notif ke admin dan pembuat buying request saat eskporter deal buying request
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d H:i:s');
        $cari1 = DB::select("select id_pembuat,by_role from csc_buying_request where id='" . $id2 . "'");
        foreach ($cari1 as $aja1) {
            $data1 = $aja1->id_pembuat;
            $data3 = $aja1->by_role;
        }
        $cari2 = DB::select("select email from itdp_company_users where id='" . $data1 . "'");
        foreach ($cari2 as $aja2) {
            $data2 = $aja2->email;
        }
        $cari3 = DB::select("select name,email from itdp_admin_users where id='" . $data1 . "'");
        foreach ($cari3 as $aja2a) {
            $data2email = $aja2a->email;
            $data2name = $aja2a->name;
        }
        //        dd($id2);

        $it = $id2 . "/" . $id;
        //        dd('a');
        //        dd(Auth::guard('eksmp')->user()->id_profil);

        if ($data3 == 3) {
            //pembuat buying requestnya importer
            $ket = getExBadan(Auth::guard('eksmp')->user()->id) . getCompanyName(Auth::guard('eksmp')->user()->id) . " Deal Buying Request";
            $insertnotif = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,waktu,status_baca) values	
            ('3','" . getCompanyName(Auth::guard('eksmp')->user()->id) . "','" . Auth::guard('eksmp')->user()->id . "','" . getCompanyNameImportir($data1) . "','" . $data1 . "','" . $ket . "','front_end/history','" . $date . "','0')
            ");
            $data = [
                'email' => "",
                'email1' => $data2,
                'username' => getCompanyName(Auth::guard('eksmp')->user()->id),
                'main_messages' => "",
                'receiver' => getCompanyNameImportir($data1),
                'id' => $id2,
                'id2' => $id,
                'bu' => getExBadan(Auth::guard('eksmp')->user()->id),
                'bur' => getExBadanImportir($data1),
            ];
            Mail::send('UM.user.sendbrdeal4', $data, function ($mail) use ($data) {
                $mail->to($data['email1'], $data['username']);
                $mail->subject('Exporter Deal Buying Request');
            });
        } else if ($data3 == 4) {
            //            dd('a');
            //pembuat buying requestnya representative
            //notif untuk representative
            $ket = getExBadan(Auth::guard('eksmp')->user()->id) . getCompanyName(Auth::guard('eksmp')->user()->id) . " Deal Buying Request";
            $insertnotif = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values	
            ('4','" . getCompanyName(Auth::guard('eksmp')->user()->id) . "','" . Auth::guard('eksmp')->user()->id . "','" . getAdminName($data1) . "','" . $data1 . "','" . $ket . "','br_pw_chat','" . $id . "','" . $date . "','0')
            ");
            $data = [
                'email' => "",
                'email1' => getAdminMail($data1),
                'username' => getCompanyName(Auth::guard('eksmp')->user()->id),
                'main_messages' => "",
                'receiver' => getAdminName($data1),
                'id' => $id,
                'bu' => getExBadan(Auth::guard('eksmp')->user()->id),
            ];
            Mail::send('UM.user.sendbrdeal', $data, function ($mail) use ($data) {
                $mail->to($data['email1'], $data['username']);
                $mail->subject('Exporter Deal Buying Request');
            });
        } else if ($data3 == 1) {
            $ket = getExBadan(Auth::guard('eksmp')->user()->id) . getCompanyName(Auth::guard('eksmp')->user()->id) . " Deal Buying Request";
            $insertnotif = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values	
            ('1','" . getCompanyName(Auth::guard('eksmp')->user()->id) . "','" . Auth::guard('eksmp')->user()->id . "','" . getAdminName($data1) . "','" . $data1 . "','" . $ket . "','br_pw_chat','" . $id . "','" . $date . "','0')
            ");
            $data = [
                'email' => "",
                'email1' => getAdminMail($data1),
                'username' => getCompanyName(Auth::guard('eksmp')->user()->id),
                'main_messages' => "",
                'receiver' => getAdminName($data1),
                'id' => $id,
                'bu' => getExBadan(Auth::guard('eksmp')->user()->id),
            ];
            Mail::send('UM.user.sendbrdeal', $data, function ($mail) use ($data) {
                $mail->to($data['email1'], $data['username']);
                $mail->subject('Exporter Deal Buying Request');
            });
        }
        //        $data22 = [
        //            'email' => "",
        //            'email1' => Auth::guard('eksmp')->user()->email,
        //            'username' => Auth::guard('eksmp')->user()->username,
        //            'main_messages' => "",
        //            'id' => $id
        //        ];
        //        Mail::send('UM.user.sendbrdeal2', $data22, function ($mail) use ($data22) {
        //            $mail->to($data22['email1'], $data22['username']);
        //            $mail->subject('You Was Deal Buying Request');
        //        });

        //        $ket2 = $company->company . " Deal Buying Request";
        //        $insertnotif2 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
        //		('1','".$company->company."','" . Auth::guard('eksmp')->user()->id . "','Super Admin','1','" . $ket2 . "','br_pw_chat','" . $id . "','" . Date('Y-m-d H:m:s') . "','0')
        //		");
        //
        //        $data33 = [
        //            'email' => "",
        //            'email1' => env('MAIL_USERNAME','admin@inaexport.id'),
        //            'username' => $company->company,
        //            'main_messages' => "",
        //            'receiver' => "Admin",
        //            'id' => $id
        //        ];
        //        Mail::send('UM.user.sendbrdeal3', $data33, function ($mail) use ($data33) {
        //            $mail->to($data33['email1'], $data33['username']);
        //            $mail->subject('Exporter Was Deal Buying Request');
        //        });

        $maxid = 0;
        $update = DB::select("update csc_buying_request_join set status_join='4' where id='" . $id . "' ");
        $update2 = DB::select("update csc_buying_request set status='4', deal='" . $id3 . "' where id='" . $id2 . "' ");
        $ambildata = DB::select("select * from csc_buying_request where id='" . $id2 . "'");
        foreach ($ambildata as $ad) {
            $isi1 = $ad->id_pembuat;
            $isi2 = $ad->by_role;
        }

        $insert = DB::select("
			insert into csc_transaksi (id_pembuat,by_role,id_eksportir,id_terkait,origin,created_at,status_transaksi) values
			('" . $isi1 . "','" . $isi2 . "','" . Auth::guard('eksmp')->user()->id . "','" . $id2 . "','2','" . Date('Y-m-d H:m:s') . "','0')");
        $querymax = DB::select("select max(id_transaksi) as maxid from csc_transaksi");
        foreach ($querymax as $maxquery) {
            $maxid = $maxquery->maxid;
        }
        //log
        $insert = DB::select("
			insert into log_user (email,waktu,date,ip_address,id_role,id_user,id_activity,keterangan) values
			('" . Auth::guard('eksmp')->user()->email . "','" . date('H:i:s') . "','" . date('Y-m-d') . "','','" . Auth::guard('eksmp')->user()->id_role . "'
			,'" . Auth::guard('eksmp')->user()->id . "','4','deal buying request')");

        //end log
        return redirect('input_transaksi/' . $maxid);
    }

    public function br_chat($id)
    {
        // echo "wkwk";die();
        //        dd(auth::guard('eksmp'));
        if (Auth::guard('eksmp')->user() || Auth::user()) {
            $pageTitle = "Chat Buying Request Indonesian Exporter";
            return view('buying-request.chat', compact('id', 'pageTitle'));
        } else {
            return redirect('/login');
        }
    }

    public function notification($id)
    {
        $options = array(
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'encrypted' => true
        );
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $data['message'] = 'New message';
        $channel = 'notify-channel-' . $id;
        $pusher->trigger($channel, 'App\\Events\\Notify', $data);
    }

    public function br_pw_chat($id)
    {
        if (Auth::guard('eksmp')->user() || Auth::user()) {
            $pageTitle = "Chat Buying Request";
            $id = decrypt($id);
            return view('buying-request.chat2', compact('id', 'pageTitle'));
        } else {
            return redirect('/login');
        }
    }

    public function br_save_join($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d H:i:s');
        $id_user = Auth::guard('eksmp')->user()->id;
        $data1 = "";
        $data2 = "";
        $data3 = "";
        $data4 = "";
        $data5 = "";
        $id_br = "";
        $caribrsl = DB::select("select * from csc_buying_request_join where id='" . $id . "'");
        foreach ($caribrsl as $val1) {
            $data1 = $val1->id_eks;
            $data2 = $val1->id_br;
        }
        $caribrs2 = DB::select("select * from csc_buying_request where id='" . $data2 . "'");
        foreach ($caribrs2 as $val2) {
            $data3 = $val2->id_pembuat;
            $data5 = $val2->by_role;
            $id_br = $val2->id;
        }
        $caribrs3 = DB::select("select * from itdp_company_users where id='" . $data3 . "'");
        foreach ($caribrs3 as $val3) {
            $data4 = $val3->email;
            $id_profil = $val3->id_profil;
        }
        $caribrs4 = DB::select("select * from itdp_admin_users where id='" . $data3 . "'");
        $greed = "greed@gmail.com";
        if (count($caribrs4) != 0) {
            //            dd($caribrs4);
            foreach ($caribrs4 as $cb4) {
                $greed = $cb4->email;
                $name = $cb4->name;
            }
        }
        //        dd($data5);
        //        dd($id_profil);
        //        if($id_profil){
        //            $companyname = DB::table('itdp_profil_eks')->where('id', $id_profil)->get();
        //        }
        //        dd($companyname);
        //        dd();

        if ($data5 == 3) {
            $ket = getExBadan($id_user) . getCompanyName($id_user) . " Join to your Buying Request";
            $insertnotif = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values	
                ('3','" . getCompanyName($id_user) . "','" . Auth::guard('eksmp')->user()->id . "','" . getCompanyNameImportir($data3) . "','" . $data3 . "','" . $ket . "','br_importir_lc','" . $data2 . "','" . $date . "','0')
                ");
            //            $ket2 = Auth::guard('eksmp')->user()->username . " Join to Buying Request";
            //            $insertnotif2 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
            //		('1','Eksportir','" . Auth::guard('eksmp')->user()->id . "','Super Admin','1','" . $ket2 . "','br_pw_lc','" . $data2 . "','" . Date('Y-m-d H:m:s') . "','0')
            //		");
            $data = [
                'email' => "",
                'email1' => $data4,
                'username' => getCompanyName($id_user),
                'main_messages' => "",
                'receiver' => getCompanyNameImportir($data3),
                'id' => $data2,
                'bu' => getExBadan($id_user),
                'bur' => getExBadanImportir($data3),
            ];
            Mail::send('UM.user.sendbrjoinimp', $data, function ($mail) use ($data) {
                $mail->to($data['email1'], $data['username']);
                $mail->subject('Exporter Join to Your Buying Request');
            });

            //            $data33 = [
            //                'email' => "",
            //                'email1' => env('MAIL_USERNAME','no-reply@inaexport.id'),
            //                'username' => Auth::guard('eksmp')->user()->username,
            //                'main_messages' => "",
            //                'id' => $data2
            //            ];
            //            Mail::send('UM.user.sendbrjoin3', $data33, function ($mail) use ($data33) {
            //                $mail->to($data33['email1'], $data33['username']);
            //                $mail->subject('Exporter Join to Buying Request');
            //            });

        } else if ($data5 == 1) {
            $ket = getExBadan($id_user) . getCompanyName($id_user) . " Join to your Buying Request";
            $insertnotif = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values	
                ('1','" . getExBadan($id_user) . getCompanyName($id_user) . "','" . Auth::guard('eksmp')->user()->id . "','" . getAdminName($data3) . "','" . $data3 . "','" . $ket . "','br_pw_lc','" . $data2 . "','" . $date . "','0')
                ");

            $data = [
                'email' => "",
                'email1' => getAdminMail($data3),
                'username' => getCompanyName($id_user),
                'main_messages' => "",
                'receiver' => getAdminName($data3),
                'id' => $data2,
                'bu' => getExBadan($id_user),
            ];
            Mail::send('UM.user.sendbrjoin', $data, function ($mail) use ($data) {
                $mail->to($data['email1'], $data['username']);
                $mail->subject('Exporter Join to Your Buying Request');
            });
        } else if ($data5 == 4) {
            $ket = getExBadan($id_user) . getCompanyName($id_user) . " Join to your Buying Request";
            $insertnotif = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values	
                ('4','" . getCompanyName($id_user) . "','" . Auth::guard('eksmp')->user()->id . "','" . getAdminName($data3) . "','" . $data3 . "','" . $ket . "','br_pw_lc','" . $data2 . "','" . $date . "','0')
                ");

            $data = [
                'email' => "",
                'email1' => getAdminMail($data3),
                'username' => getCompanyName($id_user),
                'main_messages' => "",
                'id' => $data2,
                'receiver' => getAdminName($data3),
                'bu' => getExBadan($id_user),
            ];
            Mail::send('UM.user.sendbrjoin', $data, function ($mail) use ($data) {
                $mail->to($data['email1'], $data['username']);
                $mail->subject('Exporter Join to Your Buying Request');
            });
        }

        //        $data22 = [
        //            'email' => "",
        //            'email1' => Auth::guard('eksmp')->user()->email,
        //            'username' => "",
        //            'main_messages' => Auth::guard('eksmp')->user()->username,
        //            'id' => $id
        //        ];
        //
        //        Mail::send('UM.user.sendbrjoin2', $data22, function ($mail) use ($data22) {
        //            $mail->to($data22['email1'], $data22['username']);
        //            $mail->subject('You Join To Buying Request');
        //        });

        // $cek = DB::table('csc_buying_request_join')->where('id', $id)->first();
        // if ($cek->status_join == 1) {
        //     $update = DB::select("update csc_buying_request_join set status_join='2' where id='" . $id . "' ");
        // } else if ($cek->status_join == 0) {
        $update = DB::select("update csc_buying_request_join set status_join='1' where id='" . $id . "' ");
        // }
        $update_br = DB::select("update csc_buying_request set status='1' where id='" . $id_br . "' ");
        //log
        $insert = DB::select("
			insert into log_user (email,waktu,date,ip_address,id_role,id_user,id_activity,keterangan) values
			('" . Auth::guard('eksmp')->user()->email . "','" . date('H:i:s') . "','" . date('Y-m-d') . "','','" . Auth::guard('eksmp')->user()->id_role . "'
			,'" . Auth::guard('eksmp')->user()->id . "','4','join buying request')");

        //end log
        return redirect('br_list');
    }

    public function br_pw_bc_choose_eks(Request $request)
    {
        $date = date('Y-m-d H:i:s');
        // dd($date);
        $dataeksportir = $request->dataeksportir;
        $explodeksportir = explode(',', $dataeksportir);
        $databr = DB::select("select * from csc_buying_request where id='" . $request->id . "'");
        if (isset($databr[0]->by_role) == 4) {
            $namapembuat = getPerwakilanName($databr[0]->id_pembuat);
            $zzz = $databr[0]->id_pembuat;
        } else {
            $namapembuat = getPerwakilanName($databr[0]->id_pembuat);
            $zzz = $databr[0]->id_pembuat;
        }
        foreach ($explodeksportir as $eksportir) {
            $cekada = DB::select("select * from csc_buying_request_join where id_br='" . $request->id . "' and id_eks='" . (int)$eksportir . "'");
            if (count($cekada) == 0) {
                $insert = DB::select("insert into csc_buying_request_join (id_br,id_eks,date) values
					('" . $request->id . "','" . (int)$eksportir . "','" . Date('Y-m-d H:m:s') . "')");

                //NOTIF
                $id_terkait = "";
                $ket = "Buying Request created by " . $namapembuat;
                $insert3 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
					('2','" . $namapembuat . "','" . $zzz . "','Eksportir','" . (int)$eksportir . "','" . $ket . "','br_list','" . $id_terkait . "','" . Date('Y-m-d H:m:s') . "','0')
				");

                //END NOTIF
                //EMAIL
                $caridataeks = DB::select("select * from itdp_company_users where id ='" . $eksportir . "'");

                if (count($caridataeks) != 0) {
                    foreach ($caridataeks as $vm) {
                        $vc1 = $vm->email;
                    }
                    $datacomeks = DB::select("select * from itdp_profil_eks where id = '" . $vm->id_profil . "'");
                    $data = [
                        'username' => $namapembuat,
                        'id2' => '0',
                        'nama' => $namapembuat,
                        'password' => '',
                        'email' => $vc1,
                        'company' => $datacomeks[0]->company,
                        'bu' => $datacomeks[0]->badanusaha,
                    ];
                    Mail::send('UM.user.emailbr', $data, function ($mail) use ($data) {
                        $mail->to($data['email'], $data['company']);
                        $mail->subject('Buying Was Created');
                    });
                }
                //END EMAIL
            }
        }
        $update = DB::select("update csc_buying_request set status='1' where id='" . $request->id . "'");
        // $update = DB::select("update csc_buying_request set status='1', data_eksportir = '".$request->dataeksportir."' where id='".$request->id."'");
        // return redirect('br_list')->with('success','Success Broadcast Data');
        $baliknya = 'sukses';
        return json_encode($baliknya);
    }

    public function br_join_published($id)
    {
        $date = date('Y-m-d H:i:s');
        $id_eks = Auth::guard('eksmp')->user()->id;
        $databr = DB::select("select * from csc_buying_request where id='" . $id . "'");
        if (isset($databr[0]->by_role) == 3) {
            $bentukpt = getExBadanImportir($databr[0]->id_pembuat);
            $namapembuat = getCompanyNameImportir($databr[0]->id_pembuat);
            // $namapembuat = getPerwakilanName($databr[0]->id_pembuat );
            $zzz = $databr[0]->id_pembuat;
        }

        if (Auth::guard('eksmp')->user()->id_role == 2 && $databr[0]->publish) {
            $cekada = DB::select("select * from csc_buying_request_join where id_br='" . $id . "' and id_eks='" . $id_eks . "'");
            if (count($cekada) == 0) {
                $insert = DB::select("insert into csc_buying_request_join (id_br,id_eks,date) values
                    ('" . $id . "','" . (int)$id_eks . "','" . Date('Y-m-d H:m:s') . "')");

                //NOTIF
                $id_terkait = "";
                $ket = "Buying Request created by " . $bentukpt . $namapembuat;
                $insert3 = DB::select("insert into notif (to_role,dari_nama,dari_id,untuk_nama,untuk_id,keterangan,url_terkait,id_terkait,waktu,status_baca) values
                    ('2','" . $namapembuat . "','" . $zzz . "','" . getCompanyName($id_eks) . "','" . (int)$id_eks . "','" . $ket . "','br_list','" . $id_terkait . "','" . $date . "','0')
                ");
                //END NOTIF

                //EMAIL
                $caridataeks = DB::select("select * from itdp_company_users where id ='" . $id_eks . "'");

                if (count($caridataeks) != 0) {
                    foreach ($caridataeks as $vm) {
                        $vc1 = $vm->email;
                    }
                    $datacomeks = DB::select("select * from itdp_profil_eks where id = '" . $vm->id_profil . "'");
                    $data = [
                        'username' => getCompanyName($zzz),
                        'id2' => '0',
                        'nama' => getCompanyNameImportir($zzz),
                        'company' => $datacomeks[0]->company,
                        'password' => '',
                        'email' => $vc1,
                        'bu' => $datacomeks[0]->badanusaha,
                        'bur' => getExBadanImportir($zzz)
                    ];
                    Mail::send('UM.user.emailbr2', $data, function ($mail) use ($data) {
                        $mail->to($data['email'], $data['username']);
                        $mail->subject('Buying Request Was Created');
                    });
                }
                //END EMAIL
            }
        }

        //log
        $insert = DB::select("
			insert into log_user (email,waktu,date,ip_address,id_role,id_user,id_activity,keterangan) values
			('" . Auth::guard('eksmp')->user()->email . "','" . date('H:i:s') . "','" . date('Y-m-d') . "','','" . Auth::guard('eksmp')->user()->id_role . "'
			,'" . $id_eks . "','4','Published Inquiry')");
        //end log

        $baliknya = 'sukses';
        // return json_encode($baliknya);
        return redirect('br_list');
    }

    public function ambilt2($id, $perusahaan = null)
    {
        return view('buying-request.t2', compact('id', 'perusahaan'));
    }

    public function ambilt3($id, $perusahaan = null)
    {
        return view('buying-request.t3', compact('id', 'perusahaan'));
    }

    public function br_save(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d H:i:s');
        if ($request->tp == null) {
            $ch2 = 0;
        } else {
            $ch1 = str_replace(".", "", $request->tp);
            $ch2 = str_replace(",", ".", $ch1);
        }

        $kumpulcat = "";
        if ($request->t2s == 0 && $request->t3s == 0) {
            $kumpulcat =  $request->category[0] . ',';
        } else if ($request->t3s == 0) {
            $kumpulcat =  $request->category[0] . ',' . $request->t2s . ',';
        } else {
            $kumpulcat =  $request->category[0] . ',' . $request->t2s . ',' . $request->t3s . ',';
        }

        // if($request->t2s == 0 && $request->t3s == 0){
        //     $kumpulcat2 =  $request->category.',';
        // }else if($request->t3s== 0){
        //     $kumpulcat2 =  $request->category.','.$request->t2s.',';
        // }else{
        //     $kumpulcat2 =  $request->category.','.$request->t2s.','.$request->t3s.',';
        // }
        //        $g = count($request->category);
        //        for ($a = 0; $a < $g; $a++) {
        //            $kumpulcat = $kumpulcat . $request->category[$a] . ",";
        //        }
        //        $h = explode(",", $kumpulcat);

        if (empty($request->file('doc'))) {
            $file = "";
        } else {
            $file = $request->file('doc')->getClientOriginalName();
            $destinationPath = public_path() . "/uploads/buy_request";
            $request->file('doc')->move($destinationPath, $file);
        }
        $cat = $request->category[0] != '' ? $request->category[0] : 0; 
        $cat1 = $request->t2s != '' ? $request->t2s : 0; 
        $cat2 = $request->t23 != '' ? $request->t23 : 0; 
        $insert = DB::select("
			insert into csc_buying_request (subyek,valid,id_mst_country,city,id_csc_prod_cat,id_csc_prod_cat_level1,id_csc_prod_cat_level2,shipping,spec,files
			,eo,neo,tp,ntp,by_role,id_pembuat,date,id_csc_prod, publish) values
			('" . $request->cmp . "','" . $request->valid . "','" . $request->country . "','" . $request->city . "','".$cat."','".$cat1."','".$cat2."','" . $request->ship . "','" . $request->spec . "','" . $file . "','" . $request->eo . "','" . $request->neo . "'
			,'" . $ch2 . "','" . $request->ntp . "','" . Auth::user()->id_group . "','" . Auth::user()->id . "','" . $date . "','" . $kumpulcat . "', true)");

        return redirect('br_list')->with('success', 'Success Add Data');
    }

    public function br_save_trx(Request $request)
    {
        $update = DB::select("update csc_buying_request set status_trx='" . $request->tipekirim . "', type_tracking='" . $request->type_tracking . "',no_track='" . $request->no_track . "' where id='" . $request->id1 . "' ");
        return redirect('trx_list');
    }

    public function delete(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $today = date("Y-m-d h:i:s");
        DB::table('csc_buying_request')->where('id', $request->id)->update(['deleted_at' => $today]);
        // $msg = ["status"=>"success"];
        // echo json_encode($msg);

        return redirect('br_list')->with('error', 'Success Delete Data');
    }

    public function br_dele($id)
    {
        // echo "wkwk";die();
        date_default_timezone_set('Asia/Jakarta');
        $today = date("Y-m-d h:i:s");
        //DB::table('csc_buying_request')->where('id', $id)->update(['deleted_at'=>$today]);
        $data = DB::select("delete from csc_buying_request where id='" . $id . "'");

        // $msg = ["status"=>"success"];
        // echo json_encode($msg);

        return redirect('br_list')->with('error', 'Success Delete Data');;
    }

    public function br_dele_new($id)
    {
        return redirect('br_list')->with('error', 'Success Delete Data');;
    }

    public function send_mail_supplier(Request $request, $id, $type)
    {
        $id_csc_prod = '';

        if ($type == 'br') {
            $id_csc_prod = buying_and_inqueri::where('id_csc_buying_request', decrypt($id))->first()->id_csc_prod;
        } else {
            $id_csc_prod = buying_and_inqueri::where('id_csc_inquiry_br', decrypt($id))->first()->id_csc_prod;
        }
        $v_inquiry_br = buying_and_inqueri::where('id_csc_buying_request', decrypt($id))->first();

        $array_id_product = explode(',', $id_csc_prod);

        if (count($array_id_product) > 0) {
            $category = isset($array_id_product[0]) == true ? $array_id_product[0] : NULL;
            $sub_category_1 = isset($array_id_product[1]) == true ? $array_id_product[1] : NULL;
            $sub_category_2 = isset($array_id_product[2]) == true ? $array_id_product[2] : NULL;

            $array_supplier_join = DB::table('csc_buying_request_join')->where('id_br', decrypt($id))->get()->pluck('id_eks')->toArray();

            $suppliers = DB::table('csc_product_single')
                ->join('itdp_company_users', 'itdp_company_users.id', 'csc_product_single.id_itdp_company_user')
                ->join('itdp_profil_eks', 'itdp_company_users.id_profil', 'itdp_profil_eks.id')
                ->when($category, function ($query) use ($category) {
                    $query->where('csc_product_single.id_csc_product', $category);
                })
                ->when($sub_category_1, function ($query) use ($sub_category_1) {
                    $query->where('csc_product_single.id_csc_product_level1', $sub_category_1);
                })
                ->when($sub_category_2, function ($query) use ($sub_category_2) {
                    $query->where('csc_product_single.id_csc_product_level2', $sub_category_2);
                });

            if (count($array_supplier_join) > 0) {
                $suppliers = $suppliers->whereNotIn('itdp_profil_eks.id', [implode(',', $array_supplier_join)]);
            }

            $suppliers = $suppliers->select('itdp_company_users.email', 'itdp_company_users.id')
                ->groupby('itdp_company_users.email', 'itdp_company_users.id')
                ->get();

            //Send Mail
            $negera_buyer_or_perwadag = '';
            if ($v_inquiry_br->by_role == 3) {
                //buyer
                $negera_buyer_or_perwadag = getImpCountry($v_inquiry_br->id_pembuat);
            } else if ($v_inquiry_br->by_role == 4) {
                // perwadag
                $negera_buyer_or_perwadag = getPerwakilanCountry2($v_inquiry_br->id_pembuat);
            } else {
                $negera_buyer_or_perwadag = "-";
            }
            if (count($suppliers) != 0) {
                foreach ($suppliers as $s) {
                    if ($s->email != '') {
                        $data = [
                            'email' => $s->email,
                            'nama_perusahaan' => getCompanyName($s->id),
                            'tanggal_inquiry' => $v_inquiry_br->date,
                            'negara_buyer_or_perwadag' => $negera_buyer_or_perwadag,
                            'subyek' => $v_inquiry_br->subyek,
                            'valid' => $v_inquiry_br->valid
                        ];
                        Mail::send('UM.user.emailbr_from_admin', $data, function ($mail) use ($data) {
                            $mail->to($data['email'], $data['nama_perusahaan']);
                            $mail->subject('Informasi trade inquiry terbaru di Inaexport');
                        });
                    }
                }
            }


            return json_encode([
                'success' => true,
                'message' => 'Success send e-mail to supplier'

            ]);
        } else {
            return json_encode([
                'success' => false,
                'message' => 'Internal Server Error. Id Product not found!'

            ]);
        }
    }

    public function send_mail_reminder_supplier(Request $request, $id, $id_user)
    {
        $v_inquiry_br = buying_and_inqueri::where('id_csc_buying_request', $id)->first();

        $supplier = DB::table('csc_buying_request_join')->where('id_eks', $id_user)->first()->id_eks;

        $suppliers = DB::table('itdp_company_users')
            ->where('itdp_company_users.id', $supplier)
            ->select('itdp_company_users.email', 'itdp_company_users.id')
            ->get();
        //Send Mail
        $negera_buyer_or_perwadag = '';
        if ($v_inquiry_br->by_role == 3) {
            //buyer
            $negera_buyer_or_perwadag = getImpCountry($v_inquiry_br->id_pembuat);
        } else if ($v_inquiry_br->by_role == 4) {
            // perwadag
            $negera_buyer_or_perwadag = getPerwakilanCountry2($v_inquiry_br->id_pembuat);
        }
        if ($suppliers != '') {
            foreach ($suppliers as $s) {
                if ($s->email != '') {
                    $data = [
                        'email' => $s->email,
                        'nama_perusahaan' => getCompanyName($s->id),
                        'tanggal_inquiry' => $v_inquiry_br->date,
                        'negara_buyer_or_perwadag' => $negera_buyer_or_perwadag,
                        'subyek' => $v_inquiry_br->subyek,
                        'valid' => $v_inquiry_br->valid
                    ];
                    Mail::send('UM.user.emailbr_reminder_from_admin', $data, function ($mail) use ($data) {
                        $mail->to($data['email'], $data['nama_perusahaan']);
                        $mail->subject('Reminder trade inquiry terbaru di Inaexport');
                    });
                }
            }
        }


        return json_encode([
            'success' => true,
            'message' => 'Success send e-mail reminder to supplier'

        ]);
    }
}
