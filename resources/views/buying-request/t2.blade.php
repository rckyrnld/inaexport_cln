<?php 
// $qr = DB::select("select id,nama_kategori_en from csc_product where level_1='".$id."' and level_2='0' order by nama_kategori_en asc");
if($perusahaan == null) {
	$qr = DB::table('csc_product')
			->select('id','nama_kategori_en')
			->where('level_1', $id)
			->where('level_2', 0)
			->orderBy('nama_kategori_en', 'asc')
			->get();
} else {
	$qr = DB::table('csc_product AS a')
			->join('csc_product_single AS b', 'b.id_csc_product_level1', '=', 'a.id')
			->select('a.id','a.nama_kategori_en')
			->where('level_1', $id)
			->where('level_2', 0)
			->where('b.id_itdp_company_user', $perusahaan)
			->where('b.status', 2)
			->groupBy('a.id','a.nama_kategori_en')
			->orderBy('nama_kategori_en', 'asc')
			->get();
}

if(count($qr) == 0){
?>
<input type="hidden" name="t2s" id="t2s" value="0">
<?php }else{ ?>
<div class="">
    <div class="col-sm-12">
        <label><b>Sub Category 1</b></label>
    </div>
    <div class="form-group col-sm-12" style="font-size: 12px !important;">

        <select style="color:black;font-size: 12px!important;" size="13" class="column J-noselect" name="t2s" id="t2s"
            onchange="t2()" form="form_br">
            <option value="">-- Select Sub Category 1 --</option>
            <?php foreach($qr as $val1){ ?>
            <option style="font-size: 12px !important;" value="<?php echo $val1->id; ?>"><?php echo $val1->nama_kategori_en; ?></option>
            <?php } ?>
        </select>
    </div>

</div>
<?php } ?>
