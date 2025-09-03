<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//////////////////////////////////// START FRONTEND ////////////////////////////////////////////////////////////
Route::get('locale/{locale}', function ($locale) {
    Session::put('locale', $locale);
    return redirect()->back();
});
// Route::get('/', function () {
//     return redirect('/front_end');
// });
Route::get('switch/{locale}', function ($locale) {
    App::setLocale($locale);
});
Route::get('/register_buyer', 'RegistrasiController@register_buyer');
Route::get('/forget_a', 'RegistrasiController@forget_a');
Route::get('/resetpass_send', 'RegistrasiController@resetpass_send');
Route::get('/gantipass1/{id}', 'RegistrasiController@gantipass1');
Route::get('/gantipass2/{id}', 'RegistrasiController@gantipass2');
Route::post('/updatepass1/{id}', 'RegistrasiController@updatepass1');
Route::post('/updatepass2/{id}', 'RegistrasiController@updatepass2');
Route::post('/resetpass', 'RegistrasiController@resetpass');
Route::post('/api-tracking/', 'Api\TrackingController@tracking')->name('api.tracking');
Route::get('/check', 'UserController@userOnlineStatus');
Route::get('/check2', 'UserEksmpController@usereksmpOnlineStatus');
Route::get('/pendapatan_list', 'RekapPendapatanController@index');
Route::get('/exportpendapatanall', 'RekapPendapatanController@exportpendapatanall');
Route::get('/cetakrc', 'RekapPendapatanController@cetakrc');
Route::get('/exportpendapatandetail/{id}', 'RekapPendapatanController@exportpendapatandetail');
Route::get('/detailpendapatan/{id}', 'RekapPendapatanController@detailpendapatan');

Route::namespace('FrontEnd')->group(function () {
    //Berita
    Route::get('/detail-artikel/{judul_seo}', 'FrontController@detail')->name('detail-artikel');

    /* Created by Meidiyanah */
    //Transaction
    Route::get('/front_end/list_transaction', 'TransactionFrontController@index');
    Route::get('/front_end/transaction_getdata', 'TransactionFrontController@datanya')->name('front.datatables.transaction');
    //Product
    Route::get('/', 'FrontController@index')->name('homepage');
    Route::get('/front_end/list_product', 'FrontController@list_product');
    //SEO FRIENDLY 
    Route::get('/produk', 'FrontController@list_product');
    Route::get('/products', 'FrontController@list_product');

    Route::get('/kategori', 'FrontController@list_product');
    Route::get('/front_end/getCategory', 'FrontController@getCategory')->name('front.product.getCategory');
    Route::get('/front_end/list_product/category/{id}', 'FrontController@product_category')->name('front.product.product_category');
    //SEO FRIENDLY 
    Route::get('/kategori/{id}/{category}', 'FrontController@product_category_seo')->name('front.product.product_category');
    Route::get('/kategori_profil/{id}/{category}', 'FrontController@product_category_seo_profil')->name('front.product.product_category_profil');


    Route::get('/front_end/list_product/categoryeks/{id}', 'FrontController@product_categoryeks')->name('front.product.product_categoryeks');
    Route::get('/front_end/getManufactur', 'FrontController@getManufactur')->name('front.product.getManufactur');
    Route::get('/front_end/product/{id}', 'FrontController@view_product');
    //SEO FRIENDLY
    Route::get('/produk/{kategori}/{id}/{title}', 'FrontController@view_product_seo');

    //Inquiry Pembeli
    Route::get('/front_end/inquiry_product/{id}', 'InquiryFrontController@create');
    Route::post('front_end/inquiry_act/{id}', 'InquiryFrontController@store');
    Route::get('/front_end/ver_inquiry/{id}', 'InquiryFrontController@verifikasi_inquiry');
    Route::get('/front_end/chat_inquiry/{id}', 'InquiryFrontController@chatting')->name('front.inquiry.chatting');
    Route::post('/front_end/inquiry_chatfile/fileChat', 'InquiryFrontController@fileChat')->name('front.inquiry.fileChat');
    Route::get('/front_end/inquiry_chat/sendChat', 'InquiryFrontController@sendChat')->name('front.inquiry.sendChat');
    Route::get('/front_end/view_inquiry/{id}', 'InquiryFrontController@view')->name('front.inquiry.view');
    //Ticketing Support
    //Eksportir
    Route::get('/front_end/ticketing_support/list', 'TicketingSupportFrontController@index')->name('front.ticket.index');
    Route::get('/front_end/ticketing_support', 'TicketingSupportFrontController@create')->name('front.ticket.create');
    Route::post('/front_end/ticketing_support/store', 'TicketingSupportFrontController@store')->name('front.ticket.store');
    Route::get('/front_end/ticketing_support/chatview/{id}', 'TicketingSupportFrontController@vchat')->name('front.ticket.vchat');
    Route::post('/front_end/ticketing_support/sendchat', 'TicketingSupportFrontController@sendchat')->name('front.ticket.sendchat');
    Route::post('/front_end/ticketing_support/sendFilechat', 'TicketingSupportFrontController@sendFilechat')->name('front.ticket.sendfilechat');
    Route::get('/front_end/ticketing_support/view/{id}', 'TicketingSupportFrontController@view')->name('front.ticket.view');
    Route::get('/front_end/ticketing_support/delete/{id}', 'TicketingSupportFrontController@destroy')->name('front.ticket.delete');
    Route::get('/front_end/ticketing/getData', 'TicketingSupportFrontController@getTicket')->name('ticket_support.getData.seller');
    Route::get('/front_end/ticketing/getDep', 'TicketingSupportFrontController@getDep')->name('ticket_support.getDep.seller');
    Route::get('/front_end/ticketing/changeStatusTicket', 'TicketingSupportFrontController@changestatustiket')->name('ticket_support.changestatus');
    Route::post('/front_end/ticketing_support/add', 'TicketingSupportFrontController@addticket')->name('front.ticket.add');
    Route::post('/front_end/ticketing_support/addanswer', 'TicketingSupportFrontController@addanswer')->name('front.ticket.addanswer');
    Route::get('/front_end/ticketing_support/manage/{id}', 'TicketingSupportFrontController@manage')->name('front.ticket.manage');
    Route::get('/front_end/ticketing_support/convertmili/{timestamp}', 'TicketingSupportFrontController@convertmili')->name('front.ticket.convert');

    // V2
    Route::get('/front_end/ticketing_support/response/{id}/{id_respondent}', 'TicketingSupportFrontController@vchat_v2')->name('front.ticket.vchat_v2');
    Route::post('/front_end/ticketing_support/response/sendchat_v2', 'TicketingSupportFrontController@sendchat_v2')->name('front.ticket.sendchat_v2');
    Route::post('/front_end/ticketing_support/response/sendFilechat_v2', 'TicketingSupportFrontController@sendFilechat_v2')->name('front.ticket.sendfilechat_v2');
    //History Transaction
    Route::get('/front_end/history', 'HistoryFrontController@index')->name('front.histori.index');
    //Ticketing Support
    Route::get('/front_end/history/ticketing_getdata', 'HistoryFrontController@data_ticketing')->name('front.datatables.ticketing');
    //Inquiry
    Route::get('/front_end/history/inquiry_getdata', 'HistoryFrontController@data_inquiry')->name('front.datatables.inquiry');
    //Buying Request
    Route::get('/front_end/history/br_getdata', 'HistoryFrontController@data_br')->name('front.datatables.br');
    //buying new
    Route::get('/front_end/history/br_getdata/new', 'HistoryFrontController@data_br_new')->name('front.datatables.br.new');

    //List Perusahaan (Eksportir)
    Route::get('/front_end/list_perusahaan', 'SuppliersFrontController@list_perusahaan')->name('front.eksportir.index');
    //SEO FRIENDLY
    Route::get('/perusahaan', 'SuppliersFrontController@list_perusahaan')->name('front.eksportir.index');
    Route::get('/suppliers', 'SuppliersFrontController@list_perusahaan')->name('front.eksportir.index');
    Route::get('/change_lg/{id}', 'SuppliersFrontController@change_lg')->name('front.eksportir.change_lg');
    Route::get('/front_end/list_perusahaan/getCategory', 'SuppliersFrontController@getCategory')->name('front.eksportir.getCategory');
    Route::get('/front_end/list_perusahaan/category/{id}', 'SuppliersFrontController@eksportir_category')->name('front.eksportir.category');

    //SEO FRIENDLY
    //Route::get('/perusahaan-kategori/{id}', 'SuppliersFrontController@eksportir_category')->name('front.eksportir.category');
    Route::get('/perusahaan-kategori/{id}/{catname}', 'SuppliersFrontController@eksportir_category_seo')->name('front.eksportir.category_seo');
    Route::get('/perusahaan-kategori-profil/{id}/{catid}/{catname}', 'SuppliersFrontController@eksportir_category_seo_profil')->name('front.eksportir.category_seo_profil');
    Route::get('/front_end/list_perusahaan/view/{id}/{cat?}/{send?}', 'SuppliersFrontController@view_eksportir')->name('front.eksportir.view');
    // Route::post('/certif_modal', 'SuppliersFrontController@certif_modal')->name('certif.modal');

    Route::get('/front_end/listeksportir/cetakpdf/{id}', 'SuppliersFrontController@importPdfEksportir')->name('front.ekspor.print.pdf');
    Route::get('/front_end/listeksportir/cetakpdfnew/{id}', 'SuppliersFrontController@importPdfEksportirFront')->name('front.ekspor.print.pdf.new');

    //addqueri
    Route::get('/br_importir_add/suplaier/{id}', 'SuppliersFrontController@br_importir_add_suplai');
    Route::post('/br_importir_save_new', 'SuppliersFrontController@br_importir_save_new');
    //yoga
    Route::get('/front_end/data-brand/{id}', 'SuppliersFrontController@dataBrand')->name('front.eksportir.data.brand');
    Route::get('/front_end/data-brand-modal/{id}', 'SuppliersFrontController@dataBrandModal')->name('front.eksportir.data.brand_modal');
    Route::get('/front_end/country_patern_brand/{id}', 'SuppliersFrontController@dataCountry')->name('front.eksportir.data.country');
    Route::get('/front_end/country_patern_brand_modal/{id}', 'SuppliersFrontController@dataCountryModal')->name('front.eksportir.data.country_modal');
    Route::get('/front_end/data-procap/{id}', 'SuppliersFrontController@dataProcap')->name('front.eksportir.data.procap');
    Route::get('/front_end/data-capacity/{id}', 'SuppliersFrontController@datacapacity')->name('front.eksportir.data.capacity');
    Route::get('/front_end/data-raw/{id}', 'SuppliersFrontController@dataRaw')->name('front.eksportir.data.raw');
    Route::get('/front_end/data-sales/{id}', 'SuppliersFrontController@dataSales')->name('front.eksportir.data.sales');
    Route::get('/front_end/data-labor/{id}', 'SuppliersFrontController@dataLabor')->name('front.eksportir.data.labor');
    Route::get('/front_end/data-tax/{id}', 'SuppliersFrontController@dataTax')->name('front.eksportir.data.labor');
    Route::get('/front_end/data-desti/{id}', 'SuppliersFrontController@dataDesti')->name('front.eksportir.data.labor');
    Route::get('/front_end/data-portland/{id}', 'SuppliersFrontController@dataPortland')->name('front.eksportir.data.portland');
    Route::get('/front_end/data-exhib/{id}', 'SuppliersFrontController@dataExhib')->name('front.eksportir.data.exhib');
    Route::get('/front_end/data-exhib-modal/{id}', 'SuppliersFrontController@dataExhibModal')->name('front.eksportir.data.exhib_modal');
    Route::get('/front_end/certif_modal', 'SuppliersFrontController@certif_modal')->name('front.eksportir.data.certif_modal');
    Route::get('/front_end/data-training/{id}', 'SuppliersFrontController@dataTraining')->name('front.eksportir.datatables.training');

    //SEO FRIENDLY
    Route::get('/perusahaan/{id}', 'SuppliersFrontController@view_eksportir')->name('front.eksportir.view');


    //List Perwadag (Atase)
    Route::get('/list_perwadag/{tipe}', 'RepresentativeFrontController@index')->name('front.perwadag.index');
    Route::get('/perwakilan_negara/{param}', 'RepresentativeFrontController@country')->name('front.perwadag.country');


    //dew
    Route::get('/support', 'FrontController@indexSupp')->name('front.supp');
    Route::get('/support/data', 'FrontController@dataSupp')->name('front.supp.data');
    Route::get('/support/add', 'FrontController@addSupp')->name('front.supp.add');
    Route::post('/support/data/search', 'FrontController@getdatasupp')->name('front.supp.data.get');
    Route::post('/support/add/act', 'FrontController@addSuppAct')->name('supp.add.act');
    ////////////////////////////////  AeNGeGeA  ///////////////////////////////////////////
    Route::get('/front_end/research-corner', 'FrontController@research_corner');
    Route::get('/front_end/tracking', 'FrontController@tracking');
    Route::get('/about/', 'FrontController@about');
    Route::get('/faq/', 'FrontController@faq');
    Route::get('/contact-us', 'FrontController@contact_us');
    Route::post('/contact-us/send', 'FrontController@contact_us_send');
    Route::get('/front_end/service-detail/{id}', 'FrontController@service');
    Route::get('/profile/getCity/{param}', 'ImporterController@getCity')->name('ajax-city');
    Route::get('/profile/', 'ImporterController@profile')->name('profile');
    Route::post('/profile/update/', 'ImporterController@update')->name('profile.update');
    Route::post('/profile/contact_update/', 'ImporterController@contact_update')->name('profile.contact_update');
    Route::post('/product/hot/', 'FrontController@hot')->name('product.hot');
    Route::get('/product/category-all', 'FrontController@getCategoryAll')->name('front.all-category');
    Route::get('/front_end/test', function () {
        return view('frontend.contoh.content_home');
    });
    ////////////////////////////////  AeNGeGeA  ///////////////////////////////////////////
    /////yoga
    Route::get('/front_end/publication', 'FrontController@index_publication');
    Route::get('/front_end/publication/search', 'FrontController@search_publication');
    Route::get('/front_end/publication/search/side', 'FrontController@search_publication_type');
    /**
     * Createdby Intan Kamelia
     */
    Route::get('/front_end/event', 'FrontController@Event');
    Route::any('/front_end/event/search', 'FrontController@search_event');
    Route::get('/front_end/join_event/{id}', 'FrontController@join_event');
    Route::post('/front_end/check_eksportirproduct', 'FrontController@check_eksportirproduct')->name('check.eksproduct');
    Route::get('/front_end/gabung_event/{id}', 'FrontController@gabung_event');
    Route::post('/event-interest', 'FrontController@event_interest')->name('event.interest');
    Route::post('/daftar-peserta', 'FrontController@daftar_peserta')->name('event.daftar_peserta');

    //YOSS
    //Front End TrainingController
    Route::get('/front_end/training', 'FrontController@indexTraining');
    Route::get('frontend/training/search', 'FrontController@indexTrainingSearch');
    Route::post('/training-interest', 'FrontController@training_interest')->name('training.interest');
    //End Training Frontend
    //our inqueris
    Route::get('/front_end/ourinqueris', 'FrontController@index_queries');
    Route::get('/front_end/ourinqueris/get-id', 'FrontController@getIdProduk')->name('front_end.get.data.id');
    Route::get('/front_end/ourinqueris/search', 'FrontController@search');

    //News
    Route::get('/front_end/news', 'FrontController@index_news');
    Route::post('/front_end/news/search', 'FrontController@search_news');

    //TODO: Business Matching
    //! Created by MNF
    Route::group(['prefix' => 'front_end', 'as' => 'front_end.'], function () {
        Route::get('event_zoom', 'FrontController@event_zoom');
        Route::post('event_zoom/join_event', 'FrontController@join_event_zoom');
    });
});

