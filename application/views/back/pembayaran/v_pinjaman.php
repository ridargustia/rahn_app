<div class="card-footer">
    <div class="row mb-2">
        <!-- Card Total Deposito -->
        <div class="col-xl-4 col-md-12 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total Pinjaman</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">RP <?php echo number_format($pinjaman->jml_pinjaman, 0, ',', '.') ?></div>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">RP <?php echo number_format($pinjaman->total_biaya_sewa, 0, ',', '.') ?></div>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">RP <?php echo number_format($tanggungan, 0, ',', '.') ?></div>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">RP <?php echo number_format($pinjaman->jml_terbayar, 0, ',', '.') ?></div>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">RP <?php echo number_format($kekurangan_bayar, 0, ',', '.') ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6 col-md-12">
            <a href="#" id="cicilanPembayaran" class="btn btn-info btn-block" data-toggle="modal" data-target="#cicilanPembayaranModal" data-id_pembiayaan="<?php echo $pinjaman->id_pembiayaan ?>" data-id_cabang="<?php echo $pinjaman->cabang_id ?>" data-id_instansi="<?php echo $pinjaman->instansi_id ?>">Cicil</a>
        </div>
        <div class="col-xl-6 col-md-12">
            <a href="<?php echo base_url('admin/pembayaran/create_lunas_action/' . $pinjaman->id_pembiayaan) ?>" class="btn btn-success btn-block" id="lunasPembayaran">Lunas</a>
        </div>
    </div>
</div>