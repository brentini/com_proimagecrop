<?php
/**
 * @package		Pro Image Crop
 * @subpackage	com_proimagecrop
 * @copyright	Copyright (C) AtomTech, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

/**
 * ProImageCrop component helper.
 *
 * @package		Pro Image Crop
 * @subpackage	com_proimagecrop
 * @since		2.5
 */
class ProImageCropHelper
{
	public static $extension = 'com_proimagecrop';

	/**
	 * Configure the Linkbar.
	 *
	 * @param	string	$vName	The name of the active view.
	 *
	 * @return	void
	 * @since	2.5
	 */
	public static function addSubmenu($vName)
	{
		JSubMenuHelper::addEntry(
			JText::_('COM_PROIMAGECROP_SUBMENU_CROP'),
			'index.php?option=com_proimagecrop&view=crop',
			$vName == 'crop'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_PROIMAGECROP_SUBMENU_FORMATS'),
			'index.php?option=com_proimagecrop&view=formats',
			$vName == 'formats'
		);
	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @return	JObject
	 */
	public static function getActions()
	{
		$user		= JFactory::getUser();
		$result		= new JObject;
		$assetName	= 'com_proimagecrop';

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.state', 'core.delete'
		);

		foreach ($actions as $action) {
			$result->set($action,	$user->authorise($action, $assetName));
		}

		return $result;
	}
}
