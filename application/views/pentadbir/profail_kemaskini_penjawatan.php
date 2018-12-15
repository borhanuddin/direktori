            <div class="block-header">
                <h2><?php echo $title; ?></h2>
            </div>

            <!-- Vertical Layout | With Floating Label -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>Kemaskini Maklumat Penjawatan<small>Ruangan bertanda asterik (*) wajib diisi.</small></h2>
                        </div>
                        <div class="body">
                            <form method="post" autocomplete="off">
                                
                                <div class="row clearfix">
                                    <div class="col-md-6">
                                        <div class="form-group form-float">
                                            <?php
                                            $FormName = 'inpGelaran';
                                            $value = (empty(set_value($FormName))) ? $profail->pjwn_gelaran : set_value($FormName);
                                            $focused = (empty($value) && !is_numeric($value)) ? '' : ' focused';
                                            $error = (empty(form_error($FormName))) ? '' : ' error';
                                            ?>
                                            <div class="form-line<?php echo $focused . $error; ?>">
                                                <input id="inpGelaran" name="inpGelaran" type="text" class="form-control typeahead" value="<?php echo $value; ?>" data-json='<?php echo json_encode($senarai_gelaran); ?>'>
                                                <label class="form-label">Gelaran</label>
                                            </div>
                                            <?php echo form_error($FormName, "<label class=\"error\" for=\"$FormName\">", '</label>'); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group form-float">
                                            <?php
                                            $FormName = 'inpKod';
                                            $value = (empty(set_value($FormName))) ? $profail->pjwn_kod : set_value($FormName);
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
                                    <div class="col-md-2">
                                        <div class="form-group form-float">
                                            <?php
                                            $FormName = 'inpGred';
                                            $value = (empty(set_value($FormName))) ? $profail->pjwn_gred : set_value($FormName);
                                            $focused = (empty($value) && !is_numeric($value)) ? '' : ' focused';
                                            $error = (empty(form_error($FormName))) ? '' : ' error';
                                            ?>
                                            <div class="form-line<?php echo $focused . $error; ?>">
                                                <input id="inpGred" name="inpGred" type="text" class="form-control typeahead" style="text-transform:uppercase;" value="<?php echo $value; ?>" data-json='<?php echo json_encode($senarai_gred); ?>'>
                                                <label class="form-label">Gred</label>
                                            </div>
                                            <?php echo form_error($FormName, "<label class=\"error\" for=\"$FormName\">", '</label>'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group form-float">
                                            <?php
                                            $FormName = 'inpTel';
                                            $value = (empty(set_value($FormName))) ? $profail->pjwn_tel : set_value($FormName);
                                            $focused = (empty($value) && !is_numeric($value)) ? '' : ' focused';
                                            $error = (empty(form_error($FormName))) ? '' : ' error';
                                            ?>
                                            <div class="form-line<?php echo $focused . $error; ?>">
                                                <input id="inpTel" name="inpTel" type="text" class="form-control typeahead" value="<?php echo $value; ?>" data-inputmask="'mask': '9{2}-9{4} 9{1,4}[ 9{1,4}]'">
                                                <label class="form-label">No. Telefon</label>
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
                                            $value = (empty(set_value($FormName))) ? $profail->org_id : set_value($FormName);
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
                                    <div class="col-md-6">
                                        <div class="form-group form-float">
                                            <?php
                                            $FormName = 'slcPenyelia';
                                            $value = (empty(set_value($FormName))) ? $profail->pjwn_penyelia_pjwn_id : set_value($FormName);
                                            $focused = (empty($value) && !is_numeric($value)) ? '' : ' focused';
                                            $error = (empty(form_error($FormName))) ? '' : ' error';
                                            ?>
                                            <div class="form-line<?php echo $focused . $error; ?>">
                                                <select id="slcPenyelia" name="slcPenyelia" class="form-control show-tick" data-live-search="true">
                                                    <option value="">-- Sila Pilih --</option>
                                                    <?php  foreach ($senarai_penyelia as $org_nama => $penyelia) { ?>
                                                    <optgroup label="<?php echo $org_nama; ?>">
                                                        <?php foreach ($penyelia as $pjwn_id => $staf_nama) { ?>
                                                        <option value="<?php echo $pjwn_id; ?>"<?php if ($pjwn_id == $value) { echo ' selected'; } ?>><?php echo $staf_nama; ?></option>
                                                        <?php } ?>
                                                    <?php if(end($senarai_penyelia) === $organisasi) { ?>
                                                    </optgroup>
                                                    <?php } } ?>
                                                </select>
                                                <label class="form-label" style="top: -10px; font-size: 12px;">Penyelia</label>
                                            </div>
                                            <?php echo form_error($FormName, "<label class=\"error\" for=\"$FormName\">", '</label>'); ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        <div class="form-group form-float">
                                            <?php
                                            $FormName = 'txtCatatan';
                                            $value = (empty(set_value($FormName))) ? $profail->pjwn_catatan : set_value($FormName);
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
                                        <a href="<?php echo site_url('pentadbir/profail'); ?>" class="btn btn-link waves-effect">Kembali ke Profail</a>
                                        <button type="submit" class="btn bg-mdi waves-effect">SIMPAN</button>
                                    </div>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Vertical Layout | With Floating Label -->