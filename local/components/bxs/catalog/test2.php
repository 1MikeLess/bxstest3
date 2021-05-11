<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

CModule::includeModule('iblock');

function create_catalog_iblock() {
      $ib = new CIBlock;

      $IBLOCK_TYPE = "sale_catalog"; // Тип инфоблока
      $SITE_ID = "s1"; // ID сайта


      // Айдишники групп, которым будем давать доступ на инфоблок
      // $contentGroupId = $this->GetGroupIdByCode("CONTENT");
      // $editorGroupId = $this->GetGroupIdByCode("EDITOR");
      // $ownerGroupId = $this->GetGroupIdByCode("OWNER");


      //===================================//
      // Создаем инфоблок каталога товаров //
      //===================================//

      // Настройка доступа
      $arAccess = array(
         "2" => "R", // Все пользователи
      );
         // if ($contentGroupId) $arAccess[$contentGroupId] = "X"; // Полный доступ
         // if ($editorGroupId) $arAccess[$editorGroupId] = "W"; // Запись
         // if ($ownerGroupId) $arAccess[$ownerGroupId] = "X"; // Полный доступ

      $arFields = Array(
         "ACTIVE" => "Y",
         "NAME" => "Заказы",
         "CODE" => "orders",
         "IBLOCK_TYPE_ID" => $IBLOCK_TYPE,
         "SITE_ID" => $SITE_ID,
         "SORT" => "5",
         "GROUP_ID" => $arAccess, // Права доступа
         "FIELDS" => array(
            // Символьный код элементов
            "CODE" => array(
               "IS_REQUIRED" => "N", // Обязательное
               "DEFAULT_VALUE" => array(
                  "UNIQUE" => "Y", // Проверять на уникальность
                  "TRANSLITERATION" => "Y", // Транслитерировать
                  "TRANS_LEN" => "30", // Максмальная длина транслитерации
                  "TRANS_CASE" => "L", // Приводить к нижнему регистру
                  "TRANS_SPACE" => "-", // Символы для замены
                  "TRANS_OTHER" => "-",
                  "TRANS_EAT" => "Y",
                  "USE_GOOGLE" => "N",
                  ),
               ),
            "LOG_SECTION_ADD" => array("IS_REQUIRED" => "Y"), // Журналирование
            "LOG_SECTION_EDIT" => array("IS_REQUIRED" => "Y"),
            "LOG_SECTION_DELETE" => array("IS_REQUIRED" => "Y"),
            "LOG_ELEMENT_ADD" => array("IS_REQUIRED" => "Y"),
            "LOG_ELEMENT_EDIT" => array("IS_REQUIRED" => "Y"),
            "LOG_ELEMENT_DELETE" => array("IS_REQUIRED" => "Y"),
         ),

         "VERSION" => 1, // Хранение элементов в общей таблице

         "ELEMENT_NAME" => "Заказ",
         "ELEMENTS_NAME" => "Заказы",
         "ELEMENT_ADD" => "Добавить заказ",
         "ELEMENT_EDIT" => "Изменить заказ",
         "ELEMENT_DELETE" => "Удалить заказ",

         "SECTION_PROPERTY" => "N", // Разделы каталога имеют свои свойства (нужно для модуля интернет-магазина)
      );

      $ID = $ib->Add($arFields);
      if ($ID > 0) {
         echo "&mdash; инфоблок \"Каталог товаров\" успешно создан<br />";
      }
      else {
         echo "&mdash; ошибка создания инфоблока \"Каталог товаров\"<br />";
         return false;
      }


      //=======================================//
      // Добавляем свойства к каталогу товаров //
      //=======================================//

      // Определяем, есть ли у инфоблока свойства
      $dbProperties = CIBlockProperty::GetList(array(), array("IBLOCK_ID" => $ID));
      if ($dbProperties->SelectedRowsCount() <= 0) {
         $ibp = new CIBlockProperty;

         $arFields = Array(
            "NAME" => "Товары",
            "ACTIVE" => "Y",
            "SORT" => 100, // Сортировка
            "CODE" => "PRODUCTS",
            "MULTIPLE" => "Y",
            "PROPERTY_TYPE" => "S",
            "FILTRABLE" => "Y", // Выводить на странице списка элементов поле для фильтрации по этому свойству
            "IBLOCK_ID" => $ID
           );
         $propId = $ibp->Add($arFields);
         if ($propId > 0)
         {
            $arFields["ID"] = $propId;
            $arCommonProps[$arFields["CODE"]] = $arFields;
            echo "&mdash; Добавлено свойство ".$arFields["NAME"]."<br />";
         }
         else
            echo "&mdash; Ошибка добавления свойства ".$arFields["NAME"]."<br />";

         $arFields = Array(
            "NAME" => "Итого",
            "ACTIVE" => "Y",
            "SORT" => 200,
            "CODE" => "TOTAL",
            "PROPERTY_TYPE" => "N",
            "FILTRABLE" => "Y",
            "IBLOCK_ID" => $ID
           );
         $propId = $ibp->Add($arFields);
         if ($propId > 0)
         {
            $arFields["ID"] = $propId;
            $arCommonProps[$arFields["CODE"]] = $arFields;
            echo "&mdash; Добавлено свойство ".$arFields["NAME"]."<br />";
         }
         else
            echo "&mdash; Ошибка добавления свойства ".$arFields["NAME"]."<br />";
      } else
         echo "&mdash; Для данного инфоблока уже существуют свойства<br />";

      // Возвращаем номер добавленного инфоблока
      return $ID;
   }

create_catalog_iblock();
?>
