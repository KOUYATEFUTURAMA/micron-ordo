
/* global angular */

try {
    var $validator = jQuery("#addForm").validate({
        lang: 'tr',
        highlight: function (formElement, label) {
            jQuery(label).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        success: function (label, formElement) {
            jQuery(label).closest('.form-group').removeClass('has-error');
            $(label).remove();
        }
    });
} catch (e) {
    // console.log("Erreur", e);
}


/**
 * Creation ou modification
 * 
 * @param string url Lien
 * @param object $formObject
 * @param string formData données serializées à envoyer
 * @param object $ajoutLoader
 * @param object $table L'objet bootstrap-table
 * @param boolean ajout determine si c'est un ajout ou une modification
 * @returns null
 */

function editAction(methode, url, $formObject, formData, $ajaxSpinner, $table, add = true) {
    jQuery.ajax({
        type: methode,
        url: url,
        cache: false,
        data: formData,
        success:function (response, textStatus, xhr){
            if (response.code === 1) {
                document.forms["addForm"].reset();
                if (add) { //creation
                    $table.bootstrapTable('refresh');
                } else { //Modification
                    $table.bootstrapTable('refresh');
                    $(".bs-modal-add").modal("hide");
                }

                $formObject.trigger('eventAdd', [response.data]);
                toastr.success(response.msg, "MEDYA KONTROL");
            }
            if (response.code === 0) {
                toastr.warning(response.msg, "MEDYA KONTROL");
            }
            if (response.code === -1) {
                toastr.error(response.msg, "MEDYA KONTROL");
            }
         },
        error: function (err) {
            var res = eval('('+err.responseText+')');
            toastr.error(res.message, "MEDYA KONTROL");
            $formObject.removeAttr("disabled");
            $ajaxSpinner.removeClass('spinner');
        },
        beforeSend: function () {
            $formObject.attr("disabled", true);
            $ajaxSpinner.addClass('spinner');
        },
        complete: function () {
            $ajaxSpinner.removeClass('spinner');
        },
    });
};

//Delet action
function deleteAction(url, formData, $ajaxLoader, $table) {
    jQuery.ajax({
        type: "DELETE",
        url: url,
        cache: false,
        data: formData,
        success: function (response) {
            if (response.code === 1) {
                $table.bootstrapTable('refresh');
                $(".bs-modal-delete").modal("hide");
               toastr.success(response.msg, "MEDYA KONTROL"); 
            }
            if (response.code === 0) {
                toastr.warning(response.msg, "MEDYA KONTROL");
            }
            if (response.code === -1) {
                toastr.error(response.msg, "MEDYA KONTROL");
            }
        },
        error: function (err) {
            var res = eval('('+err.responseText+')');
            toastr.error(res.message, "MEDYA KONTROL");
            $ajaxLoader.removeClass('spinner');
        },
        beforeSend: function () {
             $ajaxLoader.addClass('spinner');
        },
        complete: function () {
            $ajaxLoader.removeClass('spinner');
        }
    });
}