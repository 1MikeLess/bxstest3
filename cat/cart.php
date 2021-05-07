<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');//Обязательная строка инициирующая движок Битрикса, но не подключающая шаблон

class CartHandler {
  private function getCart() {
    if (!empty($_SESSION['BX_CART'])) {//Проверяем существует ли наша корзина в массиве $_SESSION
        $arChart= $_SESSION['BX_CART'];//Если да то получаем текущиие данные о корзине
    } else {
        $arChart = array();//Если нет присваиваем пустой массив
    }
    return $arChart;
  }

  public function add() {
    if (!isset($_POST['PRODUCT_ID'])) {
        return array('ERROR' => 'PRODUCT_ID ??');
    }

    $arChart = $this->getCart();
    $qty = $_POST['QTY'] ?? 1;

    $arChart[$_POST['PRODUCT_ID']]['QTY'] += $_POST['QTY'];

    return array(
      'PRODUCT_ID' => $_POST['PRODUCT_ID'],
      'QTY' => $arChart[$_POST['PRODUCT_ID']]['QTY']
    );
  }

  public function getChart() {
    $arChart = $this->getCart();

    return $arChart;
  }
}

// $id = $_POST['id'];//Получаем из глабального массива $_POST id товара
// $kol = $_POST['kol'];//Получаем количество
// if (!empty($_SESSION['BX_CART'])) {//Проверяем существует ли наша корзина в массиве $_SESSION
//     $arChart= $_SESSION['BX_CART'];//Если да то получаем текущиие данные о корзине
// } else {
//     $arChart = array();//Если нет присваиваем пустой массив
// }
// $arChart[$id] = $arChart[$id]+$kol;//Значение элемента массива с id товара увеличиваем на введенное количество
// $_SESSION['BX_CART'] = $arChart;//Сохраняем в сесии массив с корзиной
// echo count($_SESSION['BX_CART']);//Возвращаем количество отдельных позиций в корзине
// print_r($_SESSION['BX_CART']);//Вернем ответ о содержании корзины

if (isset($_REQUEST['METHOD']) && method_exists(CartHandler, $_REQUEST['METHOD'])) {
  $handler = new CartHandler();
  $response = $handler->{$_REQUEST['METHOD']}();

  echo json_encode($response);
}