Route::get('/br_importir_all', 'BRFrontController@br_importir_all');
Route::get('/br_importir', 'BRFrontController@br_importir');
Route::get('/br_importir_add', 'BRFrontController@br_importir_add');
Route::get('/br_select_category/{id}/{id_lv_1?}', 'BRFrontController@br_select_category');
Route::get('/br_importir_detail/{id}', 'BRFrontController@br_importir_detail');
Route::get('/br_importir_dele/{id}', 'BRFrontController@br_importir_dele');
Route::group(['middleware' => ['auth:eksmp']], function () {
    Route::get('/br_importir_lc/{id}', 'BRFrontController@br_importir_lc');
});
Route::get('/br_importir_chat/{id}/{id2}', 'BRFrontController@br_importir_chat');
Route::get('/br_importir_bc/{id}', 'BRFrontController@br_importir_bc');
Route::get('/br_pw_bc/{id}', 'BRFrontController@br_pw_bc');
Route::post('/broadcastbuyingrequest/pw', 'BRFrontController@br_pw_bc_choose_eks')->name('broadcastbuyingrequest.pw');
Route::post('/broadcastbuyingrequest/imp', 'BRFrontController@br_importir_bc_choose_eks')->name('broadcastbuyingrequest.imp');
Route::get('/br_pw_bcs/{id}', 'BRFrontController@br_pw_bcs');
Route::get('/br_konfirm/{id}/{id2}', 'BRFrontController@br_konfirm');
Route::get('/br_konfirm2/{id}/{id2}', 'BRFrontController@br_konfirm2');
Route::get('/refreshchat/{id}/{id2}', 'BRFrontController@refreshchat');
Route::get('/refreshchatnj/{id}', 'BRFrontController@refreshchatnj');
Route::get('/refreshchat2/{id}/{id2}', 'BRFrontController@refreshchat2');
Route::get('/refreshchat3/{id}/{id2}', 'BRFrontController@refreshchat3');
Route::post('/br_importir_save', 'BRFrontController@br_importir_save');
Route::post('/br_importir_update', 'BRFrontController@br_importir_update');
Route::post('/br_importir_next', 'BRFrontController@br_importir_next');
Route::post('/uploadpop', 'BRFrontController@uploadpop');
Route::post('/uploadpop2', 'BRFrontController@uploadpop2');
Route::post('/uploadpop3', 'BRFrontController@uploadpop3');
Route::post('/uploadpop4', 'BRFrontController@uploadpop4');
Route::get('/ambilbroad/{id}', 'BRFrontController@ambilbroad');
Route::get('/ambilbroad2', 'BRFrontController@ambilbroad2');
Route::get('/check_buyer_verification/{id}', 'BRFrontController@check_buyer_verification');
/* Route::get('/registrasi_pembeli/{locale}', function ($locale) {
    App::setLocale($locale);
    return view('auth.register_pembeli');
}); */
Route::post('/simpan_rpembeli', 'RegistrasiController@simpan_rpembeli');
Route::get('/verifypembeli/{id}', 'RegistrasiController@verifypembeli');
Route::get('/br_getdata2', 'RegistrasiController@data_br2')->name('front.datatables.br2');

Route::get('/registrasi_penjual', 'RegistrasiController@registrasi_penjual');
Route::post('/simpan_rpenjual', 'RegistrasiController@simpan_rpenjual');
Route::get('/verifypenjual/{id}', 'RegistrasiController@verifypenjual');

Route::post('/loginei', 'LoginEIController@loginei')->name('loginei.login');
Route::post('check_status', 'LoginEIController@checkstatus')->name('login.check_status');
Route::post('change_status', 'LoginEIController@changestatus')->name('login.change_status');
Route::get('/admin', 'RegistrasiController@loginadmin');
Route::get('/pilihregister', 'RegistrasiController@pilihregister');
Route::get('/createaccount', 'RegistrasiController@pilihregister');
Route::get('/createnewaccount', 'RegistrasiController@pilihregister_new');
Route::get('/client', 'RegistrasiController@addclient');
Route::get('/cekmail/{id}', 'RegistrasiController@cekmail');


//////////////////////////////////// END FRONTEND ////////////////////////////////////////////////////////////
//////////////////////////////////// START BACKEND ////////////////////////////////////////////////////////////

Route::get('/login', 'HomeController@index');
Route::get('/logout-help', 'Auth\LoginController@logout_help')->name('logout-help');
Route::get('/dashboard', 'DashboardController@index');
Route::get('/dashboard-seller', 'DashboardEksportirController@index');
Route::get('/chart/total_member', 'HomeController@chart');
Route::get('/chart/total_rc', 'HomeController@chart_rc');
Route::get('/chart/total_inquiry', 'HomeController@chart_inquiry');
Route::get('/chart/total_buying_request', 'HomeController@chart_buying_req');
Route::get('/chart/total_event', 'HomeController@chart_event');
Route::get('/chart/total_training', 'HomeController@chart_training');
Route::get('/chart/total_rep', 'HomeController@chart_rep');
Route::get('/chart/total_income', 'HomeController@chart_income');
//Verify User 
Route::get('ceknpwp', 'VerifyuserController@ceknpwp');
Route::get('/bacanotif/{id}', 'VerifyuserController@bacanotif');
Route::get('/verifyuser', 'VerifyuserController@index');
Route::post('/verifyuser/delete_multiple', 'VerifyuserController@multipleDeletion');

//member dinas
Route::get('/member', 'VerifyuserController@indexMember');

