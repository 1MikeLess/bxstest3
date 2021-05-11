<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if (isset($_GET['SUBMIT'])) {
  $componentName = "submit";
} elseif (isset($_GET['ORDER_ID'])) {
  $componentName = "success";
} else {
  $componentName = "make";
}

$APPLICATION->IncludeComponent(
  "bxs:sale.order.".$componentName,
  "",
);
