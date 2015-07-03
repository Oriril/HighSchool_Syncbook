<div class="container fix-navbar">

    <!-- echo out the system feedback (error and success messages) -->
    <?php $this->renderFeedbackMessages(); ?>

    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
            <div class="well center">
                <form class="form-horizontal" method="post" action="<?php echo Config::get('URL'); ?>login/register_action">
                    <fieldset>
                        <legend>Register a new account</legend>

                        <div class="form-group">
                            <div class="col-lg-12">
                                <input type="text" class="form-control floating-label" data-hint="Only Letters are allowed. Max 16 Characters long." pattern="[a-zA-Z]{1,16}" id="user_firstname" data-focus="focus" name="user_firstname" placeholder="First name" required/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-12">
                                <input type="text" class="form-control floating-label" data-hint="Only Letters are allowed. Max 16 Characters long." pattern="[a-zA-Z]{1,16}" id="user_lastname" name="user_lastname" placeholder="Last name" required/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-12">
                                <input type="text" class="form-control floating-label" data-hint="Only Letters and Numbers are allowed. Max 16 Characters long." pattern="[a-zA-Z0-9]{1,16}" id="user_name" name="user_name" placeholder="Username" required />
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-12">
                                <input type="email" class="form-control floating-label" data-hint="A Valid E-Mail address." id="user_email" name="user_email" placeholder="Email" required />
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-lg-12">
                                <input type="password" class="form-control floating-label" data-hint="Min 6 Characters long." id="user_password_new" name="user_password_new" pattern=".{6,}" placeholder="Password" required autocomplete="off" />
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-lg-12">
                                <input type="password" class="form-control floating-label" data-hint="Repeat your Password." id="user_password_repeat" name="user_password_repeat" pattern=".{6,}" required placeholder="Repeat your password." autocomplete="off" />
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-12">
                                <!-- show the captcha by calling the login/showCaptcha-method in the src attribute of the img tag -->
                                <img id="captcha" class="img-responsive center" src="<?php echo Config::get('URL'); ?>login/showCaptcha" />
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-12">
                                <input type="text" class="form-control floating-label" data-hint="Please enter above Characters" name="captcha" placeholder="Captcha" required />
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-12">
                                <!-- quick & dirty captcha reloader -->
                                <a href="#" style="display: block; font-size: 11px; margin: 5px 0 15px 0; text-align: center"
                                   onclick="document.getElementById('captcha').src = '<?php echo Config::get('URL'); ?>login/showCaptcha?' + Math.random(); return false">Reload Captcha</a>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-12">
                                <input type="submit" class="btn btn-primary" value="Register" />
                            </div>
                        </div>
                </form>
            </div>
        </div>
        <div class="col-sm-2"></div>
    </div>
</div>