Route::get('/listactv/{id}', 'VerifyuserController@listactv');
Route::get('/geteksportir', 'VerifyuserController@geteksportir');
Route::get('/verifyimportir', 'VerifyuserController@index2');
Route::get('/verifybuyer-perwadag', 'VerifyuserController@index2');
Route::get('/addbuyer', 'VerifyuserController@addbuyer')->name('addbuyer');
Route::post('/savebuyer', 'VerifyuserController@savebuyer')->name('savebuyer');
Route::get('/addexpor', 'VerifyuserController@addexpor')->name('addexpor');
Route::post('/saveexpor', 'VerifyuserController@saveexpor')->name('saveexpor');
Route::get('/hapuseksportir/{id}', 'VerifyuserController@hapuseksportir');
Route::get('/reseteksportir/{id}', 'VerifyuserController@reseteksportir');
Route::get('/hapusimportir/{id}', 'VerifyuserController@hapusimportir');
Route::get('/resetimportir/{id}', 'VerifyuserController@resetimportir');
Route::get('/getimportir', 'VerifyuserController@getimportir');
Route::get('/profilperwakilan', 'VerifyuserController@index3');
Route::get('/getpw', 'VerifyuserController@getpw');
Route::get('/tambahperwakilan', 'VerifyuserController@tambahperwakilan');
Route::get('/tambahperwakilan/get-benua', 'VerifyuserController@getBenua')->name('tambah.perwakilan.getBenua');
Route::get('/tambahperwakilan/get-country', 'VerifyuserController@getCountry')->name('tambah.perwakilan.getCountry');
Route::get('/detailverify/{id}', 'VerifyuserController@detailverify');
Route::get('/viewperwakilan/{id}', 'VerifyuserController@viewperwakilan');
Route::get('/hapusperwakilan/{id}', 'VerifyuserController@hapusperwakilan');
Route::get('/editperwakilan/{id}', 'VerifyuserController@editperwakilan');
Route::get('/editperwakilans/{id}', 'VerifyuserController@editperwakilans');
Route::get('/saveverify/{id}', 'VerifyuserController@saveverify');
Route::get('/profil/{id}/{id2}', 'VerifyuserController@profil');
Route::get('/profil_front/{id}/{id2}', 'VerifyuserController@profil_front');
Route::get('/profildoc/{id}/{id2}', 'VerifyuserController@profildoc');
Route::get('/profil', 'VerifyuserController@profilb');
Route::get('/profile_supplier', 'VerifyuserController@profilb');
Route::get('/profildoc', 'VerifyuserController@profildocb');
Route::get('/profil2/{id}/{id2}', 'VerifyuserController@profil2');
Route::post('/simpan_profil', 'VerifyuserController@simpan_profil');
Route::post('/simpan_profilb', 'VerifyuserController@simpan_profilb');
Route::post('/simpan_profil_docb', 'VerifyuserController@simpan_dokumenb');
Route::post('/simpan_profil2', 'VerifyuserController@simpan_profil2');
Route::post('/simpanperwakilan', 'VerifyuserController@simpanperwakilan');
Route::post('/updateperwakilan', 'VerifyuserController@updateperwakilan');
Route::post('/updateperwakilans', 'VerifyuserController@updateperwakilans');
Route::post('/simpan_kontak', 'VerifyuserController@simpan_kontak');

// Master Slide
Route::resource('/master-slide', 'Master\MasterSliderController');
Route::get('/tambah-slide', 'Master\MasterSliderController@create');
Route::post('/save-slider', 'Master\MasterSliderController@store');
Route::get('/edit-slide/{id}', 'Master\MasterSliderController@edit');
Route::post('/update-slider', 'Master\MasterSliderController@update');
Route::get('/hapus-slide/{id}', 'Master\MasterSliderController@hapus');


// Group
Route::resource('/group', 'UM\GroupController');
Route::post('/group_save', 'UM\GroupController@store');
Route::get('/group_edit/{id}', 'UM\GroupController@edit');
Route::post('/group_update/{id}', 'UM\GroupController@update');
Route::get('/group_delete/{id}', 'UM\GroupController@destroy');

//user
Route::resource('/users', 'UM\UsersController');
Route::post('/user_save', 'UM\UsersController@store');
Route::get('/user_edit/{id}', 'UM\UsersController@edit');
Route::get('/getem/{id}', 'UM\UsersController@getem');
Route::post('/user_update/{id}', 'UM\UsersController@update');
Route::get('/user_delete/{id}', 'UM\UsersController@destroy');

//menu
Route::resource('/menus', 'UM\MenuController');
Route::get('/menu_add', 'UM\MenuController@create');
Route::post('/menu_save', 'UM\MenuController@store');
Route::get('/menu_edit/{id}', 'UM\MenuController@edit');
Route::post('/menu_update/{id}', 'UM\MenuController@update');
Route::get('/menu_delete/{id}', 'UM\MenuController@destroy');
Route::any('/search_menu', 'UM\MenuController@search_menu');

Route::get('/submenu_add/{id}', 'UM\MenuController@create_submenu');
Route::post('/submenu_save', 'UM\MenuController@store_submenu');
Route::get('/submenu_edit/{id}', 'UM\MenuController@edit_submenu');
Route::post('/submenu_update/{id}', 'UM\MenuController@update_submenu');

//permissions
Route::resource('/permissions', 'UM\PermissionsController');
Route::post('/permission_save', 'UM\PermissionsController@store');
Route::get('/permission_edit/{id}', 'UM\PermissionsController@edit');
Route::post('/permission_update/{id}', 'UM\PermissionsController@update');
Route::get('/permission_delete/{id}', 'UM\PermissionsController@destroy');

//buy request 
Route::resource('/br_list', 'BuyingRequestController');
Route::get('/br_list_message', 'BuyingRequestController@message')->name('br_list.message');
Route::get('/getcscperwakilan', 'BuyingRequestController@getcscperwakilan');
Route::get('/getcsc0', 'BuyingRequestController@getcsc0');
Route::get('/getcsc', 'BuyingRequestController@getcsc');
Route::get('/getcsc3', 'BuyingRequestController@getcsc3');
Route::get('/simpanchatbr/{id}/{id2}/{id3}/{id4}/{id5}/{id6}', 'BuyingRequestController@simpanchatbr');
Route::get('/br_add', 'BuyingRequestController@add');
Route::get('/br_dele/{id}', 'BuyingRequestController@br_dele');
Route::get('/br_dele_new/{id}', 'BuyingRequestController@br_dele_new');
Route::get('/br_pw_lc/{id}', 'BuyingRequestController@br_pw_lc');
Route::get('/br_pw_lc_new/{id}', 'BuyingRequestController@br_pw_lc_new');
Route::get('/br_pw_dt/{id}', 'BuyingRequestController@br_pw_dt');
Route::get('/br_pw_dt_new/{id}', 'BuyingRequestController@br_pw_dt_new');
Route::get('/br_join/{id}', 'BuyingRequestController@br_join');
Route::get('/ourinquiries_join/{id}', 'BuyingRequestController@br_join_public');
Route::get('/br_join_published/{id}', 'BuyingRequestController@br_join_published');
Route::get('/br_pw_chat/{id}', 'BuyingRequestController@br_pw_chat');
Route::get('/br_chat/{id}', 'BuyingRequestController@br_chat');
Route::get('/br_deal/{id}/{id2}/{id3}', 'BuyingRequestController@br_deal');
Route::get('/br_trx/{id}/{id2}', 'BuyingRequestController@br_trx');
Route::get('/br_trx2/{id}', 'BuyingRequestController@br_trx2');
Route::get('/br_save_join/{id}', 'BuyingRequestController@br_save_join');
Route::get('/ambilt2/{id}/{perusahaan?}', 'BuyingRequestController@ambilt2');
Route::get('/ambilt3/{id}/{perusahaan?}', 'BuyingRequestController@ambilt3');
Route::post('/br_save', 'BuyingRequestController@br_save');
Route::post('/br_save_trx', 'BuyingRequestController@br_save_trx');
Route::get('/show_all_notif', 'BuyingRequestController@show_all_notif');
Route::get('/unread_all_notif', 'BuyingRequestController@unread_all_notif');
Route::get('/notification/{id_br_join}', 'BuyingRequestController@notification');
Route::get('/send_mail_supplier/{id}/{type}', 'BuyingRequestController@send_mail_supplier');
Route::get('/send_mail_reminder_supplier/{id}/{id_user}', 'BuyingRequestController@send_mail_reminder_supplier');

//trx 
Route::resource('/trx_list', 'TrxController');
Route::get('/input_transaksi/{id}', 'TrxController@input_transaksi');
Route::post('/save_trx', 'TrxController@save_trx');
Route::get('/br_getdata3', 'TrxController@data_br3')->name('front.datatables.br3');
Route::get('/br_getdata4', 'TrxController@data_br4')->name('front.datatables.br4');
Route::get('/detailtrx/{id}', 'TrxController@detailtrx');
Route::get('/allgr/{id}', 'TrxController@allgr');
Route::get('/joineks/{id}/{id2}', 'TrxController@joineks');
Route::get('/caritab/{id}/{id2}', 'TrxController@caritab');
Route::get('/cetaktrx/{id}/{id2}', 'TrxController@cetaktrx');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/gantipass', 'HomeController@gantipass');
Route::post('/updatepass', 'HomeController@updatepass');
Route::get('/get-notif-modal', 'HomeController@get_notif_modal')->name('home.get_notif_modal');

Route::get('/directory/', 'DirectoryController@index')->name('directory.index');
Route::post('/directory/getData/', 'DirectoryController@getData')->name('directory.getData');
Route::get('/directory/view/{id}', 'DirectoryController@view')->name('directory.view');

Route::get('/user-guide/', 'HomeController@user_guide')->name('user-guide.index');
Route::get('/user-guide/getData', 'HomeController@user_guide_data')->name('user-guide.getData');
Route::post('/user-guide/update', 'HomeController@user_guide_update')->name('user-guide.update');

//Tutorial for Buyer, Supplier, Perwakilan Luar Negeri, Dinas
Route::get('/tutorial', 'TutorialController@index');

