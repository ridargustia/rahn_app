<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 80%;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail <?php echo $page_title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="location.reload()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Content -->
                <div class="row">
                    <div class="col-md-6">
                        <div id="showImage"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <tbody>
                                    <tr>
                                        <td width="190px">No Invoice</td>
                                        <td width="5px">:</td>
                                        <td class="text-primary"><b>#<span class="no_invoice"></span></b></td>
                                    </tr>
                                    <tr>
                                        <td>Nominal</td>
                                        <td>:</td>
                                        <td><b><span class="nominal"></span></b></td>
                                    </tr>
                                    <tr>
                                        <td>Diverifikasi Oleh</td>
                                        <td>:</td>
                                        <td><b><span class="verificated_by"></span></b></td>
                                    </tr>
                                    <tr>
                                        <td>Diverifikasi Pada</td>
                                        <td>:</td>
                                        <td><b><span class="verificated_at"></span></b></td>
                                    </tr>
                                    <tr>
                                        <td>Dibuat Oleh</td>
                                        <td>:</td>
                                        <td><b><span class="created_by"></span></b></td>
                                    </tr>
                                    <tr>
                                        <td>Dibuat Pada</td>
                                        <td>:</td>
                                        <td><b><span class="created_at"></span></b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Content -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-dismiss="modal" onclick="location.reload()">Close</button>
            </div>
        </div>
    </div>
</div>