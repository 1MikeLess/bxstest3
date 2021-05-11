<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die(); ?>
<?
if (CModule::includeModule('iblock')) {
  if (empty($_SESSION['BX_CART'])) $_SESSION['BX_CART'] = array();

  foreach ($_SESSION['BX_CART'] as $arProduct) {
    $reProduct = CIBlockElement::GetList(
      ['ORDER' => 'ASC'],
      ['ID' => $arProduct['PRODUCT_ID'], 'ACTIVE' => 'Y'],
    );
    $arItem = $reProduct->GetNext();

    $iterator = CIBlockElement::GetProperty(7, $arItem['ID'], array("sort" => "asc"), Array("CODE" => "PRICE"));
    if ($arProps = $iterator->Fetch()) {
      $price = IntVal($arProps["VALUE"]);
      $priceFormatted = number_format($price, 2, ',', ' ');
      $priceFormatted = $priceFormatted . " р.";
    } else {
      $price = false;
    }

    $arItem['QTY'] = $arProduct['QTY'];
    $arItem["PRICE"] = $price;
    $arItem["PRICE_FORMATTED"] = $priceFormatted;
    $arItem["PREVIEW_PICTURE"] = CFile::GetPath($arItem["PREVIEW_PICTURE"]);

    $arResult['ITEMS'][] = $arItem;
  }

  $this->IncludeComponentTemplate();
}
