<?php
$category = $use->getCategory($_GET['id']);
if (isset($_POST['submit'])) {
    $use->updateCategory($_POST['name'], $_FILES['image'],$_GET['id']);
    echo "<script>alert('success');location='./?page=categories'</script>";

}
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Categories</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a style="text-transform: capitalize"
                                                       href="#">Categories</a></li>
                                                <li class="breadcrumb-item active"><?= $_GET['page'] ?></li>
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
                            <h5 class="m-0">Edit Category</h5>
                        </div>
                        <div class="card-body">
                            <div class="form">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="">Name</label>
                                        <input type="text" class="form-control" name="name" value="<?= $category['category_name'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Image</label> <br>
                                        <img src="../img/category/<?= $category['category_image'] ?>" alt="" width="100">
                                        <input type="file" class="form-control" name="image">
                                    </div>
                                    <button class="btn btn-primary" name="submit">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col-md-8 -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
