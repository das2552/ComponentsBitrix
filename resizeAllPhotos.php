<?php


CModule::IncludeModule('iblock');
$arSelect = Array("ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM","PROPERTY_*");
$items_list = CIBlockElement::GetList(
	array(
		'NAME' => 'ASC'
	),
	array(
		'IBLOCK_ID' => 82, // ID блока
		'ACTIVE' => 'Y',
		'PROPERTY_<PHOTOS>' => true
	),
	false,
	false,
	$arSelect
);
$element = new CIBlockElement;

 
while($item = $items_list->GetNext()) {
	
	global $APPLICATION;
  CModule::IncludeModule('iblock');
  $IBLOCK_ID = 82; // ID инфоблока свойство которых нуждается в масштабировании
  $PROPERTY_CODE = "PHOTOS";  // код свойства
  $imageMaxWidth = 1000; // Максимальная ширина картинки
  $imageMaxHeight = 800; // Максимальная высота картинки
  // для начала убедимся, что изменяется элемент нужного нам инфоблока
  if($item["IBLOCK_ID"] == $IBLOCK_ID) {
	$VALUES = $VALUES_OLD = array();
	//Получаем свойство значение сво-ва $PROPERTY_CODE
	$res = CIBlockElement::GetProperty($item["IBLOCK_ID"], $item["ID"], "sort", "asc", array("CODE" => $PROPERTY_CODE));
	while ($ob = $res->GetNext()) {
		$file_path = CFile::GetPath($ob['VALUE']); // Получаем путь к файлу
		if($file_path) {
			$imsize = getimagesize($_SERVER["DOCUMENT_ROOT"].$file_path); //Узнаём размер файла
			// Если размер больше установленного максимума
			if($imsize[0] > $imageMaxWidth or $imsize[1] > $imageMaxHeight) {
				// Уменьшаем размер картинки
				$file = CFile::ResizeImageGet($ob['VALUE'], array(
						'width'=>$imageMaxWidth,
						'height'=>$imageMaxHeight
					), BX_RESIZE_IMAGE_PROPORTIONAL, true);
				// добавляем в массив VALUES новую уменьшенную картинку
				$VALUES[] = array("VALUE" => CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"].$file["src"]), "DESCRIPTION" => $ob['DESCRIPTION']);
				} else {
				// добавляем в массив VALUES старую картинку
				$VALUES[] = array("VALUE" => CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"].$file_path), "DESCRIPTION" => $ob['DESCRIPTION']);
			}
			// Собираем в массив ID старых файлов для их удаления (чтобы не занимали место)
			$VALUES_OLD[] = $ob['VALUE']; 
		}
	}
	// Если в массиве есть информация о новых файлах
	if(count($VALUES) > 0) {
		$PROPERTY_VALUE = $VALUES;  // значение свойства
		// Установим новое значение для данного свойства данного элемента
		CIBlockElement::SetPropertyValuesEx($item["ID"], $item["IBLOCK_ID"], array($PROPERTY_CODE => $PROPERTY_VALUE));
		// Удаляем старые большие изображения
		foreach ($VALUES_OLD as $key=>$val) {
			CFile::Delete($val);
		}
	}
	unset($VALUES);
	unset($VALUES_OLD);
  }
}


