<div class="container">

    <!-- echo out the system feedback (error and success messages) -->
    <?php //$this->renderFeedbackMessages(); ?>

    <div class="row">
        <div class="col-sm-6">
            <div class="well">
                <!-- login box on left side -->
                <form class="form-horizontal" action="<?php echo Config::get('URL'); ?>login/login" method="post">
                    <fieldset>
                        <legend>Login here</legend>

                        <div class="form-group">
                            <label for="user_name" class="col-lg-2 control-label">Username or email</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Username or email" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="user_password" class="col-lg-2 control-label">Password</label>
                            <div class="col-lg-10">
                                <input type="password" class="form-control" id="user_password" name="user_password" placeholder="Password" required />
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="set_remember_me_cookie"> Remember me for 2 weeks
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-10">
                                <input type="submit" class="btn-primary" value="Log in"/>
                            </div>
                        </div>
                    </fieldset>
                </form>
                <div class="link-forgot-my-password">
                    <a href="<?php echo Config::get('URL'); ?>login/requestPasswordReset">I forgot my password</a>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="well">
                <form class="form-horizontal">
                    <fieldset>
                        <legend>No account yet ?</legend>
                        <div class="col-lg-10">
                            <a href="<?php echo Config::get('URL'); ?>login/register">Register!</a>
                        </div>
                    </fieldset>
                </form>
            </div>

        </div>
    </div>
</div>
