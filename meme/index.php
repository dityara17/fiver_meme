<?php
require "config/MainClass.php";
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

if (isset($_GET['upvote'])) {
    if (empty($_SESSION['member'])) {
        echo "<script>alert('You need to login first');</script>";
    } else {
        $use->doVote('1', $_GET['upvote'], $_SESSION['member']['id']);
        echo "<script>alert('Thanks for vote');location='index.php'</script>";
    }
}
if (isset($_GET['unvote'])) {
    if (empty($_SESSION['member'])) {
        echo "<script>alert('You need to login first');</script>";
    } else {
        $use->doVote('0', $_GET['unvote'], $_SESSION['member']['id']);
        echo "<script>alert('Thanks for vote');location='index.php'</script>";
    }
}
if (isset($_SESSION['member'])) {
    $postUser = $use->getPostByUser($_SESSION['member']['id']);
    $voteUser = $use->getVoteByUser($_SESSION['member']['id']);
}

$limit = 8;
if (empty($_GET['page'])) {
    $page = 1;
} else {
    if ($_GET['page'] < 1) {
        $page = 1;
    } else {
        $page = $_GET['page'];
    }
}

$memes = $use->getIndexMemes($page, $limit);
$memePage = $use->memeimithal($limit);
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
                            <?php if ($memePage > $page): ?>
                                <!--      next                      -->
                                <div class="button-next-post">
                                    <a href="./?page=<?= $page + 1; ?>">Next Post <i
                                                class="glyphicon glyphicon-circle-arrow-right"></i></a>
                                </div>
                            <?php endif; ?>
                            <?php foreach ($memes as $meme): ?>
                                <article class="main-post">

                                    <div class="article-top">
                                        <h1>
                                            <a href="post.php?uid=<?= $meme['id_meme'] ?>"><?= $meme['meme_caption'] ?></a>
                                        </h1>
                                        <hr/>
                                        <div class="counters-line">
                                            <div class="pull-left">
                                                <div class="date"><i
                                                            class="icon-date"></i> <?= date('m.d', strtotime($meme['meme_date'])) ?>
                                                </div>
                                                <div class="user"><i class="icon-user"></i> <a
                                                            href="profile.php?url=<?= $meme['path'] ?>"><?= $meme['name'] ?></a>
                                                </div>
                                                <div class="comments"><i class="icon-comments"></i> <a href="post.php?uid=<?= $meme['id_meme'] ?>">Comments</a></div>
                                            </div>
                                            <div class="pull-right">
                                                <div class="like"><a href="./?upvote=<?= $meme['id_meme'] ?>"><i
                                                                class="icon-like"></i> <?= $meme['upvote'] ?></a></div>
                                                <div class="dislike"><a href="./?unvote=<?= $meme['id_meme'] ?>"><i
                                                                class="icon-dislike"></i> <?= $meme['unvote'] ?></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="buttons-bar">
                                            <div class="buttons">
                                                <div class="count"
                                                     style="background: black"><?= $meme['upvote'] ?></div>
                                            </div>
                                            <div class="social-icons">
                                                <a href="javascript:void(0)"
                                                   data-href="https://www.facebook.com/sharer/sharer.php?u=<?= base_url . "post.php?uid=" . $meme['id_meme'] ?>"
                                                   class='facebook has-tooltip'
                                                   data-title="Share on Facebook">facebook</a>
                                                <a href="javascript:void(0)"
                                                   data-href="https://twitter.com/intent/tweet?source=tweetbutton&amp;text=<?= $meme['meme_caption'] ?>&url=<?= base_url . "post.php?uid=" . $meme['id_meme'] ?>"
                                                   class='twitter has-tooltip' data-title="Share on Twitter">twitter</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="article-content">
                                        <figure>
                                            <div class="corner-tag green"><a href="#"><?= $meme['category_name'] ?></a>
                                            </div>
                                            <img class="lazy" data-original="img/meme/<?= $meme['meme_image'] ?>"
                                                 alt="<?= $meme['meme_caption'] ?>"/>
                                        </figure>
                                    </div>
                                </article>
                            <?php endforeach; ?>

                            <?php if ($memePage > $page): ?>
                                <!--      next                      -->
                                <div class="button-next-post-bot">
                                    <a href="./?page=<?= $page + 1 ?>">Next Post <i
                                                class="glyphicon glyphicon-circle-arrow-right"></i></a>
                                </div>
                            <?php endif; ?>
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