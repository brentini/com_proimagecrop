<?php
/**
 * @package		Pro Image Crop
 * @subpackage	com_proimagecrop
 * @copyright	Copyright (C) AtomTech, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die();

jimport('joomla.application.component.controllerform');

/**
 * Crop controller class.
 *
 * @package     Pro Image Crop
 * @subpackage  com_proimagecrop
 * @since       2.5
 */
class ProImageCropControllerCrop extends JControllerForm
{

	/**
	 * @var    string  The prefix to use with controller messages.
	 * @since  2.5
	 */
	protected $text_prefix = 'COM_PROIMAGECROP_CROP';

	/**
	 * Method to edit an existing override
	 *
	 * @param	string	$key		The name of the primary key of the URL variable (not used here).
	 * @param	string	$urlVar	The name of the URL variable if different from the primary key (not used here).
	 *
	 * @return	void
	 *
	 * @since	2.5
	 */
	public function edit($key = null, $urlVar = null)
	{
		$var['image_path'] = JRequest::getVar('image_path');
		$var['format_scelta'] = JRequest::getVar('format_scelta');
		
		print $var['format_scelta'];
		
		if ($var['image_path'] == '' && $var['format_scelta'] == '')
		{
			$error = JText::_('COM_PROIMAGECROP_MESSAGE_SELECT_IMAGE_AND_CROP_FORMAT');
		}
		elseif ($var['image_path'] == '')
		{
			$error = JText::_('COM_PROIMAGECROP_MESSAGE_SELECT_IMAGE');
		}
		elseif ($var['format_scelta'] == '')
		{
			$error = JText::_('COM_PROIMAGECROP_MESSAGE_SELECT_CROP_FORMAT');
		}
		
		if ($error != '')
		{
			JError::raiseWarning(500, $error);
			$url = 'index.php?option=com_proimagecrop';
		}
		else
		{
			$ar = base64_encode(serialize($var));
			$url = 'index.php?option=com_proimagecrop&view=crop&layout=edit&ar=' . $ar;
			;
		}
		
		$tmpl = JRequest::getVar('tmpl');
		
		if ($tmpl == 'component')
		{
			$url .= '&tmpl=component';
			$e_name = JRequest::getVar('e_name');
			$url .= '&e_name=' . $e_name;
		}
		
		$this->setRedirect($url);
	}

	/**
	 * 
	 */
	function preview()
	{
		$tmpl = JRequest::getVar('tmpl');
		$formatID = JRequest::getVar('formatID');
		$cropped = $this->savedfile();
		$url = 'index.php?option=com_proimagecrop&view=crop&layout=preview';
		if ($tmpl == 'component')
		{
			$url .= '&tmpl=component';
			$e_name = JRequest::getVar('e_name');
			$url .= '&e_name=' . $e_name;
		}
		$url .= '&formatID=' . $formatID;
		$url .= '&cropped=' . $cropped;
		
		$this->setRedirect($url);
	}

	/**
	 * 
	 */
	function savedfile()
	{
		require_once JPATH_COMPONENT . DS . 'helpers' . DS . 'proimagecrop.php';
		
		//Informazioni dell'area di crop
		$x1 = JRequest::getVar('x1');
		$x2 = JRequest::getVar('x2');
		$y1 = JRequest::getVar('y1');
		$y2 = JRequest::getVar('y2');
		$w = JRequest::getVar('w');
		$h = JRequest::getVar('h');
		
		//Informazioni sull'immagine desiderata
		$ThumbWidth = JRequest::getVar('ThumbWidth'); //Width che si desidera raggiungere		
		$ThumbHeight = JRequest::getVar('ThumbHeight'); //Haight che si desidera raggiungere	
		
		//Fattore di scale
		$scale = $ThumbWidth / $w;
		
		$imagePath = JRequest::getVar('imagePath'); //Es path: images/nome.extension
		
		//Costruisco il path assoluto del server per l'immagine di origine
		$largeImageLocation = JPath::clean(JPATH_ROOT . DS . $imagePath);
		
		$OriginalImageName = basename($imagePath); //ritorna il nome.estenzione dal path di origine dell'immagine
		//Recupero dimenzioni reali immagine di origine
		list ($imagewidth, $imageheight, $imageType) = getimagesize($largeImageLocation);
		
		//recupero dalla configurazione il path di salvataggio finale compreso dello / iniziale non non quello finale. Es: /images/crop
		$config = JComponentHelper::getParams('com_proimagecrop');
		$cropPath = $config->get('cropPath');
		
		if ($cropPath == "")
		{
			$cropPath = "images";
		}
		
		$template = JRequest::getVar('tmpl');
		if ($template == "component")
		{
			//Verifico sia abilitato l'autoresize per il plugin
			$resizePlugin = $config->get('resizePlugin');
			$maxWidthPlugin = $config->get('maxWidthPlugin');
			
			if ($resizePlugin == 1 && $imagewidth > $maxWidthPlugin)
			{
				$ratio = $imagewidth / $maxWidthPlugin;
				$x1 = ceil($x1 * $ratio);
				$y1 = ceil($y1 * $ratio);
				$x2 = ceil($x2 * $ratio);
				$y2 = ceil($y2 * $ratio);
				$w = ceil($w * $ratio);
				$h = ceil($h * $ratio);
			}
		}
		else
		{
			//Verifico sia abilitato l'autoresize per il componente
			$resizeComponent = $config->get('resizeComponent');
			$maxWidthComponent = $config->get('maxWidthComponent');
			
			if ($resizeComponent == 1 && $imagewidth > $maxWidthComponent)
			{
				$ratio = $imagewidth / $maxWidthComponent;
				$x1 = ceil($x1 * $ratio);
				$y1 = ceil($y1 * $ratio);
				$x2 = ceil($x2 * $ratio);
				$y2 = ceil($y2 * $ratio);
				$w = ceil($w * $ratio);
				$h = ceil($h * $ratio);
			}
		}
		$thumbImageName = $ThumbWidth . 'x' . $ThumbHeight . '_' . $OriginalImageName;
		
		$thumbImageLocation = $this->checkFileName(JPath::clean(JPATH_ROOT . DS . $cropPath . DS . $thumbImageName));
		
		$cropped = $this->resizeThumbnailImage($thumbImageLocation, $largeImageLocation, $w, $h, $x1, $y1, $scale, $ThumbWidth, $ThumbHeight);
		
		return $cropped;
	}

