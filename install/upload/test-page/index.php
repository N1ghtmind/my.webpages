<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
$APPLICATION->SetTitle("WebPages");
?>

<?
if (CModule::IncludeModule("my.webpages"))
{
	if($_GET["item_id"]) {
		// детальная
		$itemId = $_GET["item_id"];
		
		$arItem = MyWebpages\TableManager::getItem($itemId);
		$APPLICATION->SetTitle($arItem["TITLE"]);
		
		
		?>
		<div class="webpage-detail">
			<div class="webpage-detail-data">
				<div class="webpage-detail-data__item">
					<span>Дата добавления:</span> <?=$arItem["CREATED"]?>
				</div>
				<div class="webpage-detail-data__item">
					<span>URL страницы:</span> <?=$arItem["URL"]?>
				</div>
				<div class="webpage-detail-data__item">	
					<span>Заголовок страницы:</span> <?=$arItem["TITLE"]?>
				</div>	
				<div class="webpage-detail-data__item">	
					<span>HTML содержимое страницы:</span><br> 
					<div class="html_code">
					<?=str_replace(['<', '>'], ['&lt;', '&gt;'], $arItem["HTML"])?>
					</div>
				</div>				
			</div>
			
		<?
			if($_POST["webpage_item_id"]){
				if(MyWebpages\TableManager::deliteItem($_POST["webpage_item_id"], $_POST["webpage_item_pwd"]))
				{
					LocalRedirect($APPLICATION->GetCurPage(false));
				} else {
					echo "Ошибка удаления! Не верный пароль!";
				}			
			}			
		?>			
			
			<form action="" method="post">
				<input type="hidden" name="webpage_item_id" value="<?=$itemId?>">
				<?if($arItem["PASSWORD"] != "-"):?>
				<br><b>Введите пароль удаления:</b><br><br>
				<input type="text" name="webpage_item_pwd" value=""><br><br>
				<? else: ?>
				<input type="hidden" name="webpage_item_pwd" value="-">
				<? endif; ?>				
				<input type="submit" value="Кнопка удаления">
			</form>
		</div>
		<br>
		<a class="webpage-add-btn" href="?item_add=y">Добавить страницу</a>
		<?
		
	} elseif($_GET["item_add"]) {
		// страница добавления
		
		if($_POST["webpage_add_item"]){
			
			$addResult = MyWebpages\TableManager::addItem($_POST["title"], $_POST["url"], $_POST["password"]);
			
			if($addResult["STATUS"] == "OK"){
				echo "<p><b>Запись успешно добавлена!</b></p>";
			} else {
				echo "<p><b>Ошибка добавления записи:</b></p><p>".$addResult["ERROR"]."</p>";
			}			
		}
		
		?>
		<form action="" method="post">
			<input type="hidden" name="webpage_add_item" value="y">
			<label>Название страницы:</label><br>
			<input type="text" name="title" value="" required="required"><br><br>
			<label>URL:</label><br>
			<input type="text" name="url" value="" required="required"><br><br>
			<label>Пароль удаления:</label><br>
			<input type="text" name="password" value=""><br><br>
			<input type="submit" value="Добавить">
		</form>
		<?
		//
		
		
	} else {
		// разводящая
		$cnt = MyWebpages\TableManager::getCount();
		$perPage = 2;
		
		if($_GET["page"]){
			$page = $_GET["page"];
		} else {
			$page = 1;
		}
		
		$pages = ceil($cnt / $perPage);
		
		$arItems = MyWebpages\TableManager::getSectionList($page, $perPage);

		if(count($arItems) > 0) { ?>
			<div class="webpage-list">
			<? foreach($arItems as $item): ?>
				<div class="webpage-list-item">
					<div class="webpage-list-item__date"><span>Дата:</span> <?=$item["CREATED"]?></div>
					<div class="webpage-list-item__url"><span>URL:</span> <?=$item["URL"]?></div>
					<div class="webpage-list-item__title"><span>Заголовок:</span> <a href="?item_id=<?=$item["ID"]?>"><?=$item["TITLE"]?></a></div>
				</div>
			<? endforeach; ?>
			</div>
		<?
		}?>	
		
		<? if($pages > 1){ ?>
			<div class="pager">
				<ul>
				<? for ($i = 1; $i <= $pages; $i++) { ?>
					<li <?=($i == $page) ? "class='active'" : "";?>><a href="?page=<?=$i?>"><?=$i?></a></li>				
				<? } ?>
				</ul>
			</div>
		<? } ?>	
		<br><a class="webpage-add-btn" href="?item_add=y">Добавить страницу</a>
		<?		
	}
	?>	
	<?
}
?>

<style>
	.webpage-add-btn {
		border: solid 1px;
		padding: 5px 30px;
		margin: 15px 0;
	}
	.webpage-list {
		display: flex;
		flex-wrap: wrap;
		justify-content: space-between;
	}
	.webpage-list-item {
		border: solid 1px;
		width: calc(50% - 9px);
		padding: 5px;
	}
	.webpage-list-item span {
		font-weight: bold;
	}
	.pager {
		margin: 30px 0;
	}
	.pager ul {
		list-style: none;
		text-align: right;
	}
	.pager ul li {
		display: inline-block;
	}	
	.pager ul li.active {
		font-weight: bold;
	}
	.webpage-detail-data__item {
		margin-bottom: 15px;
	}
	.webpage-detail-data__item span {
		font-weight: bold;
	}
	.html_code {
		max-width: 100%;
		max-height: 400px;
		overflow: auto;
		margin-top: 15px;
	}
</style>

<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');
?>