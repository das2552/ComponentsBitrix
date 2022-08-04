<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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


<?echo $arResult["NAV"]; // печатаем постраничную навигацию ?>
<table border="1">
	<tr>
		<th>ИД</th>
		<th>Активность</th>
		<th>Логин</th>
		<th>Фото</th>
		<th>Количество заказов (общее)</th>
	</tr>
    <?foreach ($arResult["ITEMS"] as $arUsers):?>
		<tr>
			<th><?=$arUsers["ID"]?></th>
			<th><?echo ($arUsers["ACTIVE"] == "Y") ? "Да" : "Нет" ;?></th>
			<th><?=$arUsers["LOGIN"]?></th>
			<? $file = CFile::ResizeImageGet($arUsers["PERSONAL_PHOTO"], array('width'=>60, 'height'=>60), BX_RESIZE_IMAGE_PROPORTIONAL, true);?>
			<th><img src="<?=$file["src"]?>" alt="" width="60px" height="60px"></th>
			<th><a href="<?=$arUsers["DETAIL_PAGE_URL"]?>"><?=$arUsers["COUNT_ORDERS"]?></a></th>
		</tr>
    <?endforeach;?>
</table>
