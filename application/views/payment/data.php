<html>
    <head><title>Test</title></head>
    <body>
        <form method="post" action="<?= site_url('paypal/getcoinpaymentpostdata');?>">
            <input  type="text" name="user_id">
            <input type="text" name="price">
            <input type="submit" value="save">
        </form>
    </body>
</html>