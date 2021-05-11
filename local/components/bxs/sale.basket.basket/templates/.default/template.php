<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
  $this->addExternalCss(__DIR__."/styles.css");
?>
<div class="basket">
  <? if (!empty($arResult['ITEMS'] )): ?>
    <table border="1">
      <thead>
        <tr>
          <th></th>
          <th>Название</th>
          <th>Цена</th>
          <th>Удалить</th>
          <th>Кол-во</th>
        </tr>
      </thead>
      <tbody>
        <? foreach ($arResult['ITEMS'] as $arItem): ?>
        <tr data-product-id="<?=$arItem['ID']?>">
          <input type="hidden" name="PRODUCT_ID" value="<?=$arItem['ID']?>">
          <td><img height="70" width="70" src="<?=$arItem["PREVIEW_PICTURE"]?>" alt=""></td>
          <td width="225"><?=$arItem['NAME']?></td>
          <td><?=$arItem['PRICE_FORMATTED']?></td>
          <td><button class="remove-product" type="button" value="<?=$arItem['ID']?>">&times;</button></td>
          <td><input onchange="qtyOnChange(this, <?=$arItem['ID']?>)" type="number" name="QTY" value="<?=$arItem['QTY']?>"></td>
        </tr>
        <? endforeach; ?>
      </tbody>
    </table>
    <div class="basket__make-order">
      <a href="#">Оформить заказ</a>
    </div>
  <? else: ?>
  <h4>Корзина пуста</h4>
  <? endif; ?>

  <!-- <pre>
    <?php print_r($arResult) ?>
  </pre> -->
</div>

<script type="text/javascript">
  function removeProduct(id) {
    let result = new Promise((resolve, reject) => {
      $.ajax({
        url: '/cat/cart.php',
        type: 'POST',
        dataType: 'json',
        data: {
          'METHOD': 'remove',
          'PRODUCT_ID': id,
        },
        success(response, status, jqXHR) {
          console.log(response);

          resolve('OK');
        },
        error(jqXHR, status, error) {
          console.error(status);

          reject();
        }
      });
    });

    return result;
  }

  function qtyOnChange(obj, id) {
    let qty = $(obj).val();

    changeProductQty(id, qty);
  }

  function changeProductQty(id, qty) {
    let result = new Promise((resolve, reject) => {
      $.ajax({
        url: '/cat/cart.php',
        type: 'POST',
        dataType: 'json',
        data: {
          'METHOD': 'edit',
          'QTY': qty,
          'PRODUCT_ID': id,
        },
        success(response, status, jqXHR) {
          console.log(response);

          resolve({
            product_id: response['PRODUCT_ID'],
            qty: response['QTY']
          });
        },
        error(jqXHR, status, error) {
          console.error(status);

          reject();
        }
      });
    });

    return result;
  }

  $(function() {
    $('[data-product-id] .remove-product').on('click', function() {
      if (confirm('Удалить выбранный продукт из корзины?')) {
        let productId = $(this).val();
        let result = removeProduct(productId);

        result.then(function() {
          $('[data-product-id='+productId+']').remove();
        });
      }
    });
  });
</script>
