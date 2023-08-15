<div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog width-modal" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Export <?php echo $page_title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="location.reload()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Content -->
                <a href="<?php echo base_url('admin/deposito/export') ?>" class="btn btn-success btn-block"><i class="fa fa-file-export"></i> Export Semua Data</a>
                <hr>
                <?php echo form_open($action_export) ?>
                <div class="form-group mt-4">
                    <div class="input-daterange input-group">
                        <?php echo form_input($tgl_mulai) ?>
                        <div class="input-group-prepend">
                            <span class="input-group-text">-</span>
                        </div>
                        <?php echo form_input($tgl_akhir) ?>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-file-export"></i> Export Berdasarkan Periode</button>
                <?php echo form_close() ?>
                <!-- Content -->
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>