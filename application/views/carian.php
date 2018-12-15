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
                                    echo "<li><a href=\"$k\"><i class=\"material-icons\">search</i> $v</a></li>";
                                } else {
                                    echo "<li class=\"active\"><i class=\"material-icons\">search</i> $v</li>";
                                }
                            }
                        }
                        ?>
                    </ol>
                </div>
            </div>
            
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="block-header">
                        <h2>HASIL CARIAN<small>Carian meliputi maklumat staf, penjawatan dan organisasi</small></h2>
                    </div>
                </div>
            </div>
            
            <!-- Custom Content -->
            <?php if (!empty($carian['organisasi'])) { ?>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>ORGANISASI</h2>
                        </div>
                        <div class="body">
                            <div class="list-group">
                                <?php foreach($carian['organisasi'] as $org) { ?>
                                <a href="<?php echo site_url("utama/org/$org->org_id"); ?>" class="list-group-item waves-effect" style="display: block;">
                                    <?php
                                    $Full_Org = $org->org_nama;
                                    $Full_Org .= (empty($org->po_org_nama)) ? '' : ", {$org->po_org_nama}";
                                    $Full_Org .= (empty($org->ppo_org_nama)) ? '' : ", {$org->ppo_org_nama}";
                                    $Full_Org .= (empty($org->pppo_org_nama)) ? '' : ", {$org->pppo_org_nama}";
                                    echo $Full_Org;
                                    ?>
                                </a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
            
            <?php if (!empty($carian['staf'])) { ?>
            <div id="paparan_kad">
                
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header">
                                <h2>SENARAI STAF</h2>
                            </div>
                        </div>
                    </div>
                </div>
                
                <?php
                $penjawatan_chunk = array_chunk($carian['staf'], 2);
                foreach ($penjawatan_chunk as $pjwn_chunk) {
                ?>
                <div class="row clearfix">
                    <?php foreach($pjwn_chunk as $pjwn) { ?>
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="header bg-mdi">
                                <h2 style="text-transform: uppercase;">
                                    <?php echo (empty($pjwn->staf_nama)) ? $kosong : $pjwn->staf_nama; ?>
                                </h2>
                            </div>
                            <div class="body cover-jata cover-right">
                                
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
                                        <dl style="margin-bottom: 0px;">
                                            <dt>Jawatan</dt>
                                            <dd style="word-break: break-all;"><p><?php echo (empty($pjwn->pjwn_gelaran)) ? $kosong : $pjwn->pjwn_gelaran; ?></p></dd>
                                            <dt>No. Telefon</dt>
                                            <dd style="word-break: break-all;"><p><?php echo (empty($pjwn->pjwn_tel)) ? $kosong : $pjwn->pjwn_tel; ?><?php echo (empty($pjwn->pjwn_tel_samb)) ? '' : " samb. {$pjwn->pjwn_tel_samb}"; ?></p></dd>
                                            <dt>Alamat Emel</dt>
                                            <dd style="word-break: break-all;"><p><?php echo (empty($pjwn->staf_emel)) ? $kosong : $pjwn->staf_emel; ?></p></dd>
                                            <dt>Organisasi</dt>
                                            <dd style="word-break: break-all;">
                                                <a href="<?php echo site_url("utama/org/$pjwn->org_id"); ?>">
                                                    <?php
                                                    $Full_Pjwn = $pjwn->org_nama;
                                                    $Full_Pjwn .= (empty($pjwn->po_org_nama)) ? '' : ",<br />{$pjwn->po_org_nama}";
                                                    $Full_Pjwn .= (empty($pjwn->ppo_org_nama)) ? '' : ",<br />{$pjwn->ppo_org_nama}";
                                                    $Full_Pjwn .= (empty($pjwn->pppo_org_nama)) ? '' : ",<br />{$pjwn->pppo_org_nama}";
                                                    echo $Full_Pjwn;
                                                    ?>
                                                </a>
                                            </dd>
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
                            <div class="header">
                                <h2>SENARAI STAF</h2>
                            </div>
                            <div class="body">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Jawatan</th>
                                            <th>Gred</th>
                                            <th>Taraf Jawatan</th>
                                            <th>No. Telefon</th>
                                            <th>Alamat Emel</th>
                                            <th>Organisasi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Jawatan</th>
                                            <th>Gred</th>
                                            <th>Taraf Jawatan</th>
                                            <th>No. Telefon</th>
                                            <th>Alamat Emel</th>
                                            <th>Organisasi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        $kosong = "";
                                        foreach($carian['staf'] as $pjwn) {
                                            ?>
                                            <tr>
                                                <td><?php echo (empty($pjwn->staf_nama)) ? $kosong : $pjwn->staf_nama; ?></td>
                                                <td><?php echo (empty($pjwn->pjwn_gelaran)) ? $kosong : $pjwn->pjwn_gelaran; ?></td>
                                                <td><?php echo (empty($pjwn->staf_gred)) ? $kosong : $pjwn->staf_gred; ?></td>
                                                <td><?php echo (empty($pjwn->staf_taraf)) ? $kosong : $pjwn->staf_taraf; ?></td>
                                                <td><?php echo (empty($pjwn->pjwn_tel)) ? $kosong : $pjwn->pjwn_tel; ?></td>
                                                <td><?php echo (empty($pjwn->staf_emel)) ? $kosong : $pjwn->staf_emel; ?></td>
                                                <td><a href="<?php echo site_url("utama/org/$pjwn->org_id"); ?>"><?php echo $pjwn->org_nama; ?></a></td>
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
            
            <?php if ((empty($carian['staf'])) AND (empty($carian['organisasi']))) { ?>
            <div class="row clearfix">
                <div class="col-xs-12">
                    
                    <div class="alert alert-danger">
                        <strong>CARIAN TIDAK DIJUMPAI!</strong> Tiada sebarang maklumat dijumpai berkaitan <strong><?php echo $katacarian; ?></strong>
                    </div>
                    
                </div>
            </div>
            
            <?php } ?>
            <!-- #END# Custom Content -->