<div class="modal fade" id="modalDetailUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <td width="190px">No ID</td>
                                <td width="5px">:</td>
                                <td class="text-primary"><b><span class="no_anggota"></span></b></td>
                            </tr>
                            <tr>
                                <td>Nama</td>
                                <td>:</td>
                                <td><b><span class="name"></span></b></td>
                            </tr>
                            <tr>
                                <td>Username</td>
                                <td>:</td>
                                <td><b><span class="username"></span></b></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td><b><span class="email"></span></b></td>
                            </tr>
                            <tr>
                                <td>Tempat Lahir</td>
                                <td>:</td>
                                <td><b><span class="birthplace"></span></b></td>
                            </tr>
                            <tr>
                                <td>Tanggal Lahir</td>
                                <td>:</td>
                                <td><b><span class="birthdate"></span></b></td>
                            </tr>
                            <tr>
                                <td>Jenis Kelamin</td>
                                <td>:</td>
                                <td><b><span class="gender"></span></b></td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>:</td>
                                <td><b><span class="address"></span></b></td>
                            </tr>
                            <tr>
                                <td>No. HP/Telephone</td>
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
                                <td>Usertype</td>
                                <td>:</td>
                                <td><b><span class="usertype"></span></b></td>
                            </tr>
                            <tr>
                                <td>Dibuat Oleh</td>
                                <td>:</td>
                                <td><b><span class="created_by"></span></b></td>
                            </tr>
                            <tr>
                                <td>Foto Profil</td>
                                <td>:</td>
                                <td><div id="showImage"></div></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Content -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-dismiss="modal" onclick="location.reload()">Close</button>
            </div>
        </div>
    </div>
</div>