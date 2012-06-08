<?php
/**
 * @package		Pro Image Crop
 * @subpackage	com_proimagecrop
 * @copyright	Copyright (C) AtomTech, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controlleradmin');

/**
 * Formats list controller class.
 *
 * @package		Pro Image Crop
 * @subpackage	com_proimagecrop
 * @since		2.5
 */
class ProImageCropControllerFormats extends JControllerAdmin
{
	/**
	 * @var		string	The prefix to use with controller messages.
	 * @since	2.5
	 */
	protected $text_prefix = 'COM_PROIMAGECROP_FORMATS';

	/**
	 * Constructor.
	 *
	 * @param	array An optional associative array of configuration settings.
	 * @see		JController
	 * @since	2.5
	 */
	public function __construct($config = array())
	{
		parent::__construct($config);
	}

	/**
	 * Proxy for getModel.
	 * @since	2.5
	 */
	public function getModel($name = 'Format', $prefix = 'ProImageCropModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}
}
