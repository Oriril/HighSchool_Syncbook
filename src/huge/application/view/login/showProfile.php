<div class="container fix-navbar">
    <!-- echo out the system feedback (error and success messages) -->
    <?php $this->renderFeedbackMessages(); ?>
    <div class="col-sm-4"></div>
    <div class="col-sm-4">
        <div class="well no-padding" style="padding: 0px;">
            <div class="card hovercard" style="display: block;">
                <div class="cardheader">
                </div>
                <div class="avatar">
                    <img alt="" src="<?= $this->user_gravatar_image_url; ?>">
                </div>
                <div class="info">
                    <div class="title">
                        <a target="_blank" href="https://twitter.com/LonghinFederico"><?= $this->user_name; ?></a>
                    </div>
                    <div class="desc"><?= $this->user_email; ?></div>
                    <div class="desc">Profile picture powered by <i>gravatar.com</i></div>
                </div>
                <div class="bottom"></div>
            </div>
        </div>
    </div>
    <div class="col-sm-4"></div>
</div>
