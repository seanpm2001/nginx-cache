<?php
/**
 * Nginx Cache for Craft CMS
 *
 * @link      https://ethercreative.co.uk
 * @copyright Copyright (c) 2019 Ether Creative
 */

namespace ether\gnash\console\controllers;

use Craft;
use ether\gnash\Gnash;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * Class DefaultController
 *
 * @author  Ether Creative
 * @package ether\gnash\console\controllers
 */
class DefaultController extends Controller
{

	/**
	 * Purge the entire cache
	 *
	 * ./craft nginx-cache/purge-all
	 *
	 * @return int
	 */
	public function actionPurgeAll ()
	{
		Gnash::getInstance()->gnash->purgeAll();

		return ExitCode::OK;
	}

	/**
	 * Purge elements from the cache by their given IDs
	 *
	 * ./craft nginx-cache/purge-elements 1,3,4
	 *
	 * @param string $elementIds - Comma-separated string of element IDs
	 *
	 * @return int
	 */
	public function actionPurgeElements (string $elementIds)
	{
		$elementIds = explode(
			',',
			str_replace(' ', '', $elementIds)
		);

		foreach ($elementIds as $id)
			Gnash::getInstance()->gnash->purgeElement((int) $id);

		return ExitCode::OK;
	}

	/**
	 * Purge the given URL from the cache (supports alias / env)
	 *
	 * ./craft nginx-cache/purge-url \$DEFAULT_SITE_URL
	 *
	 * @param string $url - The URL to purge
	 *
	 * @return int
	 */
	public function actionPurgeUrl (string $url)
	{
		Gnash::getInstance()->gnash->purgeUrl(
			Craft::parseEnv($url)
		);

		return ExitCode::OK;
	}

}
