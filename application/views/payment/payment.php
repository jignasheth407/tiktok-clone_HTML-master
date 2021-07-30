<style>
.loader {
  position: absolute;
  left: 50%;
  top: 50%;
  z-index: 1;
  width: 150px;
  height: 150px;
  margin: -75px 0 0 -75px;
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
.sud{
  visibility: hidden;
}
</style>
<div class="loader"></div>
<div class="sud">
<form id="redirectForm" class="" action="https://www.coinpayments.net/index.php" method="post">
                            <input type="hidden" name="cmd" value="_pay">
                            <input type="hidden" name="reset" value="1">
                            <input type="hidden" name="merchant" value="6f917dce75037fd3c022f9722da11aa9">
                            <input type="hidden" name="item_name" value="Wedo Entertainment">
                            <input type="hidden" name="item_number" value="0">
                            <input type="hidden" name="currency" value="USD">
                            <input type="hidden" name="amountf" value="<?= $value ?>">
                            <input type="hidden" name="quantity" value="1">
                            <input type="hidden" name="allow_quantity" value="0">
                            <input type="hidden" name="want_shipping" value="0">
                            <input type="hidden" name="custom" value="<?= $userid ?>">
                            <input type="hidden" name="success_url" value="<?= site_url('paypal') ?>/payment_successurl">
                            <input type="hidden" name="cancel_url" value="<?= site_url('paypal') ?>/payment_cancelurl">
                            <input type="hidden" name="ipn_url" value="<?= site_url('paypal') ?>/checkcallback">
                            <input type="hidden" name="allow_extra" value="0">
                            <input type="text"  name="total_usd" value="100" class="form-control" placeholder="Total Price in USD" id="total_p">
                            <button type="submit" class="btn-gradient-secondary" style="width:100%">Buy now</button>
</form>

</div>

<script>document.getElementById("redirectForm").submit();</script>
