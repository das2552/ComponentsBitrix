<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */

if (!CModule::IncludeModule('iblock')) {
    ShowError('Модуль «Информационные блоки» не установлен');
    return;
}

// время кеширования
if (!isset($arParams['CACHE_TIME'])) {
    $arParams['CACHE_TIME'] = 3600;
} else {
    $arParams['CACHE_TIME'] = intval($arParams['CACHE_TIME']);
}

// шаблон ссылки на страницу с содержимым раздела
$arParams['SECTION_URL'] = trim($arParams['SECTION_URL']);
// шаблон ссылки на страницу с содержимым элемента
$arParams['ELEMENT_URL'] = trim($arParams['ELEMENT_URL']);



if ($this->StartResultCache()) {

    // работаем с идентификатором элемента
    $ELEMENT_ID = $_GET['ELEMENT_ID'];

    if ($ELEMENT_ID) {
        $arFilter = Array("USER_ID" => $ELEMENT_ID);
        $arOrder = CSaleOrder::GetList(array("DATE_INSERT" => "DESC"), $arFilter, false, array("nTopCount" => "50") );
        $arItems = Array();
        while ($order = $arOrder->GetNext()){
                array_push($arItems, $order);
        }
        $arResult["ITEMS"] = $arItems;
    }
    if (isset($ELEMENT_ID)) { // данные получены успешно
        /*
         * Ключи $arResult, перечисленные при вызове этого метода,
         * будут доступны в component_epilog.php и ниже по коду;
         * обратите внимание, там уже будет другой $arResult
         */
        $this->SetResultCacheKeys(
            array(
                'ID',
                'NAME'
            )
        );
        // подключаем шаблон и сохраняем кеш
        $this->IncludeComponentTemplate();
    } else { // что-то пошло не так
        $this->AbortResultCache();
        \Bitrix\Iblock\Component\Tools::process404(
            'Страница не найдена',
            true,
            true
        );
    }
}

