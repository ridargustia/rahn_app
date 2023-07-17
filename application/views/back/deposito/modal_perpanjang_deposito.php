<div class="modal fade" id="perpanjangDepositoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog width-modal" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Atur Masa Aktif <?php echo $page_title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php echo form_open($action_jangka_waktu) ?>
            <div class="modal-body">
                <!-- Content -->
                <div class="form-group">
                    <div class="input-group mb-3">
                        <?php echo form_input($masa_aktif) ?>
                        <div class="input-group-append">
                            <span class="input-group-text">Tahun</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="dateRangePicker">Jangka Waktu Deposito</label>
                    <div class="input-daterange input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                        </div>
                        <?php echo form_input($perpanjang_waktu_deposito) ?>
                        <div class="input-group-prepend">
                            <span class="input-group-text">-</span>
                        </div>
                        <?php echo form_input($perpanjang_jatuh_tempo) ?>
                    </div>
                </div>
                <!-- Content -->
            </div>
            <?php echo form_input($deposito_id) ?>
            <?php echo form_input($data_waktu_deposito) ?>
            <?php echo form_input($data_jatuh_tempo) ?>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>