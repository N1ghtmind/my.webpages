<?php
namespace MyWebpages;

use Bitrix\Main;
use MyWebpages\WebpagesTable;
use Bitrix\Main\Entity;
 
class TableManager {
 
    public static function getSectionList($page = 1, $page_items = 2) {
		
		if($page == 1) {
			$offset = 0;
		}
		else {
			$offset = ($page * $page_items) - $page_items;
		}
		
		$arItems = [];
		
        $result = WebpagesTable::getList(
			[
				'select' => ['*'],
				'limit' => $page_items,
				'offset' => $offset,
			]
		);

		while($row = $result->fetch())
		{
			$arItems[] = $row;			
		}

        return $arItems;
    }
	
	public static function getCount() {
		
        $result = WebpagesTable::getList(
			[
				'select' => ['CNT'],
				'runtime' => array(
					new Entity\ExpressionField('CNT', 'COUNT(*)')
				)
			]      
		);
		
		if($row = $result->fetch()){
			$cntItems = $row['CNT'];
		}		
	
		return $cntItems;
	}
	
    public static function getItem($id) {
		
		$arItem = [];
		
        $result = WebpagesTable::getList(
			[
				'select' => ['*'],
				'filter' => ['ID' => $id]
			]
		);

		if($row = $result->fetch())
		{
			$arItem = $row;			
		}

        return $arItem;
    }
 
    public static function deliteItem($id, $password) {
		
        $result = WebpagesTable::getList(
			[
				'select' => ['*'],
				'filter' => ['ID' => $id]
			]
		);

		if($row = $result->fetch())
		{
			if($row["PASSWORD"] == $password)
			{
				$item = WebpagesTable::getByPrimary($id)->fetchObject();;
				$item->delete();
				return true;
			} else {
				return false;
			}
		}
		
		return false;
    }
	
    public static function addItem($title, $url, $password) {
		
		if(empty($password)){
			$password = "-";
		}

		$response = get_headers($url);		
		
		if(strstr($response[0], "200"))
		{
			$html = file_get_contents($url);
		} elseif(strstr($response[0], "404")) {
			$error = "Страница не найдена на сервере";
		} elseif(strstr($response[0], "403")) {
			$error = "Нет доступа к странице";
		} else {
			$error = "Сервер не отвечает";
		}		
		
        $result = WebpagesTable::getList(
			[
				'select' => ['*'],
				'filter' => ['URL' => $url]
			]
		);

		if($row = $result->fetch()){
			$error = "Такая страница уже есть в базе данных";
		}		
		
		if($error){			
			$arResult["ERROR"] = $error;
		} else {			
			$arResult["STATUS"] = "OK";
			WebpagesTable::add(["TITLE" => $title, "URL" => $url, "PASSWORD" => $password, "HTML" => $html]);			
		}

		return $arResult;
    }
}