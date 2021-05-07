<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die(); ?>
<div class="catalog">
  <input type="hidden" name="PRODUCT_ID" value="<?=$arResult['ID']?>">
  <img src="<?= $arResult['PREVIEW_PICTURE'] ?>" alt="">
  <div class="">
    <span>Цена: <?= $arResult['PRICE_FORMATTED'] ?></span>
    <br>
    <input type="number" name="QTY" value="1">
    <button id="add2Cart">Добавить в корзину</button>
  </div>
</div>

<script type="text/javascript">
  $('#add2Cart').on('click', function() {
    let productId = $('input[name=PRODUCT_ID]').val(),
        qty = $('input[name=QTY]').val()

    $.ajax({
      url: '/cat/cart.php',
      type: 'POST',
      dataType: 'json',
      data: {
        'METHOD': 'add',
        'PRODUCT_ID': productId,
        'QTY': qty
      },
      success(response, status, jqXHR) {
        console.log(response);
      },
      error(jqXHR, status, error) {
        console.error(status);
      }
    });
  });

</script>

<hr><br><br><br>
<pre>
  <?php print_r($arResult) ?>
</pre>
