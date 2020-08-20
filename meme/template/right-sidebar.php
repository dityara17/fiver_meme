<aside class="col-sm-3">
    <div class="widget">
        <h2>Search</h2>
        <hr/>
        <div class="widget-content">
            <div class="input-group search-widget">
                <input type="text" class="form-control" placeholder="Search something"/>
                <span class="input-group-btn">
                                        <button class="btn btn-primary custom-button" type="button">Search</button>
                                    </span>
            </div>
        </div>
    </div>
    <div class="widget">
        <h2>User functionality</h2>
        <hr/>
        <div class="widget-content">
            <?php if (isset($_SESSION['member'])): ?>
                <a  href="../my-profile.php"
                   class="btn btn-primary btn-lg btn-block custom-button">Profile</a><br/>
            <?php else: ?>
                <a data-toggle="modal" href="#registerModal"
                   class="btn btn-primary btn-lg btn-block custom-button">Register/Login</a><br/>
            <?php endif; ?>
            <a  href="post-meme.php"
               class="btn btn-primary btn-lg btn-block custom-button">Post Article</a>
        </div>
    </div>
    <div class="widget">
        <h2>Funnies Joker</h2>
        <hr/>
        <div class="widget-content">
            <div class="joker">
                <figure>
                    <img src="img/avatar01.jpg" alt=""/>
                </figure>
                <div class="text">
                    <div class="name"><a href="#">Liam McLean</a></div>
                    <div class="likes">234910 kudos</div>
                </div>
                <a href="profile.html" class="btn btn-primary btn-block custom-button">See Liam's
                    Profile</a>
            </div>
        </div>
    </div>
    <div class="widget">
        <h2>Find us on Facebook</h2>
        <hr/>
        <div class="widget-content">
            <div class="fb-like-box" data-href="https://www.facebook.com/TeoThemes" data-width="165"
                 data-height="300" data-colorscheme="light" data-show-faces="true"
                 data-header="false" data-stream="false" data-show-border="false"></div>
        </div>
    </div>
</aside>