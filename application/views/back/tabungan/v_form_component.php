<div class="alert alert-info" role="alert">
    <b>INFORMASI SALDO</b><hr>
    Saldo Tabungan di Cabang Saat Ini : <b>Rp <?php echo number_format($cabang->saldo_tabungan, 0, ',', '.') ?></b><br>
    <?php if (is_grandadmin() or is_masteradmin()) { ?>
        Total Tabungan di Instansi/Lembaga Saat Ini : <b>Rp <?php echo number_format($instansi->saldo_tabungan, 0, ',', '.') ?></b>
    <?php } ?>
</div>

<div class="card mb-4">
    <div class="card-body">
        <div class="form-group">
            <label>Nominal yang ditambahkan</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">RP</span>
                </div>
                <?php echo form_input($nominal_tabungan) ?>
                <div class="input-group-append">
                    <span class="input-group-text">,00</span>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="card-footer">
        <button type="reset" class="btn btn-warning"><?php echo $btn_reset ?></button>
        <button type="submit" class="btn btn-primary"><?php echo $btn_submit ?></button>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#nominal_tabungan').maskMoney({
            thousands: '.',
            decimal: ',',
            precision: 0
        });
    });
</script>