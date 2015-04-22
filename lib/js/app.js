var URL = "http://localhost/Syncbook/src/huge/";

var loadContactList = function () {
    $('#contactListContainer').load(URL + "contact/displaycontactlist");
}

var addSuccessFeedback = function (data) {
    var feedback = "<div class=\"alert alert-success alert-dismissible\" role=\"alert\">" +
    "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">" +
    "<span aria-hidden=\"true\">&times;</span>" +
    "</button>" + data +
    "</div>";
    $(feedback).insertBefore('#containerDashboard');
}

loadContactList();

$(document).ready(function() {

    // loading form for add contact action
    $(document).on('click', '#displayAddContactForm', function() {
        $('#mainContainer').load(URL + "contact/addcontact");
    });

    // display contact
    $(document).on('click', 'li[data-uid]', function() {
        //$('#mainContainer').html($(this).attr('data-uid'));
        $.ajax({
            url : URL + 'contact/displaycontact',
            data : 'UID=' + $(this).attr('data-uid'),
            method : 'POST',
            dataType: 'html',
            success: function (data) {
                $('#mainContainer').html(data);
            }
        });
    });

    // delete contact
    $(document).on('click', '#deleteVCard', function () {
        $.ajax({
            url : URL + 'contact/deletecontact',
            data : 'UID=' + $(this).attr('data-uid'),
            method : 'POST',
            dataType: 'html',
            success: function (data) {
                $('#mainContainer').html("<div></div>");
                addSuccessFeedback("Contact deleted.");
            }
        });
        loadContactList();
    });

    // edit contact request
    $(document).on('click', '#editVCard', function () {
        $.ajax({
            url : URL + 'contact/loadeditform',
            data : 'UID=' + $(this).attr('data-uid'),
            method : 'POST',
            dataType: 'html',
            success: function (data) {
                $('#mainContainer').html(data);
            }
        });
    });

    // add contact
    /*$(document).on('click', '#btn_save', function () {
        var card = {};
        card['contactPrefix'] = $('#contactPrefix').prop('value');
        card['contactFirstName'] = $('#contactFirstName').prop('value');
        card['contactMiddleName'] = $('#contactMiddleName').prop('value');
        card['contactLastName'] = $('#contactLastName').prop('value');
        card['contactSuffix'] = $('#contactSuffix').prop('value');
        card['contactIsCompany'] = $('#contactIsCompany').prop('value');
        card['contactCompany'] = $('#contactCompany').prop('value');
        card['contactDepartment'] = $('#contactDepartment').prop('value');
        card['contactJobTitle'] = $('#contactJobTitle').prop('value');
        card['contactJobRole'] = $('#contactJobRole').prop('value');
        card['contactBirthDate'] = $('#contactBirthDate').prop('value');
        card['phoneValue'] = $('#phoneValue').prop('value');
        card['mailValue'] = $('#mailValue').prop('value');
        card['addressStreet'] = $('#addressStreet').prop('value');
        card['addressCity'] = $('#addressCity').prop('value');
        card['addressRegion'] = $('#addressRegion').prop('value');
        card['addressPostalCode'] = $('#addressPostalCode').prop('value');
        card['addressCountry'] = $('#addressCountry').prop('value');
    });*/
});
