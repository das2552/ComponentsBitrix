<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Список пользователей");?>

<?php
$APPLICATION->IncludeComponent(
    "dev:users",
    "",
    Array(

        "CACHE_GROUPS" => "Y",
        "CACHE_TIME" => "3600",
        "CACHE_TYPE" => "A",

        "SEF_FOLDER" => "/users/",
        "SEF_MODE" => "N",   // чпу не смог пока сделать 
        "SEF_URL_TEMPLATES" => array(
            "element"=>"#ELEMENT_ID#/",
            "section"=>""
        ),
    )
);
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>