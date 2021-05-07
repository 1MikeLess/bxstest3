<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die(); ?>
<style media="screen">
  .catalog-el {
    border-bottom: 2px solid #333;
  }
</style>
<div class="catalog">
  <? foreach ($arResult['ELEMENTS'] as $arItem): ?>
    <div class="catalog-el"  data-product-id="<?= $arItem['ID'] ?>">
      <h3><a href="<?=$arItem['DETAIL_PAGE_URL']?>"><?= $arItem['NAME'] ?></a></h3>
      <div class="catalog-content clearfix">
        <div class="push-left">
          <img src="<?= $arItem['PREVIEW_PICTURE'] ?>" alt="">
        </div>
        <div class="push-right">
          <span>Цена: <?= $arItem['PRICE_FORMATTED'] ?></span>
          <br>
          <input type="number" name="qty" value="1">
          <button name="product_buy" onclick="add2Cart(<?=$arItem['ID']?>)">Добавить в корзину</button>
        </div>
      </div>
    </div>
  <? endforeach; ?>
</div>

<script type="text/javascript">
  function add2Cart(productId) {
    let qty = $('[data-product-id='+productId+'] input[name=qty]').val();


  }
</script>

<hr><br><br><br>
<pre>

  <?php print_r($arResult['ELEMENTS']) ?>

</pre>
