<?php
/**
 * @package     Pro Image Crop
 * @subpackage  com_proimagecrop
 * @copyright   Copyright (C) AtomTech, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die();
?>
<form action="index.php" id="imageForm" method="post">
	<fieldset>
		<legend><?php echo JText::_('COM_PROIMAGECROP_CROP_IMAGE_CROPPED') ?></legend>
		<div class="fltlft">
			<!--<div style="float: left;">
				<img src="<?php echo $this->croppedUrl ?>" />
			</div>-->
			<div>
				<ul class="marginlist">
					<li><div class="plugin_label"><?php echo JText::_('COM_PROIMAGECROP_FILENAME') ?>:</div>
					<?php echo $this->fileName ?></li>
					<li><div class="plugin_label"><?php echo JText::_('COM_PROIMAGECROP_IMAGE_PATH') ?>:</div>
					<?php echo $this->cropPath ?></li>
					<li><div class="plugin_label"><?php echo JText::_('COM_PROIMAGECROP_IMAGE_DIMENSION') ?>:</div>
					<?php echo $this->imageDimension ?></li>
					<?php if ($this->insertButton) : ?>
					<li>
						<div class="plugin_label"><?php echo JText::_('Url Immagine') ?>:</div>
						<?php echo $this->cropPath.$this->fileName ?>
						<input type="hidden" id="f_url" value="<?php echo $this->cropPath.$this->fileName ?>" />
					</li>
					<?php endif ?>
					<li>
						<div class="plugin_label"><?php echo JText::_('COM_PROIMAGECROP_FIELD_FILE_NAME_LABEL') ?>:</div>
						<input type="text" id="f_alt" value="<?php  echo basename($this->fileName) ?>" />
					</li>
					<?php if ($this->alignment) : ?>
					<li>
						<div class="plugin_label"><?php echo JText::_('COM_PROIMAGECROP_FIELD_ALIGN_LABEL') ?>:</div>
						<?php echo $this->alignment ?>
					</li>
					<?php endif ?>
					<li>
						<div class="plugin_label"><?php echo JText::_('COM_PROIMAGECROP_FIELD_TITLE_IMAGE_LABEL') ?>:</div>
						<input type="text" id="f_title" value="<?php echo basename($this->fileName) ?>" />
					</li>
					<li>
						<div class="plugin_label"><?php echo JText::_('COM_PROIMAGECROP_FIELD_USE_CAPTION_LABEL') ?>:</div>
						<input type="checkbox" id="f_caption" />
					</li>
					<li>
						<div class="plugin_label"><?php echo JText::_('COM_PROIMAGECROP_FIELD_MARGIN_LABEL') ?>:</div>
						<?php echo JText::_('COM_PROIMAGECROP_OPTION_TOP') ?>
						<input type="text" id="f_margin_top" size="3" value="<?php echo $this->Margin['top'] ?>" />&nbsp;&nbsp;
						<?php echo JText::_('COM_PROIMAGECROP_OPTION_RIGHT') ?>
						<input type="text" id="f_margin_right" size="3" value="<?php echo $this->Margin['right'] ?>" />&nbsp;&nbsp;
						<?php echo JText::_('COM_PROIMAGECROP_OPTION_BOTTOM') ?>
						<input type="text" id="f_margin_bottom" size="3" value="<?php echo $this->Margin['bottom'] ?>" />&nbsp;&nbsp;
						<?php echo JText::_('COM_PROIMAGECROP_OPTION_LEFT') ?>
						<input type="text" id="f_margin_left" size="3" value="<?php echo $this->Margin['left'] ?>" />
					</li>
				</ul>
				<input type="hidden" name="e_name" id="e_name" value="<?php echo $this->e_name ?>" />
				<input type="hidden" name="f_url" value="<?php echo $this->cropPath.$this->fileName ?>" />
				<input type="button" onclick="insertintoeditor();window.parent.SqueezeBox.close();"	name="insertIntoEditor" value="<?php echo JText::_('JAPPLY') ?>" />
				<input type="button" onclick="window.parent.SqueezeBox.close();" value="<?php echo JText::_('JCANCEL') ?>" />
			</ul>
		</div>
    </fieldset>
</form>
