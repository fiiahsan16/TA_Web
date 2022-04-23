<?php
$link_data = '?page=komunitas';
$link_update = '?page=update_komunitas';

$nama_komunitas = '';
$deskripsi_komunitas = '';

if (isset($_POST['save'])) {
    $error = '';
    $id = $_POST['id'];
    $action = $_POST['action'];
    $nama_komunitas = $_POST['nama_komunitas'];
    $deskripsi_komunitas = mysqli_escape_string($con, $_POST['deskripsi_komunitas']);

    if (empty($error)) {
        if ($action == 'add') {
            if (mysqli_num_rows(mysqli_query($con, "select * from komunitas where nama_komunitas='" . $nama_komunitas . "'")) > 0) {
                $error = 'Kode Gejala sudah ada';
            } else {
                $q = "insert into komunitas(nama_komunitas,deskripsi_komunitas) values ('" . $nama_komunitas . "','" . $deskripsi_komunitas . "')";
                mysqli_query($con, $q);
                exit("<script>location.href='" . $link_data . "';</script>");
            }
        }
        if ($action == 'edit') {
            $q = mysqli_query($con, "select * from komunitas where id_komunitas='" . $id . "'");
            $r = mysqli_fetch_array($q);
            $nama_komunitas_tmp = $r['nama_komunitas'];
            if (mysqli_num_rows(mysqli_query($con, "select * from komunitas where nama_komunitas='" . $nama_komunitas . "' and nama_komunitas<>'" . $nama_komunitas_tmp . "'")) > 0) {
                $error = 'Kode Gejala sudah ada';
            } else {
                $q = "update komunitas set nama_komunitas='" . $nama_komunitas . "',deskripsi_komunitas='" . $deskripsi_komunitas . "' where id_komunitas='" . $id . "'";
                mysqli_query($con, $q);
                exit("<script>location.href='" . $link_data . "';</script>");
            }
        }
    }
} else {
    $action = empty($_GET['action']) ? 'add' : $_GET['action'];
    if ($action == 'edit') {
        $id = $_GET['id'];
        $q = mysqli_query($con, "select * from komunitas where id_komunitas='" . $id . "'");
        $r = mysqli_fetch_array($q);
        $nama_komunitas = $r['nama_komunitas'];
        $deskripsi_komunitas = $r['deskripsi_komunitas'];
    }
    if ($action == 'delete') {
        $id = $_GET['id'];
        mysqli_query($con, "delete from komunitas where id_komunitas='" . $id . "'");
        exit("<script>location.href='" . $link_data . "';</script>");
    }
}
?>
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">Data Komunitas</h3>
    </div>
    <form class="form-horizontal" action="<?php echo $link_update; ?>" method="post">
        <input name="id" type="hidden" value="<?php echo $id; ?>">
        <input name="action" type="hidden" value="<?php echo $action; ?>">
        <div class="box-body">
            <?php
            if (!empty($error)) {
                echo '<div class="alert bg-danger" role="alert">' . $error . '</div>';
            }
            ?>
            <div class="form-group">
                <label for="nama_komunitas" class="col-sm-2 control-label">Nama Komunitas</label>
                <div class="col-sm-4">
                    <input name="nama_komunitas" id="nama_komunitas" class="form-control" required type="text" value="<?php echo $nama_komunitas; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="deskripsi_komunitas" class="col-sm-2 control-label">Deskripsi</label>
                <div class="col-sm-4">
                    <input name="deskripsi_komunitas" id="deskripsi_komunitas" class="form-control" required type="text" value="<?php echo $deskripsi_komunitas; ?>">
                </div>
            </div>
        </div>
        <div class="box-footer">
            <div class="text-center col-sm-6">
                <button type="submit" name="save" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
                <a href="<?php echo $link_data; ?>" class="btn btn-default"><i class="fa fa-times"></i> Batal</a>
            </div>
        </div>
    </form>
</div>