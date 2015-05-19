<div class="container fix-navbar">
    <!-- echo out the system feedback (error and success messages) -->
    <?php $this->renderFeedbackMessages(); ?>

    <div class="col-sm-8">
        <div class="panel-warning">
            <div class="panel-heading"><?= $this->user_name; ?></div>
            <div class="panel-body">
                <div class="col-sm-6">Your email:</div>
                <div class="col-sm-6"><?= $this->user_email; ?></div>
                <div class="col-sm-6">Your avatar image (on gravatar.com):</div>
                <div class="col-sm-6">
                         <img src='<?= $this->user_gravatar_image_url; ?>' />

                </div>
            </div>

        </div>
    </div>
</div>
