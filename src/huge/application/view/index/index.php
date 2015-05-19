<section id="intro" class="intro-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1>Enjoy</h1>
                <a class="btn btn-default page-scroll" href="#about">Click Me to Scroll Down!</a>
            </div>
        </div>
    </div>
</section>
<section id="about" class="about-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1>About Section</h1>
            </div>
        </div>
    </div>
</section>
<section id="services" class="services-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1>Services Section</h1>
            </div>
        </div>
    </div>
</section>
<section id="contact" class="contact-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1>Contact Section</h1>
            </div>
        </div>
    </div>
</section>
<div id="log-in-dialog" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Log in</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="<?php echo Config::get('URL'); ?>login/login" method="post">
                    <fieldset>

                        <div class="form-group">
                            <div class="col-lg-12">
                                <input type="text" class="form-control floating-label" id="user_name" name="user_name" placeholder="Username or email" required />
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