<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

// проверяем, установлен ли модуль «Информационные блоки»
if (!CModule::IncludeModule('iblock')) {
    return;
}


/*
 * Настройки компонента
 */
$arComponentParameters = array(
    
    'PARAMETERS' => array(
        
        // идентификатор элемента получать из $_REQUEST["ELEMENT_ID"]
        'ELEMENT_ID' => array(
            'PARENT' => 'BASE',
            'NAME' => 'Идентификатор элемента',
            'TYPE' => 'STRING',
            'DEFAULT' => '={$_REQUEST["ELEMENT_ID"]}',
        ),

        // шаблон ссылки на страницу элемента
        'ELEMENT_URL' => array(
            'PARENT' => 'URL_TEMPLATES',
            'NAME' => 'URL, ведущий на страницу с содержимым элемента',
            'TYPE' => 'STRING',
            'DEFAULT' => 'item/id/#ELEMENT_ID#/'
        ),



        // настройки кэширования
        'CACHE_TIME'  =>  array('DEFAULT'=>3600),
        'CACHE_GROUPS' => array(
            'PARENT' => 'CACHE_SETTINGS',
            'NAME' => 'Учитывать права доступа',
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'Y',
        ),
    ),
);

// добавляем еще одну настройку — на случай, если элемент инфоблока не найден
CIBlockParameters::Add404Settings($arComponentParameters, $arCurrentValues);