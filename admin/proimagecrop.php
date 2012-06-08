<?php
/**
 * @package		Pro Image Crop
 * @subpackage	com_proimagecrop
 * @copyright	Copyright (C) AtomTech, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_proimagecrop')) {
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

// Require helper file
if (!class_exists('ProImageCropLoader')) {
    require_once JPATH_ADMINISTRATOR.'/components/com_proimagecrop/libraries/loader.php';
}

// Include dependancies
jimport('joomla.application.component.controller');

// Execute the task.
$controller = JController::getInstance('ProImageCrop');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();
