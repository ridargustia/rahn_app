<?php echo form_input($id_pembiayaan, $this->session->id_anggota) ?>
<?php echo form_input($sumber_dana, $sumber_dana_id) ?>
<?php echo form_input($instansi_id, $this->session->instansi) ?>
<?php echo form_input($cabang_id, $this->session->cabang) ?>

<?php if ($sumber_dana_id == 1) { ?>
    <div class="alert alert-success" role="alert">
        Saldo Tabungan Saat Ini : <b>Rp <?php echo number_format($data_instansi->saldo_tabungan, 0, ',', '.') ?></b><br>
        Serapan Tabungan Saat Ini : <b>Rp <?php echo number_format($data_instansi->resapan_tabungan, 0, ',', '.') ?></b><br>
        Dana Yang Digunakan : <b>Rp <?php echo number_format($this->session->jml_pinjaman, 0, ',', '.') ?> (100%)</b>
    </div>

    <div class="card-footer">
        <button type="reset" class="btn btn-warning"><?php echo $btn_reset ?></button>
        <button type="submit" class="btn btn-primary"><?php echo $btn_submit ?></button>
    </div>
<?php } elseif ($sumber_dana_id == 2) { ?>
    <div class="alert alert-success" role="alert">
        Sisa Pembagian Deposito : <b>Rp <?php echo number_format($this->session->total_pinjaman, 0, ',', '.') ?></b><br>
        <hr>
        Deposan Terpilih : <b>
            <?php
            if (!empty($this->session->id_deposito)) {
                for ($i = 0; $i < count($this->session->id_deposito); $i++) {
                    echo $this->session->nama_deposan[$i] . ' (' . $this->session->persentase_deposito[$i] . '%). ';
                }
            } else {
                echo '-';
            }
            ?>
        </b>
    </div>

    <?php $this->load->view('back/pembiayaan/sumber_dana_deposito'); ?>
<?php } elseif ($sumber_dana_id == 3) { ?>
    <div class="alert alert-success" role="alert">
        <b>PENGGUNAAN DANA DEPOSITO</b><br>
        <hr>
        Sisa Pembagian Deposito : <b>Rp <?php echo number_format($this->session->total_pinjaman, 0, ',', '.') ?></b><br>
        Deposan Terpilih : <b>
            <?php
            if (!empty($this->session->id_deposito)) {
                for ($i = 0; $i < count($this->session->id_deposito); $i++) {
                    echo $this->session->nama_deposan[$i] . ' (' . $this->session->persentase_deposito[$i] . '%). ';
                }
            } else {
                echo '-';
            }
            ?>
        </b>
    </div>

    <?php $this->load->view('back/pembiayaan/sumber_dana_tabungan_deposito'); ?>
<?php } ?>