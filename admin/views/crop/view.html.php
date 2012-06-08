<?php
/**
 * @package		Pro Image Crop
 * @subpackage	com_proimagecrop
 * @copyright	Copyright (C) AtomTech, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die();

jimport('joomla.application.component.view');

/**
 * View to edit a crop.
 *
 * @package		Pro Image Crop
 * @subpackage	com_proimagecrop
 * @since		2.5
 */
class ProImageCropViewCrop extends JView
{

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$canDo = ProImageCropHelper::getActions();
		$config = JComponentHelper::getParams('com_proimagecrop');
		$app = JFactory::getApplication();
		$append = '';
		$layout = JRequest::getVar('layout');
		$tmpl = JRequest::getVar('tmpl');
		$doc = &JFactory::getDocument();
		
		$doc->addStyleSheet('../media/com_proimagecrop/css/backend.css');
		
		if ($tmpl == 'component')
		{
			$this->assignRef('tmpl', $tmpl);
			$e_name = JRequest::getVar('e_name');
			$this->assignRef('e_name', $e_name);
		}
		
		if ($layout == 'preview')
		{
			$e_name = JRequest::getVar('e_name');
			$doc->addScript('../media/com_proimagecrop/js/insertintoeditor.js');
			
			if ($tmpl == 'component')
			{
				$arFormat = &$this->get('formatid');
				
				$arMargin['top'] = $arFormat[0]->margin_top;
				$arMargin['bottom'] = $arFormat[0]->margin_bottom;
				$arMargin['left'] = $arFormat[0]->margin_left;
				$arMargin['right'] = $arFormat[0]->margin_right;
				
				$this->assignRef('Margin', $arMargin);
				
				$currentAlign = ($arFormat[0]->align == '') ? 'default' : $arFormat[0]->align;
				$arAlign = array(
					JHTML::_('select.option', 'default', JText::_('Select Align')), 
					JHTML::_('select.option', 'top', JText::_('Top')), 
					JHTML::_('select.option', 'bottom', JText::_('Bottom')), 
					JHTML::_('select.option', 'left', JText::_('Left')), 
					JHTML::_('select.option', 'right', JText::_('Right')));
				
				$alignment = JHTML::_('select.genericlist', $arAlign, 'f_align', null, 'value', 'text', $currentAlign);
				
				$this->assignRef('alignment', $alignment);
				$insertButton = true;
				$this->assignRef('insertButton', $insertButton);
				$this->assignRef('e_name', $e_name);
			}
			
			$cropped = JRequest::getVar('cropped');
			$pattern = '/' . ereg_replace('/', '\/', JPATH_ROOT) . '\//';
			$path = preg_replace($pattern, '', $cropped, 1);
			$croppedUrl = JURI::root() . preg_replace($pattern, '', $cropped, 1);
			$info = getimagesize($cropped);
			$imageDimention = $info[0] . 'x' . $info[1];
			$fileName = basename($cropped);
			$patternFileName = '/' . ereg_replace('\.', '\.', $fileName) . '/';
			$fileSize = filesize($cropped) . ' byte';
			$fileSizeH = filesize($cropped) / 1024;
			$fileSizeH = (int) $fileSizeH . ' KByte';
			
			$this->assignRef('croppedUrl', $croppedUrl);
			$this->assignRef('fileName', $fileName);
			$this->assignRef('cropPath', preg_replace($patternFileName, '', $path, 1));
			$this->assignRef('imageDimension', $imageDimention);
			$this->assignRef('fileSize', $fileSize);
			$this->assignRef('fileSizeH', $fileSizeH);
		}
		
		if ($layout == 'edit')
		{
			
			$ar = JRequest::getVar('ar');
			$ar = unserialize(base64_decode($ar));
			$image_path = $ar['image_path'];
			$format = explode('|', $ar['format_scelta']);
			$formatID = $format[0];
			$thumbWidth = $format[1];
			$thumbHeight = $format[2];
			$this->assignRef('formatID', $formatID);
			
			// Get image size
			$imageWidth = $this->getSize($image_path, 0);
			$imageHeight = $this->getSize($image_path, 1);
			
			if ($tmpl == 'component')
			{
				$maxWidth = $config->get('maxWidthPlugin');
				$resize = $config->get('resizePlugin');
			}
			else
			{
				$maxWidth = $config->get('maxWidthComponent');
				$resize = $config->get('resizeComponent');
			}
			if ($resize == '1')
			{
				if ($imageWidth > $maxWidth)
				{
					$ratio = ($imageWidth / $maxWidth);
					$imageWidth = $maxWidth;
					$imageHeight = ($imageHeight / $ratio);
				}
			}
			
			$imageURL = JURI::root() . $image_path;
			
			$this->assignRef('imageWidth', $imageWidth);
			$this->assignRef('imageHeight', $imageHeight);
			$this->assignRef('imageURL', $imageURL);
			$this->assignRef('imagePath', $image_path);
			$this->assignRef('thumbWidth', $thumbWidth);
			$this->assignRef('thumbHeight', $thumbHeight);
		}
		
		if (!$layout)
		{
			JHTML::_('stylesheet', 'com_proimagecrop/popup-imagemanager.css', array(), true);
			JHTML::_('script', 'media/popup-imagemanager.js', true, true);
			
			$formats = & $this->get('format');
			
			$i = 0;
			
			foreach ($formats as $format)
			{
				$nopt[$i]['value'] = $format->id . "|" . $format->width . "|" . $format->height;
				$nopt[$i]['text'] = $format->name . " (" . $format->width . " x " . $format->height . ") ";
				$i++;
			}
			
			$this->assignRef('formats', JHTML::_('select.genericlist', $nopt, 'format_scelta', 'class="inputbox"' . '', 'value', 'text', ''));
			
			if ($canDo->get('core.upload'))
			{
				$showUploader = true;
			}
			else
			{
				$showUploader = true;
			}
			
			$this->assignRef('showUploader', $showUploader);
			
			jimport('joomla.client.helper');
			
			$ftp = !JClientHelper::hasCredentials('ftp');
			
			$this->assignRef('image_path', $image_path);
			$this->assignRef('session', JFactory::getSession());
			$this->assignRef('tmpl', $tmpl);
			$this->assignRef('config', $config);
			$this->assignRef('state', $this->get('state'));
			$this->assignRef('folderList', $this->get('folderList'));
			$this->assign('require_ftp', $ftp);
		}
		
		$this->addToolbar($layout);
		
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	2.5
	 */
	protected function addToolbar($layout = 'default')
	{
		require_once JPATH_COMPONENT . '/helpers/proimagecrop.php';
		
		$canDo = ProImageCropHelper::getActions();
		
		if ($layout == 'preview')
		{
			JToolBarHelper::title(JText::_('COM_PROIMAGECROP_CROP_PREVIEW'), 'crop.png');
		}
		elseif ($layout == 'edit')
		{
			JToolBarHelper::title(JText::_('COM_PROIMAGECROP_CROP_SELECT_AREA'), 'crop.png');
		}
		else
		{
			JToolBarHelper::title(JText::_('COM_PROIMAGECROP_CROP_IMAGE'), 'crop.png');
			
			if ($canDo->get('core.admin'))
			{
				JToolBarHelper::preferences('com_proimagecrop');
			}
		}
		
		JToolBarHelper::divider();
		JToolBarHelper::help('crop', $com = true);
	}

	/**
	 * Get the size
	 */
	protected function getSize($image, $a)
	{
		$ar = getimagesize(JPATH_ROOT . DS . $image);
		return $ar[$a];
	}
}
