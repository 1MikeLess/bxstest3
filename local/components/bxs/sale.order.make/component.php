<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if (CModule::includeModule('iblock')) {
  if (empty($_SESSION['BX_CART'])) $_SESSION['BX_CART'] = array();

  $orderTotal = 0;

  foreach ($_SESSION['BX_CART'] as $arProduct) {
    $reProduct = CIBlockElement::GetList(
      ['ORDER' => 'ASC'],
      ['ID' => $arProduct['PRODUCT_ID'], 'ACTIVE' => 'Y'],
    );
    $arItem = $reProduct->GetNext();
    $total = 0;

    $iterator = CIBlockElement::GetProperty(7, $arItem['ID'], array("sort" => "asc"), Array("CODE" => "PRICE"));
    if ($arProps = $iterator->Fetch()) {
      $price = IntVal($arProps["VALUE"]);
      $priceFormatted = number_format($price, 2, ',', ' ');
      $priceFormatted = $priceFormatted . " р.";
    } else {
      $price = false;
    }

    $total = $price * $arProduct['QTY'];
    $totalFormatted = number_format($total, 2, ',', ' ');
    $totalFormatted = $totalFormatted . " р.";

    $arItem["QTY"] = $arProduct['QTY'];
    $arItem["PRICE"] = $price;
    $arItem["PRICE_FORMATTED"] = $priceFormatted;
    $arItem["PREVIEW_PICTURE"] = CFile::GetPath($arItem["PREVIEW_PICTURE"]);

    $arItem['TOTAL'] = $total;
    $arItem['TOTAL_FORMATTED'] = $totalFormatted;

    $orderTotal += $total;

    $arResult['ITEMS'][] = $arItem;
  }

  $arResult['TOTAL'] = $orderTotal;
  $orderTotalFormatted = number_format($orderTotal, 2, ',', ' ');
  $orderTotalFormatted = $orderTotalFormatted . " р.";
  $arResult['TOTAL_FORMATTED'] = $orderTotalFormatted;

  $url = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https://' : 'http://';
  $url .= $_SERVER['SERVER_NAME'];
  $url = strtok($_SERVER["REQUEST_URI"], '?');
  $url .= '?SUBMIT';
  $arResult['SUBMIT_PAGE_URL'] = $url;

  // print_r($arResult['SUBMIT_PAGE_URL']);

  $this->IncludeComponentTemplate();
}