Route::namespace('Master')->group(function () {
    // Angga Start
    //Master Country
    Route::prefix('master-country')->group(function () {
        Route::name('master.country.')->group(function () {
            Route::get('/', 'MasterCountryController@index')->name('index');
            Route::get('/getData/', 'MasterCountryController@getData')->name('getData');
            Route::get('/create/', 'MasterCountryController@create')->name('create');
            Route::get('/check-kode/', 'MasterCountryController@check')->name('kode');
            Route::get('/edit/{id}', 'MasterCountryController@edit')->name('edit');
            Route::get('/view/{id}', 'MasterCountryController@view')->name('view');
            Route::post('/store/{param}', 'MasterCountryController@store')->name('store');
            Route::get('/destroy/{id}', 'MasterCountryController@destroy')->name('destroy');
            Route::get('/export/', 'MasterCountryController@export')->name('export');
        });
    });

    //Master City
    Route::prefix('master-city')->group(function () {
        Route::name('master.city.')->group(function () {
            Route::get('/', 'MasterCityController@index')->name('index');
            Route::get('/getData/', 'MasterCityController@getData')->name('getData');
            Route::get('/create/', 'MasterCityController@create')->name('create');
            Route::get('/edit/{id}', 'MasterCityController@edit')->name('edit');
            Route::get('/view/{id}', 'MasterCityController@view')->name('view');
            Route::post('/store/{param}', 'MasterCityController@store')->name('store');
            Route::get('/destroy/{id}', 'MasterCityController@destroy')->name('destroy');
            Route::get('/export/', 'MasterCityController@export')->name('export');
        });
    });

    //Master Province
    Route::prefix('master-province')->group(function () {
        Route::name('master.province.')->group(function () {
            Route::get('/', 'MasterProvinceController@index')->name('index');
            Route::get('/getData/', 'MasterProvinceController@getData')->name('getData');
            Route::get('/create/', 'MasterProvinceController@create')->name('create');
            Route::get('/check-kode/', 'MasterProvinceController@check')->name('kode');
            Route::get('/edit/{id}', 'MasterProvinceController@edit')->name('edit');
            Route::get('/view/{id}', 'MasterProvinceController@view')->name('view');
            Route::post('/store/{param}', 'MasterProvinceController@store')->name('store');
            Route::get('/destroy/{id}', 'MasterProvinceController@destroy')->name('destroy');
            Route::get('/export/', 'MasterProvinceController@export')->name('export');
        });
    });

    //Master Port
    Route::prefix('master-port')->group(function () {
        Route::name('master.port.')->group(function () {
            Route::get('/', 'MasterPortController@index')->name('index');
            Route::get('/getData/', 'MasterPortController@getData')->name('getData');
            Route::get('/create/', 'MasterPortController@create')->name('create');
            Route::get('/check-kode/', 'MasterPortController@check')->name('kode');
            Route::get('/edit/{id}', 'MasterPortController@edit')->name('edit');
            Route::get('/view/{id}', 'MasterPortController@view')->name('view');
            Route::post('/store/{param}', 'MasterPortController@store')->name('store');
            Route::get('/destroy/{id}', 'MasterPortController@destroy')->name('destroy');
            Route::get('/export/', 'MasterPortController@export')->name('export');
        });
    });

    // MASTER BANNER FROM KHOLIL
    Route::prefix('master-banner')->group(function () {
        Route::name('master.banner.')->group(function () {
            Route::get('/', 'MasterBannerController@index')->name('index');
            Route::post('/getData/', 'MasterBannerController@getData')->name('getData');
            Route::get('/create/', 'MasterBannerController@create')->name('create');
            Route::post('/store/{param}', 'MasterBannerController@store')->name('store');
            Route::get('/message', 'MasterBannerController@message')->name('message');
            Route::post('/getCompany/', 'MasterBannerController@getCompany')->name('getCompany');
            Route::post('/getCompany2/', 'MasterBannerController@getCompany2')->name('getCompany2');
            Route::get('/check-kode/', 'MasterBannerController@check')->name('kode');
            Route::get('/edit/{id}', 'MasterBannerController@edit')->name('edit');
            Route::get('/view/{id}', 'MasterBannerController@view')->name('view');
            Route::get('/destroy/{id}', 'MasterBannerController@destroy')->name('destroy');
            Route::get('/export/', 'MasterBannerController@export')->name('export');
            Route::post('/savecompanylain/', 'MasterBannerController@addcompanylain')->name('savecompanylain');
            Route::post('/deletecompanylain/', 'MasterBannerController@destroycompanylain')->name('deletecompanylain');
            // Route::post('/deletecompanylain2/', 'MasterBannerController@destroycompanylain')->name('deletecompanylain2');
        });
    });
    // Angga End

    //TODO:: Mahmuddin
    Route::prefix('event-organizer')->group(function () {
        Route::name('master.event_organizer.')->group(function () {
            Route::get('/', 'EventOrganizerController@index')->name('index');
            Route::post('/getData/', 'EventOrganizerController@getData')->name('getData');
            Route::get('/create', 'EventOrganizerController@create')->name('create');
            Route::post('/store/{param}', 'EventOrganizerController@store')->name('store');
            Route::get('/view/{id}', 'EventOrganizerController@view')->name('view');
            Route::get('/edit/{id}', 'EventOrganizerController@edit')->name('edit');
            Route::get('/destroy/{id}', 'EventOrganizerController@destroy')->name('destroy');
        });
    });
    Route::prefix('event-place')->group(function () {
        Route::name('master.event_place.')->group(function () {
            Route::get('/', 'EventPlaceController@index')->name('index');
            Route::post('/getData/', 'EventPlaceController@getData')->name('getData');
            Route::get('/create', 'EventPlaceController@create')->name('create');
            Route::post('/store/{param}', 'EventPlaceController@store')->name('store');
            Route::get('/view/{id}', 'EventPlaceController@view')->name('view');
            Route::get('/edit/{id}', 'EventPlaceController@edit')->name('edit');
            Route::get('/destroy/{id}', 'EventPlaceController@destroy')->name('destroy');
        });
    });

    Route::prefix('link-tutorial')->group(function () {
        Route::name('master.link_tutorial.')->group(function () {
            Route::get('/', 'LinkTutorialController@index')->name('index');
            Route::post('/getData/', 'LinkTutorialController@getData')->name('getData');
            Route::get('/create', 'LinkTutorialController@create')->name('create');
            Route::post('/store/{param}', 'LinkTutorialController@store')->name('store');
            Route::get('/view/{id}', 'LinkTutorialController@view')->name('view');
            Route::get('/edit/{id}', 'LinkTutorialController@edit')->name('edit');
            Route::get('/destroy/{id}', 'LinkTutorialController@destroy')->name('destroy');
        });
    });

    //TODO:: End of Mahmuddin
});

Route::namespace('Management')->group(function () {
    // Angga Start
    //Management Category Product
    Route::prefix('management/category-product')->group(function () {
        Route::name('management.category-product.')->group(function () {
            Route::get('/', 'CategoryProductController@index')->name('index');
            Route::get('/getData/', 'CategoryProductController@getData')->name('getData');
            Route::get('/create/', 'CategoryProductController@create')->name('create');
            Route::get('/edit/{id}', 'CategoryProductController@edit')->name('edit');
            Route::get('/view/{id}', 'CategoryProductController@view')->name('view');
            Route::get('/level_2/', 'CategoryProductController@level_2')->name('level2');
            Route::post('/store/{param}', 'CategoryProductController@store')->name('store');
            Route::get('/destroy/{id}', 'CategoryProductController@destroy')->name('destroy');
            Route::post('/home/', 'CategoryProductController@home')->name('home');
            Route::get('/home/level_2/', 'CategoryProductController@level_2_home')->name('home.level2');
        });
    });

    //Management Contact Us
    Route::prefix('management/contact-us')->group(function () {
        Route::name('management.contact-us.')->group(function () {
            Route::get('/', 'DataContactUsController@index')->name('index');
            Route::get('/getData/', 'DataContactUsController@getData')->name('getData');
            Route::get('/view/{id}', 'DataContactUsController@view')->name('view');
            Route::get('/destroy/{id}', 'DataContactUsController@destroy')->name('destroy');
        });
    });
    // Angga End
});
Route::namespace('Newsletter')->prefix('newsletter')->name('newsletter.')->group(function () {
    // Angga Start
    Route::get('/', 'NewsletterController@index')->name('index');
    Route::get('/getData', 'NewsletterController@getData')->name('getData');
    // Route::get('/getDataCompany', 'NewsletterController@getDataCompany')->name('getDataCompany');
    Route::get('/create/', 'NewsletterController@create')->name('create');
    Route::get('/edit/{id}', 'NewsletterController@edit')->name('edit');
    Route::get('/view/{id}', 'NewsletterController@view')->name('view');
    Route::post('/store/{param}', 'NewsletterController@store')->name('store');
    Route::get('/destroy/{id}', 'NewsletterController@destroy')->name('destroy');
    Route::post('/broadcast/', 'NewsletterController@broadcast')->name('broadcast');
    Route::get('/unsubscribe/{id}', 'NewsletterController@unsubscribe')->name('unsubscribe');
    Route::post('/toggle/', 'NewsletterController@toggleCompany')->name('toggleCompany');
    // Angga End
});

//News
Route::namespace('News')->prefix('news')->name('news.')->group(function () {
    Route::get('/', 'NewsController@index')->name('index');
    Route::get('/getData', 'NewsController@getData')->name('getData');
    Route::get('/create/', 'NewsController@create')->name('create');
    Route::get('/edit/{id}', 'NewsController@edit')->name('edit');
    Route::get('/view/{id}', 'NewsController@view')->name('view');
    Route::get('/destroy/{id}', 'NewsController@destroy')->name('destroy');
    Route::post('/store/{param}', 'NewsController@store')->name('store');
});

//Timme
Route::namespace('LocalTime')->prefix('localtime')->name('localtime.')->group(function () {
    Route::get('/', 'TimeController@index')->name('index');
    Route::get('/getData', 'TimeController@getData')->name('getData');
    Route::get('/edit/{id}', 'TimeController@edit')->name('edit');
    Route::get('/view/{id}', 'TimeController@view')->name('view');
    Route::post('/change', 'TimeController@change')->name('change');
});

//Activity Supplier
Route::namespace('ActivitySupplier')->prefix('activity-supplier')->name('activity.')->group(function () {
    Route::get('/', 'ActivitySupplierController@index')->name('index');
    Route::get('/getData', 'ActivitySupplierController@getData')->name('getData');
    Route::get('/email-peringatan/{id}', 'ActivitySupplierController@emailPeringatan')->name('peringatan');
    Route::get('/email-banned/{id}', 'ActivitySupplierController@emailBanned')->name('banned');
    Route::get('/view/{id}', 'ActivitySupplierController@view')->name('view');
});

//Slideshow
Route::namespace('Slideshows')->prefix('slideshows')->name('slideshows.')->group(function () {
    Route::get('/', 'SlideshowsController@index')->name('index');
    Route::get('/getData', 'SlideshowsController@getData')->name('getData');
    Route::get('/create/', 'SlideshowsController@create')->name('create');
    Route::get('/edit/{id}', 'SlideshowsController@edit')->name('edit');
    Route::get('/view/{id}', 'SlideshowsController@view')->name('view');
    Route::get('/destroy/{id}', 'SlideshowsController@destroy')->name('destroy');
    Route::post('/store/{param}', 'SlideshowsController@store')->name('store');
});
//yoga publik
Route::prefix('publication')->name('publication.')->group(function () {
    Route::get('/', 'PublicController@index')->name('index');
    Route::get('/edit-data/{id}', 'PublicController@index_update')->name('index.update');
    Route::get('/create/', 'PublicController@index_create')->name('create');
    Route::post('/edit', 'PublicController@edit')->name('edit');
    Route::get('/view/{id}', 'PublicController@view')->name('view');
    Route::get('/destroy/{id}', 'PublicController@destroy')->name('destroy');
    Route::post('/store', 'PublicController@store')->name('store');
});

Route::namespace('ResearchCorner')->group(function () {
    // Angga Start
    Route::prefix('admin/research-corner')->group(function () {
        Route::name('admin.research-corner.')->group(function () {
            Route::get('/', 'AdminResearchController@index')->name('index');
            Route::get('/getData/', 'AdminResearchController@getData')->name('getData');
            Route::get('/getDataDownload/{id}', 'AdminResearchController@getDataDownload')->name('getDataDownload');
            Route::get('/create/', 'AdminResearchController@create')->name('create');
            Route::post('/store/{param}', 'AdminResearchController@store')->name('store');
            Route::get('/edit/{id}', 'AdminResearchController@edit')->name('edit');
            Route::get('/view/{id}', 'AdminResearchController@view')->name('view');
            Route::get('/destroy/{id}', 'AdminResearchController@destroy')->name('destroy');
            Route::post('/broadcast/', 'AdminResearchController@broadcast')->name('broadcast');
            Route::get('/hscode', 'AdminResearchController@hscode')->name('hscode');
        });
    });
    Route::prefix('perwakilan/research-corner')->group(function () {
        Route::name('perwakilan.research-corner.')->group(function () {
            Route::get('/', 'PerwakilanResearchController@index')->name('index');
            Route::get('/getData/', 'PerwakilanResearchController@getData')->name('getData');
            Route::get('/getDataDownload/{id}', 'PerwakilanResearchController@getDataDownload')->name('getDataDownload');
            Route::get('/create/', 'PerwakilanResearchController@create')->name('create');
            Route::post('/store/{param}', 'PerwakilanResearchController@store')->name('store');
            Route::get('/edit/{id}', 'PerwakilanResearchController@edit')->name('edit');
            Route::get('/view/{id}', 'PerwakilanResearchController@view')->name('view');
            Route::get('/destroy/{id}', 'PerwakilanResearchController@destroy')->name('destroy');
            Route::post('/broadcast/', 'PerwakilanResearchController@broadcast')->name('broadcast');
        });
    });
    Route::prefix('research-corner')->group(function () {
        Route::name('research-corner.')->group(function () {
            Route::get('/list/', 'ResearchCornerController@index')->name('index');
            Route::get('/getData/', 'ResearchCornerController@getData')->name('getData');
            Route::get('/read/{id}', 'ResearchCornerController@read')->name('view');
            Route::get('/download/', 'ResearchCornerController@download')->name('download');
        });
    });
    // Angga End
});


