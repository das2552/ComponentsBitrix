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

if ($arParams['SEF_MODE'] == 'Y') { // не работает
    /*
     * Если включен режим поддержки ЧПУ
     */

    // В этой переменной будем накапливать значения истинных переменных
    $arVariables = array();

     // Определим имя файла ( section, element), которому соответствует текущая запрошенная
     // страница. Кроме того, восстанавим те переменные, которые были заданы с помощью шаблона.
    $componentPage = CComponentEngine::ParseComponentPath(
        $arParams['SEF_FOLDER'],
        $arParams['SEF_URL_TEMPLATES'], 
        $arVariables // переменная передается по ссылке
    );

    // Метод выше не обрабатывает случай, когда шаблон пути равен пустой строке,
    // (например 'popular' => ''), поэтому делаем это сами
    if ($componentPage === false && parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) == $arParams['SEF_FOLDER']) {
        $componentPage = 'section';
    }

    /*
     * Метод служит для поддержки псевдонимов переменных в комплексных компонентах. Восстанавливает
     * истинные переменные из $_REQUEST на основании их псевдонимов из $arParams['VARIABLE_ALIASES'].
     */
    CComponentEngine::InitComponentVariables(
        $componentPage,
        null,
        array(),
        $arVariables
    );

    $arResult['VARIABLES'] = $arVariables;
    $arResult['FOLDER'] = $arParams['SEF_FOLDER'];
    $arResult['SECTION_URL'] = $arParams['SEF_FOLDER'].$arParams['SEF_URL_TEMPLATES']['section'];
    $arResult['ELEMENT_URL'] = $arParams['SEF_FOLDER'].$arParams['SEF_URL_TEMPLATES']['element'];

} else {
    /*
     * Если не включен режим поддержки ЧПУ
     */

    // В этой переменной будем накапливать значения истинных переменных
    $arVariables = array();

    // Восстановим переменные, которые пришли в параметрах запроса и запишем их в $arVariables
    CComponentEngine::InitComponentVariables(
        false,
        null,
        $arParams['VARIABLE_ALIASES'],
        $arVariables
    );

    /*
     * Теперь на основании истинных переменных $arVariables можно определить, какую страницу
     * шаблона компонента нужно показать
     */
    $componentPage = '';
    if ($_GET['ELEMENT_ID'])
        $componentPage = 'element'; // элемент инфоблока по идентификатору
    else
        $componentPage = 'section'; // главная страница компонента

    $arResult['VARIABLES'] = $arVariables;
    $arResult['FOLDER'] = '';
    
	$arResult['SECTION_URL'] =
		$APPLICATION->GetCurPage().'?'.$arParams['VARIABLE_ALIASES']['SECTION_ID'].'=#SECTION_ID#';
	$arResult['ELEMENT_URL'] =
		$APPLICATION->GetCurPage().'?'.$arParams['VARIABLE_ALIASES']['ELEMENT_ID'].'=#ELEMENT_ID#';


}

$this->IncludeComponentTemplate($componentPage);