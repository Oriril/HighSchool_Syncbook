<div class="container containerPage" id="containerPage">
    <div class="row">
        <div class="col-sm-4">
            <div class="panel panel-warning panel-no-margin-bottom">
                <div class="panel-heading">
                    <div class="float-left">
                        <h3 class="panel-title">Contacts</h3>
                    </div>
                    <!--<div class="float-right">

                        <button class="btn btn-fab btn-raised btn-default btn-xs" id="displayAddContactForm"><i class="mdi-content-add-circle"></i></button>
                    </div>-->
                    <div class="clear"></div>
                </div>
                <nav id="contactList">
                    <div class="list-group" id="contactListContainer">
                        <?php ContactModel::getContactListForAddressBook(); ?>
                    </div>
                </nav>

            </div>
        </div>
        <div class="col-sm-8" id="mainContainer">
            <div class="panel panel-danger">
                <div class="panel-heading">News</div>
                <div class="panel-body">
                    Panel content
                </div>
            </div>
        </div>
    </div>
</div>



