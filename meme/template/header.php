<?php
$popularMemes = $use->getPopularIndexMemes(0, 5);
?>
<header>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <nav class="navbar navbar-default" role="navigation">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse"
                                data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <div class="top-ten">
                            <div class="activator">
                                <div class="left">
                                    <span class="small">Top</span>
                                    <span class="small">All</span>
                                    <span class="small">Time</span>
                                </div>
                                <div class="right">5</div>
                            </div>
                            <div class="drop-down">
                                <div class="post-list">
                                    <?php foreach ($popularMemes as $key => $popularMeme): ?>
                                        <article>
                                        <figure>
                                            <img style="height: 50px;width: 50px;object-fit: cover" src="img/meme/<?= $popularMeme['meme_image'] ?>" alt=""/>
                                            <figcaption>0<?= $key+=1; ?></figcaption>
                                        </figure>
                                        <div class="text">
                                            <h3><a href="post.php?uid=<?= $popularMeme['id_meme'] ?>"><?= substr($popularMeme['meme_caption'], 0, 15); ?></a></h3>
                                            <span class="date"><?= date('m d', strtotime($popularMeme['meme_date'])) ?></span>
                                        </div>
                                    </article>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <a class="navbar-brand" href="./">
                            <!--                            <img src="img/logo.png" alt="MemeHustler  - Image Sharing, Gag, Meme Theme">-->
                            <span style="color: orange">MemeHustler</span>
                        </a>
                    </div>
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li><a href="index.php">Home</a></li>
                            <li><a href="popular-meme.php">Popular</a></li>
                        </ul>
                    </div>
                    <div class="right-container">
                        <?php if (isset($_SESSION['member'])): ?>
                            <div class="user-box">
                                <a href="#">
                                    <figure>
                                        <img src="img/user-box.png" alt=""/>
                                    </figure>
                                    <span class="name"><?= $_SESSION['member']['name'] ?></span>
                                </a>
                                <div class="drop-down" style="z-index: 999999">
                                    <div class="counters-line">
                                        <div class="half"><span class="counter"><?= count($voteUser) ?></span><span class="desc">Vote</span></div>
                                        <div class="half"><span class="counter"><?= count($postUser); ?></span><span class="desc">posts</span>
                                        </div>
                                    </div>
                                    <div class="buttons-line">
                                        <a href="post-meme.php" class="btn btn-primary btn-block custom-button">Post Fun</a>
                                        <!--                                    <a href="settings.html" class="btn btn-primary btn-block custom-button">Profile & Settings</a>-->
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>