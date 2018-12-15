            <!-- Breadcrumb -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <ol class="breadcrumb breadcrumb-bg-red">
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

            <?php if (!empty($penjawatan)) { ?>
            <!-- Media Alignment -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <?php
                                echo end($breadcrumb);
                                if (!empty($alamat->org_alamat) or !empty($alamat->org_poskod) or !empty($alamat->org_negeri) or !empty($alamat->org_tel) or !empty($alamat->org_fax) or !empty($alamat->org_emel)) {
                                    echo "<small>";
                                    if (!empty($alamat->org_alamat)) { echo "<div>" . nl2br($alamat->org_alamat) . "</div>"; }
                                    if (!empty($alamat->org_poskod) or !empty($alamat->org_negeri)) { echo "<div>{$alamat->org_poskod} {$alamat->org_negeri}</div>"; }
                                    if (!empty($alamat->org_tel)) { echo "<div>Tel: {$alamat->org_tel}</div>"; }
                                    if (!empty($alamat->org_fax)) { echo "<div>Fax: {$alamat->org_fax}</div>"; }
                                    if (!empty($alamat->org_emel)) { echo "E-Mel: {$alamat->org_emel}<br />"; }
                                    echo "</small>";
                                } 
                                ?>
                                <small>Senarai Pegawai di dalam organisasi</small>
                            </h2>
                            <div class="pull-right">
                                <div class="switch panel-switch-btn">
                                    <span class="m-r-10 font-12">JENIS PAPARAN</span>
                                    <label>JADUAL<input type="checkbox" id="chkPaparan" checked><span class="lever switch-col-cyan"></span>KAD</label>
                                </div>
                            </div>
                        </div>
                        <div class="body">
                            <div id="paparan_kad">
                                <div class="bs-example" data-example-id="media-alignment">
                                    <?php
                                    $penjawatan_chunk = array_chunk($penjawatan, 2);
                                    foreach($penjawatan_chunk as $pjwn_chunk) {
                                    ?>
                                    <div class="row clearfix">
                                        <?php foreach($pjwn_chunk as $pjwn) { ?>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="media">
                                                <div class="media-left">
                                                    <a href="javascript:void(0);">
                                                        <?php
                                                        $NamaImg = explode("@", $pjwn->staf_emel);
                                                        $StafImage = "images/staf/{$NamaImg[0]}.jpg";
                                                        $StafImage = (@getimagesize($StafImage)) ? base_url($StafImage) : $StafImage = base_url('images/staf/kosong.png');
                                                        ?>
                                                        <img class="media-object img-thumbnail" src="<?php echo $StafImage; ?>" width="138" height="197">
                                                    </a>
                                                </div>
                                                <div class="media-body">
                                                    <h4 class="media-heading" style="margin-top: 5px; margin-bottom: 10px;">
                                                        <?php echo (empty($pjwn->staf_nama)) ? $kosong : $pjwn->staf_nama; ?>
                                                    </h4>
                                                    <dl class="dl-horizontal" style="margin-bottom: 0px;">
                                                        <dt style="text-align: left;">Jawatan</dt>
                                                        <dd><p><?php echo (empty($pjwn->pjwn_gelaran)) ? $kosong : $pjwn->pjwn_gelaran; ?></p></dd>
                                                        <dt style="text-align: left;">Gelaran Jawatan</dt>
                                                        <dd><p><?php echo (empty($pjwn->pjwn_kod)) ? $kosong : $pjwn->pjwn_kod; ?></p></dd>
                                                        <dt style="text-align: left;">Gred</dt>
                                                        <dd><p><?php echo (empty($pjwn->staf_gred)) ? $kosong : $pjwn->staf_gred; ?></p></dd>
                                                        <dt style="text-align: left;">Taraf Jawatan</dt>
                                                        <dd><p><?php echo (empty($pjwn->staf_taraf)) ? $kosong : $pjwn->staf_taraf; ?></p></dd>
                                                        <dt style="text-align: left;">No. Telefon</dt>
                                                        <dd><p><?php echo (empty($pjwn->pjwn_tel)) ? $kosong : $pjwn->pjwn_tel; ?></p></dd>
                                                        <dt style="text-align: left;">Alamat Emel</dt>
                                                        <dd><p><?php echo (empty($pjwn->staf_emel)) ? $kosong : $pjwn->staf_emel; ?></p></dd>
                                                    </dl>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div id="paparan_jadual">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Jawatan</th>
                                            <th>Gelaran Jawatan</th>
                                            <th>Gred</th>
                                            <th>Taraf Jawatan</th>
                                            <th>No. Telefon</th>
                                            <th>Alamat Emel</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Jawatan</th>
                                            <th>Gelaran Jawatan</th>
                                            <th>Gred</th>
                                            <th>Taraf Jawatan</th>
                                            <th>No. Telefon</th>
                                            <th>Alamat Emel</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        $kosong = "";
                                        foreach($penjawatan as $pjwn) {
                                        ?>
                                        <tr>
                                            <td><?php echo (empty($pjwn->staf_nama)) ? $kosong : $pjwn->staf_nama; ?></td>
                                            <td><?php echo (empty($pjwn->pjwn_gelaran)) ? $kosong : $pjwn->pjwn_gelaran; ?></td>
                                            <td><?php echo (empty($pjwn->pjwn_kod)) ? $kosong : $pjwn->pjwn_kod; ?></td>
                                            <td><?php echo (empty($pjwn->staf_gred)) ? $kosong : $pjwn->staf_gred; ?></td>
                                            <td><?php echo (empty($pjwn->staf_taraf)) ? $kosong : $pjwn->staf_taraf; ?></td>
                                            <td><?php echo (empty($pjwn->pjwn_tel)) ? $kosong : $pjwn->pjwn_tel; ?></td>
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
            <!-- #END# Media Alignment -->
            <?php } ?>

            <?php if (!empty($organisasi)) { ?>
            <!-- Button Items -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <?php
                                echo end($breadcrumb);
                                if (!empty($alamat->org_alamat) or !empty($alamat->org_poskod) or !empty($alamat->org_negeri) or !empty($alamat->org_tel) or !empty($alamat->org_fax) or !empty($alamat->org_emel)) {
                                    echo "<small>";
                                    if (!empty($alamat->org_alamat)) { echo "<div>" . nl2br($alamat->org_alamat) . "</div>"; }
                                    if (!empty($alamat->org_poskod) or !empty($alamat->org_negeri)) { echo "<div>{$alamat->org_poskod} {$alamat->org_negeri}</div>"; }
                                    if (!empty($alamat->org_tel)) { echo "<div>Tel: {$alamat->org_tel}</div>"; }
                                    if (!empty($alamat->org_fax)) { echo "<div>Fax: {$alamat->org_fax}</div>"; }
                                    if (!empty($alamat->org_emel)) { echo "E-Mel: {$alamat->org_emel}<br />"; }
                                    echo "</small>";
                                } 
                                ?>
                                <small>Senarai Pejabat/Bahagian/Seksyen/Unit</small>
                            </h2>
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