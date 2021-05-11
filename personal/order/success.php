<? require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php') ?>
<div class="order-success">
  <? if (isset($_GET['ORDER_ID'])): ?>
  <h1>Ваш заказ №<?=$_GET['ORDER_ID']?> успешно оформлен!</h1>
  <? else: ?>
  <h1>Ваш заказ успешно оформлен!</h1>
  <? endif; ?>
  <a href="/">Перейти на главную</a>
  <br><br>
  <a href="/cat/">Вернуться в каталог</a>
</div>
<? require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php') ?>
