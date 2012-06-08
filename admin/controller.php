<?php
/**
 * @package		Pro Image Crop
 * @subpackage	com_proimagecrop
 * @copyright	Copyright (C) AtomTech, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

/**
 * ProImageCrop Component Controller
 *
 * @package		Pro Image Crop
 * @subpackage	com_proimagecrop
 */
class ProImageCropController extends JController
{
	/**
	 * @var		string	The default view.
	 * @since	2.5
	 */
	protected $default_view = 'crop';

	/**
	 * Method to display a view.
	 *
	 * @param	boolean			If true, the view output will be cached
	 * @param	array			An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return	JController		This object to support chaining.
	 * @since	2.5
	 */
	public function display($cachable = false, $urlparams = false)
	{
		require_once JPATH_COMPONENT.'/helpers/proimagecrop.php';

		// Load the submenu.
		ProImageCropHelper::addSubmenu(JRequest::getCmd('view', 'crop'));

		$view	= JRequest::getCmd('view', 'crop');
		$layout = JRequest::getCmd('layout', 'default');
		$id		= JRequest::getInt('id');

		parent::display();

		return $this;
	}
}
