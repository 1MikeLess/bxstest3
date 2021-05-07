<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die(); ?>
<?
if (CModule::includeModule('iblock')) {
  $arSelect = Array(
    "NAME",
    "ID",
    "XML_ID",
    "DETAIL_PAGE_URL",
    "PROPERTY_SUB_TITLE",
    "PREVIEW_PICTURE",
    "DETAIL_PICTURE",
  );
  $arFilter = Array("IBLOCK_ID" => 7, "ACTIVE" => "Y", "ID" => $arParams['ID']);

  $res = CIBlockElement::GetList(Array('SORT' => 'ASC'), $arFilter, false, false, $arSelect);
  while ($element = $res->GetNext()) {
    $iterator = CIBlockElement::GetProperty(10, $element['ID'], array("sort" => "asc"), Array("CODE" => "PRICE"));
    if ($arProps = $iterator->Fetch()) {
      $price = IntVal($arProps["VALUE"]);
      $priceFormatted = number_format($price, 2, ',', ' ');
      $priceFormatted = $priceFormatted . " р.";
    } else {
      $price = false;
    }
    $arResult["PRICE"] = $price;
    $arResult["PRICE_FORMATTED"] = $priceFormatted;

    $arResult["PREVIEW_PICTURE"] = CFile::GetPath($element["PREVIEW_PICTURE"]);
    $arResult['ID'] = $element['ID'];
  }

  $this->IncludeComponentTemplate();
}
