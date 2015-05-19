<div class="container fix-navbar">

    <!-- echo out the system feedback (error and success messages) -->
    <?php $this->renderFeedbackMessages(); ?>

    <div class="col-sm-6">
        <div class="panel-warning">
            <div class="panel-heading">Change your email address</div>
            <div class="panel-body">
                    <form class="form-horizontal" action="<?php echo Config::get('URL'); ?>login/editUserEmail_action" method="post">
                        <label>
                            New email address: <input type="text" name="user_email" required />
                        </label>
                        <input class="btn btn-primary btn-raised" type="submit" value="Submit" />
                    </form>
            </div>
        </div>
    </div>
</div>
