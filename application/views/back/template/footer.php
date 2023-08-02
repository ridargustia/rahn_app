<!-- Login Content -->
<script src="<?php echo base_url('assets/jquery/jquery.min.js') ?>"></script>
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?php echo base_url('assets/jquery-easing/jquery.easing.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/ruang-admin.min.js') ?>"></script>
<!-- SweetAlert -->
<script src="<?php echo base_url('assets/') ?>sweetalert/js/sweetalert2.all.min.js"></script>
<!-- SweetAlert -->

<script type="text/javascript">
    $(document).on('click', '#delete-button', function(e) {
        e.preventDefault();
        const link = $(this).attr('href');

        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Data akan dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#00a65a',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = link;
            }
        })
    });

    $(document).on('click', '#delete-button-permanent', function(e) {
        e.preventDefault();
        const link = $(this).attr('href');

        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Data akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#00a65a',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = link;
            }
        })
    });

    $(document).on('click', '#lunasPembayaran', function(e) {
        e.preventDefault();
        const link = $(this).attr('href');

        Swal.fire({
            title: 'Konfirmasi Pelunasan',
            text: "Pastikan Anggota telah melakukan pelunasan pinjaman sebelum anda melakukan konfirmasi.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#00a65a',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Konfirmasi'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = link;
            }
        })
    });

    $(document).on('click', '#konfirmasi-tarik-deposito', function(e) {
        e.preventDefault();
        const link = $(this).attr('href');

        Swal.fire({
            title: 'Konfirmasi Tarik Deposito',
            text: "Apakah anda yakin akan melakukan tarik Deposito? Jika Anda melakukan penarikan Deposito, maka data Deposito ini akan di nonaktifkan dan tidak dapat di aktifkan kembali.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#00a65a',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Tarik Tunai'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = link;
            } else {
                location.reload();
            }
        })
    });
</script>