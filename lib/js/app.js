var URL = window.location.origin + "/Syncbook/src/huge/";

var loadContactList = function () {
    $('#contactListContainer').load(URL + "contact/displaycontactlist");
}

var addSuccessFeedback = function (data) {
    var type = "success";
    var feedback = "<div class=\"container fix-navbar\"><div class=\"alert alert-success alert-dismissible\" role=\"alert\" data-feedback=" + type + ">" +
        "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">" +
        "<span aria-hidden=\"true\">&times;</span>" +
        "</button><strong>" + data +
        "</strong></div></div>";

    $(feedback).insertBefore('#containerPage');
    setTimeout(function () {
        $('div[data-feedback]:last').remove();
    }, 5000);
}

var getFormFields = function () {
    var vCard = {};
    vCard['contactPrefix'] = $('#contactPrefix').prop('value');
    vCard['contactFirstName'] = $('#contactFirstName').prop('value');
    vCard['contactMiddleName'] = $('#contactMiddleName').prop('value');
    vCard['contactLastName'] = $('#contactLastName').prop('value');
    vCard['contactSuffix'] = $('#contactSuffix').prop('value');

    vCard['contactIsCompany'] = $('#contactIsCompany').prop('value');
    vCard['contactCompany'] = $('#contactCompany').prop('value');
    vCard['contactDepartment'] = $('#contactDepartment').prop('value');
    vCard['contactJobTitle'] = $('#contactJobTitle').prop('value');
    vCard['contactJobRole'] = $('#contactJobRole').prop('value');

    vCard['contactBirthDate'] = $('#contactBirthDate').prop('value');

    vCard['phoneType'] = $('#phoneType').prop('value');
    vCard['phoneValue'] = $('#phoneValue').prop('value');

    vCard['mailType'] = $('#mailType').prop('value');
    vCard['mailValue'] = $('#mailValue').prop('value');

    vCard['addressType'] = $('#addressType').prop('value');
    vCard['addressStreet'] = $('#addressStreet').prop('value');
    vCard['addressCity'] = $('#addressCity').prop('value');
    vCard['addressRegion'] = $('#addressRegion').prop('value');
    vCard['addressPostalCode'] = $('#addressPostalCode').prop('value');
    vCard['addressCountry'] = $('#addressCountry').prop('value');

    vCard['internetType'] = $('#internetType').prop('value');
    vCard['internetValue'] = $('#internetValue').prop('value');

    vCard['contactNotes'] = $('#contactNotes').prop('value');
    return vCard;
}

var inputControl = function (vCard) {
    if (vCard.contactFirstName.length == 0 || vCard.contactLastName.length == 0) {
        return 1;
    }

    if (vCard.addressCity.length != 0 ||
        vCard.addressCountry.length != 0 ||
        vCard.addressPostalCode.length != 0 ||
        vCard.addressRegion.length != 0 ||
        vCard.addressStreet.length != 0) {

        if (vCard.addressCity.length == 0 ||
            vCard.addressCountry.length == 0 ||
            vCard.addressPostalCode.length == 0 ||
            vCard.addressRegion.length == 0 ||
            vCard.addressStreet.length == 0) {

            return 2;
        }
    }

    return 0;
}

var displayContact = function (UID) {
    $.ajax({
        url : URL + 'contact/displaycontact',
        data : 'UID=' + UID,
        method : 'POST',
        dataType: 'html',
        success: function (data) {
            $('#mainContainer').html(data);
        }
    });
}

loadContactList();

$(document).ready(function() {

    // loading form for add contact action
    $(document).on('click', '#displayAddContactForm', function() {
        $('#mainContainer').load(URL + "contact/addcontact");
    });

    // display contact
    $(document).on('click', 'div[data-uid]', function() {
        displayContact($(this).attr('data-uid'));
    });

    // delete contact
    $(document).on('click', '#deleteVCard', function () {
        $.ajax({
            url : URL + 'contact/deletecontact',
            data : 'UID=' + $(this).attr('data-uid'),
            method : 'POST',
            dataType: 'html',
            success: function () {
                $('#mainContainer').html("");
                addSuccessFeedback("Contact deleted.");
                loadContactList();
            }
        });

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

    // edit action
    $(document).on('click', '#btn_save_changes', function () {
        var vCard = getFormFields();
        vCard['UID'] = $(this).attr('data-uid');

        var control = inputControl(vCard);
        switch(control) {
            case 0:
                $.ajax({
                    url : URL + 'contact/applychangestocontact',
                    data : vCard,
                    method : 'POST',
                    dataType: 'html',
                    success: function () {
                        $('#mainContainer').html("");
                        addSuccessFeedback("Contact modified.");
                        loadContactList();
                    }
                });
                break;

            case 1:
                alert("First name and last name fields are required!");
                break;

            case 2:
                alert("Complete all the address fields!");
                break;
        }
    });

    // add contact
    $(document).on('click', '#btn_save', function () {
        var vCard = getFormFields();

        var control = inputControl(vCard);
        switch(control) {
            case 0:
                $.ajax({
                    url : URL + 'contact/insertnewcontact',
                    data : vCard,
                    method : 'POST',
                    dataType: 'html',
                    success: function () {
                        loadContactList();
                        $('#mainContainer').html("");
                        //displayContact(vCard.UID);
                        addSuccessFeedback("Contact added.")
                    }
                });
                break;

            case 1:
                alert("First name and last name fields are required!");
                break;

            case 2:
                alert("Complete all the address fields!");
                break;
        }
    });

    $('input[data-focus]').focus();
});
