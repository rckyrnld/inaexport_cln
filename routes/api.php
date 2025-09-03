<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:userApis')->get('/userApi', function (Request $request) {
//     return $request->user();
// });
// Route::middleware('auth:adminApis')->get('/adminApi', function (Request $request) {
//     return $request->user();
// });

// $api = app('Dingo\Api\Routing\Router');

// $api->version('v1', function ($api){
/*API Auth*/

Route::group(['middleware' => ['api']], function () {
    Route::post('admin-login', 'Api\Auth\Admin\LoginController@login');
    Route::post('user-login', 'Api\Auth\User\LoginController@login');

    //!public API AKBAR
    Route::post('/suppliers', 'Api\User\ProductController@list_perusahaan');
    Route::post('/suppliers/detail', 'Api\User\ProductController@list_perusahaan_detail');

    // Public API BR
    Route::get('data_br_published', 'Api\User\BuyingreqController@data_br_published');
    Route::get('data_br_published_all', 'Api\User\BuyingreqController@data_br_published_all');
});
/*API Auth*/
/*************************************************************************************************************/
Route::group(['middleware' => ['api', 'manage_token:api_admin,1|2|4']], function () {

    Route::post('getRekapAnggota', 'Api\Admin\ManagementController@getRekapAnggota');
    Route::post('getRekapAnggotaEks', 'Api\Admin\ManagementController@getRekapAnggotaEks');

    Route::post('getDetailVerifikasiImportir', 'Api\Admin\ManagementController@detailVerifikasiImportir');
    Route::post('submitVerifikasiImportir', 'Api\Admin\ManagementController@submitVerifikasiImportir');

    Route::post('getDetailVerifikasiEksportir', 'Api\Admin\ManagementController@detailVerifikasiEksportir');
    Route::post('submitVerifikasiEksportir', 'Api\Admin\ManagementController@submitVerifikasiEksportir');

    //Buying Request
    Route::get('list_br_admin', 'Api\Admin\ManagementController@list_br_admin');
    Route::get('list_br_view_admin', 'Api\Admin\ManagementController@list_br_view');
    Route::get('list_br_detail_admin', 'Api\Admin\ManagementController@list_br_join');
    Route::post('list_br_chat', 'Api\Admin\ManagementController@list_br_chat');
    Route::post('br_admin_save', 'Api\Admin\ManagementController@br_admin_save');
    Route::post('bc_admin', 'Api\Admin\ManagementController@bc_admin');
    Route::post('bc_verif', 'Api\Admin\ManagementController@bc_verif');
    Route::post('simpanchatadmin', 'Api\Admin\ManagementController@simpanchatadmin');
    Route::post('count_br_chat_admin', 'Api\Admin\ManagementController@count_br_chat_admin');
    Route::post('uploadpop_admin', 'Api\Admin\ManagementController@uploadpop_admin');
    Route::post('br_importir_lc_admin', 'Api\Admin\ManagementController@br_importir_lc');

    //Inquiry 
    Route::get('list_inquiry_admin', 'Api\Admin\InquiryController@list_inquiry_admin');
    Route::post('insert_inquiry_admin', 'Api\Admin\InquiryController@store');
    Route::post('bc_inquiry_admin', 'Api\Admin\InquiryController@bc_inquiry_admin');
    Route::get('list_inquiry_broadcast', 'Api\Admin\InquiryController@list_inquiry_broadcast');
    Route::get('inquiry_detail_admin', 'Api\Admin\InquiryController@inquiry_detail_admin');
    Route::post('list_inquiry_hc', 'Api\Admin\InquiryController@list_inquiry_hc');
    Route::post('verif_inquiry_admin', 'Api\Admin\InquiryController@verif_inquiry_admin');
    Route::post('count_inq_chat_admin', 'Api\Admin\InquiryController@count_inq_chat_admin');
    Route::post('simpanchat_inquiry_admin', 'Api\Admin\InquiryController@simpanchat_inquiry_admin');
    Route::post('uploadpop_inquiry', 'Api\Admin\InquiryController@uploadpop_inquiry');
    Route::post('br_importir_chat', 'Api\Admin\InquiryController@br_importir_chat');

    //Brayen
    //Inquiry
    Route::post('list_inquiry_perwadag', 'Api\Admin\InquiryController@list_inquiry_perwadag');
    Route::get('inquiry_detail_perwadag', 'Api\Admin\InquiryController@inquiry_detail_perwadag');
    Route::get('inquiry_detail_perwadag_new', 'Api\Admin\InquiryController@inquiry_detail_perwadag_new');
    // End Inquiry

    Route::post('chat_admin_eks_imp', 'Api\Admin\ManagementController@chat_admin_eks_imp');
    //Brayen

    // LIST COMPANY
    Route::post('listCompany', 'Api\Admin\ManagementController@listCompany');

    // PRODUCT BY EKS
    Route::get('listProduct', 'Api\Admin\ManagementController@listProduct');
    Route::post('listProductCompany', 'Api\Admin\ManagementController@listProductCompany');
    Route::post('activate_product', 'Api\Admin\ManagementController@activate_product');

    // DETAIL EKS
    Route::post('detailCompany', 'Api\Admin\ManagementController@detailCompany');
    Route::post('searchcompany', 'Api\Admin\EksreportController@searchcompany');
    Route::post('searchproduct', 'Api\Admin\EksreportController@searchproduct');

    //Management User
    Route::get('list_eksportir', 'Api\Admin\ManagementController@list_eksportir');
    Route::get('unapprove_eksportir', 'Api\Admin\ManagementController@unapprove_eksportir');
    Route::get('search_eksportir', 'Api\Admin\ManagementController@search_eksportir');
    Route::get('list_importir', 'Api\Admin\ManagementController@list_importir');
    Route::get('unapprove_importir', 'Api\Admin\ManagementController@unapprove_importir');
    Route::get('search_importir', 'Api\Admin\ManagementController@search_importir');
    Route::post('saveapprove', 'Api\Admin\ManagementController@saveapprove');
    Route::get('detail_dokumen', 'Api\Admin\ManagementController@detail_dokumen');
    Route::get('detail_dokumen_importir', 'Api\Admin\ManagementController@detail_dokumen_importir');
    Route::post('cek_npwp', 'Api\Admin\ManagementController@ceknpwp');
});

