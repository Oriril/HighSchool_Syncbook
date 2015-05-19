<div class="container fix-navbar">

    <!-- echo out the system feedback (error and success messages) -->
    <?php $this->renderFeedbackMessages(); ?>
    <div class="col-sm-12">
        <div class="panel-warning">
            <div class="panel-heading">Request a password reset</div>
            <div class="panel-body">
                <!-- request password reset form box -->
                <form method="post" action="<?php echo Config::get('URL'); ?>login/requestPasswordReset_action">
                    <label>
                        Enter your username or email and you'll get a mail with instructions:
                        <input type="text" name="user_name_or_email" required />
                    </label>
                    <input class="btn btn-primary btn-raised" type="submit" value="Send me a password-reset mail" />
                </form>
            </div>
        </div>
    </div>
</div>
