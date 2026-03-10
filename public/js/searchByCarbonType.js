$(document).ready(function() {

    var carbonLabels = {
        'Cs' : 'C*',
        'CHs' : 'CH*',
        'CH2s' : 'CH<sub>2</sub>*',
        'CH3s' : 'CH<sub>3</sub>*',
        'COs' : 'C-O*',
        'CHOs' : 'CH-O*',
        'CH2Os' : 'CH<sub>2</sub>-O*',
        'CH3Os' : 'CH<sub>3</sub>-O*',
        'CNs' : 'C-N*',
        'CHNs' : 'CH-N*',
        'CH2Ns' : 'CH<sub>2</sub>-N*',
        'CH3Ns' : 'CH<sub>3</sub>-N*',
        'C' : 'C',
        'CH' : 'CH',
        'CH2' : 'CH<sub>2</sub>',
        'CH3' : 'CH<sub>3</sub>',
        'CO' : 'C-O',
        'CHO' : 'CH-O',
        'CH2O' : 'CH<sub>2</sub>-O',
        'CH3O' : 'CH<sub>3</sub>-O',
        'CN' : 'C-N',
        'CHN' : 'CH-N',
        'CH2N' : 'CH<sub>2</sub>-N',
        'CH3N' : 'CH<sub>3</sub>-N',
        'O' : 'O',
        'N' : 'N',
        'H' : 'H',
        'F' : 'F',
        'Cl' : 'Cl',
        'Br' : 'Br',
        'I' : 'I',
        'P' : 'P',
        'S' : 'S',
        'CTali' : 'CT ali',
        'CTaro' : 'CT aro',
        'CTole' : 'CT ole',
        'Csp2' : 'Csp<sup>2</sup>',
        'Cali' : 'C ali',
        'CHali' : 'CH ali',
        'CH2ali' : 'CH<sub>2</sub> ali',
        'COali' : 'C-O ali',
        'CHOali' : 'CH-O ali',
        'CNali' : 'C-N ali',
        'CHNali' : 'CH-N ali',
        'Caro' : 'C aro',
        'CHaro' : 'CH aro',
        'COaro' : 'C-O aro',
        'CHOaro' : 'CH-O aro',
        'CNaro' : 'C-N aro',
        'CHNaro' : 'CH-N aro',
        'Cole' : 'C ole',
        'CHole' : 'CH ole',
        'CH2ole' : 'CH<sub>2</sub> ole',
        'CCarbonil' : 'C=O',
    };

    var formulario = $('#sliderForm');

    $('input[type=checkbox]').change(function() {
        if($(this).is(':checked')) {
            newSlider($(this).val());
        }
        else {
            removeSlider($(this).val())
        }
    })

    $('#btnSearch').click(submitForm);

    init();

    /**
     * Muestra unos sliders por defecto
     */
    function init() {
        var checkbox = $('#menu3 input[type=checkbox]');
        $('#menu3 input[type=checkbox]').prop('checked', true);
        for(var i = 0; i < checkbox.length; i++){
            newSlider(checkbox[i].value);
        }
    }
    /**
     * Crea un nuevo slider
     * @param value
     */
    function newSlider(value) {
        formulario.append($('<div>', {
            id: 'sliderContainer' + value,
            label: value,
            class: 'sliderContainer col-md-1 col-md-offset-0 col-sm-1 col-sm-offset-0 col-xs-12 text-center',
            style: 'margin-top: 25px;',
        }).append($('<div>', {
            id: 'slider' + value,
            class: 'slider hidden-xs',
        })));


        $('#sliderContainer' + value).append($('<div>', {
            id: 'slider-xs' + value,
            class: 'slider-xs visible-xs-block',
        }));
        $('#sliderContainer' + value).append('<span class="text-center"><strong>'+ carbonLabels[value] + '</strong><br>');
        $('#sliderContainer' + value).append('<button type="button" class="btn-xs btn-danger">X</button>');

        $('#sliderContainer' + value + ' button').click(function() {
            $('input[type=checkbox][value='+value+']').prop('checked', false);
            $('#sliderContainer' + value).remove();
        });

        //Creamos el slider
        var slider = document.getElementById('slider' + value);
        var slider_xs = document.getElementById('slider-xs' + value);

        noUiSlider.create(slider, {
            start: [ 0, 10 ], // Handle start position
            margin: 0, // Handles must be more than '1' apart
            tooltips: true,
            connect: true, // Display a colored bar between the handles
            direction: 'rtl', // Put '0' at the bottom of the slider
            orientation: 'vertical', // Orient the slider vertically
            behaviour: 'tap-drag', // Move handle on tap, bar is draggable
            range: { // Slider can select '0' to '100'
                'min': 0,
                'max': 30
            },
            format: {
                to: function ( value ) {
                    return parseInt(value);
                },
                from: function ( value ) {
                    return parseInt(value);
                }
            }
        });
        noUiSlider.create(slider_xs, {
            start: [ 0, 10 ], // Handle start position
            margin: 0, // Handles must be more than '1' apart
            tooltips: true,
            connect: true, // Display a colored bar between the handles
            direction: 'ltr', // Put '0' at the bottom of the slider
            orientation: 'horizontal', // Orient the slider vertically
            behaviour: 'tap-drag', // Move handle on tap, bar is draggable
            range: { // Slider can select '0' to '100'
                'min': 0,
                'max': 30
            },
            format: {
                to: function ( value ) {
                    return parseInt(value);
                },
                from: function ( value ) {
                    return parseInt(value);
                }
            }
        });

        var initialVal = slider.noUiSlider.get();

        $('#sliderContainer' + value).append('<input type="hidden" class="input-value" id="input-value-'+value+'" label="'+value+'" min="'+initialVal[0]+'" max="'+initialVal[1]+'">');

        var input = document.getElementById('input-value-' + value);

        // When the slider value changes, update the input and span
        slider.noUiSlider.on('slide', function( values, handle ) {
            input.setAttribute('min', values[0]);
            input.setAttribute('max', values[1]);
            slider_xs.noUiSlider.set([values[0], values[1]]);
        });

        slider_xs.noUiSlider.on('slide', function( values, handle ) {
            input.setAttribute('min', values[0]);
            input.setAttribute('max', values[1]);
            slider.noUiSlider.set([values[0], values[1]]);
        });
    }

    /**
     * Elimina un slider
     * @param value
     */
    function removeSlider(value) {
        var slider = document.getElementById('sliderContainer' + value);
        slider.remove();
    }

    /**
     * Envia el formulario
     */
    function submitForm() {
        var inputs = document.getElementsByClassName('input-value');
        for (var i = 0; i < inputs.length; i++) {
            $('<input>').attr({
                type: 'hidden',
                name: 'range[' + i + '][max]',
                value: inputs[i].getAttribute('max'),
            }).appendTo('#queryForm');
            $('<input>').attr({
                type: 'hidden',
                name: 'range[' + i + '][min]',
                value: inputs[i].getAttribute('min'),
            }).appendTo('#queryForm');
            $('<input>').attr({
                type: 'hidden',
                name: 'range[' + i + '][label]',
                value: inputs[i].getAttribute('label'),
            }).appendTo('#queryForm');
        }
        $('#queryForm').submit();
    }
})