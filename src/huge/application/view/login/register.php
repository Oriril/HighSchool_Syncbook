<div class="container">
    <!-- echo out the system feedback (error and success messages) -->
    <?php /*$this->renderFeedbackMessages();
             @TODO add tooltips on input group */?>
    <div class="row">
        <div class="col-sm-6">
            <div class="well">
                <form class="form-horizontal" method="post" action="<?php echo Config::get('URL'); ?>login/register_action">
                    <fieldset>
                        <legend>Register a new account</legend>


                            <div class="form-control-wrapper">

                                    <input type="text" class="form-control floating-label" data-hint="Letters" pattern="[a-zA-Z]" id="user_firstname" name="user_firstname" placeholder="First name" required/>

                            </div><br/>



                            <div class="form-control-wrapper">

                                    <input type="text" class="form-control floating-label" data-hint="Letters" pattern="[a-zA-Z]" id="user_lastname" name="user_lastname" placeholder="Last name" required/>

                            </div><br/>




                            <div class="form-control-wrapper">

                                    <input type="text" class="form-control floating-label" data-hint="Letters and numbers, 2-64 chars." pattern="[a-zA-Z0-9]{2,64}" id="user_name" name="user_name" placeholder="Username" required />

                            </div><br/>



                            <div class="form-control-wrapper">

                                    <input type="email" class="form-control floating-label" data-hint="A real address." id="user_email" name="user_email" placeholder="Email" required />

                            </div><br/>


                            <div class="form-control-wrapper">

                                    <input type="password" class="form-control floating-label" data-hint="6+ characters." id="user_password_new" name="user_password_new" pattern=".{6,}" placeholder="Password" required autocomplete="off" />

                            </div><br/>


                            <div class="form-control-wrapper">

                                    <input type="password" class="form-control floating-label" data-hint="Repeat your password." id="user_password_repeat" name="user_password_repeat" pattern=".{6,}" required placeholder="Repeat your password." autocomplete="off" />

                            </div><br/>



                            <div class="form-control-wrapper">
                                <div class="col-lg-2"></div>
                                <div class="col-lg-10">
                                <!-- show the captcha by calling the login/showCaptcha-method in the src attribute of the img tag -->
                                    <img id="captcha" src="<?php echo Config::get('URL'); ?>login/showCaptcha" />
                                </div>
                            </div><br/>

                            <div class="form-control-wrapper">
                                <div class="col-lg-12">
                                    <input type="text" class="form-control floating-label" data-hint="Please enter above characters" name="captcha" placeholder="Captcha" required />
                                </div>
                            </div><br/>

                            <div class="form-control-wrapper">
                                <div class="col-lg-12">
                            <!-- quick & dirty captcha reloader -->
                                <a href="#" style="display: block; font-size: 11px; margin: 5px 0 15px 0; text-align: center"
                                   onclick="document.getElementById('captcha').src = '<?php echo Config::get('URL'); ?>login/showCaptcha?' + Math.random(); return false">Reload Captcha</a>
                                </div>
                            </div><br/>

                            <div class="form-control-wrapper">
                                <div class="col-lg-2">
                                    <input type="submit" class="btn btn-primary" value="Register" />
                                </div>
                            </div><br/>

                </form>
            </div>
        </div>
    </div>
</div>
