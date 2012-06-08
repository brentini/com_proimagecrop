<?php
/**
 * @package		Pro Image Crop
 * @subpackage	com_proimagecrop
 * @copyright	Copyright (C) AtomTech, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die();

jimport('joomla.application.component.modeladmin');

/**
 * Item Model for a Contact.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_proimagecrop
 * @since		1.6
 */
class ProImageCropModelCrop extends JModelAdmin
{

	var $_format = null;

	var $_formatid = null;
	
	//print JPATH_ROOT;
	public function getTable($type = 'format', $prefix = 'ProImageCropTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Method to get the row form.
	 *
	 * @param	array	$data		Data for the form.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 *
	 * @return	mixed	A JForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		jimport('joomla.form.form');
		
		// Get the form.
		$form = $this->loadForm('com_proimagecrop.crop', 'crop', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form))
		{
			return false;
		}
		return $form;
	}

	public function getFormat()
	{
		if (empty($this->_format))
		{
			$this->_format = "SELECT * FROM #__proimagecrop_formats WHERE published = 1 ORDER BY ordering ASC";
			$this->_format = $this->_getList($this->_format);
		}
		return $this->_format;
	}

	public function getFormatID()
	{
		$formatid = JRequest::getVar('formatID');
		if (empty($this->_formatid))
		{
			$this->_formatid = "SELECT * FROM #__proimagecrop_formats WHERE id = '" . $formatid . "';";
			$this->_formatid = $this->_getList($this->_formatid);
		}
		return $this->_formatid;
		//return $formatid;
	}
	
	//////////////////////////////////////////////
	function getState($property = null, $default = null)
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
		
		return parent::getState($property, $default);
	}

	function getImages()
	{
		$list = $this->getList();
		
		return $list['images'];
	}

	function getFolders()
	{
		$list = $this->getList();
		
		return $list['folders'];
	}

	function getDocuments()
	{
		$list = $this->getList();
		
		return $list['docs'];
	}

	/**
	 * Build imagelist
	 *
	 * @param string $listFolder The image directory to display
	 * @since 1.5
	 */
	function getList()
	{
		static $list;
		
		// Only process the list once per request
		if (is_array($list))
		{
			return $list;
		}
		
		// Get current path from request
		$current = $this->getState('folder');
		
		// If undefined, set to empty
		if ($current == 'undefined')
		{
			$current = '';
		}
		
		// Initialise variables.
		if (strlen($current) > 0)
		{
			$basePath = COM_MEDIA_BASE . '/' . $current;
		}
		else
		{
			$basePath = COM_MEDIA_BASE;
		}
		
		$mediaBase = str_replace(DS, '/', COM_MEDIA_BASE . '/');
		
		$images = array();
		$folders = array();
		$docs = array();
		
		// Get the list of files and folders from the given folder
		$fileList = JFolder::files($basePath);
		$folderList = JFolder::folders($basePath);
		
		// Iterate over the files if they exist
		if ($fileList !== false)
		{
			foreach ($fileList as $file)
			{
				if (is_file($basePath . '/' . $file) && substr($file, 0, 1) != '.' && strtolower($file) !== 'index.html')
				{
					$tmp = new JObject();
					$tmp->name = $file;
					$tmp->title = $file;
					$tmp->path = str_replace(DS, '/', JPath::clean($basePath . DS . $file));
					$tmp->path_relative = str_replace($mediaBase, '', $tmp->path);
					$tmp->size = filesize($tmp->path);
					
					$ext = strtolower(JFile::getExt($file));
					switch ($ext)
					{
						// Image
						case 'jpg':
						case 'png':
						case 'gif':
						case 'xcf':
						case 'odg':
						case 'bmp':
						case 'jpeg':
							$info = @getimagesize($tmp->path);
							$tmp->width = @$info[0];
							$tmp->height = @$info[1];
							$tmp->type = @$info[2];
							$tmp->mime = @$info['mime'];
							
							if (($info[0] > 60) || ($info[1] > 60))
							{
								$dimensions = MediaHelper::imageResize($info[0], $info[1], 60);
								$tmp->width_60 = $dimensions[0];
								$tmp->height_60 = $dimensions[1];
							}
							else
							{
								$tmp->width_60 = $tmp->width;
								$tmp->height_60 = $tmp->height;
							}
							
							if (($info[0] > 16) || ($info[1] > 16))
							{
								$dimensions = MediaHelper::imageResize($info[0], $info[1], 16);
								$tmp->width_16 = $dimensions[0];
								$tmp->height_16 = $dimensions[1];
							}
							else
							{
								$tmp->width_16 = $tmp->width;
								$tmp->height_16 = $tmp->height;
							}
							
							$images[] = $tmp;
							break;
						
						// Non-image document
						default:
							$tmp->icon_32 = "media/mime-icon-32/" . $ext . ".png";
							$tmp->icon_16 = "media/mime-icon-16/" . $ext . ".png";
							$docs[] = $tmp;
							break;
					}
				}
			}
		}
		
		// Iterate over the folders if they exist
		if ($folderList !== false)
		{
			foreach ($folderList as $folder)
			{
				$tmp = new JObject();
				$tmp->name = basename($folder);
				$tmp->path = str_replace(DS, '/', JPath::clean($basePath . DS . $folder));
				$tmp->path_relative = str_replace($mediaBase, '', $tmp->path);
				$count = MediaHelper::countFiles($tmp->path);
				$tmp->files = $count[0];
				$tmp->folders = $count[1];
				
				$folders[] = $tmp;
			}
		}
		
		$list = array('folders' => $folders, 'docs' => $docs, 'images' => $images);
		
		return $list;
	}

	function getFolderList($base = null)
	{
		jimport('joomla.filesystem.folder');
		
		$folders = JFolder::folders(JPATH_ROOT . '/images', '.', true, true);
		
		// Build the array of select options for the folder list
		$options[] = JHtml::_('select.option', "", "/");
		
		foreach ($folders as $folder)
		{
			//$folder		= str_replace(COM_MEDIA_BASE, "", $folder);
			$folder = str_replace(JPATH_ROOT . '/images', "", $folder);
			$value = substr($folder, 1);
			$text = str_replace(DS, "/", $folder);
			$options[] = JHtml::_('select.option', $value, $text);
		}
		
		// Sort the folder list array
		if (is_array($options))
		{
			sort($options);
		}
		
		// Create the drop-down folder select list
		$asset = JRequest::getVar('asset');
		$author = JRequest::getVar('author');
		$list = JHtml::_('select.genericlist', $options, 'folderlist', 
			"class=\"inputbox\" size=\"1\" onchange=\"ImageManager.setFolder(this.options[this.selectedIndex].value,'" . $asset . "','$author'" .
				 ")\" ", 'value', 'text', $base);
		
		return $list;
	}
}