/**
 * Createdby Intan Kamelia
 */
Route::namespace('Event')->prefix('event')->group(function () {
    Route::get('/', 'EventController@index');
    Route::get('/comodity', 'EventController@comodity')->name('event.comodity');
    Route::get('/create', 'EventController@create');
    Route::post('/store', 'EventController@store');
    Route::post('/bcevent', 'EventController@bcevent');
    Route::get('/edit/{id}', 'EventController@edit');
    Route::post('/update/{id}', 'EventController@update');
    Route::get('/delete/{id}', 'EventController@delete');
    Route::get('/show_company/{id}', 'EventController@show_company');
    Route::get('/show/read/{id}', 'EventController@show');
    Route::get('/show_detail/{id}', 'EventController@show_detail');
    Route::get('/show_detail/front/{id}', 'EventController@show_detail');
    Route::any('/search', 'EventController@search');
    Route::any('/search_eksportir', 'EventController@search_eksportir');
    Route::get('/getDataInterest/{id}', 'EventController@getDataInterest')->name('event.getDataInterest');
    Route::get('/getParticipants', 'EventController@getParticipants')->name('event.getParticipants');
    Route::get('/export_participants', 'EventController@export_participants')->name('event.export_participants');

    Route::post('/getEventOrg', 'EventController@getEventOrg');
    Route::post('/getEventPlace', 'EventController@getEventPlace');
    Route::post('/update_status_join', 'EventController@updatestatjoin');
    Route::post('/update_status_ver', 'EventController@updatestatver');
    Route::post('/store_company', 'EventController@store_company');
    Route::post('/update_status_company', 'EventController@updatestatcompany');
});