// Route::group(['middleware' => ['api', 'manage_token:api_admin,1|4']], function () {
//     Route::post('simpanchatbr', 'Api\User\BuyingreqController@simpanchatbr');
// });

Route::group(['middleware' => ['api', 'manage_token:api_user,2|3']], function () {
    Route::post('simpanchatbr', 'Api\User\BuyingreqController@simpanchatbr');
});

Route::group(['middleware' => ['api', 'manage_token:api_user,2|3|4']], function () {
    Route::post('br_importir_chat_eksportir', 'Api\Admin\InquiryController@br_importir_chat');
    //Greed
    Route::post('count_br_chat', 'Api\User\BuyingreqController@count_br_chat');
    Route::post('count_tkt_chat', 'Api\User\ManagementUserController@count_tkt_chat');
    Route::post('count_inq_chat', 'Api\User\ManagementUserController@count_inq_chat');
    Route::post('count_notif_bb', 'Api\User\ManagementUserController@count_notif_bb');
    Route::post('count_notif_all', 'Api\User\ManagementUserController@count_notif_all');
    Route::post('aktifasiulang', 'Api\User\ManagementUserController@aktifasiulang');
    Route::get('detail_dokumen_eksporter', 'Api\User\ManagementUserController@detail_dokumen');
    Route::post('cek_npwp_user', 'Api\User\ManagementUserController@ceknpwp');

    //End Greed

    Route::post('getProdukList', 'Api\User\ProductController@findProductById');
    Route::post('browseProduk', 'Api\User\ProductController@browseProduct');

    Route::post('insertProduk', 'Api\User\ProductController@insertProduct');
    Route::post('updateProduk', 'Api\User\ProductController@updateProduct');
    Route::post('deleteProduk', 'Api\User\ProductController@deleteProduct');
    Route::post('detailProdukById', 'Api\User\ProductController@detailProduk');

    //profile
    Route::post('detailProfileExp', 'Api\User\ProfileController@findProfileExp');
    Route::post('detailFotoExp', 'Api\User\ProfileController@findImageExp');
    Route::post('updateDataExp', 'Api\User\ProfileController@updateProfilExp');

    Route::post('detailProfileImp', 'Api\User\ProfileController@findProfileImp');
    Route::post('detailFotoImp', 'Api\User\ProfileController@findImageimp');
    Route::post('updateDataImp', 'Api\User\ProfileController@updateProfilImp');

    //training
    Route::post('joinTraining', 'Api\User\ManagementUserController@joinTraining');
    Route::post('trainingInterest', 'Api\User\ManagementUserController@trainingInterest');

    //event
    Route::post('joinEvent', 'Api\User\ManagementUserController@joinEvent');
    Route::post('eventInterest', 'Api\User\ManagementUserController@eventInterest');

    //tiketing
    Route::post('createTicket', 'Api\User\ManagementUserController@createTicketing');
    Route::post('data_ticketing', 'Api\User\ManagementUserController@data_ticketing');
    Route::post('vchat', 'Api\User\ManagementUserController@vchat');
    Route::post('sendchat', 'Api\User\ManagementUserController@sendchat');
    Route::post('destroytiketing', 'Api\User\ManagementUserController@destroytiketing');

    //RC
    Route::post('downloadResearch', 'Api\User\ManagementUserController@downloadResearch');

    //inquiry
    //imp
    Route::post('getinquirynew', 'Api\User\InquiryController@getinquirynew');
    Route::post('getInquiry', 'Api\User\InquiryController@getListinquiry');
    Route::get('getInquiry_kedua', 'Api\User\InquiryController@getListinquiry_kedua');
    Route::post('searchInquiry', 'Api\User\InquiryController@searchListinquiry');
    Route::post('simpanInquiryImportir', 'Api\User\InquiryController@store');
    Route::post('verifikasi_inquiryImportir', 'Api\User\InquiryController@verifikasi_inquiry');
    Route::post('chatImportir', 'Api\User\InquiryController@masukchattingImp');
    Route::post('sendchatImportir', 'Api\User\InquiryController@sendChatimp');

    Route::post('sendchatFile', 'Api\User\InquiryController@fileChat');

    //eks
    Route::post('getInquiryeks', 'Api\User\InquiryController@getDataeks');
    Route::get('getInquiryeks_kedua', 'Api\User\InquiryController@getDataeks_kedua');
    Route::get('getInquiryeks_admin', 'Api\User\InquiryController@getDataeks_admin');
    Route::post('joinedEks', 'Api\User\InquiryController@joined');
    Route::post('acceptjoinedEks', 'Api\User\InquiryController@accept_chat');
    Route::post('chatEksportir', 'Api\User\InquiryController@masukchattingEks');
    Route::post('sendchatEksportir', 'Api\User\InquiryController@sendChatEks');
    Route::post('dealingEksportir', 'Api\User\InquiryController@dealing');
    //inquiry end
    //BR
    Route::post('impmasukbr', 'Api\User\BuyingreqController@impmasukbr');
    Route::post('impdata_br', 'Api\User\BuyingreqController@impdata_br');
    Route::post('br_importir_save', 'Api\User\BuyingreqController@br_importir_save');
    Route::post('br_importir_save_new', 'Api\User\BuyingreqController@br_importir_save_new');
    Route::post('br_importir_brodcast', 'Api\User\BuyingreqController@br_importir_bc');
    Route::post('br_importir_lc', 'Api\User\BuyingreqController@br_importir_lc');
    Route::post('br_konfirm', 'Api\User\BuyingreqController@br_konfirm');
    Route::post('eks_br_chat', 'Api\User\BuyingreqController@eks_br_chat');
    Route::post('uploadpop', 'Api\User\BuyingreqController@uploadpop');
    Route::post('eksfrontBR', 'Api\User\BuyingreqController@eksfrontBR');
    Route::post('savefrontBR', 'Api\User\BuyingreqController@savefrontBR');
    Route::post('ekslistbr', 'Api\User\BuyingreqController@ekslistbr');
    Route::post('eksjoinbr', 'Api\User\BuyingreqController@eksjoinbr');
    Route::post('br_save_join', 'Api\User\BuyingreqController@br_save_join');
    Route::post('br_deal', 'Api\User\BuyingreqController@br_deal');
    Route::post('data_br_get', 'Api\User\BuyingreqController@data_br_new');

    //transaksi
    Route::post('getTransaksi', 'Api\User\ManagementUserController@getTransaksi');
    Route::post('detailTransaksi', 'Api\User\ManagementUserController@detailTransaksi');
    Route::post('save_trx', 'Api\User\ManagementUserController@save_trx');

    //notif
    Route::post('getNotif', 'Api\User\ManagementUserController@getNotif');
    Route::post('updateNotif', 'Api\User\ManagementUserController@updateNotif');
    Route::post('read_all_notif', 'Api\User\ManagementUserController@read_all_notif');
    Route::post('read_one_notif', 'Api\User\ManagementUserController@read_one_notif');

    // Published Buying Request
    Route::post('published_br_join', 'Api\User\ManagementUserController@published_br_join');
    Route::post('interest_process', 'Api\User\ManagementUserController@interest_process');
});
Route::group(['middleware' => ['api', 'manage_token:api_user,2']], function () {
    // Only Supplier
    Route::post('checkProductSupllier', 'Api\User\ManagementUserController@checkProductSupllier'); 
});

