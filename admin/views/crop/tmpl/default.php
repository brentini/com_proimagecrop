<?php
/**
 * @package		Pro Image Crop
 * @subpackage	com_proimagecrop
 * @copyright	Copyright (C) AtomTech, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die();

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

$canDo = ProImageCropHelper::getActions();
$user = JFactory::getUser();
$params = JComponentHelper::getParams('com_media');
?>
<script type='text/javascript'>
	var image_base_path = '<?php echo $params->get('image_path', 'images') ?>/';

	function submitCrop()
	{
		var formatvalue = document.getElementById("format_scelta").value;
		document.getElementById("format_scelta_h").value = formatvalue;
		document.imageForm.submit();
	}
</script>
<div class="width-30 fltlft">
	<fieldset class="adminform">
		<legend><?php echo JText::_('COM_PROIMAGECROP_CROP_FORMAT_IMAGE') ?></legend>
		<div class="fltlft">
			<?php echo $this->formats ?>
		</div>
		<div class="fltrt">
			<a href="#" alt="next" onclick="submitCrop();"><img src="../media/com_proimagecrop/images/next-icon.png" alt="<?php echo JText::_('JNEXT') ?>" title="<?php echo JText::_('JNEXT') ?>" /></a>
		</div>
	</fieldset>
	<?php if ($this->showUploader) : ?>
	<form action="<?php echo JURI::base(); ?>index.php?option=com_proimagecrop&amp;task=crop.upload&amp;tmpl=component&amp;<?php echo $this->session->getName().'='.$this->session->getId(); ?>&amp;<?php echo JUtility::getToken();?>=1&amp;asset=<?php echo JRequest::getCmd('asset');?>&amp;author=<?php echo JRequest::getCmd('author');?>&amp;format=<?php /*echo $this->config->get('enable_flash')=='1' ? 'json' : '' */?>" id="uploadForm" name="uploadForm" method="post" enctype="multipart/form-data">
		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_PROIMAGECROP_CROP_SEND_IMAGE') ?></legend>
			<?php echo $this->folderList; ?>
			<button type="button" id="upbutton" title="<?php echo JText::_('COM_EASYCROP_DIRECTORY_UP'); ?>"><?php echo JText::_('COM_PROIMAGECROP_UP') ?></button>
			<fieldset id="upload-noflash" class="actions">
				<input type="file" id="upload-file" name="Filedata" />
				<input type="submit" id="upload-submit" value="<?php echo JText::_('COM_PROIMAGECROP_START_UPLOAD') ?>" />
			</fieldset>
			<?php
			$template = "";
			if (JRequest::getCmd('tmpl') == 'component')
			{
				$template = "&tmpl=component";
			}
			?>
			<input type="hidden" name="return-url" value="<?php echo base64_encode('index.php?option=com_proimagecrop'.$template.'&view=crop&fieldid='.JRequest::getCmd('fieldid', '').'&e_name='.JRequest::getCmd('e_name').'&asset='.JRequest::getCmd('asset').'&author='.JRequest::getCmd('author')) ?>" />
		</fieldset>
	</form>
	<?php endif ?>
</div>
<div class="width-70 fltrt">
	<form action="<?php echo JRoute::_('index.php?option=com_proimagecrop&amp;task=crop.edit') ?>" method="post" name="imageForm" id="imageForm" enctype="multipart/form-data">
		<fieldset class="adminform">
			<div id="messages" style="display: none;">
				<span id="message"></span> <?php echo JHTML::_('image','com_proimagecrop/dots.gif', '...', array('width' =>22, 'height' => 12), true)?>
			</div>
			<legend><?php echo JText::_('COM_PROIMAGECROP_CROP_SELECT_IMAGE') ?></legend>
			<iframe id="imageframe" name="imageframe" src="index.php?option=com_media&amp;view=imagesList&amp;tmpl=component&amp;folder=<?php echo $this->state->folder?>&amp;asset=<?php echo JRequest::getCmd('asset') ?>&amp;author=<?php echo JRequest::getCmd('author') ?>"></iframe>
			<input type="text" id="f_url" value="" name="image_path" />
			<input type="hidden" id="format_scelta_h" value="" name="format_scelta" />
			<?php if ($this->tmpl == 'component') : ?>
			<input type="hidden" name="tmpl" value="component" />
			<input type="hidden" name="e_name" value="<?php echo $this->e_name ?>" />
			<?php endif ?>
		</fieldset>
	</form>
</div>