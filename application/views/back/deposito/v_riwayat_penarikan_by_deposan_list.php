<div class="card mb-4 mt-3">
    <div class="table-responsive">
        <table class="table align-items-center table-flush">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Nominal</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Jatuh Tempo</th>
                    <th>Dibuat Oleh</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($riwayat_penarikan as $data) {
                        if ($data->status == 0) {
                            $status = '<span class="badge badge-info">Ditarik Setelah Jatuh Tempo</span>';
                        } elseif ($data->status ==1) {
                            $status = '<span class="badge badge-secondary">Ditarik Sebelum Jatuh Tempo</span>';
                        }
                ?>
                    <tr>
                        <td class="text-primary"><?php echo $data->no_penarikan ?></td>
                        <td>Rp. <?php echo number_format($data->jml_penarikan, 0, ',', '.') ?></td>
                        <td><?php echo datetime_indo4($data->created_at) ?></td>
                        <td><?php echo $status ?></td>
                        <td><?php echo date_only2($data->jatuh_tempo) ?></td>
                        <td><?php echo $data->created_by ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>