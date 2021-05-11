<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentDescription = array(
  "NAME" => GetMessage("Детальное описание"),
  "DESCRIPTION" => GetMessage("Детальное описание товара"),
  "PATH" => array(
    "ID" => "dv_components",
    "CHILD" => array(
      "ID" => "curdate",
      "NAME" => "Текущая дата"
    )
  ),
  "ICON" => "/images/icon.gif",
);
