<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$this->setFrameMode(true);
?>

<?php
$APPLICATION->IncludeComponent(
    'dev:users.element',
    '',
    Array(

        'ELEMENT_ID' => $arResult['VARIABLES']['ELEMENT_ID'],     // идентификатор элемента инфоблока
        'ELEMENT_CODE' => $arResult['VARIABLES']['ELEMENT_CODE'], // символьный код элемента инфоблока

        // URL, ведущий на страницу с содержимым раздела
        'SECTION_URL' => $arResult['SECTION_URL'],
        // URL, ведущий на страницу с содержимым элемента
        'ELEMENT_URL' => $arResult['ELEMENT_URL'],

        // настройки кэширования
        'CACHE_TYPE' => $arParams['CACHE_TYPE'],
        'CACHE_TIME' => $arParams['CACHE_TIME'],
        'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
    
    ),
    $component
);
?>