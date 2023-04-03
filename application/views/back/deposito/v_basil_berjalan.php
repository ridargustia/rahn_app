<!-- Content -->
<div class="table-responsive">
    <table class="table align-items-center table-flush">
        <tbody>
            <tr>
                <td width="190px">Total</td>
                <td width="5px">:</td>
                <td><b>Rp. <?php echo number_format($data_deposito->resapan_deposito, 0, ',', '.') ?></b></td>
            </tr>
            <tr>
                <td>Saldo</td>
                <td>:</td>
                <td><b>Rp. <?php echo number_format($data_deposito->saldo_deposito, 0, ',', '.') ?></b></td>
            </tr>
            <tr>
                <td>Basil Deposan</td>
                <td>:</td>
                <td><b>Rp. <?php echo number_format($basil_berjalan, 0, ',', '.') ?></b></td>
            </tr>
        </tbody>
    </table>
</div>
<!-- Content -->