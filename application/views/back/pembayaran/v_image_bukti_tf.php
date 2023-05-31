<div class="modal-body">
    <!-- Content -->
    <div class="row">
        <div class="col-md-12">
            <img src="<?php echo base_url('assets/images/bukti_tf/' . $image_bukti_tf) ?>" width="100%">
        </div>
    </div>
    <?php if ($is_paid == 0) { ?>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="text-primary font-weight-bold">Konfirmasi Nominal Pembayaran</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp</span>
                        </div>
                        <?php echo form_input($nominal) ?>
                        <div class="input-group-append">
                            <span class="input-group-text">,00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <!-- Content -->
</div>
<?php if ($is_paid == 0) { ?>
    <div class="modal-footer">
        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Verifikasi Pembayaran</button>
    </div>
<?php } ?>

<script>
    $(document).ready(function() {
        $('#nominal').maskMoney({
            thousands: '.',
            decimal: ',',
            precision: 0
        });
    });
</script>