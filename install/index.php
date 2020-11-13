<?
IncludeModuleLangFile(__FILE__);
 
use \Bitrix\Main\ModuleManager;
 
Class My_Webpages extends CModule
{
 
    var $MODULE_ID = "my.webpages";
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $errors;
 
    function __construct()
    {        
        $this->MODULE_VERSION = "1.0.0";
        $this->MODULE_VERSION_DATE = "12.11.2020";
        $this->MODULE_NAME = "Модуль myWebpages";
        $this->MODULE_DESCRIPTION = "Тестовое задание";		
    }
 
    function DoInstall()
    {
        $this->InstallDB();
        $this->InstallEvents();
        $this->InstallFiles();
        RegisterModule("my.webpages");
        return true;
    }
 
    function DoUninstall()
    {
        $this->UnInstallDB();
        $this->UnInstallEvents();
        $this->UnInstallFiles();
        UnRegisterModule("my.webpages");
        return true;
    }
 
    function InstallDB()
    {
		$sql = file_get_contents(__DIR__ .'/db/install.sql');
		if ($sql) {
			Bitrix\Main\Application::getConnection()->query($sql);
		}
    }
 
    function UnInstallDB()
    {
		$sql = file_get_contents(__DIR__ .'/db/uninstall.sql');
		if ($sql) {
			Bitrix\Main\Application::getConnection()->query($sql);
		}
    }
 
    function InstallEvents()
    {
        return true;
    }
 
    function UnInstallEvents()
    {
        return true;
    }
 
    function InstallFiles()
    {
		CopyDirFiles(__DIR__."/upload", $_SERVER["DOCUMENT_ROOT"], true, true);
        return true;
    }
 
    function UnInstallFiles()
    {
		DeleteDirFilesEx("/test-page");
        return true;
    }
}