/////////////////////////////////////////ILYAS START//////////////////////////////////////////////////////////////////////////////////
Route::namespace('Eksportir')->prefix('eksportir')->group(function () {
    //admin all
    Route::get('/admin', 'AnnualController@indexadmin')->name('eksportir.indexadmin');
    Route::any('/admin/search', 'AnnualController@search');
    Route::any('/admin/perwadag_search', 'AnnualController@perwadag_search');
    Route::any('/admin/dinas_search', 'AnnualController@dinas_search');
    Route::get('/front_end/event', 'FrontController@Event');
    Route::get('/buyer/admin', 'AnnualController@perwakilanBuyerIndex')->name('buyer.indexadmin');
    Route::any('buyer/admin/search', 'AnnualController@searchBuyer');
    // Route::get('/admin', 'AnnualController@indexadminNew')->name('eksportir.indexadmin');
    Route::get('/getreporteksportir', 'AnnualController@getreporteksportir')->name('datatables.reporteksportir');
    Route::get('/listeksportir/{id}', 'AnnualController@listeksportir');
    Route::get('/listeksportir/cetakpdf/{id}', 'AnnualController@printpdfeksportir');

    //Annual SALES USER
    Route::get('/annual_sales', 'AnnualController@index')->name('annual_sales.index');
    Route::get('/tambah_annual', 'AnnualController@tambah');
    Route::post('/annual_save', 'AnnualController@store');
    Route::get('/sales_getdata', 'AnnualController@datanya')->name('datatables.sales');
    Route::get('/sales_edit/{id}', 'AnnualController@edit')->name('sales.detail');
    Route::get('/sales_view/{id}', 'AnnualController@view')->name('sales.view');
    Route::get('/sales_delete/{id}', 'AnnualController@delete')->name('sales.delete');
    Route::post('/sales_update', 'AnnualController@update');

    //ADMIN
    Route::get('/annual_sales_admin/{id}', 'AnnualController@indexadminannualsales')->name('annual_sales.indexadmin');
    Route::get('/sales_getdata_admin/{id}', 'AnnualController@datanyaadmin');

    //Brand USER
    Route::get('/brand', 'BrandController@index')->name('brand.index');
    Route::get('/tambah_brand', 'BrandController@tambah');
    Route::post('/brand_save', 'BrandController@store');
    Route::get('/brand_getdata', 'BrandController@datanya')->name('datatables.brand');
    Route::get('/brand_edit/{id}', 'BrandController@edit')->name('brand.detail');
    Route::get('/brand_view/{id}', 'BrandController@view')->name('brand.view');
    Route::get('/brand_delete/{id}', 'BrandController@delete')->name('brand.delete');
    Route::post('/brand_update', 'BrandController@update');

    //Size USER
    Route::get('/size', 'SizeController@index')->name('size.index');
    Route::get('/tambah_size', 'SizeController@tambah');
    Route::post('/size_save', 'SizeController@store');
    Route::get('/size_getdata', 'SizeController@datanya')->name('datatables.size');
    Route::get('/size_edit/{id}', 'SizeController@edit')->name('size.detail');
    Route::get('/size_view/{id}', 'SizeController@view')->name('size.view');
    Route::get('/size_delete/{id}', 'SizeController@delete')->name('size.delete');
    Route::post('/size_update', 'SizeController@update');

    //ADMIN
    Route::get('/brand_admin/{id}', 'BrandController@indexadmin')->name('brand.indexadmin');
    Route::get('/brand_getdata_admin/{id}', 'BrandController@datanyaadmin')->name('datatables.brandadmin');

    //country patern brand
    Route::get('/country_patern_brand', 'CountryPaternBrandController@index')->name('country_patern_brand.index');
    Route::get('/tambah_country_patern_brand', 'CountryPaternBrandController@tambah');
    Route::post('/country_patern_brand_save', 'CountryPaternBrandController@store');
    Route::get('/country_patern_brand_getdata', 'CountryPaternBrandController@datanya')->name('datatables.country_patern_brand');
    Route::get('/country_patern_brand_edit/{id}', 'CountryPaternBrandController@edit')->name('country_patern_brand.detail');
    Route::get('/country_patern_brand_view/{id}', 'CountryPaternBrandController@view')->name('country_patern_brand.view');
    Route::get('/country_patern_brand_delete/{id}', 'CountryPaternBrandController@delete')->name('country_patern_brand.delete');
    Route::post('/country_patern_brand_update', 'CountryPaternBrandController@update');

    //ADMIN
    Route::get('/country_patern_brand_admin/{id}', 'CountryPaternBrandController@indexadmin')->name('country_patern_brand.indexadmin');
    Route::get('/country_patern_brand_getdata_admin/{id}', 'CountryPaternBrandController@datanyaadmin')->name('datatables.country_patern_brandadmin');

    //production capacity
    Route::get('/product_capacity', 'ProcapController@index')->name('brand.index');
    Route::get('/tambah_procap', 'ProcapController@tambah');
    Route::post('/procap_save', 'ProcapController@store');
    Route::get('/procap_getdata', 'ProcapController@datanya')->name('datatables.procap');
    Route::get('/procap_edit/{id}', 'ProcapController@edit')->name('procap.detail');
    Route::get('/procap_view/{id}', 'ProcapController@view')->name('procap.view');
    Route::get('/procap_delete/{id}', 'ProcapController@delete')->name('procap.delete');
    Route::post('/procap_update', 'ProcapController@update');

    //ADMIN
    Route::get('/product_capacity_admin/{id}', 'ProcapController@indexadmin')->name('product_capacity.indexadmin');
    Route::get('/product_capacity_getdata_admin/{id}', 'ProcapController@datanyaadmin')->name('datatables.product_capacity');


    //contact USER
    Route::get('/contact', 'ContactController@index')->name('contact.index');
    Route::get('/tambah_contact', 'ContactController@tambah');
    Route::post('/contact_save', 'ContactController@store');
    Route::get('/contact_getdata', 'ContactController@datanya')->name('datatables.contact');
    Route::get('/contact_edit/{id}', 'ContactController@edit')->name('contact.detail');
    Route::get('/contact_view/{id}', 'ContactController@view')->name('contact.view');
    Route::get('/contact_delete/{id}', 'ContactController@delete')->name('contact.delete');
    Route::post('/contact_update', 'ContactController@update');

    //ADMIN
    Route::get('/contact_admin/{id}', 'ContactController@indexadmin')->name('contact.indexadmin');
    Route::get('/contact_getdata_admin/{id}', 'ContactController@datanyaadmin')->name('datatables.contactadmin');

    //export destination
    Route::get('/export_destination', 'ExsdesController@index')->name('exportdes.index');
    Route::get('/tambah_export_destination', 'ExsdesController@tambah');
    Route::post('/exdes_save', 'ExsdesController@store');
    Route::get('/exdes_getdata', 'ExsdesController@datanya')->name('datatables.exdes');
    Route::get('/exdes_edit/{id}', 'ExsdesController@edit')->name('exdes.detail');
    Route::get('/exdes_view/{id}', 'ExsdesController@view')->name('exdes.view');
    Route::get('/exdes_delete/{id}', 'ExsdesController@delete')->name('exdes.delete');
    Route::post('/exdes_update', 'ExsdesController@update');

    //ADMIN
    Route::get('/export_destination_admin/{id}', 'ExsdesController@indexadmin')->name('export_destination.indexadmin');
    Route::get('/export_destination_getdata_admin/{id}', 'ExsdesController@datanyaadmin');

    //port landing
    Route::get('/portland', 'PortlandController@index')->name('portland.index');
    Route::get('/tambah_portland', 'PortlandController@tambah');
    Route::post('/portland_save', 'PortlandController@store');
    Route::get('/portland_getdata', 'PortlandController@datanya')->name('datatables.portland');
    Route::get('/portland_edit/{id}', 'PortlandController@edit')->name('portland.detail');
    Route::get('/portland_view/{id}', 'PortlandController@view')->name('portland.view');
    Route::get('/portland_delete/{id}', 'PortlandController@delete')->name('portland.delete');
    Route::post('/portland_update', 'PortlandController@update');

    //ADMIN
    Route::get('/portland_admin/{id}', 'PortlandController@indexadmin')->name('export_destination.indexadmin');
    Route::get('/portland_getdata_admin/{id}', 'PortlandController@datanyaadmin');

    //exhibition
    Route::get('/exhibition', 'ExhibitionController@index')->name('exhibition.index');
    Route::get('/tambah_exhibition', 'ExhibitionController@tambah');
    Route::post('/exhibition_save', 'ExhibitionController@store');
    Route::get('/exhibition_getdata', 'ExhibitionController@datanya')->name('datatables.exhibition');
    Route::get('/exhibition_edit/{id}', 'ExhibitionController@edit')->name('exhibition.detail');
    Route::get('/exhibition_view/{id}', 'ExhibitionController@view')->name('exhibition.view');
    Route::get('/exhibition_delete/{id}', 'ExhibitionController@delete')->name('exhibition.delete');
    Route::post('/exhibition_update', 'ExhibitionController@update');
    Route::get('/carievent', 'ExhibitionController@loadP');

    //ADMIN
    Route::get('/exhibition_admin/{id}', 'ExhibitionController@indexadmin')->name('exhibition.indexadmin');
    Route::get('/exhibition_getdata_admin/{id}', 'ExhibitionController@datanyaadmin');

    //capacity utilization USER
    Route::get('/capulti', 'CapultiController@index')->name('capulti.index');
    Route::get('/tambah_capulti', 'CapultiController@tambah');
    Route::post('/capulti_save', 'CapultiController@store');
    Route::get('/capulti_getdata', 'CapultiController@datanya')->name('datatables.capulti');
    Route::get('/capulti_edit/{id}', 'CapultiController@edit')->name('capulti.detail');
    Route::get('/capulti_view/{id}', 'CapultiController@view')->name('capulti.view');
    Route::get('/capulti_delete/{id}', 'CapultiController@delete')->name('capulti.delete');
    Route::post('/capulti_update', 'CapultiController@update');

    //ADMIN
    Route::get('/capulti_admin/{id}', 'CapultiController@indexadmin')->name('capulti.indexadmin');
    Route::get('/capulti_getdata_admin/{id}', 'CapultiController@datanyaadmin');

    //raw material
    Route::get('/rawmaterial', 'RawmaterialController@index')->name('rawmaterial.index');
    Route::get('/tambah_rawmaterial', 'RawmaterialController@tambah');
    Route::post('/rawmaterial_save', 'RawmaterialController@store');
    Route::get('/rawmaterial_getdata', 'RawmaterialController@datanya')->name('datatables.rawmaterial');
    Route::get('/rawmaterial_edit/{id}', 'RawmaterialController@edit')->name('rawmaterial.detail');
    Route::get('/rawmaterial_view/{id}', 'RawmaterialController@view')->name('rawmaterial.view');
    Route::get('/rawmaterial_delete/{id}', 'RawmaterialController@delete')->name('rawmaterial.delete');
    Route::post('/rawmaterial_update', 'RawmaterialController@update');

    //ADMIN
    Route::get('/rawmaterial_admin/{id}', 'RawmaterialController@indexadmin');
    Route::get('/rawmaterial_getdata_admin/{id}', 'RawmaterialController@datanyaadmin');

    //labor
    Route::get('/labor', 'LaborController@index')->name('brand.index');
    Route::get('/tambah_labor', 'LaborController@tambah');
    Route::post('/labor_save', 'LaborController@store');
    Route::get('/labor_getdata', 'LaborController@datanya')->name('datatables.labor');
    Route::get('/labor_edit/{id}', 'LaborController@edit')->name('labor.detail');
    Route::get('/labor_view/{id}', 'LaborController@view')->name('labor.view');
    Route::get('/labor_delete/{id}', 'LaborController@delete')->name('labor.delete');
    Route::post('/labor_update', 'LaborController@update');

    //ADMIN
    Route::get('/labor_admin/{id}', 'LaborController@indexadmin');
    Route::get('/labor_getdata_admin/{id}', 'LaborController@datanyaadmin');

    //consultan
    Route::get('/consultan', 'ConsultanController@index')->name('consultan.index');
    Route::get('/tambah_consultan', 'ConsultanController@tambah');
    Route::post('/consultan_save', 'ConsultanController@store');
    Route::get('/consultan_getdata', 'ConsultanController@datanya')->name('datatables.consultan');
    Route::get('/consultan_edit/{id}', 'ConsultanController@edit')->name('consultan.detail');
    Route::get('/consultan_view/{id}', 'ConsultanController@view')->name('consultan.view');
    Route::get('/consultan_delete/{id}', 'ConsultanController@delete')->name('consultan.delete');
    Route::post('/consultan_update', 'ConsultanController@update');

    //certificate eksportir
    Route::get('/certificate', 'CertificateController@index')->name('index');
    Route::get('/certificate_getData', 'CertificateController@getData')->name('certificate.getData');
    Route::get('/certificate_create/', 'CertificateController@create')->name('certificate.create');
    Route::get('/certificate_edit/{id}', 'CertificateController@edit')->name('certificate.edit');
    Route::get('/certificate_view/{id}', 'CertificateController@view')->name('certificate.view');
    Route::get('/certificate_destroy/{id}', 'CertificateController@destroy')->name('certificate.destroy');
    Route::post('/certificate_store/{param}', 'CertificateController@store')->name('certificate.store');

    //certificate Product eksportir
    Route::get('/certificatepro', 'CertificateProController@index')->name('index');
    Route::get('/certificatepro_getData', 'CertificateProController@getData')->name('certificatepro.getData');
    Route::get('/certificatepro_create/', 'CertificateProController@create')->name('certificatepro.create');
    Route::get('/certificatepro_edit/{id}', 'CertificateProController@edit')->name('certificatepro.edit');
    Route::get('/certificatepro_view/{id}', 'CertificateProController@view')->name('certificatepro.view');
    Route::get('/certificatepro_destroy/{id}', 'CertificateProController@destroy')->name('certificatepro.destroy');
    Route::post('/certificatepro_store/{param}', 'CertificateProController@store')->name('certificatepro.store');

    //ADMIN
    Route::get('/consultan_admin/{id}', 'ConsultanController@indexadmin');
    Route::get('/consultan_getdata_admin/{id}', 'ConsultanController@datanyaadmin');

    //training
    Route::get('/training', 'TrainingController@index')->name('training.index');
    Route::get('/tambah_training', 'TrainingController@tambah');
    Route::post('/training_save', 'TrainingController@store');
    Route::get('/training_getdata', 'TrainingController@datanya')->name('datatables.training');
    Route::get('/training_edit/{id}', 'TrainingController@edit')->name('training.detail');
    Route::get('/training_view/{id}', 'TrainingController@view')->name('training.vieweksportir');
    Route::get('/training_delete/{id}', 'TrainingController@delete')->name('training.delete');
    Route::post('/training_update', 'TrainingController@update');

    //ADMIN
    Route::get('/training_admin/{id}', 'TrainingController@indexadmin');
    Route::get('/training_getdata_admin/{id}', 'TrainingController@datanyaadmin');

    //tax
    Route::get('/taxes', 'TaxesController@index')->name('taxes.index');
    Route::get('/tambah_taxes', 'TaxesController@tambah');
    Route::post('/taxes_save', 'TaxesController@store');
    Route::get('/taxes_getdata', 'TaxesController@datanya')->name('datatables.taxes');
    Route::get('/taxes_edit/{id}', 'TaxesController@edit')->name('taxes.detail');
    Route::get('/taxes_view/{id}', 'TaxesController@view')->name('taxes.view');
    Route::get('/taxes_delete/{id}', 'TaxesController@delete')->name('taxes.delete');
    Route::post('/taxes_update', 'TaxesController@update');

    //ADMIN
    Route::get('/taxes_admin/{id}', 'TaxesController@indexadmin');
    Route::get('/taxes_getdata_admin/{id}', 'TaxesController@datanyaadmin');

    //Meidi
    //Product
    Route::get('/product_admin/{id}', 'EksProductController@index_admin')->name('eksproduct.index_admin');
    Route::get('/product_unverif', 'EksProductController@product_unverif')->name('eksproduct.product_unverif');
    Route::get('/product', 'EksProductController@index')->name('eksproduct.index');
    Route::get('/product_getdata_admin/{id}', 'EksProductController@datanya_admin')->name('datatables.eksproduct_admin');
    Route::get('/product_getdata_admin_un/{id}', 'EksProductController@datanya_admin_un')->name('datatables.eksproduct_admin_un');
    Route::get('/product_getdata', 'EksProductController@datanya')->name('datatables.eksproduct');
    Route::get('/getsub/', 'EksProductController@getSub')->name('eksproduct.getSub');
    Route::get('/searchsub/', 'EksProductController@searchsub')->name('eksproduct.searchsub');
    Route::get('/getHsCode/', 'EksProductController@getHsCode')->name('eksproduct.getHsCode');
    Route::get('/tambah_product', 'EksProductController@tambah');
    Route::post('/product_save', 'EksProductController@store');
    Route::get('/product_view/{id}', 'EksProductController@view')->name('eksproduct.view');
    Route::get('/product_edit/{id}', 'EksProductController@edit')->name('eksproduct.edit');
    Route::post('/product_update/{id}', 'EksProductController@update');
    Route::get('/product_delete/{id}', 'EksProductController@delete')->name('eksproduct.delete');
    Route::get('/verifikasi_product/{id}', 'EksProductController@verifikasi')->name('eksproduct.verifikasi');
    Route::post('/actver_product/{id}', 'EksProductController@verifikasi_act')->name('eksproduct.verifikasi_act');

    // Rekomendasi Kategori
    Route::post('/recommended-category', 'EksProductController@getKategori')->name('product-category.recommendation');

    //Angga
    //Service
    Route::prefix('service')->group(function () {
        Route::name('service.')->group(function () {
            Route::get('/', 'ServiceController@index')->name('index');
            Route::get('/admin/{id}', 'ServiceController@index_admin')->name('index_admin');
            Route::get('/getData/{id}', 'ServiceController@getData')->name('getData');
            Route::get('/create/', 'ServiceController@create')->name('create');
            Route::get('/edit/{id}', 'ServiceController@edit')->name('edit');
            Route::get('/view/{id}', 'ServiceController@view')->name('view');
            Route::post('/store/', 'ServiceController@store')->name('store');
            Route::post('/update/{id}', 'ServiceController@update')->name('update');
            Route::get('/destroy/{id}', 'ServiceController@destroy')->name('destroy');
            Route::get('/verifikasi/{id}', 'ServiceController@verifikasi')->name('verifikasi');
            Route::get('/approve/{id}', 'ServiceController@approval')->name('approve');
        });
    });
});



//////////////////////////////////////////ILYAS END////////////////////////////////////////////////////////////////////////////////

