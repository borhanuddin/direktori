            <div class="block-header">
                <h2><?php echo $title; ?></h2>
            </div>

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="info-box hover-zoom-effect hover-expand-effect">
                        <div class="icon bg-pink">
                            <i class="material-icons">supervisor_account</i>
                        </div>
                        <div class="content">
                            <div class="text">PERINGKAT CAPAIAN</div>
                            <div class="number"><?php echo $profail->aks_nama; ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Hover Zoom Effect -->

            <!-- Basic Card -->
            <div class="row clearfix">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>Maklumat Staf</h2>
                            <ul class="header-dropdown m-r--5">
                                <li>
                                    <a href="<?php echo site_url('pentadbir/profail/kemaskini_staf'); ?>">
                                        <i class="material-icons">edit</i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="bs-example" data-example-id="media-alignment">
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-21 col-sm-12 col-xs-12" style="margin-bottom: 0;">
                                        <div class="media" style="margin-bottom: 0;">
                                            <div class="media-left">
                                                <a href="javascript:void(0);">
                                                    <?php
                                                    $NamaImg = explode("@", $profail->staf_emel);
                                                    $StafImage = "images/staf/{$NamaImg[0]}.jpg";
                                                    $StafImage = (@getimagesize($StafImage)) ? base_url($StafImage) : $StafImage = '../../images/user.png';
                                                    ?>
                                                    <img class="media-object img-thumbnail" src="<?php echo $StafImage; ?>" width="138" height="197">
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <h4 class="media-heading" style="margin-top: 5px; margin-bottom: 10px;">
                                                    <?php echo (empty($profail->staf_nama)) ? $kosong : "{$profail->staf_gelaran} {$profail->staf_nama}"; ?>
                                                </h4>
                                                <dl class="dl-horizontal" style="margin-bottom: 0px;">
                                                    <dt style="text-align: left;">MyKad</dt>
                                                    <dd><p><?php echo (empty($profail->staf_mykad)) ? $kosong : $profail->staf_mykad; ?></p></dd>
                                                    <dt style="text-align: left;">Jawatan</dt>
                                                    <dd><p><?php echo (empty($profail->staf_jawatan)) ? $kosong : $profail->staf_jawatan; ?></p></dd>
                                                    <dt style="text-align: left;">Gred</dt>
                                                    <dd><p><?php echo (empty($profail->staf_gred)) ? $kosong : $profail->staf_gred; ?></p></dd>
                                                    <dt style="text-align: left;">Taraf Jawatan</dt>
                                                    <dd><p><?php echo (empty($profail->staf_taraf)) ? $kosong : $profail->staf_taraf; ?></p></dd>
                                                    <dt style="text-align: left;">Alamat Emel</dt>
                                                    <dd><p><?php echo (empty($profail->staf_emel)) ? $kosong : $profail->staf_emel; ?></p></dd>
                                                    <dt style="text-align: left;">Status</dt>
                                                    <dd><p><?php echo (empty($profail->staf_status)) ? $kosong : $profail->staf_status; ?></p></dd>
                                                    <dt style="text-align: left;">Catatan</dt>
                                                    <dd><p><?php echo (empty($profail->staf_catatan)) ? $kosong : nl2br($profail->staf_catatan); ?></p></dd>
                                                </dl>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Maklumat Penjawatan
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li>
                                    <a href="<?php echo site_url('pentadbir/profail/kemaskini_penjawatan'); ?>">
                                        <i class="material-icons">edit</i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            
                            <dl class="dl-horizontal" style="margin-bottom: 0px;">
                                <dt style="text-align: left;">Gelaran Jawatan</dt>
                                <dd><p><?php echo (empty($profail->staf_jawatan)) ? $kosong : $profail->staf_jawatan; ?></p></dd>
                                <dt style="text-align: left;">Singkatan Penjawatan</dt>
                                <dd><p><?php echo (empty($profail->pjwn_kod)) ? $kosong : $profail->pjwn_kod; ?></p></dd>
                                <dt style="text-align: left;">Gred</dt>
                                <dd><p><?php echo (empty($profail->pjwn_gred)) ? $kosong : $profail->pjwn_gred; ?></p></dd>
                                <dt style="text-align: left;">No. Telefon</dt>
                                <dd><p><?php echo (empty($profail->pjwn_tel)) ? $kosong : $profail->pjwn_tel; ?></p></dd>
                                <dt style="text-align: left;">Organisasi</dt>
                                <dd><p><?php echo (empty($profail->org_nama)) ? $kosong : $profail->org_nama; ?></p></dd>
                                <dt style="text-align: left;">Penyelia</dt>
                                <dd><p><?php echo (empty($profail->pjwn_penyelia_nama)) ? $kosong : $profail->pjwn_penyelia_nama; ?></p></dd>
                                <dt style="text-align: left;">Catatan</dt>
                                <dd><p><?php echo (empty($profail->pjwn_catatan)) ? $kosong : nl2br($profail->pjwn_catatan); ?></p></dd>
                            </dl>
                            
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Basic Card -->
            
            