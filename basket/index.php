<?php require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php') ?>

<?$APPLICATION->IncludeComponent(
  "bxs:sale.basket.basket",
  "",
  array()
)?>

<script type="text/javascript">
  $(function() {
    $.ajax({
      url: '/cat/cart.php',
      type: 'POST',
      dataType: 'json',
      data: {
        'METHOD': 'getChart',
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

<?php require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php') ?>
