<div class="modal fade" id="modalEditUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 70%;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit <?php echo $page_title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php echo form_open_multipart($action) ?>
            <div class="modal-body">
                <!-- Content -->
                <h5 class="m-0 font-weight-bold text-primary">Data Personal</h5>
                <br>
                <div class="form-group">
                    <label>Nama Lengkap<span style="color: red">*</span></label>
                    <?php echo form_input($name) ?>
                </div>
                <div class="form-group">
                    <label>Jenis Kelamin<span style="color: red">*</span></label>
                    <?php echo form_dropdown('', $gender_value, '', $gender) ?>
                </div>
                <div class="form-group">
                    <label>Tempat Lahir</label>
                    <?php echo form_input($birthplace) ?>
                </div>
                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <div class="input-group date">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                        </div>
                        <?php echo form_input($birthdate) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label>No HP/Telephone/WhatsApp<span style="color: red">*</span></label>
                    <?php echo form_input($phone) ?>
                </div>
                <div class="form-group">
                    <label>Alamat Lengkap</label>
                    <?php echo form_input($address) ?>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="dateRangePicker">Foto Profil</label>
                            <div id="currentImage"></div>
                            <img id="preview" width="100%" />
                        </div>
                        <div class="form-group">
                            <div class="custom-file">
                                <input type="file" name="photo" onchange="photoPreview(this,'preview')" class="custom-file-input" id="customFile">
                                <label class="custom-file-label" for="customFile">Ubah Foto</label>
                            </div>
                            <small class="form-text text-muted">Maximum file size 2Mb</small>
                        </div>
                    </div>
                </div>
                <hr>
                <h5 class="m-0 font-weight-bold text-primary">Data Authentikasi</h5>
                <br>
                <div class="form-group">
                    <label>Username<span style="color: red">*</span></label>
                    <?php echo form_input($username) ?>
                </div>
                <div class="form-group">
                    <label>Email<span style="color: red">*</span></label>
                    <?php echo form_input($email) ?>
                </div>
                <?php if (is_grandadmin() or is_masteradmin()) { ?>
                <div id="showComponent"></div>
                <?php } ?>
                <div class="form-group">
                    <label>Usertype<span style="color: red">*</span></label>
                    <?php echo form_dropdown('', $get_all_combobox_usertype, '', $usertype_id) ?>
                </div>
                <div class="form-group">
                    <label>Akses Data<span style="color: red">*</span></label>
                    <div id="currentAccessData"></div>
                </div>
                <!-- Content -->
            </div>
            <?php echo form_input($id_users) ?>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>