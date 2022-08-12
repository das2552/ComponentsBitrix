<?php 
function translit($s) {
    $s = (string) $s; // преобразуем в строковое значение
    $s = trim($s); // убираем пробелы в начале и конце строки
    $s = function_exists('mb_strtolower') ? mb_strtolower($s) : strtolower($s); // переводим строку в нижний регистр (иногда надо задать локаль)
    $s = strtr($s, array('а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'e','ж'=>'j','з'=>'z','и'=>'i','й'=>'y','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u','ф'=>'f','х'=>'h','ц'=>'c','ч'=>'ch','ш'=>'sh','щ'=>'shch','ы'=>'y','э'=>'e','ю'=>'yu','я'=>'ya','ъ'=>'','ь'=>''));
    return $s; // возвращаем результат
  }
//Подключаем модуль работы с инфоблоками

CModule::IncludeModule( 'iblock' );

$arFilter = array(
	'IBLOCK_ID' => 1,
);

// Получаем массив всех элементов
$res = CIBlockelement::GetList( false, $arFilter, array( 'IBLOCK_ID', 'ID', 'CODE', 'NAME', 'PROPERTY_675','PROPERTY_676','PROPERTY_677','PROPERTY_370','PROPERTY_2') );

// Перебираем все элементы инфоблока и записываем в массив их IDшники
while ( $el = $res->GetNext() ){
	
  $elem = new CIBlockelement;
  $PROP = array();

  if($el['PROPERTY_677_VALUE'] > 200000) {
    $PROP[370] = 1; 
  } else {
    $PROP[370] = 0;
  }
  $PROP[675] = $el['PROPERTY_675_VALUE'];
  $PROP[676] = $el['PROPERTY_676_VALUE'];
  $PROP[677] = $el['PROPERTY_677_VALUE'];
  $PROP[2] = $el['PROPERTY_675_VALUE'] . "," . $el['PROPERTY_676_VALUE'];
  
  $translit = translit($el['NAME']);
  
  $arLoadProductArray = Array(
    "MODIFIED_BY"    => $USER->GetID(), 
    "PROPERTY_VALUES"=> $PROP,
    "CODE" => $translit,
    );
  
  $PRODUCT_ID = $el['ID'];
  $result = $elem->Update($PRODUCT_ID, $arLoadProductArray);
	if ($result){ 
    echo "OK!";
  } else {
		echo "FAIL!";
  }
  
}




    