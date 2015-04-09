<div class="container">
    <div class="row">
        <div class="col-sm-2">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Actions</h3>
                </div>
                <div class="panel-body">
                    <ul class="list-group">
                        <div class="list-group-item " id="displayAddContactForm">
                            <div class="list-group-item-heading"><strong>Add contact</strong></div>
                        </div>
                        <div class="list-group-item ">
                            <div class="list-group-item-heading"><strong>Contacts</strong></div>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-sm-10" id="mainContainer">
            <div class="panel panel-info">
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

    });
</script>
