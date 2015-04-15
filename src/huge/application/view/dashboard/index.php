<div class="container">
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
<script>
    var URL = "http://localhost/Syncbook/src/huge/";

    $('#contactListContainer').load(URL + "contact/displaycontactlist");

    $(document).ready(function() {

        $(document).on('click', '#displayAddContactForm', function() {
            $('#mainContainer').load(URL + "contact/addcontact");
        });

        $(document).on('click', 'li[data-uid]', function() {
            $('#mainContainer').html($(this).attr('data-uid'));
        });
    });

</script>
