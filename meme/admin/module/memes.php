<?php
$memes = $use->getMemes(0, 9999999);
if (isset($_GET['delete'])) {
    $use->destoryMeme($_GET['id']);
    echo "<script>alert('success');location='./?page=memes'</script>";
}
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Memes</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a style="text-transform: capitalize"
                                                       href="#"><?= $_GET['page'] ?></a></li>
                        <!--                        <li class="breadcrumb-item active">Starter Page</li>-->
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- /.col-md-8 -->
                <div class="col-lg-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="m-0">Memes Data</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="dataTable1" class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Caption</th>
                                        <th>Photo</th>
                                        <th>Posted By</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($memes as $key => $meme): ?>
                                        <tr>
                                            <td><?= $key += 1; ?></td>
                                            <td><?= $meme['meme_caption']  ?></td>
                                            <td>
                                                <img src="../img/meme/<?= $meme['meme_image'] ?>" alt=""
                                                     style="width: 70px;height: 70px; object-fit: cover">
                                            </td>
                                            <td><?= $meme['name']  ?></td>
                                            <td>
                                                <a href="<?= base_url."post.php?uid=".$meme['id_meme'] ?>"
                                                   class="btn btn-info" target="_blank">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="./?page=memes&id=<?= $meme['id_meme'] ?>&delete"
                                                   class="btn btn-danger"
                                                   onclick="return confirm('Do you wanna delete this item?') ">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
