<!-- app/Views/master/users.php -->
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen User</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css'); ?>">
</head>

<body>
    <div class="container mt-5">
        <h2>Manajemen User</h2>
        <!-- Tabel Daftar User -->
        <div id="user-list">
            <a href="#" class="btn btn-primary mb-3" onclick="showForm('create')">Tambah User</a>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>No HP</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= $user['id_user']; ?></td>
                            <td><?= $user['nama']; ?></td>
                            <td><?= $user['username']; ?></td>
                            <td><?= $user['role']; ?></td>
                            <td><?= $user['no_hp']; ?></td>
                            <td><?= $user['status']; ?></td>
                            <td>
                                <a href="#" class="btn btn-info btn-sm" onclick="showDetail(<?= $user['id_user']; ?>)">Detail</a>
                                <a href="#" class="btn btn-warning btn-sm" onclick="showEdit(<?= $user['id_user']; ?>)">Edit</a>
                                <a href="<?= base_url('users/delete/' . $user['id_user']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus user?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!-- Form Tambah/Edit User (hidden by default) -->
        <div id="user-form" style="display:none;"></div>
        <!-- Detail User (hidden by default) -->
        <div id="user-detail" style="display:none;"></div>
    </div>
    <script>
        function showForm(mode, id = null) {
            // AJAX load form create/edit ke #user-form
            // mode: 'create' atau 'edit', id: user id jika edit
            // Implementasi AJAX tergantung backend Anda
            // Contoh:
            // $('#user-form').load('<?= base_url('users/form'); ?>/'+mode+'/'+id, function() {
            //     $('#user-form').show();
            //     $('#user-list').hide();
            //     $('#user-detail').hide();
            // });
            alert('Fitur form ' + mode + ' user belum diimplementasikan AJAX.');
        }

        function showDetail(id) {
            // AJAX load detail user ke #user-detail
            // $('#user-detail').load('<?= base_url('users/show'); ?>/'+id, function() {
            //     $('#user-detail').show();
            //     $('#user-list').hide();
            //     $('#user-form').hide();
            // });
            alert('Fitur detail user belum diimplementasikan AJAX.');
        }

        function showEdit(id) {
            showForm('edit', id);
        }
    </script>
</body>

</html>