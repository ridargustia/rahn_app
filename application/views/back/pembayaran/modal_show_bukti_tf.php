<div class="modal fade" id="checkImageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 85%;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Verifikasi Bukti Transfer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="location.reload()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php echo form_open($action) ?>
            <div id="showBuktiTf"></div>

            <?php echo form_input($id_riwayat_pembayaran) ?>
            <?php echo form_input($id_pembiayaan) ?>
            <?php echo form_input($id_instansi) ?>
            <?php echo form_input($id_cabang) ?>

            <?php echo form_close() ?>
        </div>
    </div>
</div>