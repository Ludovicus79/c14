$(document).ready(init);

/**
 * Carga el select con las familias
 */
function init() {
    showLoading();
    $.getJSON("", {_: new Date().getTime()}).done(function(jsonData) {
        $('#family').empty();
        $('#family').append('<option value="">- - -</option>');
        $.each(jsonData, function(i, data) {
            for(var j = 0; j < data.length; j++) {
                if(data[j].family)
                    $('#family').append(
                        $('<option></option>', {
                            'value' : data[j].family,
                            'text' : data[j].family,
                        })
                    )
            }
        })
        stopLoading();
    });

    $('#family').change(loadSubFamily);

    $('#subFamily').prop('disabled', true);
    $('#subFamily').change(loadSubSubFamily);

    $('#subSubFamily').prop('disabled', true);
}

/**
 * Carga las subfamilias
 */
function loadSubFamily() {
    showLoading();
    $.getJSON("", {'family': $(this).val(), _: new Date().getTime()}).done(function(jsonData) {
        $('#subFamily').empty();
        $('#subFamily').append('<option value="">- - -</option>');
        $('#subSubFamily').empty();
        $('#subSubFamily').append('<option value="">- - -</option>');
        $.each(jsonData, function(i, data) {
            for(var j = 0; j < data.length; j++) {
                if(data[j].subFamily)
                    $('#subFamily').append(
                        $('<option></option>', {
                            'value' : data[j].subFamily,
                            'text' : data[j].subFamily,
                        })
                    )
            }
        })
        stopLoading();
        if($('#family').val() == '') {
            $('#subFamily').prop('disabled', true);
            $('#subSubFamily').prop('disabled', true);
        }
        else
            $('#subFamily').prop('disabled', false);
    });
}

/**
 * Carga las subSubFamilias
 */
function loadSubSubFamily() {
    showLoading();
    $.getJSON("", {'subFamily': $(this).val(), 'family': $('#family').val(), _: new Date().getTime()}).done(function(jsonData) {
        $('#subSubFamily').empty();
        $('#subSubFamily').append('<option value="">- - -</option>');
        $.each(jsonData, function(i, data) {
            for(var j = 0; j < data.length; j++) {
                if(data[j].subSubFamily)
                    $('#subSubFamily').append(
                        $('<option></option>', {
                            'value' : data[j].subSubFamily,
                            'text' : data[j].subSubFamily,
                        })
                    )
            }
        })
        stopLoading();
        if($('#subFamily').val() == '')
            $('#subSubFamily').prop('disabled', true);
        else
            $('#subSubFamily').prop('disabled', false);
    });
}