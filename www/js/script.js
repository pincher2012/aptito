'use strict';

function Datepicker(item, callback) {
    var pickday,
        $item = $(item),
        $input = $item.find($item.data('input')),
        $inputContainer = $item.find($item.data('input-container')),
        $clear = $item.find($item.data('clear')),
        $trigger = $item.find($item.data('trigger'));

    $item.find('label').on('click', function (e) {
        e.preventDefault();
    });

    $trigger.on('click', function () {
        $input.focus();
    });

    $clear.on('click', function () {
        $input[0].value = null;
        pickday.hide();
        callback();
    });

    pickday = new Pikaday({
        field: $item.find('input')[0],
        format: 'DD/MM/YYYY',
        onSelect: function () {
            $inputContainer.removeClass('error');
            callback();
        }
    });

    function validateDate(value) {
        if (value == '') {
            return true;
        }

        return value.search(/^\d{1,2}\/\d{1,2}\/\d{4}$/) !== -1 && moment(value, 'DD/MM/YYYY').isValid();
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
                callback();
            }
        }, 1000);
    })
}

function OrdersTable(item) {
    var self = this,
        $item = $(item),
        $dataContainer = $item.find($item.data('container')),
        $totalContainer = $item.find($item.data('total')),
        timezone = $item.data('timezone'),
        requestData = {};

    self.update = function () {
        var dateFrom = $('input[name=date_from]').val(),
            dateTo = $('input[name=date_to]').val(),
            day,
            month,
            year;

        if (dateFrom) {
            [day, month, year] = dateFrom.split('/');
            requestData['dateFrom'] = moment.tz([year, month, day], timezone).unix();
        }

        if (dateTo) {
            [day, month, year] = dateTo.split('/');
            requestData['dateTo'] = moment.tz([year, month, day + 1, 0, 0, -1], 'Europe/Berlin').unix();
        }

        $.ajax({
            url: '/api',
            data: requestData,
            success: function (response) {
                if (response.status === 'success') {
                    $dataContainer.html('');
                    response.data.orders.forEach(function (el) {
                        $dataContainer.append(renderRow(el));
                    });

                    $totalContainer.html(renderTotal(response.data.total));
                } else {
                    console.log('Здесь должен быть код обработки ошибки');
                }
            },
            error: function () {
                console.log('Здесь должен быть код обработки ошибки');
            }
        })
        ;
    };

    function formatMoney(n) {
        return '$&nbsp;' + parseInt(n).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
    }

    function renderRow(row) {
        return $('<tr class="b-orders__row">')
            .append(renderCell(row.name, false, false, false))
            .append(renderCell(row.qty, false, false, false))
            .append(renderCell(row.price, false, true, false))
            .append(renderCell(row.tax, false, true, true))
            .append(renderCell(row.net, true, true, false));
    }

    function renderTotal(row) {
        return $('<tr class="b-orders__row">')
            .append(renderCell('All orders &mdash; ' + row.count, true, false, false))
            .append(renderCell(row.qty, true, false, false))
            .append(renderCell(row.price, true, true, false))
            .append(renderCell(row.tax, true, true, true))
            .append(renderCell(row.net, true, true, false));
    }

    function renderCell(cell, isLast, isMoney, isTax) {
        var $result = $('<td class="b-orders__cell">'),
            content = cell;

        if (isMoney) {
            $result.addClass('b-orders__cell_money');
            content = formatMoney(content);
            if (isTax) {
                $result.addClass('b-orders__cell_tax-not-null');
                if (cell > 0) {
                    content = '-' + content;
                }
            }
        }

        if (isLast) {
            $result.addClass('b-orders__cell_last');
        }

        return $result.html(content);
    }
}

$(function () {
    var orders = new OrdersTable($('.js-orders')[0]);

    $('.js-datepicker').each(function () {
        new Datepicker(this, orders.update);
    });
});
