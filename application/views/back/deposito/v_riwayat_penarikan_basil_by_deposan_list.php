<div class="card mb-4 mt-3">
    <div class="table-responsive">
        <table class="table align-items-center table-flush">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Nominal</th>
                    <th>Tanggal</th>
                    <th>Dibuat Oleh</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($riwayat_penarikan_basil as $data) { ?>
                    <tr>
                        <td class="text-primary"><?php echo $data->no_penarikan ?></td>
                        <td>Rp. <?php echo number_format($data->jml_penarikan, 0, ',', '.') ?></td>
                        <td><?php echo datetime_indo4($data->created_at) ?></td>
                        <td><?php echo $data->created_by ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>