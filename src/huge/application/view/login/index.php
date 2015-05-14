<div class="container">

    <!-- echo out the system feedback (error and success messages) -->
    <?php //$this->renderFeedbackMessages(); ?>

    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="well">
                <!-- login box on left side -->
                <form class="form-horizontal" action="<?php echo Config::get('URL'); ?>login/login" method="post">
                    <fieldset>
                        <legend>Login</legend>

                        <div class="form-group">
                            <div class="col-lg-12">
                                <input type="text" class="form-control floating-label" id="user_name" name="user_name" placeholder="Username or email" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-12">
                                <input type="password" class="form-control" id="user_password" name="user_password" placeholder="Password" required />
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
        <div class="col-md-3"></div>
    </div>
</div>
