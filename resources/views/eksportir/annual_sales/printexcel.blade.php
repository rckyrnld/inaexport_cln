<?php
ob_start();
ob_get_clean();
header('Content-Disposition: attachment; filename=Data Supplier.xls');
header('Content-type: application/vnd.ms-excel; charset=utf-8');
?>

<style>
    .str {
        mso-number-format: \@;
    }

</style>

<!--product details start-->
<div class="">
    @if (Auth::user()->id_group == 5)
        <?php
        $provinsi = DB::table('itdp_admin_users')
            ->join('itdp_admin_dn', 'itdp_admin_dn.id', '=', 'itdp_admin_users.id_admin_dn')
            ->join('mst_province', 'mst_province.id', '=', 'itdp_admin_dn.id_country')
            ->where('itdp_admin_users.id', Auth::user()->id)
            ->get();
        ?>
        <h1>
            <center>
                @foreach ($provinsi as $prov)
                    Data Supplier Provinsi {{ $prov->province_en }}
                    {{ isset($cat) ? 'Kategori Produk ' . $cat->nama_kategori_en : '' }}
                @endforeach
            </center>
        </h1>
    @else
        <h1>
            <center> Data Supplier {{ isset($cat) ? 'Kategori Produk ' . $cat->nama_kategori_en : '' }}</center>
        </h1>
    @endif

    <table id="example1" border="1">
        <thead>
            <th width="10%">No</th>
            <th>
                <center>Nama Perusahaan</center>
            </th>
            <th>
                <center>PIC</center>
            </th>
            <th>
                <center>No. Telepon</center>
            </th>
            <th>
                <center>Email</center>
            </th>
            <th>
                <center>Alamat</center>
            </th>
            @if (isset($cat))
                <th>
                    <center>Produk</center>
                </th>
            @else
                <th>
                    <center>Kategori</center>
                </th>
            @endif
            <th>
                <center>Tanggal</center>
            </th>
        </thead>
        <tbody align="left">
            <?php
            $na = 1;
            foreach ($pesan as $ryu) {
                ?>
            <tr>
                <td style="text-align: left;"><?php echo $na; ?></td>
                <?php
                $badan_usaha = '';
                if ($ryu->nmbadanusaha != '') {
                    $badan_usaha = ', ' . $ryu->nmbadanusaha;
                }
                ?>
                <td style="text-align: left;"><?php echo $ryu->company . '' . $badan_usaha; ?></td>
                <td style="text-align: left;">
                    <?php
                    $namapicnya = '';
                    $no = 0;
                    $datapic = DB::table('itdp_contact_eks')
                        ->where('id_itdp_profil_eks', $ryu->id)
                        ->get();
                    if (count($datapic) > 0) {
                        foreach ($datapic as $namapic) {
                            if ($no == 0) {
                                $namapicnya .= $namapic->name;
                            } else {
                                $namapicnya .= ', ' . $namapic->name;
                            }
                            $no++;
                        }
                    }
                    ?>
                    {{ $namapicnya }}
                </td>
                <td style="text-align: left;" class="str">
                    <?php
                    $telppicnya = '';
                    $no2 = 0;
                    
                    $datapic2 = DB::table('itdp_contact_eks')
                        ->where('id_itdp_profil_eks', $ryu->id)
                        ->get();
                    if (count($datapic2) > 0) {
                        foreach ($datapic2 as $telppic) {
                            if ($no2 == 0) {
                                $telppicnya .= $telppic->phone;
                            } else {
                                $telppicnya .= ', ' . $telppic->phone;
                            }
                            $no2++;
                        }
                    }
                    ?>
                    {{ $telppicnya }}
                </td>
                <td style="text-align: left;">
                    {{ $ryu->email }}
                </td>
                <td>
                    {{ $ryu->addres }}
                </td>
                @if (isset($cat))
                    <td>
                        <?php
                        $products = getProductExpByCat($ryu->id_user, 2, null, 'in', $cat->id);
                        if ($products) {
                            $array_products = [];
                            foreach ($products as $key => $value) {
                                $array_products[] = $value->prodname_en;
                            }
                            echo implode(', ', $array_products);
                        } else {
                            echo '-';
                        }
                        ?>
                    </td>
                @else
                    <td>
                        <?php
                        $catnya = [];
                        $categoryutama = DB::table('csc_product')
                            ->join('csc_product_single', 'csc_product.id', 'csc_product_single.id_csc_product')
                            ->select('csc_product.id', 'csc_product.level_1', 'csc_product.level_2', 'csc_product.nama_kategori_en', 'csc_product.nama_kategori_in', 'csc_product.nama_kategori_chn', 'csc_product.created_at', 'csc_product.updated_at', 'csc_product.type', 'csc_product.logo')
                            ->groupby('csc_product.id', 'csc_product.level_1', 'csc_product.level_2', 'csc_product.nama_kategori_en', 'csc_product.nama_kategori_in', 'csc_product.nama_kategori_chn', 'csc_product.created_at', 'csc_product.updated_at', 'csc_product.type', 'csc_product.logo')
                            ->where('id_itdp_profil_eks', $ryu->id)
                            ->where('csc_product_single.status', 2)
                            ->orderBy('nama_kategori_en', 'ASC')
                            ->get();
                        if (count($categoryutama) > 0) {
                            foreach ($categoryutama as $category) {
                                $catnya[] = $category->nama_kategori_en;
                            }
                        }
                        ?>
                        @if (count($catnya) > 0)
                            {{ implode(', ', $catnya) }}
                        @else
                            -
                        @endif
                    </td>
                @endif
                <td style="text-align: left;">
                    {{ date('d F Y', strtotime($ryu->verified_at)) }}
                </td>
            </tr>
            <?php $na++;
            } ?>

        </tbody>
    </table>
</div>
