            <div class="block-header">
                <h2><?php echo $title; ?></h2>
            </div>

            <!-- Vertical Layout | With Floating Label -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>Kemaskini Organisasi<small>Ruangan bertanda asterik (*) wajib diisi.</small></h2>
                        </div>
                        <div class="body">
                            <form method="post" autocomplete="off">
                                <div class="row clearfix">
                                    <div class="col-md-6">
                                        <div class="form-group form-float">
                                            <?php
                                            $FormName = 'inpNama';
                                            $value = (empty(set_value($FormName))) ? $organisasi->org_nama : set_value($FormName);
                                            $focused = (empty($value) && !is_numeric($value)) ? '' : ' focused';
                                            $error = (empty(form_error($FormName))) ? '' : ' error';
                                            ?>
                                            <div class="form-line<?php echo $focused . $error; ?>">
                                                <input id="inpNama" name="inpNama" type="text" class="form-control" value="<?php echo $value; ?>">
                                                <label class="form-label">Nama Organisasi *</label>
                                            </div>
                                            <?php echo form_error($FormName, "<label class=\"error\" for=\"$FormName\">", '</label>'); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-float">
                                            <?php
                                            $FormName = 'slcNamaSub';
                                            $value = (empty(set_value($FormName))) ? $organisasi->org_sub_org_id : set_value($FormName);
                                            $focused = (empty($value) && !is_numeric($value)) ? '' : ' focused';
                                            $error = (empty(form_error($FormName))) ? '' : ' error';
                                            ?>
                                            <div class="form-line<?php echo $focused . $error; ?>">
                                                <select id="slcNamaSub" name="slcNamaSub" class="form-control show-tick" data-live-search="true">
                                                    <option value="">-- Sila Pilih --</option>
                                                    <?php foreach ($senarai_org as $org_id => $org_nama) { ?>
                                                    <option value="<?php echo $org_id; ?>"<?php if ($org_id == $value) { echo ' selected'; } ?>><?php echo $org_nama; ?></option>
                                                    <?php } ?>
                                                </select>
                                                
                                                <label class="form-label" style="top: -10px; font-size: 12px;">Organisasi Induk</label>
                                            </div>
                                            <?php echo form_error($FormName, "<label class=\"error\" for=\"$FormName\">", '</label>'); ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <?php
                                            $FormName = 'txtAlamat';
                                            $value = (empty(set_value($FormName))) ? $organisasi->org_alamat : set_value($FormName);
                                            $focused = (empty($value) && !is_numeric($value)) ? '' : ' focused';
                                            $error = (empty(form_error($FormName))) ? '' : ' error';
                                            ?>
                                            <div class="form-line<?php echo $focused . $error; ?>">
                                                <textarea id="txtAlamat" name="txtAlamat" rows="1" class="form-control no-resize auto-growth"><?php echo $value; ?></textarea>
                                                <label class="form-label">Alamat</label>
                                            </div>
                                            <span class="help-block font-12">Tekan <span class="label label-primary">Enter</span> pada papan kekunci untuk baris baru.</span>
                                            <?php echo form_error($FormName, "<label class=\"error\" for=\"$FormName\">", '</label>'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group form-float">
                                            <?php
                                            $FormName = 'inpPoskod';
                                            $value = (empty(set_value($FormName))) ? $organisasi->org_poskod : set_value($FormName);
                                            $focused = (empty($value) && !is_numeric($value)) ? '' : ' focused';
                                            $error = (empty(form_error($FormName))) ? '' : ' error';
                                            ?>
                                            <div class="form-line<?php echo $focused . $error; ?>">
                                                <input id="inpPoskod" name="inpPoskod" type="number" class="form-control" value="<?php echo $value; ?>">
                                                <label class="form-label">Poskod</label>
                                            </div>
                                            <?php echo form_error($FormName, "<label class=\"error\" for=\"$FormName\">", '</label>'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group form-float">
                                            <?php
                                            $FormName = 'inpNegeri';
                                            $value = (empty(set_value($FormName))) ? $organisasi->org_negeri : set_value($FormName);
                                            $focused = (empty($value) && !is_numeric($value)) ? '' : ' focused';
                                            $error = (empty(form_error($FormName))) ? '' : ' error';
                                            ?>
                                            <div class="form-line<?php echo $focused . $error; ?>">
                                                <input id="inpNegeri" name="inpNegeri" type="text" class="form-control typeahead" value="<?php echo $value; ?>" data-json='<?php //echo json_encode($senarai_gelaran); ?>'>
                                                <label class="form-label">Negeri</label>
                                            </div>
                                            <?php echo form_error($FormName, "<label class=\"error\" for=\"$FormName\">", '</label>'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group form-float">
                                            <?php
                                            $FormName = 'inpNegara';
                                            $value = (empty(set_value($FormName))) ? $organisasi->org_negara : set_value($FormName);
                                            $focused = (empty($value) && !is_numeric($value)) ? '' : ' focused';
                                            $error = (empty(form_error($FormName))) ? '' : ' error';
                                            ?>
                                            <div class="form-line<?php echo $focused . $error; ?>">
                                                <input id="inpNegara" name="inpNegara" type="text" class="form-control typeahead" value="<?php echo $value; ?>" data-json='<?php //echo json_encode($senarai_gelaran); ?>'>
                                                <label class="form-label">Negara</label>
                                            </div>
                                            <?php echo form_error($FormName, "<label class=\"error\" for=\"$FormName\">", '</label>'); ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row clearfix">
                                    <div class="col-sm-2">
                                        <div class="form-group form-float">
                                            <?php
                                            $FormName = 'inpTel';
                                            $value = (empty(set_value($FormName))) ? $organisasi->org_tel : set_value($FormName);
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
                                            $value = (empty(set_value($FormName))) ? $organisasi->org_tel_samb : set_value($FormName);
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
                                    <div class="col-sm-2">
                                        <div class="form-group form-float">
                                            <?php
                                            $FormName = 'inpFax';
                                            $value = (empty(set_value($FormName))) ? $organisasi->org_fax : set_value($FormName);
                                            $focused = (empty($value) && !is_numeric($value)) ? '' : ' focused';
                                            $error = (empty(form_error($FormName))) ? '' : ' error';
                                            ?>
                                            <div class="form-line<?php echo $focused . $error; ?>">
                                                <input id="inpFax" name="inpFax" type="text" class="form-control tel" value="<?php echo $value; ?>">
                                                <label class="form-label">No. Faks</label>
                                            </div>
                                            <?php echo form_error($FormName, "<label class=\"error\" for=\"$FormName\">", '</label>'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group form-float">
                                            <?php
                                            $FormName = 'inpEmel';
                                            $value = (empty(set_value($FormName))) ? $organisasi->org_emel : set_value($FormName);
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
                                    <div class="col-sm-1">
                                        <div class="form-group form-float">
                                            <?php
                                            $FormName = 'inpHirarki';
                                            $value = (empty(set_value($FormName))) ? $organisasi->org_hirarki : set_value($FormName);
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
                                            $FormName = 'chkPaparSub';
                                            $DBChecked = ('Ya' == $organisasi->org_papar_sub) ? ' checked="checked"' : '';
                                            $checked = (($this->input->server('REQUEST_METHOD') != 'POST')) ? $DBChecked : set_checkbox($FormName, 'Ya');
                                            $error = (empty(form_error($FormName))) ? '' : ' error';
                                            ?>
                                            <div class="switch form-line" style="border-bottom: transparent;">
                                                <span class="font-12 form-label" style="top: -10px;">Papar Sub *</span>
                                                <label class="p-b-0 p-t-10">Tidak<input id="chkPaparSub" name="chkPaparSub" type="checkbox" value="Ya"<?php echo $checked; ?>><span class="lever switch-col-blue"></span>Ya</label>
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
                                            $value = (empty(set_value($FormName))) ? $organisasi->org_catatan : set_value($FormName);
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
                                        <a href="<?php echo site_url('pentadbir/organisasi'); ?>" class="btn btn-link waves-effect">Kembali ke Senarai Organisasi</a>
                                        <button type="submit" class="btn bg-mdi waves-effect">SIMPAN</button>
                                    </div>
                                </div>
                                
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>