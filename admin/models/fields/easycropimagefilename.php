<?php
/**
 * @package		Pro Image Crop
 * @subpackage	com_proimagecrop
 * @copyright	Copyright (C) AtomTech, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die();

jimport('joomla.form.formfield');

class JFormFieldProImageCropFileName extends JFormField
{

	public $type = 'ProImageCropFileName';

	protected function getInput()
	{
		// Initialize variables.
		$html = array();
		$link = 'index.php?option=com_proimagecrop&amp;view=image&amp;tmpl=component&amp;field=' . $this->id;
		
		// Initialize some field attributes.
		$attr = $this->element['class'] ? ' class="' . (string) $this->element['class'] . '"' : '';
		$attr .= $this->element['size'] ? ' size="' . (int) $this->element['size'] . '"' : '';
		
		// Initialize JavaScript field attributes.
		$onchange = (string) $this->element['onchange'];
		
		// Load the modal behavior script.
		JHtml::_('behavior.modal', 'a.modal_' . $this->id);
		
		// If external image, we don't need the filename will be required
		$extId = (int) $this->form->getValue('extid');
		if ($extId > 0)
		{
			$readonly = ' readonly="readonly"';
			return '<input type="text" name="' . $this->name . '" id="' . $this->id . '" value="-" ' . $attr . $readonly . ' />';
		}
		
		// Build the script.
		$script = array();
		$script[] = '	function ProImageCropFileName_' . $this->id . '(title) {';
		$script[] = '		document.getElementById("' . $this->id . '_id").value = title;';
		$script[] = '		' . $onchange;
		$script[] = '		SqueezeBox.close();';
		$script[] = '	}';
		
		// Add the script to the document head.
		JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));
		
		$html[] = '<div class="fltlft">';
		$html[] = '	<input type="text" id="' . $this->id . '_id" name="' . $this->name . '" value="' . $this->value . '"' . ' ' . $attr . ' />';
		$html[] = '</div>';
		
		// Create the user select button.
		$html[] = '<div class="button2-left">';
		$html[] = '  <div class="blank">';
		$html[] = '		<a class="modal_' . $this->id . '" title="' . JText::_('COM_PROIMAGECROP_FORM_SELECT_FILENAME') . '"' . ' href="' .
			 ($this->element['readonly'] ? '' : $link) . '"' . ' rel="{handler: \'iframe\', size: {x: 650, y: 375}}">';
		$html[] = '			' . JText::_('COM_PROIMAGECROP_FORM_SELECT_FILENAME') . '</a>';
		$html[] = '  </div>';
		$html[] = '</div>';
		
		return implode("\n", $html);
	}
}