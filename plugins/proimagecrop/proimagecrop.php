<?php
/**
 * @package		Pro Image Crop
 * @subpackage	plg_proimagecrop
 * @copyright	Copyright (C) AtomTech, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

/**
 * ProImageCrop Button plugin
 *
 * @package		Pro Image Crop
 * @subpackage	Editors-xtd.proimagecrop
 * @since		2.5
 */
class plgButtonProImageCrop extends JPlugin
{
	/**
	 * Constructor
	 *
	 * @access		protected
	 * @param       object  $subject The object to observe
	 * @param       array   $config  An array that holds the plugin configuration
	 *
	 * @since       2.5
	 */
	public function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadLanguage();
	}

	/**
	 * Display the button
	 *
	 * @return array A two element array of (imageName, textToInsert)
	 */
	public function onDisplay($name, $asset, $author)
	{
		$app	= JFactory::getApplication();
		$params	= JComponentHelper::getParams('com_media');
 		$user	= JFactory::getUser();
		
		if ($user->authorise('core.edit', $asset) 
			|| $user->authorise('core.create', $asset) 
			|| ($user->authorise('core.edit.own', $asset) && $author==$user->id)) 
		{
			$link = 'index.php?option=com_proimagecrop&view=crop&tmpl=component&e_name=' . $name;
			
			JHtml::_('behavior.modal');
			
			$button = new JObject;
			$button->set('modal', true);
			$button->set('link', $link);
			$button->set('text', JText::_('PLG_PROIMAGECROP_BUTTON'));
			$button->set('name', 'blank');
			$button->set('options', "{handler: 'iframe', size: {x: 820, y: 550}}");
			
			return $button;
		}
			else
		{
			return false;
		}
	}
}
