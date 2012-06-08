<?php
/**
 * @package		Pro Image Crop
 * @subpackage	com_proimagecrop
 * @copyright	Copyright (C) AtomTech, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die();

$user = JFactory::getUser();

$document = &JFactory::getDocument();
$document->addStyleSheet('../media/com_proimagecrop/css/imgareaselect-default.css');
$document->addStyleSheet('../media/com_proimagecrop/css/css/format.css');
$document->addScript('../media/com_proimagecrop/js/jquery.min.js');
$document->addScript('../media/com_proimagecrop/js/jquery.imgareaselect.pack.js');
$document->addScript('../media/com_proimagecrop/js/insertintoeditor.js');
?>
<script type="text/javascript">
	function preview(img, selection) {
		if (!selection.width || !selection.height)
			return;
		var scaleX = <?php echo $this->thumbWidth; ?> / selection.width;
		var scaleY = <?php echo $this->thumbHeight; ?> / selection.height;
		$('#preview img').css({
			width: Math.round(scaleX * <?php echo $this->imageWidth; ?>),
			height: Math.round(scaleY * <?php echo $this->imageHeight; ?>),
			marginLeft: -Math.round(scaleX * selection.x1),
			marginTop: -Math.round(scaleY * selection.y1)
		});
		$('#x1').val(selection.x1);
		$('#y1').val(selection.y1);
		$('#x2').val(selection.x2);
		$('#y2').val(selection.y2);
		$('#w').val(selection.width);
		$('#h').val(selection.height);    
	}
	
	$(function () {
		$('#photo').imgAreaSelect({ aspectRatio: '<?php echo $this->thumbWidth; ?>:<?php echo $this->thumbHeight; ?>', handles: true, fadeSpeed: 200, onSelectChange: preview });
	});
</script>
<form action="index.php?option=com_proimagecrop&amp;task=crop.preview" id="imageForm" name="imageForm" method="post" enctype="multipart/form-data">
	<?php if ($this->tmpl == 'component') : ?>
	<input type="hidden" name="tmpl" value="component" /> <input type="hidden" name="e_name" value="<?php echo $this->e_name; ?>" />
	<?php endif ?>
    <fieldset>
		<legend><?php echo JText::_('COM_PROIMAGECROP_CROP_ORIGINAL_IMAGE'); ?></legend>
		<div class="container">
			<div id="original_image">
				<div class="frame" style="margin: 0 0.3em;  width:<?php echo $this->imageWidth; ?>px; height:<?php echo $this->imageHeight; ?>px;">
					<img id="photo" src="<?php echo $this->imageURL; ?>" width="<?php echo $this->imageWidth; ?>" height="<?php echo $this->imageHeight; ?>" />
				</div>
			</div>
		</div>
	</fieldset>
	<fieldset>
		<legend><?php echo JText::_('COM_PROIMAGECROP_CROP_PREVIEW'); ?></legend>
		<div class="container">
			<div id="preview_image">
				<div class="frame" id="format_preview" style="width: <?php echo $this->thumbWidth; ?>px; height: <?php echo $this->thumbHeight; ?>px;">
					<div id="preview" style="width: <?php echo $this->thumbWidth; ?>px; height: <?php echo $this->thumbHeight; ?>px; overflow: hidden;">
						<img src="<?php echo $this->imageURL; ?>" style="width: <?php echo $this->thumbWidth; ?>px; height: <?php echo $this->thumbHeight; ?>px;" />
					</div>
				</div>
			</div>
		</div>
		<div style="display: none;">
			<table style="margin-top: 1em;">
				<thead>
					<tr>
						<th colspan="2" style="font-size: 110%; font-weight: bold; text-align: left; padding-left: 0.1em;">
							<?php echo JText::_('Coordinates'); ?>
						</th>
						<th colspan="2" style="font-size: 110%; font-weight: bold; text-align: left; padding-left: 0.1em;">
							<?php echo JText::_('Dimensions'); ?>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td style="width: 10%;"><b>X<sub>1</sub>:
						</b></td>
						<td style="width: 30%;"><input type="text" name="x1" id="x1" value="-" /></td>
						<td style="width: 20%;"><b><?php JText::_('Width'); ?>:</b></td>
						<td><input type="text" value="-" name="w" id="w" /></td>
					</tr>
					<tr>
						<td><b>Y<sub>1</sub>:
						</b></td>
						<td><input type="text" name="y1" id="y1" value="-" /></td>
						<td><b><?php JText::_('Height'); ?>:</b></td>
						<td><input type="text" name="h" id="h" value="-" /></td>
					</tr>
					<tr>
						<td><b>X<sub>2</sub>:
						</b></td>
						<td><input type="text" name="x2" id="x2" value="-" /></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td><b>Y<sub>2</sub>:
						</b></td>
						<td><input type="text" name="y2" id="y2" value="-" /></td>
						<td></td>
						<td></td>
					</tr>
				</tbody>
			</table>
		</div>
	</fieldset>
	<fieldset>
		<legend><?php echo JText::_('COM_PROIMAGECROP_CROP_INFO'); ?></legend>
		<div class="fltlft">
			<p>
				<?php echo JText::_('COM_PROIMAGECROP_CROP_DESC'); ?>
			</p>
		</div>
		<div class="fltrt">
			<a href="#" alt="next" onclick="return checkcrop();"><img src="../media/com_proimagecrop/images/next-icon.png" alt="<?php echo JText::_('JNEXT') ?>" title="<?php echo JText::_('JNEXT') ?>" /></a>
		</div>
	</fieldset>
	<?php echo JHTML::_('form.token'); ?>
  	<input type="hidden" name="formatID" id="formatID" value="<?php echo $this->formatID; ?>" />
  	<input type="hidden" name="OriginalImageName" id="OriginalImageName" value="<?php echo $this->imageURL; ?>" />
  	<input type="hidden" name="imagePath" id="imagePath" value="<?php echo $this->imagePath; ?>" />
  	<input type="hidden" name="ThumbWidth" id="ThumbWidth" value="<?php echo $this->thumbWidth; ?>" />
  	<input type="hidden" name="ThumbHeight" id="ThumbHeight" value="<?php echo $this->thumbHeight; ?>" />
</form>