	/**
	   * 
	   */
	function resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale, $newImageWidth, $newImageHeight)
	{
		list ($imagewidth, $imageheight, $imageType) = getimagesize($image);
		$imageType = image_type_to_mime_type($imageType);
		if (!isset($newImageWidth) || $newImageWidth == 0)
		{
			$newImageWidth = ceil($width * $scale);
		}
		if (!isset($newImageHeight) || $newImageHeight == 0)
		{
			$newImageHeight = ceil($height * $scale);
		}
		$newImage = imagecreatetruecolor($newImageWidth, $newImageHeight);
		switch ($imageType)
		{
			case "image/gif":
				$source = imagecreatefromgif($image);
				break;
			case "image/pjpeg":
			case "image/jpeg":
			case "image/jpg":
				$source = imagecreatefromjpeg($image);
				break;
			case "image/png":
			case "image/x-png":
				$source = imagecreatefrompng($image);
				break;
		}
		imagecopyresampled($newImage, $source, 0, 0, $start_width, $start_height, $newImageWidth, $newImageHeight, $width, $height);
		switch ($imageType)
		{
			case "image/gif":
				imagegif($newImage, $thumb_image_name);
				break;
			case "image/pjpeg":
			case "image/jpeg":
			case "image/jpg":
				imagejpeg($newImage, $thumb_image_name, 90);
				break;
			case "image/png":
			case "image/x-png":
				imagepng($newImage, $thumb_image_name);
				break;
		}
		
		return $thumb_image_name;
	}

	/**
	 * 
	 */
	function upload()
	{
		jimport('joomla.filesystem.file');
		
		// Check for request forgeries
		JRequest::checkToken('request') or jexit(JText::_('JINVALID_TOKEN'));
		
		// Get the user
		$user = JFactory::getUser();
		
		// Get some data from the request
		$file = JRequest::getVar('Filedata', '', 'files', 'array');
		$folder = JRequest::getVar('folder', '', '', 'path');
		$return = JRequest::getVar('return-url', null, 'post', 'base64');
		
		// Set FTP credentials, if given
		jimport('joomla.client.helper');
		JClientHelper::setCredentialsFromRequest('ftp');
		
		// Set the redirect
		if ($return)
		{
			$this->setRedirect(base64_decode($return) . '&folder=' . $folder);
		}
		
		// Make the filename safe
		$file['name'] = JFile::makeSafe($file['name']);
		
		if (isset($file['name']))
		{
			// The request is valid
			$err = null;		

			JPath::setPermissions(JPATH_ROOT . DS . 'images' . DS, '0775', '0775');
			$filepath = JPath::clean(JPATH_ROOT . DS . 'images' . DS . $folder . DS . strtolower($file['name']));
			
			// Trigger the onContentBeforeSave event.
			JPluginHelper::importPlugin('content');
			$dispatcher = JDispatcher::getInstance();
			$object_file = new JObject($file);
			$object_file->filepath = $filepath;
			$result = $dispatcher->trigger('onContentBeforeSave', array('com_media.file', &$object_file));
			
			if (in_array(false, $result, true))
			{
				// There are some errors in the plugins
				JError::raiseWarning(100, 
					JText::plural('COM_MEDIA_ERROR_BEFORE_SAVE', count($errors = $object_file->getErrors()), implode('<br />', $errors)));
				return false;
			}
			
			$file = (array) $object_file;
			
			if (JFile::exists($file['filepath']))
			{
				// File exists
				JError::raiseWarning(100, JText::_('COM_PROIMAGECROP_ERROR_FILE_EXISTS'));
				//return false;
			}
			
			if (!JFile::upload($file['tmp_name'], $file['filepath']))
			{
				// Error in upload
				JError::raiseWarning(100, JText::_('COM_PROIMAGECROP_ERROR_UNABLE_TO_UPLOAD_FILE'));
				return false;
			}
			else
			{
				// Trigger the onContentAfterSave event.
				$dispatcher->trigger('onContentAfterSave', array('com_media.file', &$object_file));
				$this->setMessage(JText::sprintf('COM_PROIMAGECROP_UPLOAD_COMPLETE', substr($file['filepath'], strlen(COM_MEDIA_BASE))));
				
				return true;
			}
		}
		else
		{
			$this->setRedirect('index.php', JText::_('COM_PROIMAGECROP_INVALID_REQUEST'), 'error');
			return false;
		}
	}

	/**
	 * 
	 */
	protected function checkFileName($path, $count = 0)
	{
		if (file_exists($path))
		{
			$i = $count + 1;
			$path_parts = pathinfo($path);
			$dirname = $path_parts['dirname'];
			$filename = $path_parts['filename'];
			
			if ($count > 0)
			{
				$filename = str_replace("__" . $count, "__" . $i, $filename);
			}
			else
			{
				$filename = $filename . "__" . $i;
			}
			$estensione = $path_parts['extension'];
			
			$new_path = $dirname . DS . $filename . "." . $estensione;
			return $this->checkFileName($new_path, $i);
		}
		else
		{
			return $path;
		}
	}
}
