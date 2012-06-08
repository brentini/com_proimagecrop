<?php
/**
 * @package     Pro Image Crop
 * @subpackage  com_proimagecrop
 * @copyright   Copyright (C) AtomTech, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
$canDo = ProImageCropHelper::getActions();
?>
<form action="<?php echo JRoute::_('index.php?option=com_proimagecrop&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="format-form" class="form-validate">
    <div class="width-60 fltlft">
        <fieldset class="adminform">
            <legend><?php echo empty($this->item->id) ? JText::_('COM_PROIMAGECROP_FORMAT_ADD') : JText::sprintf('COM_PROIMAGECROP_FORMAT_EDIT', $this->item->id); ?></legend>
            <ul class="adminformlist">
                <?php if ($this->item->id): ?>
                    <li><?php echo $this->form->getLabel('id'); ?>
                    <?php echo $this->form->getInput('id'); ?></li>
                <?php endif ?>

                <li><?php echo $this->form->getLabel('name'); ?>
                <?php echo $this->form->getInput('name'); ?></li>

                <?php if ($canDo->get('core.edit.state')) : ?>
                    <li><?php echo $this->form->getLabel('published'); ?>
                    <?php echo $this->form->getInput('published'); ?></li>
                <?php endif; ?>

                <li><?php echo $this->form->getLabel('ordering'); ?>
                <?php echo $this->form->getInput('ordering'); ?></li>
                <li><?php echo $this->form->getLabel('description'); ?>
                <?php echo $this->form->getInput('description'); ?></li>
            </ul>
        </fieldset>
    </div>
    <div class="width-40 fltrt">
        <?php echo $this->loadTemplate('properties'); ?>
    </div>
    <div>
        <input type="hidden" name="task" value="" />
        <?php echo JHtml::_('form.token'); ?>
    </div>
    <div class="clr"></div>
</form>
