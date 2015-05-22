<section id="intro" class="intro-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1>Welcome to Syncbook</h1>
                <p>Some text here</p>
                <a class="btn btn-raised page-scroll" href="#services">See more</a>
            </div>
        </div>
    </div>
</section>
<section id="services" class="services-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1>What can I do with Syncbook?</h1>
            </div>
        </div>
        <div class="row" style="text-align: left;">
            <div class="col-sm-6">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>
            <div class="col-sm-6">Random image of a syncing process.</div>
        </div>
    </div>
</section>
<section id="powered-by" class="powered-by-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="well">
                    <h1>PHP</h1>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="well">
                    <h1>CSS3 & Bootstrap</h1>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="well">
                    <h1>jQuery</h1>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="well">
                    <h1>Sabre</h1>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="team" class="team-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1>Our Team</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-3">
                <div class="well no-padding" style="padding: 0px;">
                    <div class="card hovercard" style="display: block;">
                        <div class="cardheader">

                        </div>
                        <div class="avatar">
                            <img alt="" src="https://gravatar.com/avatar/8345625bf8f31967f3faba078126d0d9">
                        </div>
                        <div class="info">
                            <div class="title">
                                <a target="_blank" href="http://scripteden.com/">Federico Longhin</a>
                            </div>
                            <div class="desc">Passionate designer</div>
                            <div class="desc">Curious developer</div>
                            <div class="desc">Tech geek</div>
                        </div>
                        <div class="bottom">
                            <a class="btn btn-material-blue-400 btn-twitter btn-sm" href="https://twitter.com/webmaniac">
                                <i class="fa fa-twitter"></i>
                            </a>
                            <a class="btn btn-danger btn-sm" rel="publisher"
                               href="https://plus.google.com/+ahmshahnuralam">
                                <i class="fa fa-google-plus"></i>
                            </a>
                            <a class="btn btn-material-indigo-600 btn-sm" rel="publisher"
                               href="https://plus.google.com/shahnuralam">
                                <i class="fa fa-facebook"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="well no-padding" style="padding: 0px;">
                    <div class="card hovercard" style="display: block;">
                        <div class="cardheader">

                        </div>
                        <div class="avatar">
                            <img alt="" src="https://www.gravatar.com/avatar/8d669acbd39ba16bb05a92e2937b2c70.png">
                        </div>
                        <div class="info">
                            <div class="title">
                                <a target="_blank" href="https://twitter.com/enrixubi">Enrico Basso</a>
                            </div>
                            <div class="desc">Passionate designer</div>
                            <div class="desc">Curious developer</div>
                            <div class="desc">Tech geek</div>
                        </div>
                        <div class="bottom">
                            <a class="btn btn-material-blue-400 btn-twitter btn-sm" href="https://twitter.com/enrixubi">
                                <i class="fa fa-twitter"></i>
                            </a>
                            <a class="btn btn-danger btn-sm" rel="publisher"
                               href="https://plus.google.com/+ahmshahnuralam">
                                <i class="fa fa-google-plus"></i>
                            </a>
                            <a class="btn btn-material-indigo-600 btn-sm" rel="publisher"
                               href="https://plus.google.com/shahnuralam">
                                <i class="fa fa-facebook"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3"></div>
        </div>
    </div>
</section>
<div id="log-in-dialog" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Log in</h4> -->
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="<?php echo Config::get('URL'); ?>login/login" method="post">
                    <fieldset>

                        <div class="form-group">
                            <div class="col-lg-12">
                                <input type="text" class="form-control floating-label" id="user_name" name="user_name" placeholder="Username or E-Mail" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-12">
                                <input type="password" class="form-control floating-label" id="user_password" name="user_password" placeholder="Password" required />
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="set_remember_me_cookie"> Remember me for 2 weeks
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-12">
                                <input type="submit" class="btn btn-primary" value="Log in"/>
                                No account Yet? <a href="<?php echo Config::get('URL'); ?>login/register">Register!</a>
                            </div>
                        </div>
                    </fieldset>
                </form>
                <div class="link-forgot-my-password">
                    <a href="<?php echo Config::get('URL'); ?>login/requestPasswordReset">I forgot my password</a>
                </div>
            </div>
        </div>

    </div>
</div>
</div>
</div>