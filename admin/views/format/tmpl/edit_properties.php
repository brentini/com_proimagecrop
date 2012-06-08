<?php
/**
 * @package     Pro Image Crop
 * @subpackage  com_proimagecrop
 * @copyright   Copyright (C) AtomTech, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
?>
<fieldset class="adminform">
	<legend><?php echo JText::_('COM_PROIMAGECROP_FIELDSET_PROPERTIES'); ?></legend>
	<ul class="adminformlist">
		<li><label title="" for="jform_width" id="jform_width-lbl"><?php echo JText::_('COM_PROIMAGECROP_FIELD_SIZE_LABEL') ?></label>
		<?php echo $this->form->getInput('width'); ?> <span class="divisor">x</span> <?php echo $this->form->getInput('height'); ?></li>
		<li><label title="" for="jform_margin_top" id="jform_margin_top-lbl" aria-invalid="false"><?php echo JText::_('COM_PROIMAGECROP_FIELD_MARGIN_LABEL') ?></label>
		<span class="title">&uarr;</span> <?php echo $this->form->getInput('margin_top'); ?>
		<span class="title">&rarr;</span> <?php echo $this->form->getInput('margin_right'); ?>
		<span class="title">&darr;</span> <?php echo $this->form->getInput('margin_bottom'); ?>
		<span class="title">&larr;</span> <?php echo $this->form->getInput('margin_left'); ?></li>
		<li><?php echo $this->form->getLabel('align'); ?>
		<?php echo $this->form->getInput('align'); ?></li>
	</ul>
</fieldset>
