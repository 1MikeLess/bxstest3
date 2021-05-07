<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if (isset($_GET['ID'])) {
  $APPLICATION->IncludeComponent(
    "bxs:catalog.detail",
    "",
    Array(
      "ID" => $_GET['ID']
    ),
    false
  );
} else {
  if (CModule::includeModule('iblock')) {
    $arSelect = Array(
      "NAME",
      "ID",
      "XML_ID",
      "DETAIL_PAGE_URL",
      "PROPERTY_SUB_TITLE",
      "PREVIEW_PICTURE",
      "DETAIL_PICTURE",
      
      "EDIT_LINK", // <--------
    );
    $arFilter = Array("IBLOCK_ID" => 7, "ACTIVE" => "Y");

    $res = CIBlockElement::GetList(Array('SORT' => 'ASC'), $arFilter, false, false, $arSelect);
    while ($element = $res->GetNext()) {
      $db_props = CIBlockElement::GetProperty(10, $element['ID'], array("sort" => "asc"), Array("CODE" => "PRICE"));
      if ($arProps = $db_props->Fetch()) {
        $price = IntVal($arProps["VALUE"]);
        $priceFormatted = number_format($price, 2, ',', ' ');
        $priceFormatted = $priceFormatted . " р.";
      } else {
        $price = false;
      }
      $element["PRICE"] = $price;
      $element["PRICE_FORMATTED"] = $priceFormatted;

      $element["PREVIEW_PICTURE"] = CFile::GetPath($element["PREVIEW_PICTURE"]);
      $element["DETAIL_PAGE_URL"] = $APPLICATION->GetCurPageParam('ID='.$element['ID'], ['ID'], false);

      $arResult["ELEMENTS"][] = $element;
    }

    $this->IncludeComponentTemplate();
  }
}
