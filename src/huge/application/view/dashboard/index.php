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
                    <ul class="list-group" id="contactListContainer">
                        <?php ContactModel::getContactListForAddressBook() ?>
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

    //$('#contactListContainer').load(URL + "contact/displaycontactlist");

    $(document).ready(function() {

        $('#displayAddContactForm').click(function() {
            $('#mainContainer').load(URL + "contact/addcontact");
        });

        $('li[data-uid]').click(function() {
            $('#mainContainer').html($(this).attr('data-uid'));
        });
    });

</script>
