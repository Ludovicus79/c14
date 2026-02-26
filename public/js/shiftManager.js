function updateByShift(field) {
    shiftField = $(field).parent().siblings().andSelf().find('.shiftInput');
    shiftValue = shiftField.val().trim();
    toleranceField = $(field).parent().siblings().andSelf().find('.toleranceInput');
    toleranceValue = toleranceField.val().trim();

    minField = $(field).parent().siblings().find('.minInput');
    maxField = $(field).parent().siblings().find('.maxInput');

    if (!isNaN(shiftValue) && !isNaN(toleranceValue) && shiftValue != "" && toleranceValue != "") {
        minField.val(parseFloat(shiftValue) - parseFloat(toleranceValue));
        maxField.val(parseFloat(shiftValue) + parseFloat(toleranceValue));
    }
}

function updateByMinMax(field) {
    minField = $(field).parent().siblings().andSelf().find('.minInput');
    minValue = minField.val().trim();
    maxField = $(field).parent().siblings().andSelf().find('.maxInput');
    maxValue = maxField.val().trim();

    shiftField = $(field).parent().siblings().find('.shiftInput');
    toleranceField = $(field).parent().siblings().find('.toleranceInput');

    if (!isNaN(minValue) && !isNaN(maxValue) && minValue != "" && maxValue != "") {
        shiftField.val(parseFloat(maxValue) - (parseFloat(maxValue) - parseFloat(minValue)) / 2);
        toleranceField.val((parseFloat(maxValue) - parseFloat(minValue)) / 2);
    }
}

function switchTolerance() {
    $('#shiftsContainer h4').not('#typeLabel').toggle();
    $('#shiftsContainer input').parent().toggle();
}

function createShift() {
    var index = $('.shift').length;
    var lastValue = $('.shift').last().find('.toleranceInput').val();
    newShift = $('.shift').first().clone();
    newShift.find('input').val("")
    newShift.find('.minInput').attr('name', 'shiftsArray[' + index + '][shiftMin]');
    newShift.find('.maxInput').attr('name', 'shiftsArray[' + index + '][shiftMax]');
    newShift.find('.typeInput').attr('name', 'shiftsArray[' + index + '][carbonType]').val("C");
    newShift.find('.toleranceInput').attr('name', 'shiftsArray[' + index + '][tolerance]');
    newShift.find('.toleranceInput').val(lastValue);
    newShift.appendTo('#shiftsContainer');

    var options = "<option value='1'>" + alltranslation + "</option>";
    options += "<option value='" + index + "'>" + allminustranslation + "</option>";
    // for (var i = 0; i < index; i++) {
    //     options += "<option value='" + (i+1) + "'>" + allminustranslation + " " + (i+1) + "</option>";
    // }
    $("#minCarbons").find('option').remove().end().append(options);
}

function deleteShift() {
    var index = $('.shift').length;

    if (index > 1) {
        $('.shift').last().remove();

        index = $('.shift').length;
        var options = "<option value='1'>" + alltranslation + "</option>";
        options += "<option value='" + index + "'>" + allminustranslation + "</option>";
        // for (var i = 0; i < (index - 1); i++) {
        //     options += "<option value='" + (i+1) + "'>" + allminustranslation + " " + (i+1) + "</option>";
        // }
        $("#minCarbons").find('option').remove().end().append(options);
    }

}
