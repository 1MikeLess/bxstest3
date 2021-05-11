<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<style media="screen">
  .input-group {
    margin-bottom: 12px;
  }
  .order-submit {
    margin-top: 20px;
  }
</style>
<div class="order-make">
  <div class="order-items">
    <form id="order-form" class="form">
      <h4>Список товаров</h4>
      <table border="1">
        <thead>
          <tr>
            <th></th>
            <th>Название</th>
            <th>Цена</th>
            <th>Кол-во</th>
            <th>Всего</th>
          </tr>
        </thead>
        <tbody>
          <? foreach ($arResult['ITEMS'] as $arItem): ?>
          <tr data-product-id="<?=$arItem['ID']?>">
            <input type="hidden" name="PRODUCT_ID" value="<?=$arItem['ID']?>">
            <td><img height="70" width="70" src="<?=$arItem["PREVIEW_PICTURE"]?>" alt=""></td>
            <td width="225"><?=$arItem['NAME']?></td>
            <td><?=$arItem['PRICE_FORMATTED']?></td>
            <td><?=$arItem['QTY']?></td>
            <td><?=$arItem['TOTAL_FORMATTED']?></td>
          </tr>
          <? endforeach; ?>
          <tr>
            <td colspan="4" style="text-align:right">Итого:</td>
            <td><?=$arResult['TOTAL_FORMATTED']?></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="order-fields">
      <h4>Параметры заказа</h4>
        <div class="input-group">
          <label for="order_phone">Телефон:</label><br>
          <input id="order_phone" type="phone" name="PHONE" value="" placeholder="+7 (800) 55-55-55">
        </div>
        <div class="input-group">
          <label for="order_email">EMAIL:</label><br>
          <input id="order_email" type="email" name="EMAIL" value="" placeholder="example@google.com">
        </div>
    </div>
    <div class="order-submit">
      <input type="submit" value="Оформить заказ">
    </div>
  </form>

</div>

<script type="text/javascript">
  $('#order-form').on('submit', function(e) {
    e.preventDefault();

    let email = $('input[name=EMAIL]').val(),
        phone = $('input[name=PHONE]').val();
    email = encodeURI(email);
    phone = encodeURI(phone);

    // window.location = '/personal/order/submit.php?EMAIL='+email+'&PHONE_NUM='+phone;
    window.location = '<?=$arResult['SUBMIT_PAGE_URL']?>&EMAIL='+email+'&PHONE_NUM='+phone;
  });

  $(function() {
    // $.ajax({
    //   url: '/cat/cart.php',
    //   type: 'POST',
    //   dataType: 'json',
    //   data: {
    //     'METHOD': 'getChart',
    //   },
    //   success(response, status, jqXHR) {
    //     console.log(response);
    //   },
    //   error(jqXHR, status, error) {
    //     console.error(status);
    //   }
    // });
  });
</script>
