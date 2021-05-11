<? require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

if (CModule::includeModule('iblock') && !empty($_SESSION['BX_CART'])) {
  $orderTotal = 0;
  $arOrderItems = array();
  $arOrderItemPairs = array();
  $mailHtml = "";
  $arOrder = array();

  foreach ($_SESSION['BX_CART'] as $arProduct) {
    $reProduct = CIBlockElement::GetList(
      ['ORDER' => 'ASC'],
      ['ID' => $arProduct['PRODUCT_ID']],
    );
    $arItem = $reProduct->GetNext();

    $iterator = CIBlockElement::GetProperty(7, $arItem['ID'], array("sort" => "asc"), Array("CODE" => "PRICE"));
    if ($arProps = $iterator->Fetch()) {
      $price = IntVal($arProps["VALUE"]);
    } else {
      $price = 0;
    }

    $orderTotal += $price * $arProduct['QTY'];

    // Format - PRODUCT_ID:QTY
    $arOrderItemPairs[] = $arProduct['PRODUCT_ID'] . ':' . $arProduct['QTY'];

    // Email data
    $arOrderItems[] = [
      'NAME' => $arItem['NAME'],
      'PRICE' => number_format($price, 2, ',', ' ') . ' р.',
      'QTY' => $arProduct['QTY'],
      'SUM' => number_format($orderTotal, 2, ',', ' ') . ' р.',
    ];

    unset($_SESSION['BX_CART'][$arProduct['ID']]);
  }
  $orderTotalFormatted = number_format($orderTotal, 2, ',', ' ') . " р.";

  $el = new CIBlockElement; // обязательно указываем класс

  $arProps = array();
  $arProps["PRODUCTS"] = $arOrderItemPairs;
  $arProps["TOTAL"] = $orderTotal;
  $arProps["EMAIL"] = !empty($_GET['EMAIL'])? $_GET['EMAIL'] : '';
  $arProps["PHONE_NUM"] = !empty($_GET['PHONE_NUM'])? $_GET['PHONE_NUM'] : '';

  $code = "order_".time().rand(100,999);
  $arOrderFields = Array(
    "ACTIVE" => "Y",
    "ACTIVE_FROM" => date('d.m.Y H:i:s'),
    "MODIFIED_BY" => $USER->GetID(),
    "IBLOCK_SECTION_ID" => false,
    "IBLOCK_ID" => 9,
    "PROPERTY_VALUES" => $arProps,
    "CODE" => $code,
    "NAME" => $code,

    'ITEMS' => $arOrderItems,
  );

  ob_start();
  require('mail_template.php');
  $mailHtml = ob_get_contents();
  ob_end_clean();

  $orderID = $el->Add($arOrderFields);
  if ($orderID > 0) {
    $to = 'bob@example.com';

    $subject = 'Website Change Request';

    $headers = "From: " . strip_tags("mewniiofficial@gmail.com") . "\r\n";
    $headers .= "Reply-To: ". strip_tags("mewniiofficial@gmail.com") . "\r\n";
    $headers .= "CC: susan@example.com\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

    mail($_GET['EMAIL'], "Новый заказ №$orderID с сайта", $mailHtml, $headers);

    Header('Location: /personal/order/success.php?ORDER_ID='.$orderID);
  }
}
