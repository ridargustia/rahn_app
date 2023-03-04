<div class="table-responsive p-3">
    <table class="table align-items-center table-flush table-hover" id="dataTableHover">
        <thead class="thead-light">
            <tr>
                <th>Nama Deposan</th>
                <th>Deposito</th>
                <th>Serapan Dana</th>
                <th>Saldo</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $btn_status = false;
            $count = count($this->session->id_deposito);

            foreach ($deposito as $data) {
                // Action
                if ($count > 0) {
                    for ($i = 0; $i < $count; $i++) {
                        if ($this->session->id_deposito[$i] == $data->id_deposito || $this->session->total_pinjaman == 0) {
                            $btn_status = true;
                            break;
                        } elseif ($this->session->id_deposito[$i] != $data->id_deposito) {
                            $btn_status = false;
                        }
                    }
                }

                if ($btn_status == true) {
                    $persentase = '<button type="button" class="btn btn-sm btn-info" style="cursor: not-allowed;" disabled>Persentase</button>';
                } else {
                    $persentase = '<a href="#" id="persentaseDeposito" class="btn btn-sm btn-info" title="Persentase" data-toggle="modal" data-target="#exampleModal" data-id_deposito="' . $data->id_deposito . '">Persentase</a>';
                }
            ?>
                <tr>
                    <td><?php echo $data->name ?></td>
                    <td><?php echo 'Rp ' . number_format($data->total_deposito, 0, ',', '.') ?></td>
                    <td><?php echo 'Rp ' . number_format($data->resapan_deposito, 0, ',', '.') ?></td>
                    <td><?php echo 'Rp ' . number_format($data->saldo_deposito, 0, ',', '.') ?></td>
                    <td><?php echo $persentase ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<div class="alert alert-success" role="alert">
    <!-- Notifikasi Ketersediaan Saldo Tabungan -->
    <?php if ($cek_tabungan < 0) { ?>
        <div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-ban"></i><b> Saldo Tabungan Tidak Cukup!</b></h6></div>
    <?php } ?>
    <!-- Notifikasi Ketersediaan Saldo Tabungan -->

    <b>PENGGUNAAN DANA TABUNGAN</b><br>
    <hr>
    Saldo Tabungan Saat Ini : <b>Rp <?php echo number_format($cabang->saldo_tabungan, 0, ',', '.') ?></b><br>
    Serapan Tabungan Saat Ini : <b>Rp <?php echo number_format($cabang->resapan_tabungan, 0, ',', '.') ?></b><br>
    Persentase Dana Yang Digunakan : <b><?php echo $this->session->persentase_tabungan ?>% dari jumlah pinjaman Anggota menggunakan dana tabungan</b><br>
    Nominal Dana Yang Digunakan : <b>Rp <?php echo number_format($this->session->total_pinjaman, 0, ',', '.') ?></b>
</div>