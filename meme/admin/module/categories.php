<?php
$categories = $use->getCategories();
if (isset($_POST['submit'])) {
    $use->storeCategory($_POST['name'], $_FILES['image']);
    echo "<script>alert('success');location='./?page=categories'</script>";
}
if (isset($_GET['delete'])){
    $use->destroyCategory($_GET['id']);
    echo "<script>alert('success');location='./?page=categories'</script>";
}
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Starter Page</h1>
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
                <!-- /.col-md-4 -->
                <div class="col-lg-4">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="m-0">Add Category</h5>
                        </div>
                        <div class="card-body">
                            <div class="form">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="">Name</label>
                                        <input type="text" class="form-control" name="name">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Image</label>
                                        <input type="file" class="form-control" name="image">
                                    </div>
                                    <button class="btn btn-primary" name="submit">Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col-md-8 -->
                <div class="col-lg-8">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="m-0">Categories Data</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Image</th>
                                        <th>Url</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($categories as $key => $category): ?>
                                        <tr>
                                            <td><?= $key += 1; ?></td>
                                            <td><?= $category['category_name'] ?></td>
                                            <td>
                                                <img src="../img/category/<?= $category['category_image'] ?>" alt="" width="100">
                                            </td>
                                            <td><?= base_url . $category['category_path'] ?></td>
                                            <td>
                                                <a href="./?page=category-edit&id=<?= $category['id_category'] ?>"
                                                   class="btn btn-info">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                <a href="./?page=categories&id=<?= $category['id_category'] ?>&delete"
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