Route::namespace('Api')->group(function () {
    /*Contact Us*/

    Route::post('contactUs', 'ManagementNoAuthController@contactUs');
    /*Contact Us*/
    /* Slide Content */
    Route::get('getslide', 'ProductNonAuthController@getslide');
    /* end slide content */
    /* Event */
    Route::get('event_suggest', 'EventNonAuthController@event_suggest');
    Route::post('event_list', 'EventNonAuthController@event_list');
    /*end event */

    Route::post('browseProdukFe', 'ProductNonAuthController@browseProduct');
    Route::post('FindProdukByKategori', 'ProductNonAuthController@findProduct');
    Route::post('browseProdukFeByKategori', 'ProductNonAuthController@browseProductByKategori');
    Route::get('getKategori', 'ProductNonAuthController@findKategori');
    Route::post('detailProdukFe', 'ProductNonAuthController@detailProduk');
    Route::get('getImageProduk/{id}/{image}', 'ProductNonAuthController@getImageProduk');
    Route::get('getRandomProduct', 'ProductNonAuthController@getRandomProduct');
    Route::get('getParentCategory', 'ProductNonAuthController@getKategorina');
    Route::post('getLevel1Category', 'ProductNonAuthController@getSubKategorina');
    Route::post('getLevel2Category', 'ProductNonAuthController@getSubKategorina2');
    Route::get('getprodukBaru', 'ProductNonAuthController@getprodukBaru');
    Route::post('browseProductListBynameAndKategori', 'ProductNonAuthController@browseProductDetailBynameAndKategori');
    Route::post('suggestProductkategorisearch', 'ProductNonAuthController@browseProductBynameAndKategori');
    Route::get('suggestProductnamesearch', 'ProductNonAuthController@suggestProductname');

    //training
    Route::get('getTrainingall', 'TrainingNonAuthController@browseTraining');
    Route::post('getDetailTrainingID', 'TrainingNonAuthController@findTrainingById');

    //register
    Route::post('registerExp', 'ManagementNoAuthController@RegisterExp');
    Route::post('registerImp', 'ManagementNoAuthController@RegisterImp');
    Route::post('checkEmail', 'ManagementNoAuthController@checkEmail');

    //country province
    Route::get('getCountry', 'ManagementNoAuthController@getCountry');
    Route::get('getBadanusaha', 'ManagementNoAuthController@getBadanusaha');
    Route::get('getProvince', 'ManagementNoAuthController@getProvince');
    Route::get('getCategory', 'ManagementNoAuthController@getKategori');
    Route::post('getSub', 'ManagementNoAuthController@getSub');
    //Filter
    Route::get('getCategoryFilter', 'ManagementNoAuthController@getKategoriFilter');
    Route::get('getCountryFilter', 'ManagementNoAuthController@getCountryFilter');
    Route::get('getProvinceFilter', 'ManagementNoAuthController@getProvinceFilter');

    //RC
    Route::get('getResearchc', 'ManagementNoAuthController@getResearchchor');
    Route::post('getResearchc', 'ManagementNoAuthController@getResearchc');

    //tracking
    Route::get('getDataTracking', 'ManagementNoAuthController@getDataTracking');
    Route::post('tracking', 'TrackingController@tracking');

    //event
    Route::get('getDataEvent', 'ManagementNoAuthController@getEvent');

    //hscode
    Route::get('getHscode', 'ManagementNoAuthController@getHscode');
    Route::get('getHscode_paging', 'ManagementNoAuthController@getHscode_paging');
    Route::get('getHscodeFilter', 'ManagementNoAuthController@getHscodeFilter');

    // Populer Categories
    Route::get('populerCategories', 'ProductNonAuthController@populerCategories');

    // Get Product By Categories
    Route::post('productByCategories', 'ProductNonAuthController@productByCategories');

    // Get All Category
    Route::get('getallcategory', 'ManagementNoAuthController@getallcategory');
});
// });
