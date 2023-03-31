<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 500px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Masukkan Persentase Deposito</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php echo form_open($modal_action) ?>
            <div class="modal-body">
                <!-- Content -->
                <div class="form-group">
                    <div class="input-group mb-3">
                        <?php echo form_input($persentase_deposito) ?>
                        <div class="input-group-append">
                            <span class="input-group-text">%</span>
                        </div>
                        <div class="invalid-feedback">Persentase tidak boleh melebihi jumlah pinjaman. Silahkan ubah persentase.</div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp</span>
                        </div>
                        <?php echo form_input($konversi_nominal) ?>
                        <div class="input-group-append">
                            <span class="input-group-text">,00</span>
                        </div>
                    </div>
                </div>
                <!-- Content -->
            </div>
            <?php echo form_input($id_deposito) ?>
            <div class="modal-footer">
                <div id="button"></div>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>