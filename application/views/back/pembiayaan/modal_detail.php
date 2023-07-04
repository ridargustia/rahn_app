<div class="modal fade" id="detailPembiayaanModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog width-modal" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo $page_title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="location.reload()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Content -->
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <tbody>
                            <tr>
                                <td width="240px">No Pinjaman</td>
                                <td width="5px">:</td>
                                <td class="text-primary"><b><span class="no_pinjaman"></span></b></td>
                            </tr>
                            <tr>
                                <td>Jumlah Pinjaman</td>
                                <td>:</td>
                                <td><b>Rp. <span class="jml_pinjaman"></span></b></td>
                            </tr>
                            <tr>
                                <td>Jangka Waktu Pinjaman</td>
                                <td>:</td>
                                <td><b><span class="jangka_waktu_pinjam"></span> Bulan</b></td>
                            </tr>
                            <tr>
                                <td>Jenis Barang Yang Digadaikan</td>
                                <td>:</td>
                                <td><b><span class="jenis_barang_gadai"></span></b></td>
                            </tr>
                            <tr>
                                <td>Berat Barang Yang Digadaikan</td>
                                <td>:</td>
                                <td><b><span class="berat_barang_gadai"></span> Gram</b></td>
                            </tr>
                            <tr>
                                <td>Waktu Gadai</td>
                                <td>:</td>
                                <td><b><span class="waktu_gadai"></span></b></td>
                            </tr>
                            <tr>
                                <td>Jatuh Tempo Gadai</td>
                                <td>:</td>
                                <td><b><span class="jatuh_tempo_gadai"></span></b></td>
                            </tr>
                            <tr>
                                <td>Jangka Waktu Gadai</td>
                                <td>:</td>
                                <td><b><span class="jangka_waktu_gadai"></span> Bulan</b></td>
                            </tr>
                            <tr>
                                <td>Sewa Tempat Perbulan</td>
                                <td>:</td>
                                <td><b>Rp. <span class="sewa_tempat_perbulan"></span></b></td>
                            </tr>
                            <tr>
                                <td>Total Biaya Sewa</td>
                                <td>:</td>
                                <td><b>Rp. <span class="total_biaya_sewa"></span></b></td>
                            </tr>
                            <tr>
                                <td>Sistem Pembayaran Sewa</td>
                                <td>:</td>
                                <td><b><span class="sistem_pembayaran_sewa"></span></b></td>
                            </tr>
                            <tr>
                                <td>Dibuat Oleh</td>
                                <td>:</td>
                                <td><b><span class="created_by"></span></b></td>
                            </tr>
                            <tr>
                                <td>Dibuat Pada</td>
                                <td>:</td>
                                <td><b><span class="created_at"></span></b></td>
                            </tr>
                            <tr>
                                <td>Sumber Dana</td>
                                <td>:</td>
                                <td><b><span class="sumber_dana"></span></b> <a href="#" id="showDaftar" class="badge badge-info">Lihat Daftar</a></td>
                            </tr>
                            <tr>
                                <td>Barang Yang Digadaikan</td>
                                <td>:</td>
                                <td><a href="#" id="showImage" class="badge badge-info">Lihat Foto</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Content -->

                <!-- SimpleTables -->
                <div id="showBarangGadai"></div>
                <!-- SimpleTables -->

                <!-- SimpleTables -->
                <div id="showDeposan"></div>
                <!-- SimpleTables -->

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-dismiss="modal" onclick="location.reload()">Close</button>
            </div>
        </div>
    </div>
</div>