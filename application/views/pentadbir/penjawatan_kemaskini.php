            <div class="block-header">
                <h2><?php echo $title; ?></h2>
            </div>

            <!-- Vertical Layout | With Floating Label -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>Kemaskini Penjawatan<small>Ruangan bertanda asterik (*) wajib diisi.</small></h2>
                        </div>
                        <div class="body">
                            <form method="post" autocomplete="off">
                                <div class="row clearfix">
                                    <div class="col-md-4">
                                        <div class="form-group form-float">
                                            <?php
                                            $FormName = 'inpGelaran';
                                            $value = (empty(set_value($FormName))) ? $penjawatan->pjwn_gelaran : set_value($FormName);
                                            $focused = (empty($value) && !is_numeric($value)) ? '' : ' focused';
                                            $error = (empty(form_error($FormName))) ? '' : ' error';
                                            ?>
                                            <div class="form-line<?php echo $focused . $error; ?>">
                                                <input id="inpGelaran" name="inpGelaran" type="text" class="form-control typeahead" value="<?php echo $value; ?>" data-json='<?php echo json_encode($senarai_gelaran_penjawatan); ?>'>
                                                <label class="form-label">Gelaran *</label>
                                            </div>
                                            <?php echo form_error($FormName, "<label class=\"error\" for=\"$FormName\">", '</label>'); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group form-float">
                                            <?php
                                            $FormName = 'inpKod';
                                            $value = (empty(set_value($FormName))) ? $penjawatan->pjwn_kod : set_value($FormName);
                                            $focused = (empty($value) && !is_numeric($value)) ? '' : ' focused';
                                            $error = (empty(form_error($FormName))) ? '' : ' error';
                                            ?>
                                            <div class="form-line<?php echo $focused . $error; ?>">
                                                <input id="inpKod" name="inpKod" type="text" class="form-control" value="<?php echo $value; ?>">
                                                <label class="form-label">Singkatan Gelaran</label>
                                            </div>
                                            <?php echo form_error($FormName, "<label class=\"error\" for=\"$FormName\">", '</label>'); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group form-float">
                                            <?php
                                            $FormName = 'inpGred';
                                            $value = (empty(set_value($FormName))) ? $penjawatan->pjwn_gred : set_value($FormName);
                                            $focused = (empty($value) && !is_numeric($value)) ? '' : ' focused';
                                            $error = (empty(form_error($FormName))) ? '' : ' error';
                                            ?>
                                            <div class="form-line<?php echo $focused . $error; ?>">
                                                <input id="inpGred" name="inpGred" type="text" class="form-control" value="<?php echo $value; ?>">
                                                <label class="form-label">Gred</label>
                                            </div>
                                            <?php echo form_error($FormName, "<label class=\"error\" for=\"$FormName\">", '</label>'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-1">
                                        <div class="form-group form-float">
                                            <?php
                                            $FormName = 'inpHirarki';
                                            $value = (empty(set_value($FormName))) ? $penjawatan->pjwn_hirarki : set_value($FormName);
                                            $focused = (empty($value) && !is_numeric($value)) ? '' : ' focused';
                                            $error = (empty(form_error($FormName))) ? '' : ' error';
                                            ?>
                                            <div class="form-line<?php echo $focused . $error; ?>">
                                                <input id="inpHirarki" name="inpHirarki" type="number" class="form-control" value="<?php echo $value; ?>">
                                                <label class="form-label">Hirarki *</label>
                                            </div>
                                            <?php echo form_error($FormName, "<label class=\"error\" for=\"$FormName\">", '</label>'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group form-float">
                                            <?php
                                            $FormName = 'inpTel';
                                            $value = (empty(set_value($FormName))) ? $penjawatan->pjwn_tel : set_value($FormName);
                                            $focused = (empty($value) && !is_numeric($value)) ? '' : ' focused';
                                            $error = (empty(form_error($FormName))) ? '' : ' error';
                                            ?>
                                            <div class="form-line<?php echo $focused . $error; ?>">
                                                <input id="inpTel" name="inpTel" type="text" class="form-control tel" value="<?php echo $value; ?>">
                                                <label class="form-label">No. Telefon</label>
                                            </div>
                                            <?php echo form_error($FormName, "<label class=\"error\" for=\"$FormName\">", '</label>'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group form-float">
                                            <?php
                                            $FormName = 'inpTelSamb';
                                            $value = (empty(set_value($FormName))) ? $penjawatan->pjwn_tel_samb : set_value($FormName);
                                            $focused = (empty($value) && !is_numeric($value)) ? '' : ' focused';
                                            $error = (empty(form_error($FormName))) ? '' : ' error';
                                            ?>
                                            <div class="form-line<?php echo $focused . $error; ?>">
                                                <input id="inpTelSamb" name="inpTelSamb" type="text" class="form-control telsamb" value="<?php echo $value; ?>" title="Tekan butang [space bar] untuk no. seterusnya">
                                                <label class="form-label">Sambungan</label>
                                            </div>
                                            <?php echo form_error($FormName, "<label class=\"error\" for=\"$FormName\">", '</label>'); ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-md-6">
                                        <div class="form-group form-float">
                                            <?php
                                            $FormName = 'slcStaf';
                                            $value = (empty(set_value($FormName))) ? $penjawatan->pjwn_staf_id : set_value($FormName);
                                            $focused = (empty($value) && !is_numeric($value)) ? '' : ' focused';
                                            $error = (empty(form_error($FormName))) ? '' : ' error';
                                            ?>
                                            <div class="form-line<?php echo $focused . $error; ?>">
                                                <select id="slcStaf" name="slcStaf" class="form-control show-tick" data-live-search="true">
                                                    <option value="">-- Sila Pilih --</option>
                                                    <?php  foreach ($senarai_staf as $org_nama => $penyelia) { ?>
                                                    <optgroup label="<?php echo empty($org_nama) ? "-Tiada Organisasi-" : $org_nama; ?>">
                                                        <?php foreach ($penyelia as $pjwn_id => $staf_nama) { ?>
                                                        <option value="<?php echo $pjwn_id; ?>"<?php if ($pjwn_id == $value) { echo ' selected'; } ?>><?php echo $staf_nama; ?></option>
                                                        <?php } ?>
                                                    <?php if(end($senarai_penyelia) === $organisasi) { ?>
                                                    </optgroup>
                                                    <?php } } ?>
                                                </select>
                                                <label class="form-label" style="top: -10px; font-size: 12px;">Nama Pegawai </label>
                                            </div>
                                            <?php echo form_error($FormName, "<label class=\"error\" for=\"$FormName\">", '</label>'); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-float">
                                            <?php
                                            $FormName = 'slcPenyelia';
                                            $value = (empty(set_value($FormName))) ? $penjawatan->pjwn_penyelia_pjwn_id : set_value($FormName);
                                            $focused = (empty($value) && !is_numeric($value)) ? '' : ' focused';
                                            $error = (empty(form_error($FormName))) ? '' : ' error';
                                            ?>
                                            <div class="form-line<?php echo $focused . $error; ?>">
                                                <select id="slcPenyelia" name="slcPenyelia" class="form-control show-tick" data-live-search="true">
                                                    <option value="">-- Sila Pilih --</option>
                                                    <?php  foreach ($senarai_penyelia as $org_nama => $penyelia) { ?>
                                                    <optgroup label="<?php echo $org_nama; ?>">
                                                        <?php foreach ($penyelia as $pjwn_id => $staf_nama) { ?>
                                                        <option value="<?php echo $pjwn_id; ?>" data-subtext="<?php echo $staf_nama[0]; ?>"<?php if ($pjwn_id == $value) { echo ' selected'; } ?>><?php echo $staf_nama[1]; ?></option>
                                                        <?php } ?>
                                                    <?php if(end($senarai_penyelia) === $organisasi) { ?>
                                                    </optgroup>
                                                    <?php } } ?>
                                                </select>
                                                <label class="form-label" style="top: -10px; font-size: 12px;">Gelaran Penyelia</label>
                                            </div>
                                            <?php echo form_error($FormName, "<label class=\"error\" for=\"$FormName\">", '</label>'); ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-md-6">
                                        <div class="form-group form-float">
                                            <?php
                                            $FormName = 'slcOrg';
                                            $value = (empty(set_value($FormName))) ? $penjawatan->pjwn_org_id : set_value($FormName);
                                            $focused = (empty($value) && !is_numeric($value)) ? '' : ' focused';
                                            $error = (empty(form_error($FormName))) ? '' : ' error';
                                            ?>
                                            <div class="form-line<?php echo $focused . $error; ?>">
                                                <select id="slcOrg" name="slcOrg" class="form-control show-tick" data-live-search="true">
                                                    <option value="">-- Sila Pilih --</option>
                                                    <?php foreach ($senarai_org as $org_id => $org_nama) { ?>
                                                    <option value="<?php echo $org_id; ?>"<?php if ($org_id == $value) { echo ' selected'; } ?>><?php echo $org_nama; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <label class="form-label" style="top: -10px; font-size: 12px;">Organisasi *</label>
                                            </div>
                                            <?php echo form_error($FormName, "<label class=\"error\" for=\"$FormName\">", '</label>'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-float">
                                            <?php
                                            $FormName = 'txtCatatan';
                                            $value = (empty(set_value($FormName))) ? $penjawatan->pjwn_catatan : set_value($FormName);
                                            $focused = (empty($value) && !is_numeric($value)) ? '' : ' focused';
                                            $error = (empty(form_error($FormName))) ? '' : ' error';
                                            ?>
                                            <div class="form-line<?php echo $focused . $error; ?>">
                                                <textarea id="txtCatatan" name="txtCatatan" rows="1" class="form-control no-resize auto-growth"><?php echo $value; ?></textarea>
                                                <label class="form-label">Catatan</label>
                                            </div>
                                            <span class="help-block font-12">Tekan <span class="label label-primary">Enter</span> pada papan kekunci untuk baris baru.</span>
                                            <?php echo form_error($FormName, "<label class=\"error\" for=\"$FormName\">", '</label>'); ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-sm-12 text-right">
                                        <a href="<?php echo site_url('pentadbir/penjawatan'); ?>" class="btn btn-link waves-effect">Kembali ke Senarai Penjawatan</a>
                                        <button type="submit" class="btn bg-mdi waves-effect">SIMPAN</button>
                                    </div>
                                </div>
                                
                                <input type="hidden" name="inpID" value="<?php echo $inpID; ?>">
                                
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
            