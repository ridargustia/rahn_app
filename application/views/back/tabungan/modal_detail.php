<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 80%;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail <?php echo $page_title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Content -->
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <tbody>
                            <tr>
                                <td width="250px">No Anggota</td>
                                <td width="5px">:</td>
                                <td><b><span class="no_pinjaman"></span></b></td>
                            </tr>
                            <tr>
                                <td>Nama Anggota</td>
                                <td>:</td>
                                <td><b><span class="name"></span></b></td>
                            </tr>
                            <tr>
                                <td>NIK</td>
                                <td>:</td>
                                <td><b><span class="nik"></span></b></td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>:</td>
                                <td><b><span class="address"></span></b></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td><b><span class="email"></span></b></td>
                            </tr>
                            <tr>
                                <td>No. HP/Telephone/WA</td>
                                <td>:</td>
                                <td><b>+<span class="phone"></span></b></td>
                            </tr>
                            <?php if (is_grandadmin()) { ?>
                            <tr>
                                <td>Instansi</td>
                                <td>:</td>
                                <td><b><span class="instansi_name"></span></b></td>
                            </tr>
                            <?php } ?>
                            <tr>
                                <td>Cabang</td>
                                <td>:</td>
                                <td><b><span class="cabang_name"></span></b></td>
                            </tr>
                            <tr>
                                <td>Total Pinjaman</td>
                                <td>:</td>
                                <td><b>Rp. <span class="jml_pinjaman"></span></b></td>
                            </tr>
                            <tr>
                                <td>Jangka Waktu Pinjaman</td>
                                <td>:</td>
                                <td><b><span class="jangka_waktu_pinjam"></span> Bulan</b></td>
                            </tr>
                            <tr>
                                <td>Dibuat Oleh</td>
                                <td>:</td>
                                <td><b><span class="created_by"></span></b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Content -->
                <br>
                <h6 class="ml-2 font-weight-bold text-primary">INFORMASI PENGGUNAAN TABUNGAN</h6>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <tbody>
                            <tr>
                                <td width="250px">Persentase</td>
                                <td width="5px">:</td>
                                <td><b><span class="persentase"></span>%</b></td>
                            </tr>
                            <tr>
                                <td>Nominal Pinjaman</td>
                                <td>:</td>
                                <td><b>Rp. <span class="nominal"></span></b></td>
                            </tr>
                            <tr>
                                <td>Total Basil</td>
                                <td>:</td>
                                <td><b>Rp. <span class="basil_for_lembaga"></span></b></td>
                            </tr>
                            <tr>
                                <td>Basil Berjalan</td>
                                <td>:</td>
                                <td><b>Rp. <span class="basil_for_lembaga_berjalan"></span></b></td>
                            </tr>
                            <tr>
                                <td>Status Pinjaman</td>
                                <td>:</td>
                                <td><div id="status_pembayaran"></div></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>