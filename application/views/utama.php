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
            
            <!-- Custom Content -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                CAWANGAN JABATAN INSOLVENSI MALAYSIA (MdI)
                                <small>Senarai semua cawangan Jabatan Insolvensi Malaysia (MdI) di seluruh negara</small>
                            </h2>
                        </div>
                        <div class="body">
                            <?php
                            $OrgHQ = array_shift($organisasi);
                            $img = "images/bendera/{$OrgHQ->org_negeri}.png";
                            $img = (@getimagesize($img)) ? base_url($img) : $img = base_url()."images/bendera/Jata Negara.png";
                            ?>
                            <div class="row">
                                <div class="col-sm-offset-3 col-sm-6 col-md-offset-4 col-md-4">
                                    <div class="thumbnail">
                                        <img class="img-thumbnail" src="<?php echo $img; ?>">
                                        <div class="caption">
                                            <h3 class="text-center text-uppercase"><?php echo $OrgHQ->org_nama; ?></h3>
                                            <p>
                                                <a href="<?php echo site_url("utama/org/$OrgHQ->org_id"); ?>" class="btn btn-block bg-mdi waves-effect" role="button">Direktori <?php echo $OrgHQ->org_nama; ?></a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <?php
                            $OrgOther = array_chunk($organisasi,4);
                            foreach ($OrgOther as $OrgChunk) {
                            ?>
                            <div class="row">
                                <?php
                                foreach ($OrgChunk as $OrgSub) {
                                    $img = "images/bendera/{$OrgSub->org_negeri}.png";
                                    $img = (@getimagesize($img)) ? base_url($img) : $img = base_url()."images/bendera/Jata Negara.png";
                                ?>
                                <div class="col-sm-6 col-md-3">
                                    <div class="thumbnail">
                                        <img class="img-thumbnail" src="<?php echo $img; ?>">
                                        <div class="caption">
                                            <h3 class="text-center text-uppercase"><?php echo $OrgSub->org_nama; ?></h3>
                                            <p>
                                                <a href="<?php echo site_url("utama/org/$OrgSub->org_id"); ?>" class="btn btn-block bg-mdi waves-effect" role="button">Direktori <?php echo $OrgSub->org_nama; ?></a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Custom Content -->