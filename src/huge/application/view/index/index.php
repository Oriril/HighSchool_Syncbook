<section id="intro" class="intro-section">
    <div class="container">
        <div class="hoja">Syncbook</div>
        <div class="col-lg-12 see-more">
            <a class="btn btn-raised page-scroll" href="#services">See more</a>
        </div>
    </div>
</section>
<section id="services" class="services-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading">
                    <h1>Services</h1>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <img class="center" src="../public/avatars/bootstrap.png">
                <h3>Responsive & Material</h3>
                <p>
                    Using one of the most complete CSS Frameworks,topped with a marvelously developed Google's Material Design extension was surely very hard. But the hard work paid off when we finally finished a Website that's 100% ready for the future of Web-Development.
                </p>
            </div>
            <div class="col-sm-4">
                <div>
                    <img class="center" src="../public/avatars/responsive.png">
                    <h3>Cross Platform</h3>
                    <p>
                        Syncbook was built in this project uses the latest standard in vCards storing and formatting, letting the users manage their AddressBooks from every device, breaking the barriers that are right now imposed by the majority of manufacturers.
                    </p>
                </div>
            </div>
            <div class="col-sm-4">
                <div>
                    <img class="center" src="../public/avatars/lock.png">
                    <h3>Web Security</h3>
                    <p>
                        Thanks to one of the most advanced SSL certificates that can be found in the market, the website is completly covered by the HTTPS protocol so users don't have to worry about that their datas are beign stored in a unsafe place.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="powered-by" class="powered-by-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading">
                    <h1>Powered by</h1>
                </div>
            </div>
        </div>
        <div class="row">
            <img class="img-responsive center" src="../public/avatars/html5.png">
            <img class="img-responsive center" src="../public/avatars/css3.png">
            <img class="img-responsive center" src="../public/avatars/jquery.png">
            <img class="img-responsive center" src="../public/avatars/php5.png">
            <img class="img-responsive center" src="../public/avatars/sabre_logo.png">
        </div>
    </div>
</section>
<section id="team" class="team-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading">
                    <h1>Our Team</h1>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-4">
                <div class="well no-padding" style="padding: 0px;">
                    <div class="card hovercard" style="display: block;">
                        <div class="cardheader">
                        </div>
                        <div class="avatar">
                            <img alt="" src="https://gravatar.com/avatar/8345625bf8f31967f3faba078126d0d9">
                        </div>
                        <div class="info">
                            <div class="title">
                                <a target="_blank" href="https://twitter.com/LonghinFederico">Federico Longhin</a>
                            </div>
                            <div class="desc">Passionate designer</div>
                            <div class="desc">Curious developer</div>
                            <div class="desc">Tech geek</div>
                        </div>
                        <div class="bottom">
                            <a class="btn btn-material-blue-grey-100 btn-sm" href="https://github.com/Nildric">
                                <i class="fa fa-github"></i>
                            </a>
                            <a class="btn btn-danger btn-sm" rel="publisher"
                               href="mailto:longhin.federico.nildric@gmail.com">
                                <i class="fa fa-inbox"></i>
                            </a>
                            <a class="btn btn-material-blue-400 btn-sm" href="https://twitter.com/LonghinFederico">
                                <i class="fa fa-twitter"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
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
                            <a class="btn btn-material-blue-grey-100 btn-sm" href="https://github.com/Xooline">
                                <i class="fa fa-github"></i>
                            </a>
                            <a class="btn btn-danger btn-sm" rel="publisher"
                               href="https://plus.google.com/+EnricoBasso01">
                                <i class="fa fa-google-plus"></i>
                            </a>
                            <a class="btn btn-material-blue-400 btn-twitter btn-sm" href="https://twitter.com/enrixubi">
                                <i class="fa fa-twitter"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-2"></div>
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