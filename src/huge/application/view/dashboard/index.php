<div class="container" id="containerDashboard">
    <div class="row">
        <div class="container">
            <div class="panel">

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="panel panel-primary panel-no-margin-bottom">
                <div class="panel-heading">
                    <div class="float-left">
                        <h3 class="panel-title">Contacts</h3>
                    </div>
                    <div class="float-right">
                        <button class="btn btn-primary fa fa-plus-circle" id="displayAddContactForm"></button>
                    </div>
                    <div class="clear"></div>
                </div>
                <nav id="contactList">
                    <ul class="list-group" id="contactListContainer">
                        <?php ContactModel::getContactListForAddressBook(); ?>
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

<script src="../../../lib/js/app.js"></script>
