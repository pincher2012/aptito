<?php
/**
 * @var $orders array
 */
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="/css/style.css">
    <title>Aptito</title>
</head>
<body>
<div class="b-content">
    <header class="b-header">
        <h1 class="b-title">By menu items</h1>
        <div class="b-filter">
            <div class="b-filter-date">
                <span>Date from</span>
                <div class="b-filter-date__input">
                    <input name="date_from" type="text">
                    <div class="b-filter-date__clear"></div>
                </div>
                <div class="b-filter-date__calendar"></div>
            </div>
            <div class="b-filter-date">
                <span>Date to</span>
                <div class="b-filter-date__input">
                    <input name="date_to" type="text">
                    <div class="b-filter-date__clear"></div>
                </div>
                <div class="b-filter-date__calendar"></div>
            </div>
        </div>
    </header>
    <div class="b-warning">
        <i>!</i>
        <span>
            Final amounts affected by price modifications including voids,
            discounts and tax exempt as well as surcharges and gratuity.
        </span>
    </div>
    <table class="b-orders">
        <thead>
        <tr class="b-orders__header">
            <th class="b-orders__header-cell b-orders__header-cell_first"><div>Item</div></th>
            <th class="b-orders__header-cell"><div>Amount</div></th>
            <th class="b-orders__header-cell b-orders__header-cell_money"><div>Gross Sales</div></th>
            <th class="b-orders__header-cell b-orders__header-cell_money"><div>Tax</div></th>
            <th class="b-orders__header-cell b-orders__header-cell_money b-orders__header-cell_last"><div>Net Sales</div></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($orders as $order): ?>
            <tr class="b-orders__row">
                <td><?php echo $order['name'] ?></td>
                <td><?php echo $order['qty'] ?></td>
                <td class="b-orders__cell b-orders__cell_money">$ <?php echo number_format($order['price'], 2) ?></td>
                <?php if ($order['tax'] > 0): ?>
                    <td class="b-orders__cell b-orders__cell_money b-orders__cell_tax-not-null">-$ <?php echo number_format($order['tax'], 2) ?></td>
                <?php else: ?>
                    <td class="b-orders__cell b-orders__cell_money">$ <?php echo number_format($order['tax'], 2) ?></td>
                <?php endif ?>
                <td class="b-orders__cell b-orders__cell_money b-orders__cell_last">$ <?php echo number_format($order['net'], 2) ?></td>
            </tr>
        <?php endforeach ?>
        </tbody>
        <tfoot>
            <tr class="b-orders__row">
                <td class="b-orders__cell b-orders__cell_last">All orders &mdash; <?php echo $total['count'] ?></td>
                <td class="b-orders__cell b-orders__cell_last"><?php echo $total['qty'] ?></td>
                <td class="b-orders__cell b-orders__cell_money b-orders__cell_last">$ <?php echo $total['price'] ?></td>
                <?php if ($total['tax'] > 0): ?>
                    <td class="b-orders__cell b-orders__cell_money b-orders__cell_tax-not-null b-orders__cell_last">-$ <?php echo number_format($total['tax'], 2) ?></td>
                <?php else: ?>
                    <td class="b-orders__cell b-orders__cell_money b-orders__cell_last">$ <?php echo number_format($total['tax'], 2) ?></td>
                <?php endif ?>
                <td class="b-orders__cell b-orders__cell_money b-orders__cell_last">$ <?php echo number_format($total['net'], 2) ?></td>
            </tr>
        </tfoot>
        <script src="/js/script.js"></script>
    </table>
</div>
</body>
</html>
