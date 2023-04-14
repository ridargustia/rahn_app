<div class="modal fade" id="editPembiayaanModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 80%;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Pinjaman</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="location.reload()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php echo form_open_multipart($action) ?>
            <div class="modal-body">
                <!-- Content -->
                <div class="form-group">
                    <label>Jumlah Pinjaman</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">RP</span>
                        </div>
                        <?php echo form_input($jml_pinjaman) ?>
                        <div class="input-group-append">
                            <span class="input-group-text">,00</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="touchSpin">Jangka Waktu Pinjaman</label>
                    <?php echo form_input($jangka_waktu_pinjam) ?>
                </div>
                <div class="form-group">
                    <label>Jenis Barang Yang Digadaikan</label>
                    <?php echo form_input($jenis_barang_gadai) ?>
                </div>
                <div class="form-group">
                    <label>Berat/Nilai Barang Yang Digadaikan</label>
                    <div class="input-group mb-3">
                        <?php echo form_input($berat_barang_gadai) ?>
                        <div class="input-group-append">
                            <span class="input-group-text">Gram</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="dateRangePicker">Jangka Waktu Gadai</label>
                    <div class="input-daterange input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                        </div>
                        <?php echo form_input($waktu_gadai) ?>
                        <div class="input-group-prepend">
                            <span class="input-group-text">-</span>
                        </div>
                        <?php echo form_input($jatuh_tempo_gadai) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Sistem Pembayaran Sewa</label>
                    <?php echo form_dropdown('', $sistem_pembayaran_sewa_value, '', $sistem_pembayaran_sewa) ?>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Foto Barang Yang Digadaikan</label>
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

                <div id="showDeposanForUpdate"></div>
                <div id="buttonComponent"></div>
                <!-- Content -->
            </div>
            <?php echo form_input($id_pembiayaan) ?>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-dismiss="modal" onclick="location.reload()">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>