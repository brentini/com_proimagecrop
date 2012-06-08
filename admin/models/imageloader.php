<?php
/**
 * @package		Pro Image Crop
 * @subpackage	com_proimagecrop
 * @copyright	Copyright (C) AtomTech, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die();

jimport('joomla.application.component.model');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
ProImageCropImport('proimagecrop.file.filefolderlist');

class ProImageCropModelImageLoader extends JModel
{

	protected $option = 'com_proimagecrop';

	protected $text_prefix = 'com_proimagecrop';

	function getFolderState($property = null)
	{
		static $set;
		if (!$set)
		{
			$folder = JRequest::getVar('folder', '', '', 'path');
			$this->setState('folder', $folder);
			
			$parent = str_replace("\\", "/", dirname($folder));
			$parent = ($parent == '.') ? null : $parent;
			$this->setState('parent', $parent);
			$set = true;
		}
		return parent::getState($property);
	}

	function getImages()
	{
		$tab = JRequest::getVar('tab', 0, '', 'int');
		$muFailed = JRequest::getVar('mufailed', '0', '', 'int');
		$muUploaded = JRequest::getVar('muuploaded', '0', '', 'int');
		
		$refreshUrl = 'index.php?option=com_proimagecrop&view=imageloader&tab=' . $tab . '&mufailed=' . $muFailed . '&muuploaded=' . $muUploaded .
			 '&tmpl=component';
		$list = ProImageCropFileFolderList::getList(0, 1, 0, $refreshUrl);
		return $list['Images'];
	}

	function getFolders()
	{ /*
		$tab = JRequest::getVar( 'tab', 0, '', 'int' );
		$refreshUrl = 'index.php?option=com_proimagecrop&view=phocagalleryi&tab='.$tab.'&tmpl=component';
		$list = PhocaGalleryFileFolderList::getList(0,0,0,$refreshUrl);
		return $list['folders'];
		*/
	}
}
?>