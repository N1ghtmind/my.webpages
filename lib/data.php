<?php
namespace MyWebpages;

use Bitrix\Main,
	Bitrix\Main\Localization\Loc;

/**
 * Class WebpagesTable
 * 
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> TITLE string mandatory
 * <li> URL string mandatory
 * <li> PASSWORD string mandatory
 * <li> HTML string mandatory
 * <li> CREATED datetime optional default 'CURRENT_TIMESTAMP'
 * </ul>
 *
 * @package Webpages
 **/

class WebpagesTable extends Main\Entity\DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'my_webpages';
	}

	/**
	 * Returns entity map definition.
	 *
	 * @return array
	 */
	public static function getMap()
	{
		return array(
			'ID' => array(
				'data_type' => 'integer',
				'primary' => true,
				'autocomplete' => true,
				'title' => Loc::getMessage('WEBPAGES_ENTITY_ID_FIELD'),
			),
			'TITLE' => array(
				'data_type' => 'text',
				'required' => true,
				'title' => Loc::getMessage('WEBPAGES_ENTITY_TITLE_FIELD'),
			),
			'URL' => array(
				'data_type' => 'text',
				'required' => true,
				'title' => Loc::getMessage('WEBPAGES_ENTITY_URL_FIELD'),
			),
			'PASSWORD' => array(
				'data_type' => 'text',
				'required' => true,
				'title' => Loc::getMessage('WEBPAGES_ENTITY_PASSWORD_FIELD'),
			),
			'HTML' => array(
				'data_type' => 'text',
				'required' => true,
				'title' => Loc::getMessage('WEBPAGES_ENTITY_HTML_FIELD'),
			),
			'CREATED' => array(
				'data_type' => 'datetime',
				'title' => Loc::getMessage('WEBPAGES_ENTITY_CREATED_FIELD'),
			),
		);
	}
}