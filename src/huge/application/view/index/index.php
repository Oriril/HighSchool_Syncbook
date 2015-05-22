<section id="intro" class="intro-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1>Welcome to Syncbook</h1>
                <p>Some text here</p>
                <a class="btn btn-raised page-scroll" href="#services">See more</a>
            </div>
        </div>
    </div>
</section>
<section id="services" class="services-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1>What can I do with Syncbook?</h1>
            </div>
        </div>
        <div class="row" style="text-align: left;">
            <div class="col-sm-6">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>
            <div class="col-sm-6">Random image of a syncing process.</div>
        </div>
    </div>
</section>
<section id="powered-by" class="powered-by-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="well">
                    <h1>PHP</h1>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="well">
                    <h1>CSS3 & Bootstrap</h1>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="well">
                    <h1>jQuery</h1>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="well">
                    <h1>Sabre</h1>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="about" class="about-section">
    <div class="container">
        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-3">
                <div class="card">
                    <canvas class="header-bg" width="250" height="70" id="header-blur"></canvas>
                    <div class="avatar">
                        <img src="" alt="" />
                    </div>
                    <div class="content">
                        <p>Web Developer <br>
                            More description here</p>
                        <p><button type="button" class="btn btn-default">Contact</button></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card">
                    <canvas class="header-bg" width="250" height="70" id="header-blur"></canvas>
                    <div class="avatar">
                        <img src="https://www.gravatar.com/avatar/8d669acbd39ba16bb05a92e2937b2c70.png" alt="" />
                    </div>
                    <div class="content">
                        <p>Web Developer <br>
                            More description here</p>
                        <p><button type="button" class="btn btn-default">Contact</button></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-3"></div>
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