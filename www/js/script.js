'use strict';

function Datepicker(item) {
    var pickday,
        $item = $(item),
        $input = $item.find($item.data('input')),
        $inputContainer = $item.find($item.data('input-container')),
        $clear = $item.find($item.data('clear')),
        $trigger = $item.find($item.data('trigger')),
        timezone = $item.data('timezone');

    $item.find('label').on('click', function (e) {
        e.preventDefault();
    });

    $trigger.on('click', function () {
        $input.focus();
    });

    $clear.on('click', function () {
        $input[0].value = null;
        pickday.hide();
    });

    pickday = new Pikaday({
        field: $item.find('input')[0],
        format: 'DD/MM/YYYY',
        onSelect: function () {
            $inputContainer.removeClass('error');
        }
    });

    function validateDate(value) {
        if (value == '') {
            return true;
        }

        return value.search('/\d{1,2}\/\d{1,2}\/\d{4}/') !== -1 || !moment(value).isValid();
    }

    var timer;
    $input.on('keydown', function () {
        clearTimeout(timer);
        timer = setTimeout(function () {
            var date = $input.val();

            $inputContainer.removeClass('error');
            if (!validateDate(date)) {
                $inputContainer.addClass('error');
            } else {

            }
        }, 1000);
    })
}


$(function () {
    $('.js-datepicker').each(function () {
        new Datepicker(this);
    });
});
