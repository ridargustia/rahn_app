<?php
    foreach ($pinjaman as $data) {
        if ($data->status_pembayaran) {
            $status = '<span class="badge badge-success">LUNAS</span>';
        } else {
            $status = '<span class="badge badge-danger">BELUM LUNAS</span>';
        }
?>
<div class="card mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">#<?php echo $data->no_pinjaman ?></h6><?php echo $status ?>
    </div>
    <div class="card-body">
        <div class="row mb-2">
            <!-- Card Total Deposito -->
            <div class="col-xl-4 col-md-12 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">Total Pinjaman</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">RP <?php echo number_format($data->jml_pinjaman, 0, ',', '.') ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Card Serapan Deposito -->
            <div class="col-xl-4 col-md-12 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">Biaya Sewa</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">RP <?php echo number_format($data->total_biaya_sewa, 0, ',', '.') ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Card Saldo Deposito -->
            <div class="col-xl-4 col-md-12 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">Total Tanggungan</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">RP <?php echo number_format($data->jml_pinjaman+$data->total_biaya_sewa, 0, ',', '.') ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <!-- Card Jumlah Terbayar -->
            <div class="col-xl-6 col-md-12 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">Jumlah Terbayar</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">RP <?php echo number_format($data->jml_terbayar, 0, ',', '.') ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Card Kekurangan Bayar -->
            <div class="col-xl-6 col-md-12 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">Kekurangan Bayar</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">RP <?php echo number_format($data->jml_pinjaman+$data->total_biaya_sewa-$data->jml_terbayar, 0, ',', '.') ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6 col-md-12">
                <a href="#" class="btn btn-info btn-block" data-id_pembiayaan="<?php echo $data->id_pembiayaan ?>" data-id_cabang="<?php echo $data->cabang_id ?>" data-id_instansi="<?php echo $data->instansi_id ?>" <?php echo ($data->status_pembayaran) ? 'style="cursor: not-allowed; opacity: .5;"' : 'id="cicilanPembayaran" data-toggle="modal" data-target="#cicilanPembayaranModal"' ?> >Cicil</a>
            </div>
            <div class="col-xl-6 col-md-12">
                <?php if ($data->status_pembayaran) { ?>
                    <a href="#" class="btn btn-success btn-block" style="cursor: not-allowed; opacity: .5;">Lunas</a>
                <?php } else { ?>
                    <a href="<?php echo base_url('admin/pembayaran/create_lunas_action/' . $data->id_pembiayaan) ?>" class="btn btn-success btn-block" id="lunasPembayaran">Lunas</a>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php } ?>