//Meidi
Route::namespace('Inquiry')->group(function () {
    //Eksportir
    Route::get('/inquiry', 'InquiryEksController@index')->name('eksportir.inquiry.index');
    Route::get('/inquiry/getData/{jenis}', 'InquiryEksController@getData')->name('eksportir.inquiry.getData');
    Route::get('/inquiry/countdata', 'InquiryEksController@countData')->name('eksportir.inquiry.countData');
    Route::get('/inquiry/joined/{id}', 'InquiryEksController@joined')->name('eksportir.inquiry.join');
    Route::get('/inquiry/accept_chat/{id}', 'InquiryEksController@accept_chat')->name('eksportir.inquiry.accept_chat');
    Route::get('/inquiry/view/{id}', 'InquiryEksController@view')->name('eksportir.inquiry.view');
    Route::get('/inquiry/chatting/{id}', 'InquiryEksController@chatting')->name('eksportir.inquiry.chatting');
    Route::get('/inquiry/sendChat', 'InquiryEksController@sendChat')->name('eksportir.inquiry.sendChat');
    Route::post('/inquiry/fileChat', 'InquiryEksController@fileChat')->name('eksportir.inquiry.fileChat');
    Route::get('/inquiry/dealing/{id}/{status}', 'InquiryEksController@dealing')->name('eksportir.inquiry.dealing');
    Route::get('/refreshchatinq3/{id}', 'InquiryEksController@refreshchatinq3');

    //Perwakilan
    Route::get('/inquiry_perwakilan', 'InquiryWakilController@index')->name('perwakilan.inquiry.index');
    Route::get('/inquiry_perwakilan/getData', 'InquiryWakilController@getData')->name('perwakilan.inquiry.getData');
    Route::get('/inquiry_perwakilan/create', 'InquiryWakilController@create')->name('perwakilan.inquiry.create');
    Route::post('/inquiry_perwakilan/store', 'InquiryWakilController@store')->name('perwakilan.inquiry.store');
    Route::get('/inquiry_perwakilan/edit/{id}', 'InquiryWakilController@edit')->name('perwakilan.inquiry.edit');
    Route::post('/inquiry_perwakilan/update/{id}', 'InquiryWakilController@update')->name('perwakilan.inquiry.update');
    Route::post('/inquiry_perwakilan/broadcasting', 'InquiryWakilController@broadcasting')->name('perwakilan.inquiry.broadcasting');
    Route::get('/inquiry_perwakilan/view/{id}', 'InquiryWakilController@view')->name('perwakilan.inquiry.view');
    Route::get('/inquiry_perwakilan/delete/{id}', 'InquiryWakilController@delete')->name('perwakilan.inquiry.delete');
    Route::get('/inquiry_perwakilan/getDataCompany/{id}', 'InquiryWakilController@getDataCompany')->name('perwakilan.inquiry.getDataCompany');
    Route::get('/inquiry_perwakilan/verifikasi/{id}', 'InquiryWakilController@verifikasi')->name('perwakilan.inquiry.verifikasi');
    Route::get('/inquiry_perwakilan/chatting/{id}', 'InquiryWakilController@chatting')->name('perwakilan.inquiry.chatting');
    Route::get('/inquiry_perwakilan/sendChat', 'InquiryWakilController@sendChat')->name('perwakilan.inquiry.sendChat');
    Route::post('/inquiry_perwakilan/fileChat', 'InquiryWakilController@fileChat')->name('perwakilan.inquiry.fileChat');
    Route::get('/inquiry_perwakilan/view_detail/{id}', 'InquiryWakilController@view_detail')->name('perwakilan.inquiry.view_detail');
    Route::get('/inquiry_perwakilan/delete_detail/{id}', 'InquiryWakilController@delete_detail')->name('perwakilan.inquiry.delete_detail');
    Route::get('/refreshchatinq2/{id}', 'InquiryWakilController@refreshchatinq2');

    //Admin
    Route::get('/inquiry_admin', 'InquiryAdminController@index')->name('admin.inquiry.index');
    Route::get('/inquiry_admin/getDataAdmin', 'InquiryAdminController@getDataAdmin')->name('admin.inquiry.getDataAdmin');
    Route::get('/inquiry_admin/create', 'InquiryAdminController@create')->name('admin.inquiry.create');
    Route::post('/inquiry_admin/store', 'InquiryAdminController@store')->name('admin.inquiry.store');
    Route::get('/inquiry_admin/edit/{id}', 'InquiryAdminController@edit')->name('admin.inquiry.edit');
    Route::post('/inquiry_admin/update/{id}', 'InquiryAdminController@update')->name('admin.inquiry.update');
    Route::post('/inquiry_admin/broadcasting', 'InquiryAdminController@broadcasting')->name('admin.inquiry.broadcasting');
    Route::get('/inquiry_admin/view/{id}', 'InquiryAdminController@view')->name('admin.inquiry.view');
    Route::get('/inquiry_admin/delete/{id}', 'InquiryAdminController@delete')->name('admin.inquiry.delete');
    Route::get('/inquiry_admin/getDataCompany/{id}', 'InquiryAdminController@getDataCompany')->name('admin.inquiry.getDataCompany');
    Route::get('/inquiry_admin/verifikasi/{id}', 'InquiryAdminController@verifikasi')->name('admin.inquiry.verifikasi');
    Route::get('/inquiry_admin/chatting/{id}', 'InquiryAdminController@chatting')->name('admin.inquiry.chatting');
    Route::get('/inquiry_admin/sendChat', 'InquiryAdminController@sendChat')->name('admin.inquiry.sendChat');
    Route::post('/inquiry_admin/fileChat', 'InquiryAdminController@fileChat')->name('admin.inquiry.fileChat');
    Route::get('/inquiry_admin/view_detail/{id}', 'InquiryAdminController@view_detail')->name('admin.inquiry.view_detail');
    Route::get('/inquiry_admin/delete_detail/{id}', 'InquiryAdminController@delete_detail')->name('admin.inquiry.delete_detail');
    Route::get('/refreshchatinq/{id}', 'InquiryAdminController@refreshchatinq');
    //Tab Perwakilan
    Route::get('/inquiry_admin/getPerwakilan', 'InquiryAdminController@getPerwakilan')->name('admin.inquiry.getPerwakilan');
    Route::get('/inquiry_admin/detail_perwakilan/{id}', 'InquiryAdminController@detail_perwakilan')->name('admin.inquiry.detail_perwakilan');
    Route::get('/inquiry_admin/getDataPerwakilan/{id}', 'InquiryAdminController@getDataPerwakilan')->name('admin.inquiry.getDataPerwakilan');
    Route::get('/inquiry_admin/perwakilan_view/{id}', 'InquiryAdminController@perwakilan_view')->name('admin.inquiry.perwakilan_view');
    Route::get('/inquiry_admin/getDataCompanyWakil/{id}', 'InquiryAdminController@getDataCompanyWakil')->name('admin.inquiry.getDataCompanyWakil');
    Route::get('/inquiry_admin/view_inquiry/{id}', 'InquiryAdminController@view_inquiry')->name('admin.inquiry.view_inquiry');
    //Tab Importir
    Route::get('/inquiry_admin/getDataImportir', 'InquiryAdminController@getDataImportir')->name('admin.inquiry.getDataImportir');
    Route::get('/inquiry_admin/view_importir/{id}', 'InquiryAdminController@view_importir')->name('admin.inquiry.view_importir');
});

//YOSS---------------------------------------------

//Ticketing Support
Route::namespace('TicketingSupport')->group(function () {
    //Admin
    Route::get('admin/ticketing', 'TicketingSupportControllerAdmin@index')->name('ticket_support.index.admin')->middleware('auth');
    Route::get('admin/ticketing/getData', 'TicketingSupportControllerAdmin@getData')->name('ticket_support.getData.admin')->middleware('auth');
    Route::get('admin/ticketing/chatview/{id}', 'TicketingSupportControllerAdmin@vchat')->name('ticket_support.vchat.admin');
    Route::get('admin/ticketing/view/{id}', 'TicketingSupportControllerAdmin@view')->name('ticket_support.view.admin');
    Route::post('admin/ticketing/sendchat', 'TicketingSupportControllerAdmin@sendchat')->name('ticket_support.sendchat.admin');
    Route::post('admin/ticketing/sendFilechat', 'TicketingSupportControllerAdmin@sendFilechat')->name('ticket_support.sendFilechat.admin');
    Route::get('admin/ticketing/delete/{id}', 'TicketingSupportControllerAdmin@destroy')->name('ticket_support.delete.admin');
    Route::post('admin/ticketing/change', 'TicketingSupportControllerAdmin@change')->name('ticket_support.delete.change');
});

//Training
Route::namespace('Training')->group(function () {
    //Admin
    Route::get('admin/training', 'TrainingControllerAdmin@index')->name('training.index.admin');
    Route::get('admin/training/getData', 'TrainingControllerAdmin@getData')->name('training.getData.admin');
    Route::get('admin/training/create', 'TrainingControllerAdmin@create')->name('training.create.admin');
    Route::post('admin/training/store', 'TrainingControllerAdmin@store')->name('training.store.admin');
    Route::post('admin/training/update/{id}', 'TrainingControllerAdmin@update')->name('training.update.admin');
    Route::get('admin/training/publish/{id}', 'TrainingControllerAdmin@publish')->name('training.publish.admin');
    Route::get('admin/training/edit/{id}', 'TrainingControllerAdmin@edit')->name('training.edit.admin');
    Route::get('admin/training/view/{id}', 'TrainingControllerAdmin@view')->name('training.view.admin');
    Route::get('admin/training/destroy/{id}', 'TrainingControllerAdmin@destroy')->name('training.destroy.admin');
    Route::get('admin/training/verifed/{id}/{id_tr}/{id_profil}', 'TrainingControllerAdmin@verifed')->name('training.verifed.admin');
    Route::get('/Training-getDataInterest/{id}', 'TrainingControllerAdmin@getDataInterest')->name('training.getDataInterest');
    //Eksportir
    Route::get('training', 'TrainingControllerEksportir@index')->name('training.index');
    Route::get('training/getData', 'TrainingControllerEksportir@getData')->name('training.getData');
    Route::get('training/view', 'TrainingControllerEksportir@view')->name('training.view');
    Route::post('training/join', 'TrainingControllerEksportir@join')->name('training.join');
    Route::get('training/search', 'TrainingControllerEksportir@search')->name('training.search');
});

//END YOSS ------------------------------------------

//start mindy
Route::post('/captchaValidate', 'CaptchaController@captchaValidate')->name('captcha');
Route::get('refreshcaptcha', 'CaptchaController@refreshCaptcha')->name('refreshcaptcha');

//master perwakilan
Route::resource('/master-catper', 'Master\CatperController');
Route::get('/tambah-catper', 'Master\CatperController@create');
Route::post('/save-catper', 'Master\CatperController@store')->name('catper.save');
Route::get('/hapus-catper/{id}', 'Master\CatperController@hapus');

Route::get('/type', 'VerifyuserController@type')->name('admin.perwakilan.type');

Route::get('/qrcode', 'VerifyuserController@qrcode')->name('eksportir.qrcode');

//Rekap Anggota
Route::get('/rekap-anggota', 'RekapAnggotaController@index');
Route::get('/rekapanggota.getanggota', 'RekapAnggotaController@getData')->name('rekapang.getData');
//print csv
Route::get('/cetakra', 'RekapAnggotaController@cetakcsv')->name('cetakra.printcsv');

//Rekap Market Research
Route::get('/rekap-rc', 'RekaprcController@index');
Route::get('/rekaprc.getdata1', 'RekaprcController@getData1')->name('rekaprc1.getData');
Route::get('/rekaprc.getdata2', 'RekaprcController@getData2')->name('rekaprc2.getData');

//print csv
Route::get('/cetakrc1', 'RekaprcController@cetakcsv1')->name('cetakrc1.printcsv');
Route::get('/cetakrc2', 'RekaprcController@cetakcsv2')->name('cetakrc2.printcsv');

Route::post('/getscoope', 'VerifyuserController@getscoope')->name('getscoope');
Route::post('/gettob', 'VerifyuserController@gettob')->name('gettob');

Route::get('/getcountryall', 'FrontEnd\FrontController@getcountryall')->name('countryevent.getcountryall');
Route::get('/getcountryindonesia', 'FrontEnd\FrontController@getcountryindonesia')->name('countryevent.getcountryindonesia');
Route::get('/getcountryforeign', 'FrontEnd\FrontController@getcountryforeign')->name('countryevent.getcountryforeign');

