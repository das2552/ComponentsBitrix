<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

// проверяем, установлен ли модуль «Информационные блоки»
if (!CModule::IncludeModule('iblock')) {
    return;
}

$arComponentParameters = array(
    'PARAMETERS' => array(
        'VARIABLE_ALIASES' => array( // это для работы в режиме без ЧПУ
            'ELEMENT_ID' => array('NAME' => 'Идентификатор элемента'),
        ),
        'SEF_MODE' => array( // это для работы в режиме ЧПУ
            'section' => array(
                'NAME' => 'Главная страница',
                'DEFAULT' => '',
            ),
            'element' => array(
                'NAME' => 'Страница элемента',
                'DEFAULT' => '#ELEMENT_ID#/',
            ),
        ),

        /*
         * Настройки кэширования
         */
        'CACHE_TIME'  =>  array('DEFAULT' => 3600),
        'CACHE_GROUPS' => array( // учитываться права доступа при кешировании?
            'PARENT' => 'CACHE_SETTINGS',
            'NAME' => 'Учитывать права доступа',
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'Y',
        ),
    ),
);



// настройки на случай, если раздел или элемент не найдены, 404 Not Found
CIBlockParameters::Add404Settings($arComponentParameters, $arCurrentValues);