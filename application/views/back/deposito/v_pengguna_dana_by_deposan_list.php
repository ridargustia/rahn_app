<div class="card mb-4 mt-3">
    <div class="table-responsive">
        <table class="table align-items-center table-flush">
            <thead class="thead-light">
                <tr>
                    <th>Nama Anggota</th>
                    <th>Nominal</th>
                    <th>Total Basil</th>
                    <th>Basil Deposan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pengguna_dana as $data) { ?>
                    <tr>
                        <td><?php echo $data->name ?></td>
                        <td>Rp. <?php echo number_format($data->nominal, 0, ',', '.') ?></td>
                        <td>Rp. <?php echo number_format($data->total_basil, 0, ',', '.') ?></td>
                        <td>Rp. <?php echo number_format($data->basil_for_deposan, 0, ',', '.') ?></td>
                        <td>
                            <?php if ($data->status_pembayaran == 0) { ?>
                                <span class="badge badge-danger">BELUM LUNAS</span>
                            <?php } elseif ($data->status_pembayaran == 1) { ?>
                                <span class="badge badge-success">LUNAS</span>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>