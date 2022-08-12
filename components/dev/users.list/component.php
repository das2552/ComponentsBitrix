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



$arUsers = CUser::GetList(($by="id"), ($order="asc")); // выбираем пользователей
$is_filtered = $arUsers->is_filtered; // отфильтрована ли выборка
$arUsers->NavStart(25); // разбиваем постранично по 25 записей
$arResult["NAV"] = $arUsers->NavPrint(GetMessage("PAGES")); // постраничная навигация
$arAllUsers = Array();
$arOrders = Array();

$rsSales = CSaleOrder::GetList(array("DATE_INSERT" => "ASC"));
while ($arSales = $rsSales->Fetch())
{
	$arOrder["ID"] = $arSales["ID"];
	$arOrder["USER_ID"] = $arSales["USER_ID"];
	array_push($arOrders , $arOrder);
}

// прозодимся по каждому пользователю
while($user=$arUsers->GetNext()){
	$arUser = Array();
	
	//счетчик заказов
	$countOrders=0;
	foreach($arOrders as $order) {
		if($order["USER_ID"] == $user["ID"]){
			$countOrders++;
		}
	}
	//формируем массив
	$arUser["ID"] = $user["ID"];
	$arUser["ACTIVE"] = $user["ACTIVE"];
	$arUser["LOGIN"] = $user["LOGIN"];
	$arUser["PERSONAL_PHOTO"] = $user["PERSONAL_PHOTO"];
	$arUser["COUNT_ORDERS"] = $countOrders;
	$arUser["DETAIL_PAGE_URL"] = "/users/?ELEMENT_ID=" . $user["ID"];

	array_push($arAllUsers, $arUser);
}

$arResult["ITEMS"] = $arAllUsers;

// подключаем шаблон и сохраняем кеш
$this->IncludeComponentTemplate();





