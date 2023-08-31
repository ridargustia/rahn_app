<label>Berat/Nilai Barang Yang Digadaikan <span style="color: red">*</span></label>
<?php if ($jenis_barang == 1) { ?>
    <div class="input-group mb-3">
        <?php echo form_input($berat_barang_gadai) ?>
        <div class="input-group-append">
            <span class="input-group-text">Gram</span>
        </div>
    </div>
<?php } elseif ($jenis_barang == 2) { ?>
    <div class="input-daterange input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">Rp</span>
        </div>
        <?php echo form_input($nominal_surat_berharga) ?>
        <div class="input-group-prepend">
            <span class="input-group-text">=</span>
        </div>
        <?php echo form_input($konversi_gram) ?>
        <div class="input-group-prepend">
            <span class="input-group-text">Gram</span>
        </div>
    </div>
<?php } ?>

<script>
    $(document).ready(function() {
        $('#nominal_surat_berharga').maskMoney({
            thousands: '.',
            decimal: ',',
            precision: 0
        });
    });

    $('#nominal_surat_berharga').on('change', function() {

        nominal_surat_berharga = document.getElementById("nominal_surat_berharga").value;
        jangka_waktu_pinjam = document.getElementById("jangka_waktu_pinjam").value;

        $.ajax({
            url: "<?php echo base_url('admin/pembiayaan/konversi_gram/') ?>" + nominal_surat_berharga + "/" + jangka_waktu_pinjam,
            success: function(response) {
                var myObj = JSON.parse(response);

                $('#konversi_gram').val(myObj.nilai_surat_berharga);
                $('#sewa_tempat_perbulan').val(myObj.sewa_tempat_perbulan);
                $('#total_biaya_sewa').val(myObj.total_biaya_sewa);
            }
        });
    });

    $('#berat_barang_gadai').on('change', function() {

        berat_barang_gadai = document.getElementById("berat_barang_gadai").value;
        jangka_waktu_pinjam = document.getElementById("jangka_waktu_pinjam").value;

        $.ajax({
            url: "<?php echo base_url('admin/pembiayaan/konversi_basil/') ?>" + berat_barang_gadai + "/" + jangka_waktu_pinjam,
            success: function(response) {
                var myObj = JSON.parse(response);

                $('#sewa_tempat_perbulan').val(myObj.sewa_tempat_perbulan);
                $('#total_biaya_sewa').val(myObj.total_biaya_sewa);
            }
        });
    });
</script>