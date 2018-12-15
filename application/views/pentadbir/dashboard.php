            <div class="block-header">
                <h2><?php echo $title; ?></h2>
            </div>

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <img src="<?php echo base_url(); ?>images/Jata Negara.png" class="center-block" width="128" height="100" alt="Jata Negara"/>
                    <h1 class="text-center font-50 font-bold col-mdi">Direktori MdI</h1>
                    <h2 class="text-center">Pentadbir Sistem Direktori MdI<br /><small>Versi 1.0.3</small></h2>
                </div>
            </div>
            
            <div class="row clearfix m-t-25">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box hover-zoom-effect hover-expand-effect">
                        <div class="icon bg-deep-orange">
                            <i class="material-icons">account_balance</i>
                        </div>
                        <div class="content">
                            <div class="text">ORGANISASI</div>
                            <div class="number count-to" data-from="0" data-to="<?php echo $bil_org; ?>" data-speed="2000" data-fresh-interval="1"><?php echo $bil_org; ?></div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box hover-zoom-effect hover-expand-effect">
                        <div class="icon bg-blue">
                            <i class="material-icons">contacts</i>
                        </div>
                        <div class="content">
                            <div class="text">PENJAWATAN</div>
                            <div class="number count-to" data-from="0" data-to="<?php echo $bil_pjwn; ?>" data-speed="2000" data-fresh-interval="1"><?php echo $bil_pjwn; ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box hover-zoom-effect hover-expand-effect">
                        <div class="icon bg-purple">
                            <i class="material-icons">wc</i>
                        </div>
                        <div class="content">
                            <div class="text">STAF</div>
                            <div class="number count-to" data-from="0" data-to="<?php echo $bil_staf; ?>" data-speed="2000" data-fresh-interval="1"><?php echo $bil_staf; ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box hover-zoom-effect hover-expand-effect">
                        <div class="icon bg-teal">
                            <i class="material-icons">account_box</i>
                        </div>
                        <div class="content">
                            <div class="text">GAMBAR STAF</div>
                            <div class="number count-to" data-from="0" data-to="<?php echo $bil_gambar; ?>" data-speed="2000" data-fresh-interval="1"><?php echo $bil_gambar; ?></div>
                        </div>
                    </div>
                </div>
            </div>
            