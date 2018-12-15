            <div class="block-header">
                <h2><?php echo $title; ?></h2>
            </div>

            <!-- Vertical Layout | With Floating Label -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>Kemaskini Staf<small>Ruangan bertanda asterik (*) wajib diisi.</small></h2>
                        </div>
                        <div class="body">
                            <form method="post" autocomplete="off">
                                <div class="row clearfix">
                                    <div class="col-md-3">
                                        <div class="form-group form-float">
                                            <?php
                                            $FormName = 'inpGelaran';
                                            $value = (empty(set_value($FormName))) ? $staf->staf_gelaran : set_value($FormName);
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
                                    <div class="col-md-9">
                                        <div class="form-group form-float">
                                            <?php
                                            $FormName = 'inpNama';
                                            $value = (empty(set_value($FormName))) ? $staf->staf_nama : set_value($FormName);
                                            $focused = (empty($value) && !is_numeric($value)) ? '' : ' focused';
                                            $error = (empty(form_error($FormName))) ? '' : ' error';
                                            ?>
                                            <div class="form-line<?php echo $focused . $error; ?>">
                                                <input id="inpNama" name="inpNama" type="text" class="form-control" value="<?php echo $value; ?>">
                                                <label class="form-label">Nama Penuh *</label>
                                            </div>
                                            <?php echo form_error($FormName, "<label class=\"error\" for=\"$FormName\">", '</label>'); ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-md-2">
                                        <div class="form-group form-float">
                                            <?php
                                            $FormName = 'inpMyKad';
                                            $value = (empty(set_value($FormName))) ? $staf->staf_mykad : set_value($FormName);
                                            $focused = (empty($value) && !is_numeric($value)) ? '' : ' focused';
                                            $error = (empty(form_error($FormName))) ? '' : ' error';
                                            ?>
                                            <div class="form-line<?php echo $focused . $error; ?>">
                                                <input id="inpMyKad" name="inpMyKad" type="text" class="form-control" value="<?php echo $value; ?>" data-inputmask="'mask': '999999-99-9999'">
                                                <label class="form-label">MyKad</label>
                                            </div>
                                            <?php echo form_error($FormName, "<label class=\"error\" for=\"$FormName\">", '</label>'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="form-group form-float">
                                            <?php
                                            $FormName = 'inpJawatan';
                                            $value = (empty(set_value($FormName))) ? $staf->staf_jawatan : set_value($FormName);
                                            $focused = (empty($value) && !is_numeric($value)) ? '' : ' focused';
                                            $error = (empty(form_error($FormName))) ? '' : ' error';
                                            ?>
                                            <div class="form-line<?php echo $focused . $error; ?>">
                                                <input id="inpJawatan" name="inpJawatan" type="text" class="form-control typeahead" value="<?php echo $value; ?>" data-json='<?php echo json_encode($senarai_jawatan); ?>'>
                                                <label class="form-label">Jawatan</label>
                                            </div>
                                            <?php echo form_error($FormName, "<label class=\"error\" for=\"$FormName\">", '</label>'); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group form-float">
                                            <?php
                                            $FormName = 'inpGred';
                                            $value = (empty(set_value($FormName))) ? $staf->staf_gred : set_value($FormName);
                                            $focused = (empty($value) && !is_numeric($value)) ? '' : ' focused';
                                            $error = (empty(form_error($FormName))) ? '' : ' error';
                                            ?>
                                            <div class="form-line<?php echo $focused . $error; ?>">
                                                <input id="inpGred" name="inpGred" type="text" class="form-control typeahead" value="<?php echo $value; ?>" style="text-transform:uppercase;" data-json='<?php echo json_encode($senarai_gred); ?>'>
                                                <label class="form-label">Gred</label>
                                            </div>
                                            <?php echo form_error($FormName, "<label class=\"error\" for=\"$FormName\">", '</label>'); ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-md-2">
                                        <div class="form-group form-float">
                                            <?php
                                            $FormName = 'inpTaraf';
                                            $value = (empty(set_value($FormName))) ? $staf->staf_taraf : set_value($FormName);
                                            $focused = (empty($value) && !is_numeric($value)) ? '' : ' focused';
                                            $error = (empty(form_error($FormName))) ? '' : ' error';
                                            ?>
                                            <div class="form-line<?php echo $focused . $error; ?>">
                                                <input id="inpTaraf" name="inpTaraf" type="text" class="form-control typeahead" value="<?php echo $value; ?>" data-json='<?php echo json_encode($senarai_taraf); ?>'>
                                                <label class="form-label">Taraf Jawatan</label>
                                            </div>
                                            <?php echo form_error($FormName, "<label class=\"error\" for=\"$FormName\">", '</label>'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="form-group form-float">
                                            <?php
                                            $FormName = 'inpEmel';
                                            $value = (empty(set_value($FormName))) ? $staf->staf_emel : set_value($FormName);
                                            $focused = (empty($value) && !is_numeric($value)) ? '' : ' focused';
                                            $error = (empty(form_error($FormName))) ? '' : ' error';
                                            ?>
                                            <div class="form-line<?php echo $focused . $error; ?>">
                                                <input id="inpEmel" name="inpEmel" type="email" class="form-control" value="<?php echo $value; ?>">
                                                <label class="form-label">E-Mel</label>
                                            </div>
                                            <?php echo form_error($FormName, "<label class=\"error\" for=\"$FormName\">", '</label>'); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group form-float">
                                            <?php
                                            $FormName = 'slcStatus';
                                            $value = (empty(set_value($FormName))) ? $staf->staf_status : set_value($FormName);
                                            $focused = (empty($value) && !is_numeric($value)) ? '' : ' focused';
                                            $error = (empty(form_error($FormName))) ? '' : ' error';
                                            ?>
                                            <div class="form-line<?php echo $focused . $error; ?>">
                                                <select id="slcStatus" name="slcStatus" class="form-control show-tick">
                                                    <option value="">-- Sila Pilih --</option>
                                                    <?php foreach ($senarai_status as $status) { ?>
                                                    <option value="<?php echo $status; ?>"<?php if ($status == $value) { echo ' selected'; } ?>><?php echo $status; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <label class="form-label" style="top: -10px; font-size: 12px;">Status *</label>
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
                                            $value = (empty(set_value($FormName))) ? $staf->staf_catatan : set_value($FormName);
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
                                        <a href="<?php echo site_url('pentadbir/staf'); ?>" class="btn btn-link waves-effect">Kembali ke Senarai Staf</a>
                                        <button type="submit" class="btn bg-mdi waves-effect">SIMPAN</button>
                                    </div>
                                </div>
                                
                                <input type="hidden" name="inpID" value="<?php echo $inpID; ?>">
                                
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>