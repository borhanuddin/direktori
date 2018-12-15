            <div class="block-header">
                <h2><?php echo $title; ?></h2>
            </div>

            <div class="row clearfix">
                
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>Senarai Staf</h2>
                            <ul class="header-dropdown m-r--5">
                                <li>
                                    <a href="<?php echo site_url('pentadbir/staf/tambah'); ?>">
                                        <i class="material-icons">add_box</i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <table id="tblSenaraiStaf" class="table table-bordered table-striped table-hover dataTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>MyKad</th>
                                        <th>Gelaran</th>
                                        <th>Nama</th>
                                        <th>Jawatan</th>
                                        <th>Gred</th>
                                        <th>Taraf</th>
                                        <th>Emel</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>MyKad</th>
                                        <th>Gelaran</th>
                                        <th>Nama</th>
                                        <th>Jawatan</th>
                                        <th>Gred</th>
                                        <th>Taraf</th>
                                        <th>Emel</th>
                                        <th>Status</th>
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
                            echo "<input type=\"hidden\" id=\"inpNew\" value=\"$inpNew\">";
                            ?> 
                        </div>
                    </div>
                </div>
                
            </div>