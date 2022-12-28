<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 80%;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail <?php echo $page_title ?></h5>
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
                                <td width="190px">Nama Deposan</td>
                                <td width="5px">:</td>
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
                            <tr>
                                <td>Jumlah Deposito</td>
                                <td>:</td>
                                <td><b>Rp. <span class="total_deposito"></span></b></td>
                            </tr>
                            <tr>
                                <td>Jangka Waktu</td>
                                <td>:</td>
                                <td><b><span class="jangka_waktu"></span> Tahun</b></td>
                            </tr>
                            <tr>
                                <td>Waktu Deposito</td>
                                <td>:</td>
                                <td><b><span class="waktu_deposito"></span></b></td>
                            </tr>
                            <tr>
                                <td>Jatuh Tempo</td>
                                <td>:</td>
                                <td><b><span class="jatuh_tempo"></span></b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Content -->
                <br>
                <h6 class="ml-2 font-weight-bold text-primary">SERAPAN DANA</h6>
                <div id="showBasil"></div>
                <br>
                <h6 class="ml-2 font-weight-bold text-primary display">PENGGUNA DANA</h6> <a href="#" id="showDaftar" class="badge badge-info">Lihat Daftar</a>
                <div id="showPenggunaDana"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-dismiss="modal" onclick="location.reload()">Close</button>
            </div>
        </div>
    </div>
</div>