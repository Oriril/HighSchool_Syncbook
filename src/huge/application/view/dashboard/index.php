<div class="container">
    <div class="row">
        <div class="container">
            <div class="panel">
                <input type="submit" class="btn btn-primary" id="displayAddContactForm" value="Add contact">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Contacts</h3>
                </div>
                <nav id="contactList">
                    <ul class="list-group">
                        <li class="list-group-item" data-uid=":D">
                            <div class="col-xs-12 col-sm-3">
                                <img src="http://api.randomuser.me/portraits/men/97.jpg" alt="Seth Frazier" class="img-responsive img-circle" />
                            </div>
                            <div class="col-xs-12 col-sm-9">
                                <span class="name">Seth Frazier</span><br/>
                            </div>
                            <div class="clearfix"></div>
                        </li>
                        <li class="list-group-item" data-uid=":D">
                            <div class="col-xs-12 col-sm-3">
                                <img src="http://api.randomuser.me/portraits/women/90.jpg" alt="Jean Myers" class="img-responsive img-circle" />
                            </div>
                            <div class="col-xs-12 col-sm-9">
                                <span class="name">Jean Myers</span><br/>
                            </div>
                            <div class="clearfix"></div>
                        </li>
                        <li class="list-group-item" data-uid=":D">
                            <div class="col-xs-12 col-sm-3">
                                <img src="http://api.randomuser.me/portraits/men/24.jpg" alt="Todd Shelton" class="img-responsive img-circle" />
                            </div>
                            <div class="col-xs-12 col-sm-9">
                                <span class="name">Todd Shelton</span><br/>
                            </div>
                            <div class="clearfix"></div>
                        </li>
                        <li class="list-group-item" data-uid=":D">
                            <div class="col-xs-12 col-sm-3">
                                <img src="http://api.randomuser.me/portraits/women/34.jpg" alt="Rosemary Porter" class="img-responsive img-circle" />
                            </div>
                            <div class="col-xs-12 col-sm-9">
                                <span class="name">Rosemary Porter</span><br/>
                            </div>
                            <div class="clearfix"></div>
                        </li>
                        <li class="list-group-item" data-uid=":D">
                            <div class="col-xs-12 col-sm-3">
                                <img src="http://api.randomuser.me/portraits/women/56.jpg" alt="Debbie Schmidt" class="img-responsive img-circle" />
                            </div>
                            <div class="col-xs-12 col-sm-9">
                                <span class="name">Debbie Schmidt</span><br/>
                            </div>
                            <div class="clearfix"></div>
                        </li>
                        <li class="list-group-item" data-uid=":D">
                            <div class="col-xs-12 col-sm-3">
                                <img src="http://api.randomuser.me/portraits/women/76.jpg" alt="Glenda Patterson" class="img-responsive img-circle" />
                            </div>
                            <div class="col-xs-12 col-sm-9">
                                <span class="name">Glenda Patterson</span><br/>
                            </div>
                            <div class="clearfix"></div>
                        </li>
                    </ul>
                </nav>

            </div>
        </div>
        <div class="col-sm-8" id="mainContainer">
            <div class="panel panel-success">
                <div class="panel-heading">News</div>
                <div class="panel-body">
                    Panel content
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#displayAddContactForm').click(function() {
            $('#mainContainer').load("http://localhost/Syncbook/src/huge/contact/addcontact");
        });
        $('li[data-uid]').click(function() {
            $('#mainContainer').html($(this).attr('data-uid'));
        });
    });
</script>
