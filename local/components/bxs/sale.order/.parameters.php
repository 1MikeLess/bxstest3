<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if (!CModule::IncludeModule("iblock")) return false;

$dbIBlockType = CIBlockType::GetList(
   array("sort" => "asc"),
   array("ACTIVE" => "Y")
);
while ($arIBlockType = $dbIBlockType->Fetch()) {
   if ($arIBlockTypeLang = CIBlockType::GetByIDLang($arIBlockType["ID"], LANGUAGE_ID))
      $arIblockType[$arIBlockType["ID"]] = "[".$arIBlockType["ID"]."] ".$arIBlockTypeLang["NAME"];
}

$arComponentParameters = array(
   "GROUPS" => array(
      "MAIL" => array(
         "NAME" => "Отправка письма"
      ),
   ),
   "PARAMETERS" => array(
     "IBLOCK_TYPE_ID" => array(
         "PARENT" => "BASE",
         "NAME" => "INFOBLOCK_TYPE_PHR",
         "TYPE" => "LIST",
         "ADDITIONAL_VALUES" => "Y",
         "VALUES" => $arIblockType,
         "REFRESH" => "Y"
      ),
      "MAIL_SUBJECT" => array(
         "PARENT" => "MAIL",
         "NAME" => "Заголовок",
         "TYPE" => "STRING",
         "MULTIPLE" => "N",
         "DEFAULT" => "Новый заказ №%ORDER_ID% с сайта",
         "COLS" => 30
      ),
      "MAIL_FROM" => [
        "PARENT" => "MAIL",
        "NAME" => "Отправитель",
        "TYPE" => "STRING",
        "DEFAULT" => "example@ex.com",
      ],
   )
);
