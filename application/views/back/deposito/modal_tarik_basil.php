<div class="modal fade" id="tarikBasilModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog width-modal" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Masukkan Nominal Basil Yang Di tarik</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="location.reload()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php echo form_open($action_tarik_basil) ?>
            <div class="modal-body">
                <p>Maksimal Penarikan <b>Rp. <span class="basil_berjalan"></span></b></p>
                <!-- Content -->
                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp</span>
                        </div>
                        <?php echo form_input($nominal) ?>
                        <div class="input-group-append">
                            <span class="input-group-text">,00</span>
                        </div>
                        <div class="invalid-feedback">Saldo Basil anda tidak mencukupi.</div>
                    </div>
                </div>
                <!-- Content -->
            </div>
            <?php echo form_input($deposito_id) ?>
            <div class="modal-footer">
                <div id="button"></div>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>