Route::get('/getcategoryallevent', 'FrontEnd\FrontController@getcategoryallevent')->name('categoryevent.getcategoryallevent');
Route::get('/getcategoryindonesiaevent', 'FrontEnd\FrontController@getcategoryindonesiaevent')->name('categoryevent.getcategoryindonesiaevent');
Route::get('/getcategoryforeignevent', 'FrontEnd\FrontController@getcategoryforeignevent')->name('categoryevent.getcategoryforeignevent');


Route::get('/getcountryrc', 'FrontEnd\FrontController@getcountryrc')->name('countryrc.getcountry');
Route::get('/getcategoryrc', 'FrontEnd\FrontController@getcategoryrc')->name('categoryrc.getcategory');
Route::get('/getproductrc', 'FrontEnd\FrontController@getproductrc')->name('productrc.getproductrc');

Route::get('eksportir/annual_sales/cetak/{kat?}', 'Eksportir\AnnualController@printexportirreport')->name('annual.cetak');

Route::post('annual_sales/cetak', 'Eksportir\AnnualController@printexportirreport')->name('annual.cetak');

Route::get('buyingrequest/delete/{id}', 'BuyingRequestController@delete')->name('buyingrequest.delete');
Route::post('/getdatapiliheksportir', 'BRFrontController@getdatapiliheksportir');
Route::get('bannercompanyfront/getData', 'FrontEnd\FrontController@getDataCompanyFront')->name('bannercompanyfront.getdata');


Route::get('/getcompanynamebanner', 'Master\MasterBannerController@getcompanyname')->name('banner.companyname');
Route::post('markAsReadNotification', 'DashboardEksportirController@markAsReadNotification');

Route::namespace('CurrentIssue')->group(function () {

    Route::prefix('admin/curris')->group(function () {
        Route::name('admin.curris.')->group(function () {
            Route::get('/', 'AdminCurrentIssueController@index')->name('index');
            Route::get('/getData/', 'AdminCurrentIssueController@getData')->name('getData');
            Route::get('/getDataDownload/{id}', 'AdminCurrentIssueController@getDataDownload')->name('getDataDownload');
            Route::get('/create/', 'AdminCurrentIssueController@create')->name('create');
            Route::post('/store/{param}', 'AdminCurrentIssueController@store')->name('store');
            Route::get('/edit/{id}', 'AdminCurrentIssueController@edit')->name('edit');
            Route::get('/view/{id}', 'AdminCurrentIssueController@view')->name('view');
            Route::get('/destroy/{id}', 'AdminCurrentIssueController@destroy')->name('destroy');
            // Route::post('/broadcast/', 'AdminCurrentIssueController@broadcast')->name('broadcast');
            // Route::get('/hscode', 'AdminCurrentIssueController@hscode')->name('hscode');
        });
    });
    Route::prefix('perwakilan/curris')->group(function () {
        Route::name('perwakilan.curris.')->group(function () {
            Route::get('/', 'PerwakilanCurrentIssueController@index')->name('index');
            Route::get('/getData/', 'PerwakilanCurrentIssueController@getData')->name('getData');
            Route::get('/getDataDownload/{id}', 'PerwakilanCurrentIssueController@getDataDownload')->name('getDataDownload');
            Route::get('/create/', 'PerwakilanCurrentIssueController@create')->name('create');
            Route::post('/store/{param}', 'PerwakilanCurrentIssueController@store')->name('store');
            Route::get('/edit/{id}', 'PerwakilanCurrentIssueController@edit')->name('edit');
            Route::get('/view/{id}', 'PerwakilanCurrentIssueController@view')->name('view');
            Route::get('/destroy/{id}', 'PerwakilanCurrentIssueController@destroy')->name('destroy');
            // Route::post('/broadcast/', 'PerwakilanCurrentIssueController@broadcast')->name('broadcast');
        });
    });
    // Route::prefix('curris')->group(function () {
    //     Route::name('curris.')->group(function () {
    //         Route::get('/list/', 'CurrentIssueController@index')->name('index');
    //         Route::get('/getData/', 'CurrentIssueController@getData')->name('getData');
    //         Route::get('/read/{id}', 'CurrentIssueController@read')->name('view');
    //         // Route::get('/download/', 'CurrentIssueController@download')->name('download');
    //     });
    // });
});


Route::get('/getcountryci', 'FrontEnd\FrontController@getcountryci')->name('countryci.getcountry');
Route::get('/front_end/curris', 'FrontEnd\FrontController@current_issue');
Route::get('/front_end/curris/getData/', 'FrontEnd\FrontController@curris_data')->name('getData');
Route::get('/front_end/curris/detail/{id}', 'FrontEnd\FrontController@curris_detail')->name('frontend.detail-curris');
Route::get('/front_end/curris/download', 'CurrentIssue\CurrentIssueController@download')->name('curris.download');
Route::get('/front_end/pdf-document/{id}', 'FrontEnd\FrontController@getDocument');


// Route::get('/getdatapiliheksportir', 'BRFrontController@getdatapiliheksportir');
//end mindy

//! Start of Created by MNF
//TODO: Business Matching
Route::group(['prefix' => 'event_zoom', 'as' => 'event_zoom.', 'middleware' => 'auth'], function () {
    Route::get('/', 'EventController@index');
    Route::get('/callback', 'EventController@callback');
    Route::get('/get_meetings', 'EventController@get_meetings');
    Route::get('/create_meeting', 'EventController@create_meeting');
    Route::get('/update_meeting', 'EventController@update_meeting');
    Route::get('/delete_meeting/{meetingId}', 'EventController@delete_meeting');

    // Invite meeting user ajax
    Route::get('/autocomplete-ajax-user-exportir', 'EventController@dataAjaxUserExportir');
    Route::get('/autocomplete-ajax-user-buyer', 'EventController@dataAjaxUserBuyer');
    Route::get('/autocomplete-ajax-user-perwakilan', 'EventController@dataAjaxUserPerwakilan');
    Route::post('/add_invitation', 'EventController@add_invitation');
    Route::post('/view_invitation', 'EventController@view_invitation');
    Route::delete('/delete_invitation', 'EventController@delete_invitation');
    Route::post('/verification', 'EventController@verification');
    Route::post('/check_remaining_quota', 'EventController@check_remaining_quota');
    Route::post('/add_potential_transaction_value', 'EventController@add_potential_transaction_value');
    Route::post('/check_potential_transaction_value', 'EventController@check_potential_transaction_value');
    Route::post('/attendance', 'EventController@attendance');
});

//TODO: Chat Antara Perwadag Dengan Supplier dan Buyer
Route::group(['prefix' => 'chat_admin_eks_imp', 'as' => 'chat_admin_eks_imp.'], function () {
    // TODO: Perwadag dengan Supplier dan Buyer
    Route::get('/{id_admin}/{id_eks_imp}', 'ChattingController@chat');
    Route::post('/send_chat', 'ChattingController@send_chat');
    Route::get('/notification/{id_admin}/{id_eks_imp}', 'ChattingController@notification');
    Route::get('/refreshchat/{id_admin}/{id_eks_imp}', 'ChattingController@refreshchat');
    Route::post('/upload_file_chat_admin_and_company/{id_admin}/{id_eks_imp}', 'ChattingController@uploadFile');

    // TODO: Perwadag dengan Dinas
    Route::get('/admin/{id_admin}/{id_other_admin}', 'ChattingAdminController@chat');
    Route::post('/admin/send_chat', 'ChattingAdminController@send_chat');
    Route::get('/admin/notification/{id_admin}/{id_other_admin}', 'ChattingAdminController@notification');
    Route::get('/admin/refreshchat/{id_admin}/{id_other_admin}', 'ChattingAdminController@refreshchat');
    Route::post('/admin/upload_file_chat_admin_and_company/{id_admin}/{id_other_admin}', 'ChattingAdminController@uploadFile');
});


//TODO: Business Matching List on Supplier, Buyer and Perwadag
Route::group(['prefix' => 'business_matching_list', 'as' => 'business_matching_list.'], function () {
    Route::get('/', 'EventController@business_matching_list');
    Route::get('/business_matching_data', 'EventController@business_matching_data')->name('business_matching_data');
});

//TODO: Video Conference
Route::namespace('VideoConference')->group(
    function () {
        //TODO: Video Conference Approval by Administrator
        Route::group(['prefix' => 'video_conference', 'as' => 'video_conference.', 'middleware' => 'auth'], function () {
            Route::get('/', 'VCController@index');
            Route::get('/callback', 'VCController@callback');
            Route::get('/get_meetings', 'VCController@get_meetings');
            Route::get('/create_meeting', 'VCController@create_meeting');
            Route::get('/delete_meeting/{meetingId}', 'VCController@delete_meeting');
            Route::post('/view_invitation_admin', 'VCController@view_invitation');
            Route::get('/approve_meeting/{meetingId}', 'VCController@approve_meeting');
            Route::get('/decline_meeting/{meetingId}', 'VCController@decline_meeting');
        });

        //TODO:: Video Conference Buyer and Supplier
        Route::group(['prefix' => 'video_conference', 'as' => 'video_conference.'], function () {
            Route::get('list', 'VideoConferenceController@video_conference_list');
            Route::get('video_conference_data', 'VideoConferenceController@video_conference_data')->name('video_conference_data');
            Route::get('add_update_video_conference_data/{id?}', 'VideoConferenceController@add_update_video_conference_data')->name('add_update_video_conference_data');
            Route::get('edit-bisnis-conf/{id}', 'VideoConferenceController@editVidioEks')->name('editbusnismatch');
            Route::post('store_video_conference_data', 'VideoConferenceController@store_video_conference_data')->name('store_video_conference_data');
            // Route::post('perwadag/store_video_conference_data', 'VideoConferenceController@store_video_conference_data_pw')->name('store_video_conference_data_pw');
            Route::post('edit_video_conference_data', 'VideoConferenceController@edit_video_conference_data')->name('edit_video_conference_data');
            // Route::post('perwadag/edit_video_conference_data', 'VideoConferenceController@edit_video_conference_data_pw')->name('edit_video_conference_datapw');
            Route::get('hapus_video_conference_data/{id}', 'VideoConferenceController@hapus_video_conference_data')->name('hapus_video_conference_data');

            // Invite meeting user ajax
            Route::get('/autocomplete-ajax-user-exportir', 'VideoConferenceController@dataAjaxUserExportir');
            Route::get('/autocomplete-ajax-user-buyer', 'VideoConferenceController@dataAjaxUserBuyer');
            Route::get('/autocomplete-ajax-user-perwakilan', 'VideoConferenceController@dataAjaxUserPerwakilan');
            Route::post('/add_invitation', 'VideoConferenceController@add_invitation');
            Route::post('/view_invitation', 'VideoConferenceController@view_invitation');
            Route::delete('/delete_invitation', 'VideoConferenceController@delete_invitation');
        });
    }
);
// Route::group(['prefix' => 'translate', 'as' => 'translate.'], function () {
//     Route::get('/page', 'TranslateController@index');
// });

// Route::get('/notification', function () {
//     return view('notification');
// });

// Route::get('send', 'PusherNotificationController@index');
//! End of Created By MNF
//notif
Route::get('/chat-notif/{param}', 'NotificationController@notification')->name('chating.notif');
Route::get('/chat-notif-comnya/{param}', 'NotificationController@notificationcom')->name('chating.notif.company');
