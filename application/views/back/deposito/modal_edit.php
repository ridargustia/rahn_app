<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog width-modal" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit <?php echo $page_title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php echo form_open($action) ?>
            <div class="modal-body">
                <!-- Content -->
                <?php if (is_grandadmin() or is_masteradmin()) { ?>
                <div id="showComponent"></div>
                <hr><br>
                <?php } ?>
                <div class="form-group">
                    <label>Nama Deposan</label>
                    <?php echo form_input($name) ?>
                    <small id="emailHelp" class="form-text text-muted">Isikan nama lengkap Deposan.</small>
                </div>
                <div class="form-group">
                    <label>NIK</label>
                    <?php echo form_input($nik) ?>
                    <small id="emailHelp" class="form-text text-muted">Isikan nomor induk kependudukan sesuai KTP.</small>
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <?php echo form_input($address) ?>
                    <small id="emailHelp" class="form-text text-muted">Isikan alamat lengkap sesuai KTP.</small>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <?php echo form_input($email) ?>
                </div>
                <div class="form-group">
                    <label>No HP/Telephone/WhatsApp</label>
                    <div class="input-group mb-3">
                        <?php echo form_input($phone) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label>Jumlah Deposito</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">RP</span>
                        </div>
                        <?php echo form_input($total_deposito) ?>
                        <div class="input-group-append">
                            <span class="input-group-text">,00</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="dateRangePicker">Jangka Waktu Deposito</label>
                    <div class="input-daterange input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                        </div>
                        <?php echo form_input($waktu_deposito) ?>
                        <div class="input-group-prepend">
                            <span class="input-group-text">-</span>
                        </div>
                        <?php echo form_input($jatuh_tempo) ?>
                    </div>
                </div>
                <!-- Content -->
            </div>
            <?php echo form_input($id_deposito) ?>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>