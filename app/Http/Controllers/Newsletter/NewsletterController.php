<?php

namespace App\Http\Controllers\Newsletter;

use App\Http\Controllers\Controller;
use App\Jobs\SendEmailNewsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Session;
use Auth;

class NewsletterController extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {
        $pageTitle = 'Newsletter';
        $comp = DB::table('itdp_company_users')->whereIn('newsletter', [1, 2])->orderBy('email', 'asc')->get();
        if (isset(Auth::user()->id)) {
            if (Auth::user()->id_group == 1)
                return view('newsletter.index', compact('pageTitle', 'comp'));
            else
                return redirect('/home');
        } else {
            return redirect('/');
        }
    }

    public function getData()
    {
        $news = DB::table('itdp_newsletter')->orderBy('created_at', 'desc')->get();

        return \Yajra\DataTables\DataTables::of($news)
            ->addIndexColumn()
            ->addColumn('messages', function ($data) {
                $text = strtok($data->messages, "\n");
                $hitung = substr_count($data->messages, "\n");
                if ($hitung > 0) {
                    $text .= '&hellip;';
                }
                return strip_tags($text, "");
            })
            ->addColumn('action', function ($data) {
                $p = '<center><div class="btn-group">';
                if ($data->status == 1) {
                    $p .= '<a href="' . route('newsletter.view', $data->id) . '" class="btn btn-sm btn-info" title="View"><i class="fa fa-eye text-white"></i></a>&nbsp;<a onclick="return confirm(\'Are You Sure ?\')" href="' . route('newsletter.destroy', $data->id) . '" class="btn btn-sm btn-danger" title="Delete"><i class="fa fa-trash text-white"></i></a> ';
                } else {
                    $p .= '<button type="button" class="btn btn-sm btn-warning" title="Broadcast" onclick="broadcast(' . $data->id . ')"><i class="fa fa-bullhorn text-white"></i></button>&nbsp;<a href="' . route('newsletter.edit', $data->id) . '" class="btn btn-sm btn-success" title="Edit"><i class="fa fa-edit text-white"></i></a>';
                }
                return $p . '</div></center>';
            })
            ->addColumn('created_at', function ($data) {
                $p = '';
                if ($data->created_at != null) {
                    $p = $data->created_at;
                }
                return $p;
            })
            ->addColumn('status', function ($data) {
                $p = '';
                if ($data->status == 1) {
                    $p = '<center><span class="btn btn-sm btn-success" style="cursor:default;"><i class="fa fa-check"></i></span></center> ';
                }
                return $p;
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    public function getDataCompany()
    {
        $comp = DB::table('itdp_company_users')->whereIn('newsletter', [1, 2])->orderBy('email', 'asc')->get();

        return \Yajra\DataTables\DataTables::of($comp)
            ->addIndexColumn()
            ->addColumn('email', function ($data) {
                // return '<div align="left">'.$data->email.'</div>';
                return $data->email;
            })
            ->addColumn('company', function ($data) {
                // return '<div align="left">'.getProfileCompany($data->id_profil).'</div>';
                return getProfileCompany($data->id_profil);
            })
            ->addColumn('action', function ($data) {
                if ($data->status == 1) {
                    $p = '<input type="checkbox" checked data-toggle="toggle" data-on="Publish" data-off="Hide" data-onstyle="info" data-offstyle="default" id="statusnya"><input type="hidden" name="status" id="status" value="1">';
                } else {
                    $p = '<input type="checkbox" data-toggle="toggle" data-on="Publish" data-off="Hide" data-onstyle="info" data-offstyle="default" id="statusnya"><input type="hidden" name="status" id="status" value="2">';
                }
                return $p;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        $pageTitle = 'Newsletter';
        $page = 'create';
        $url = "/newsletter/store/Create";
        if (isset(Auth::user()->id)) {
            if (Auth::user()->id_group == 1)
                return view('newsletter.create', compact('url', 'pageTitle', 'page'));
            else
                return redirect('/home');
        } else {
            return redirect('/');
        }
    }

    public function store(Request $req, $param)
    {
        date_default_timezone_set('Asia/Jakarta');
        // Tujuan
        $send_to = '';
        if ($req->send_to) {
            foreach ($req->send_to as $key => $value) {
                if ($value == 'All') {
                    $send_to = 'All';
                    break;
                } else {
                    $send_to .= $value . ',';
                }
            }
            $send_to = rtrim($send_to, ',');
        } else {
            $send_to = 'All';
        }

        $destination = 'uploads\Newsletter\File\\';
        if ($req->hasFile('file')) {
            $file = $req->file('file');
            $nama_file = time() . '_' . date('Y_m_d') . '_' . $req->file('file')->getClientOriginalName();
            Storage::disk('uploads')->putFileAs($destination, $file, $nama_file);
        } else {
            $nama_file = $req->lastest_file;
        }

        if ($param == 'Create') {
            $data = $id =  DB::table('itdp_newsletter')->insertGetId([
                'about' => $req->about,
                'messages' => $req->messages,
                'file' => $nama_file,
                'status' => 0,
                'send_to' => $send_to,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        } else {
            $pecah = explode('|', $param);
            $param = $pecah[0];
            $id = $pecah[1];

            $data =  DB::table('itdp_newsletter')->where('id', $id)->update([
                'about' => $req->about,
                'messages' => $req->messages,
                'file' => $nama_file,
                'send_to' => $send_to,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }

        // Detail Tujuan
        if (strstr($send_to, 'Province')) {
            if ($req->province) {
                DB::table('newsletter_province')->where('id_newsletter', $id)->delete();
                foreach ($req->province as $key => $value) {
                    DB::table('newsletter_province')->insert([
                        'id_newsletter' => $id,
                        'id_province' => $value,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }
        }

        if (strstr($send_to, 'Category')) {
            if ($req->category) {
                DB::table('newsletter_category')->where('id_newsletter', $id)->delete();
                foreach ($req->category as $key => $value) {
                    DB::table('newsletter_category')->insert([
                        'id_newsletter' => $id,
                        'id_category' => $value,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }
        }

        if (strstr($send_to, 'All')) {
            DB::table('newsletter_province')->where('id_newsletter', $id)->delete();
            DB::table('newsletter_category')->where('id_newsletter', $id)->delete();
        }

        // End
        if ($data) {
            Session::flash('success', 'Success ' . $param . 'd Data');
            return redirect('/newsletter/')->with('success', 'Success ' . $param . 'd Data!');
        } else {
            Session::flash('failed', 'Failed ' . $param . 'd Data');
            return redirect('/newsletter/')->with('error', 'Failed ' . $param . 'd Data!');
        }
    }

    public function view($id)
    {
        $pageTitle = "Newsletter";
        $page = "view";
        $data =  DB::table('itdp_newsletter')->where('id', $id)->first();
        if (isset(Auth::user()->id)) {
            if (Auth::user()->id_group == 1)
                return view('newsletter.create', compact('page', 'data', 'pageTitle'));
            else
                return redirect('/home');
        } else {
            return redirect('/');
        }
    }

    public function edit($id)
    {
        $page = "edit";
        $pageTitle = "Newsletter";
        $url = "/newsletter/store/Update|" . $id;
        $data =  DB::table('itdp_newsletter')->where('id', $id)->first();
        if (isset(Auth::user()->id)) {
            if (Auth::user()->id_group == 1)
                return view('newsletter.create', compact('url', 'data', 'pageTitle', 'page'));
            else
                return redirect('/home');
        } else {
            return redirect('/');
        }
    }

    public function destroy($id)
    {
        $data =  DB::table('itdp_newsletter')->where('id', $id)->delete();
        if ($data) {
            Session::flash('error', 'Success Deleted Data');
            return redirect('/newsletter/')->with('error', 'Success Deleted Data');
        } else {
            Session::flash('error', 'Failed Deleted Data');
            return redirect('/newsletter/')->with('error', 'Failed Deleted Data');
        }
    }

    public function broadcast(Request $req)
    {
        $newsletter =  DB::table('itdp_newsletter')->where('id', $req->newsletter)->first();
        $data = [
            'subject' => $newsletter->about,
            'messages' => $newsletter->messages,
            'file' => $newsletter->file
        ];

        $query = DB::table('itdp_company_users as a')->selectRaw('a.id,a.email')->join('itdp_profil_eks as b', 'a.id_profil', 'b.id')->where('a.newsletter', 1);
        if (strstr($newsletter->send_to, 'All')) {
            $user = $query->groupBy('a.id')->groupBy('a.email')->get();
        } else {
            if (strstr($newsletter->send_to, 'Province')) {
                $arrProv = [];
                $province = DB::table('newsletter_province')->where('id_newsletter', $req->newsletter)->get();
                foreach ($province as $key => $prov) {
                    array_push($arrProv, $prov->id_province);
                }
                $query->whereIn('b.id_mst_province', $arrProv);
            }
            if (strstr($newsletter->send_to, 'Category')) {
                $arrCat = [];
                $category = DB::table('newsletter_category')->where('id_newsletter', $req->newsletter)->get();
                foreach ($category as $key => $prov) {
                    array_push($arrCat, $prov->id_category);
                }
                $query->join('csc_product_single as c', 'a.id', 'c.id_itdp_company_user');
                $query->where(function ($query) use ($arrCat) {
                    $query->whereIn('c.id_csc_product', $arrCat)->orWhereIn('c.id_csc_product_level1', $arrCat)->orWhereIn('c.id_csc_product_level2', $arrCat);
                });
            }
            $query->groupBy('a.id')->groupBy('a.email');
            $user = $query->get();
        }

        foreach ($user as $key => $value) {
            $data['email'] = $value->email;
            $data['email_unsub'] = Crypt::encryptString($value->id);
            // return view('newsletter.mail', $data);
            dispatch(new SendEmailNewsletter($data));
            // Mail::send('newsletter.mail', $data, function ($mail) use ($data) {
            //     $mail->subject($data['subject']);
            //     $mail->to($data['email']);
            // });
        }

        $simpan =   DB::table('itdp_newsletter')->where('id', $req->newsletter)->update(['status' => 1]);

        if ($simpan) {
            Session::flash('success', 'Success Broadcast Data');
            return redirect('/newsletter/')->with('success', 'Success Broadcast Data');
        } else {
            Session::flash('failed', 'Failed Broadcast Data');
            return redirect('/newsletter/')->with('error', 'Failed Broadcast Data');
        }
    }

    public function unsubscribe($lock_id)
    {
        $id = Crypt::decryptString($lock_id);
        $data = DB::table('itdp_company_users')->where('id', $id)->update(['newsletter' => 2]);
        if ($data) {
            $message = ['title' => 'You\'ve been unsubscribed.', 'body' => 'You will not get another newsletter. if you have any feedback or questions please contact us.'];
            return view('newsletter.unsubscribe', $message);
        } else {
            $message = ['title' => 'Unsubscribed Failed.', 'body' => 'Unsubscribe failed due to a data error. if you have any feedback or questions please contact us.'];
            return view('newsletter.unsubscribe', $message);
        }
    }

    public function toggleCompany(Request $req)
    {
        $pecah = explode('|', $req->id);
        if ($pecah[1] == 1) {
            $data = DB::table('itdp_company_users')->where('id', $pecah[0])->update(['newsletter' => 2]);
        } else {
            $data = DB::table('itdp_company_users')->where('id', $pecah[0])->update(['newsletter' => 1]);
        }
        if ($data)
            return 'Success';
        else
            return 'Failed';
    }
}
