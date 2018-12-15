            <div class="block-header">
                <h2><?php echo $title; ?></h2>
            </div>

            <div class="row clearfix">
                
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>Senarai Penjawatan</h2>
                            <ul class="header-dropdown m-r--5">
                                <li>
                                    <a href="<?php echo site_url('pentadbir/penjawatan/tambah'); ?>">
                                        <i class="material-icons">add_box</i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            
                            <div class="row clearfix">
                                <div class="col-md-12">
                                    <form method="post" autocomplete="off">
                                        <div class="form-group form-float">
                                            <div class="form-line<?php // echo $focused . $error; ?>">
                                                <select id="slcOrg" name="slcOrg" class="form-control show-tick" data-live-search="true">
                                                    <option value="">-- Papar Semua Organisasi --</option>
                                                    <?php foreach ($senarai_org as $org_id => $org_nama) { ?>
                                                    <option value="<?php echo $org_id; ?>"><?php echo $org_nama; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <label class="form-label" style="top: -10px; font-size: 12px;">Organisasi</label>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                            <table id="tblSenaraiPenjawatan" class="table table-bordered table-striped table-hover dataTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Gelaran</th>
                                        <th>Nama Pegawai</th>
                                        <th>Kod</th>
                                        <th>Gred</th>
                                        <th>Organisasi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Gelaran</th>
                                        <th>Nama Pegawai</th>
                                        <th>Kod</th>
                                        <th>Gred</th>
                                        <th>Organisasi</th>
                                    </tr>
                                </tfoot>
                            </table>
                            <?php
                            // Highlight newly added data
                            $inpNew = 0;
                            if (isset($_SESSION['NewID'])) {
                                $inpNew = $_SESSION['NewID'];
                                unset($_SESSION['NewID']);
                            }
//                            
                            echo "<input type=\"hidden\" id=\"inpNew\" value=\"$inpNew\">";
                            ?>
                        </div>
                    </div>
                </div>
                
            </div>