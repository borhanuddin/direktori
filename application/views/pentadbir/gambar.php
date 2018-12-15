            <div class="block-header">
                <h2><?php echo $title; ?></h2>
            </div>

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>Muat Naik Gambar Staf</h2>
                            <ul class="header-dropdown m-r--5">
                                <li>
                                    <a href="#" id="DropzoneReset">
                                        <i class="material-icons">autorenew</i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <form action="<?php echo site_url('/pentadbir/gambar/muatnaik'); ?>" id="frmFileUpload" class="dropzone" method="post" enctype="multipart/form-data">
                                <div class="dz-message">
                                    <div class="drag-icon-cph">
                                        <i class="material-icons">touch_app</i>
                                    </div>
                                    <h3>Lepaskan fail di sini atau klik untuk muat naik.</h3>
                                    <em>Fail gambar hendaklah dalam format <strong>jpg</strong> sahaja serta saiz hendaklah tidak lebih dari <strong>30kb</strong>.</em><br />
                                    <em>Dimensi fail gambar : <strong>138 x 197 pixels</strong>; Resolusi : <strong>72 dpi</strong>; Kedalaman Bit : <strong>24</strong></em><br />
                                    <em>Penamaan fail gambar hendaklah sama seperti nama e-mel rasmi sebelum aksara <strong>@</strong>.</em><br />
                                    <em>Contoh: syed.alwi@mdi.gov.my => <strong>syed.alwi.jpg</strong></em>
                                </div>
                                <div class="fallback">
                                    <input name="file" type="file" multiple />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Senarai Gambar
                            </h2>
                        </div>
                        <div class="body">
                            <table id="tblSenaraiGambar" class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
                                        <th>Nama Fail</th>
                                        <th>Saiz (bait)</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Nama Fail</th>
                                        <th>Saiz (bait)</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
