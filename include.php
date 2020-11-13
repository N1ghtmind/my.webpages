<?php

Bitrix\Main\Loader::registerAutoloadClasses(
	"my.webpages",
	array(
		"MyWebpages\\WebpagesTable" => "lib/data.php",
		"MyWebpages\\TableManager" => "lib/table_manager.php",
	)
);
