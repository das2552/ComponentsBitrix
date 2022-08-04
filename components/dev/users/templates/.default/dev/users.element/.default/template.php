<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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

<a href="/users/">Назад</a>

<table cellpadding="7" border="1">
    <tr>
        <th>Номер заказа</th>
        <th>Дата заказа</th>
        <th>Статус заказа</th>
        <th>Отмена заказа</th>
    </tr>
    <?foreach($arResult["ITEMS"] as $item):?>
        <tr>
            <th><?=$item["ID"]?></th>
            <th><?=$item["DATE_INSERT"]?></th>
            <th>
                <?switch($item["STATUS_ID"]){
                    case "F":
                        echo "Выполнен";            // Это стандартные статусы заказа, 
                        break;                      // в зависимости от списка статусов на вашем сайте - можно добавить.
                    case "N":
                        echo "Принят";
                        break;
                    case "DF":
                        echo "Отгружен";
                        break;
                    case "DN":
                        echo "Ожидает обработки";
                        break;
                }?>
            </th>
            <th><?echo ($item["CANCELED"] == "Y") ? "Заказ отменен": "Заказ не отменен";?></th>
        </tr>
    <?endforeach;?>
    
</table>