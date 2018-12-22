            <!-- Breadcrumb -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <ol class="breadcrumb breadcrumb-bg-mdi">
                        <li><a href="<?php echo site_url(); ?>"><i class="material-icons">home</i> Laman Utama</a></li>
                        <?php
                        if (isset($breadcrumb)) {
                            foreach ($breadcrumb as $k => $v) {
                                // if not last element
                                if(end($breadcrumb) !== $v){
                                    echo "<li><a href=\"$k\"><i class=\"material-icons\">account_balance</i> $v</a></li>";
                                } else {
                                    echo "<li class=\"active\"><i class=\"material-icons\">account_balance</i> $v</li>";
                                }
                            }
                        }
                        ?>
                    </ol>
                </div>
            </div>
            <!-- #END# Breadcrumb -->
            
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <h3 class="m-b-25"><?php
                    echo end($breadcrumb);
                    if (!empty($alamat->org_alamat) or !empty($alamat->org_tel) or !empty($alamat->org_fax) or !empty($alamat->org_emel)) {
                        echo "<small style=\"display: block; margin-top: 8px;\">";
                        if (!empty($alamat->org_alamat)) { echo "<div>" . nl2br($alamat->org_alamat) . "</div>"; }
                        if (!empty($alamat->org_poskod) or !empty($alamat->org_negeri)) { echo "<div>{$alamat->org_poskod} {$alamat->org_negeri}</div>"; }
                        if ((!empty($alamat->org_tel)) or (!empty($alamat->org_fax)) or (!empty($alamat->org_emel))) { echo "<br />" ;}
                        if (!empty($alamat->org_tel)) { echo "<div>Tel: {$alamat->org_tel}</div>"; }
                        if (!empty($alamat->org_fax)) { echo "<div>Fax: {$alamat->org_fax}</div>"; }
                        if (!empty($alamat->org_emel)) { echo "E-Mel: {$alamat->org_emel}<br />"; }
                        echo "</small>";
                        }
                        ?></h3>
                </div>
            </div>
            
            <?php if (!empty($penjawatan)) { ?>
            <div id="paparan_kad">
                <?php
                $pjwn_key = 0;
                $size_pjwn = sizeof($penjawatan);
                for ($i=0; $i < $size_pjwn; $i++) {
                    if (0 == $penjawatan[$i]->pjwn_hirarki) {
                        $pjwn_key = $i;
                        break;
                    }
                }
                $pjwn_ketua = $penjawatan[$pjwn_key];
                unset($penjawatan[$pjwn_key]);
                if (0 == $pjwn_ketua->pjwn_hirarki) {
                ?>
                <div class="row clearfix">
                    <div class="col-sm-6 col-sm-offset-3">
                        <div class="card">
                            <div class="header bg-mdi">
                                <h2 style="text-transform: uppercase;">
                                    <?php
                                    if (empty($pjwn_ketua->staf_nama)) {
                                        echo $kosong;
                                    } else {
                                        if (!empty($pjwn_ketua->staf_gelaran)) {
                                            echo "{$pjwn_ketua->staf_gelaran} ";
                                        }
                                        echo $pjwn_ketua->staf_nama;
                                    }
                                    ?>
                                </h2>
                            </div>
                            <div class="body cover-jata cover-right">
                                <div class="media" style="margin-bottom: 0px;">
                                    <div class="media-left">
                                        <a href="javascript:void(0);">
                                            <?php
                                            $NamaImg = explode("@", $pjwn_ketua->staf_emel);
                                            $StafImage = "images/staf/{$NamaImg[0]}.jpg";
                                            $StafImage = (@getimagesize($StafImage)) ? base_url($StafImage) : $StafImage = base_url('images/staf/kosong.png');
                                            ?>
                                            <img class="media-object img-thumbnail" src="<?php echo $StafImage; ?>" width="100" height="143">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <dl style="margin-bottom: 0px;">
                                            <dt>Jawatan</dt>
                                            <dd style="word-break: break-all;"><p><?php echo (empty($pjwn_ketua->pjwn_gelaran)) ? $kosong : $pjwn_ketua->pjwn_gelaran; ?></p></dd>
                                            <dt>No. Telefon</dt>
                                            <dd style="word-break: break-all;"><p><?php echo (empty($pjwn_ketua->pjwn_tel)) ? $kosong : $pjwn_ketua->pjwn_tel; ?><?php echo (empty($pjwn_ketua->pjwn_tel_samb)) ? '' : " samb. {$pjwn_ketua->pjwn_tel_samb}"; ?></p></dd>
                                            <dt>Emel</dt>
                                            <dd style="word-break: break-all;"><p><?php echo (empty($pjwn_ketua->staf_emel)) ? $kosong : $pjwn_ketua->staf_emel; ?></p></dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <?php
                $penjawatan_chunk = array_chunk($penjawatan, 2);
                foreach ($penjawatan_chunk as $pjwn_chunk) {
                ?>
                <div class="row clearfix">
                    <?php foreach($pjwn_chunk as $pjwn) { ?>
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="header bg-mdi">
                                <h2 style="text-transform: uppercase;">
                                    <?php
                                    if (empty($pjwn->staf_nama)) {
                                        echo $kosong;
                                    } else {
                                        if (!empty($pjwn->staf_gelaran)) {
                                            echo "{$pjwn->staf_gelaran} ";
                                        }
                                        echo $pjwn->staf_nama;
                                    }
                                    ?>
                                </h2>
                            </div>
                            <div class="body cover-jata cover-right">
                                
                                <div class="media" style="margin-bottom: 0px;">
                                    <div class="media-left">
                                        <a href="javascript:void(0);">
                                            <?php
                                            $NamaImg = explode("@", $pjwn->staf_emel);
                                            $StafImage = "images/staf/{$NamaImg[0]}.jpg";
                                            $StafImage = (@getimagesize($StafImage)) ? base_url($StafImage) : $StafImage = base_url('images/staf/kosong.png');
                                            ?>
                                            <img class="media-object img-thumbnail" src="<?php echo $StafImage; ?>" width="100" height="143">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <dl style="margin-bottom: 0px;">
                                            <dt>Jawatan</dt>
                                            <dd style="word-break: break-all;"><p><?php echo (empty($pjwn->pjwn_gelaran)) ? $kosong : $pjwn->pjwn_gelaran; ?></p></dd>
                                            <dt>No. Telefon</dt>
                                            <dd style="word-break: break-all;"><p><?php echo (empty($pjwn->pjwn_tel)) ? $kosong : $pjwn->pjwn_tel; ?><?php echo (empty($pjwn->pjwn_tel_samb)) ? '' : " samb. {$pjwn->pjwn_tel_samb}"; ?></p></dd>
                                            <dt>Emel</dt>
                                            <dd style="word-break: break-all;"><p><?php echo (empty($pjwn->staf_emel)) ? $kosong : $pjwn->staf_emel; ?></p></dd>
                                        </dl>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <?php } ?>
            </div>
            
            <div id="paparan_jadual">
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="body">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>Gelaran</th>
                                            <th>Nama</th>
                                            <th>Jawatan</th>
                                            <th>No. Telefon</th>
                                            <th>Alamat Emel</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Gelaran</th>
                                            <th>Nama</th>
                                            <th>Jawatan</th>
                                            <th>No. Telefon</th>
                                            <th>Alamat Emel</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php foreach ($penjawatan as $pjwn) { ?>
                                            <tr>
                                                <td><?php echo (empty($pjwn->staf_nama)) ? $kosong : $pjwn->staf_gelaran; ?></td>
                                                <td><?php echo (empty($pjwn->staf_nama)) ? $kosong : $pjwn->staf_nama; ?></td>
                                                <td><?php echo (empty($pjwn->pjwn_gelaran)) ? $kosong : $pjwn->pjwn_gelaran; ?></td>
                                                <td><?php echo (empty($pjwn->pjwn_tel)) ? $kosong : $pjwn->pjwn_tel; ?><?php echo (empty($pjwn->pjwn_tel_samb)) ? '' : " samb. {$pjwn->pjwn_tel_samb}"; ?></td>
                                                <td><?php echo (empty($pjwn->staf_emel)) ? $kosong : $pjwn->staf_emel; ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
            
            <?php if ((0 == $papar_sub) and (!empty($organisasi))) { ?>
            <!-- Button Items -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>ORGANISASI<small>Senarai Pejabat/Bahagian/Seksyen/Unit</small></h2>
                        </div>
                        <div class="body">
                            <div class="list-group">
                                <?php foreach($organisasi as $org) { ?>
                                <a href="<?php echo $org->org_id; ?>" class="list-group-item waves-effect" style="display: block;"><?php echo $org->org_nama; ?></a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Button Items -->
            <?php } ?>
            
            <?php
            if ((1 == $papar_sub) and (!empty($sub_organisasi))) {
                foreach ($sub_organisasi as $s_org_id => $s_org_nama) { ?>
            
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <h4 class=\"m-b-25\"><?php echo $s_org_nama; ?></h4>
                </div>
            </div>
            
            <div id="paparan_kad">
                <?php
                $sub_penjawatan_chunk = array_chunk($sub_penjawatan[$s_org_id], 2);
                foreach ($sub_penjawatan_chunk as $s_pjwn_chunk) {
                ?>
                <div class="row clearfix">
                    <?php foreach($s_pjwn_chunk as $s_pjwn) { ?>
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="header bg-mdi">
                                <h2 style="text-transform: uppercase;">
                                    <?php echo (empty($s_pjwn->staf_nama)) ? $kosong : "{$s_pjwn->staf_gelaran} {$s_pjwn->staf_nama}"; ?>
                                </h2>
                            </div>
                            <div class="body cover-jata cover-right">
                                
                                <div class="media" style="margin-bottom: 0px;">
                                    <div class="media-left">
                                        <a href="javascript:void(0);">
                                            <?php
                                            $NamaImg = explode("@", $s_pjwn->staf_emel);
                                            $StafImage = "images/staf/{$NamaImg[0]}.jpg";
                                            $StafImage = (@getimagesize($StafImage)) ? base_url($StafImage) : $StafImage = base_url('images/staf/kosong.png');
                                            ?>
                                            <img class="media-object img-thumbnail" src="<?php echo $StafImage; ?>" width="100" height="143">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <dl style="margin-bottom: 0px;">
                                            <dt>Jawatan</dt>
                                            <dd style="word-break: break-all;"><p><?php echo (empty($s_pjwn->pjwn_gelaran)) ? $kosong : $s_pjwn->pjwn_gelaran; ?></p></dd>
                                            <dt>No. Telefon</dt>
                                            <dd style="word-break: break-all;"><p><?php echo (empty($s_pjwn->pjwn_tel)) ? $kosong : $s_pjwn->pjwn_tel; ?><?php echo (empty($s_pjwn->pjwn_tel_samb)) ? '' : " samb. {$s_pjwn->pjwn_tel_samb}"; ?></p></dd>
                                            <dt>Emel</dt>
                                            <dd style="word-break: break-all;"><p><?php echo (empty($s_pjwn->staf_emel)) ? $kosong : $s_pjwn->staf_emel; ?></p></dd>
                                        </dl>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <?php } ?>
            </div>
            
            <?php } } ?>