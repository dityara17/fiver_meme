<?php
require "config/MainClass.php";
if (empty($_SESSION['member'])) {
    header("location: index.php");
}
$categories = $use->getCategories('alpha');
if (isset($_POST['register'])) {
    if ($_POST['register_password'] != $_POST['register_password_verify']) {
        echo "<script>alert('your password does not match')</script>";
    } else {
        $cechk = $use->registerMember($_POST['register_username'], $_POST['register_email'], $_POST['register_password']);
        if ($cechk == false) {
            echo "<script>alert('Username or email already taken');</script>";
        } else {
            echo "<script>alert('Great you are already registered ');location='index.php';</script>";
        }
    }
}
if (isset($_POST['login'])) {
    $cechk = $use->login($_POST['login_email'], $_POST['login_password']);
    if ($cechk == 1) {
        echo "<script>alert('Welcome back...');location='index.php'</script>";
    } else {
        echo "<script>alert('Undefined user');</script>";
    }
}
?>
<!DOCTYPE html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Meme</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">
    <link rel="icon" type="image/png" href="favicon.png">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,500,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Dosis:300,400,500,600,700,800' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Nunito:400,300,700' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
          integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
          crossorigin="anonymous"/>
    <link rel="stylesheet" href="css/slider.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/jquery.selectBoxIt.css">
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.css">
    <link rel="stylesheet" href="fileupload/css/jquery.fileupload.css">
    <link rel="stylesheet" href="fileupload/css/jquery.fileupload-ui.css">
    <link rel="stylesheet" href="css/jquery.tagsinput.css">
    <link rel="stylesheet" href="css/style.css">

    <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>

</head>
<body>
<?php include "template/header.php"; ?>
<section id="main" role="main">
    <div class="container">
        <div class="row">
            <div class="col-sm-9 right-content">
                <div class="row">
                    <div class="col-sm-9">
                        <div class="main-wrap">

                            <!--           post-meme form                 -->
                            <form action="#" method="post" enctype="multipart/form-data">
                                <h2>Post meme</h2>
                                <div class="post-window window-video">
                                    <input type="hidden" value="<?= $_SESSION['member']['id'] ?>" name="meme_user">
                                    <div class="form-group">
                                        <label for="#CaptionMeme">Caption</label>
                                        <textarea id="CaptionMeme" class="form-control" name="memeCaption" rows="3"
                                                  placeholder="Post Caption"
                                                  maxlength="100" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="#CategoryMeme">Category</label>
                                        <select name="memeCategory" id="CategoryMeme" class="form-control">
                                            <?php foreach ($categories as $category): ?>
                                                <option value="<?= $category['id_category'] ?>"><?= $category['category_name'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <div class="upload-wrap">
                                             <span class="btn btn-success ">
                                                 <span class="purple">UPLOAD YOUR IMAGE HERE</span><br/>
                                                 <span>PNG, GIF or JPG accepted. <br/> Max Size is 5MB.</span>
                                                 <!-- The file input field used as target for the file upload widget -->
                                                   <input class="" type="file" required name="memeImage"
                                                          rel="files-slider10">
                                            </span>
                                        </div>
                                    </div>
                                    <button name="postMeme" type="submit"
                                            style="background: #333;color: white;padding: 15px"
                                            class="btn btn-link btn-block">Post It / Upload
                                    </button>
                                </div>
                            </form>
                            <?php
                            if (isset($_POST['postMeme'])) {
                                $use->storeMeme($_POST['meme_user'], $_POST['memeCategory'], $_POST['memeCaption'], $_FILES['memeImage']);
                                echo "<script>alert('Great you are meme already posted ');location='index.php';</script>";
                            }
                            ?>
                        </div>
                    </div>


                    <?php include "template/right-sidebar.php"; ?>

                </div>
            </div>
            <?php include "template/left-sidebar.php"; ?>
        </div>
    </div>
</section>

<?php include "template/footer.php"; ?>


<div id="scripts">
    <script src="js/vendor/jquery-1.10.1.min.js"></script>
    <script src="js/vendor/jquery-ui.min.js"></script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <script src="js/vendor/jquery.flexslider-min.js"></script>
    <script src="js/vendor/jquery.selectBoxIt.min.js"></script>
    <script src="js/vendor/jquery.mCustomScrollbar.min.js"></script>
    <script src="js/vendor/jquery.mousewheel.min.js"></script>
    <script src="fileupload/js/vendor/jquery.ui.widget.js"></script>
    <script src="js/vendor/jquery.tagsinput.min.js"></script>
    <script src="fileupload/js/jquery.iframe-transport.js"></script>
    <script src="fileupload/js/jquery.fileupload.js"></script>
    <script src="fileupload/js/jquery.fileupload-process.js"></script>
    <script src="fileupload/js/jquery.fileupload-image.js"></script>
    <script src="fileupload/js/jquery.fileupload-audio.js"></script>
    <script src="fileupload/js/jquery.fileupload-video.js"></script>
    <script src="fileupload/js/jquery.fileupload-validate.js"></script>
    <script src="js/main.js"></script>
    <script src="js/retina-1.1.0.min.js"></script>
    <script src="js/jquery.lazyload.min.js"></script>
</div>
</body>

<!-- Mirrored from teothemes.com/html/Aruna/ by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 15 Aug 2020 03:39:06 GMT -->
</html>