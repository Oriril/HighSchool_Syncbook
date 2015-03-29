<div class="container">
    <!-- echo out the system feedback (error and success messages) -->
    <?php //$this->renderFeedbackMessages(); ?>
    <div class="row">
        <div class="col-sm-6">
            <div class="well">
                <form class="form-horizontal" method="post" action="<?php echo Config::get('URL'); ?>login/register_action">
                    <fieldset>
                        <legend>Register a new account</legend>

                        <!-- the user name input field uses a HTML5 pattern check -->
                        <div class="form-group">
                            <label for="user_firstname" class="col-lg-2 control-label">First name</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" pattern="[a-zA-Z]{2,64}" id="user_firstname" name="user_firstname" placeholder="Your first name (letters)" required/>
                                </div>
                        </div>
                        <div class="form-group">
                            <label for="user_lastname" class="col-lg-2 control-label">Last name</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" pattern="[a-zA-Z]{2,64}" id="user_lastname" name="user_lastname" placeholder="Your last name (letters)" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="user_name" class="col-lg-2 control-label">Username</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" pattern="[a-zA-Z0-9]{2,64}" id="user_name" name="user_name" placeholder="Username (letters/numbers, 2-64 chars)" required />
                                <span id="helpBlock" class="help-block">letters/numbers, 2-64 chars</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="user_email" class="col-lg-2 control-label">Email</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="user_email" name="user_email" placeholder="email address (a real address)" required />
                                <span id="helpBlock" class="help-block">A real address</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="user_password_new" class="col-lg-2 control-label">Password</label>
                            <div class="col-lg-10">
                                <input type="password" class="form-control" id="user_password_new" name="user_password_new" pattern=".{6,}" placeholder="Password (6+ characters)" required autocomplete="off" />
                                <span id="helpBlock" class="help-block">6+ characters</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="user_password_repeat" class="col-lg-2 control-label">Repeat Password</label>
                            <div class="col-lg-10">
                                <input type="password" class="form-control" id="user_password_repeat" name="user_password_repeat" pattern=".{6,}" required placeholder="Repeat your password" autocomplete="off" />
                                <span id="helpBlock" class="help-block">Repeat your password</span>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-lg-2"></div>
                            <div class="col-lg-10">
                            <!-- show the captcha by calling the login/showCaptcha-method in the src attribute of the img tag -->
                                <img id="captcha" src="<?php echo Config::get('URL'); ?>login/showCaptcha" />
                                </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-2"></div>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" name="captcha" placeholder="Please enter above characters" required />
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-2"></div>
                            <div class="col-lg-10">
                        <!-- quick & dirty captcha reloader -->
                            <a href="#" style="display: block; font-size: 11px; margin: 5px 0 15px 0; text-align: center"
                               onclick="document.getElementById('captcha').src = '<?php echo Config::get('URL'); ?>login/showCaptcha?' + Math.random(); return false">Reload Captcha</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-2">
                                <input type="submit" class="btn-primary" value="Register" />
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <p style="display: block; font-size: 11px; color: #999;">
        Please note: This captcha will be generated when the img tag requests the captcha-generation
        (= a real image) from YOURURL/login/showcaptcha. As this is a client-side triggered request, a
        $_SESSION["captcha"] dump will not show the captcha characters. The captcha generation
        happens AFTER the request that generates THIS page has been finished.
    </p>
</div>
