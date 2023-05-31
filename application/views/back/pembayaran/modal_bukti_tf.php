<div class="modal fade" id="buktiTfModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 70%;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Informasi Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php echo form_open_multipart($modal_action) ?>
            <div class="modal-body">
                <!-- Content -->
                <p class="font-weight-bold">Silahkan transfer pembayaran anda ke salah satu no rekening berikut. Sebelum mengirim bukti pembayaran pada form di bawah ini.</p>
                <div class="row mb-1">
                    <div class="col-xl-6 col-md-12 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-uppercase mb-1">Bank BSI</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">No. Rek: 7839092928</div>
                                        <div class="text-s font-weight-bold mb-0">A/n: KSPPS Bhapedes</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-12 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-uppercase mb-1">Bank Mandiri</div>
                                        <div class="h5 mb-1 font-weight-bold text-gray-800">No. Rek: 124-00-0799292-6</div>
                                        <div class="text-s font-weight-bold mb-0">A/n: KSPPS Bhapedes</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <img id="preview" width="100%"/>
                        </div>
                        <div class="form-group">
                            <div class="custom-file">
                                <input type="file" name="photo" onchange="photoPreview(this,'preview')" class="custom-file-input" id="customFile" required>
                                <label class="custom-file-label" for="customFile">Upload Bukti Transfer Disini</label>
                            </div>
                            <small class="form-text text-muted">Maximum file size 2Mb</small>
                        </div>
                    </div>
                </div>
                <!-- Content -->
            </div>
            <?php echo form_input($id_pembiayaan) ?>
            <?php echo form_input($id_instansi) ?>
            <?php echo form_input($id_cabang) ?>
            <?php echo form_input($no_pinjaman) ?>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Kirim</button>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>