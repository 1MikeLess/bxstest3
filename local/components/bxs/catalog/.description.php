<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentDescription = array(
  "NAME" => GetMessage("Каталог"),
  "DESCRIPTION" => GetMessage("Каталог товаров"),
  "PATH" => array(
    "ID" => "dv_components",
    "CHILD" => array(
      "ID" => "curdate",
      "NAME" => "Текущая дата"
    )
  ),
  "ICON" => "/images/icon.gif",
);
