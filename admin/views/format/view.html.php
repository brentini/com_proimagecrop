<?php
/**
 * @package		Pro Image Crop
 * @subpackage	com_proimagecrop
 * @copyright	Copyright (C) AtomTech, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View to edit a format.
 *
 * @package		Pro Image Crop
 * @subpackage	com_proimagecrop
 * @since		2.5
 */
class ProImageCropViewFormat extends JView
{
	protected $form;
	protected $item;
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		// Initialiase variables.
		$this->form	= $this->get('Form');
		$this->item	= $this->get('Item');
		$this->state = $this->get('State');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}
		
		// Get document
		$doc = JFactory::getDocument();
		$doc->addStyleSheet('../media/com_proimagecrop/css/backend.css');

		$this->addToolbar();
		
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	2.5
	 */
	protected function addToolbar()
	{
		JRequest::setVar('hidemainmenu', true);

		$user	= JFactory::getUser();
		$userId	= $user->get('id');
		$isNew	= ($this->item->id == 0);
		$checkedOut= !($this->item->checked_out == 0 || $this->item->checked_out == $userId);
		// Since we don't track these assets at the item level, use the category id.
		$canDo	= ProImageCropHelper::getActions();

		JToolBarHelper::title($isNew ? JText::_('COM_PROIMAGECROP_FORMAT_ADD') : JText::_('COM_PROIMAGECROP_FORMAT_EDIT'), 'format.png');

		// If not checked out, can save the item.
		if (!$checkedOut && ($canDo->get('core.edit') || count($user->getAuthorisedCategories('com_proimagecrop', 'core.create')) > 0)) {
			JToolBarHelper::apply('format.apply');
			JToolBarHelper::save('format.save');

			if ($canDo->get('core.create')) {
				JToolBarHelper::save2new('format.save2new');
			}
		}

		// If an existing item, can save to a copy.
		if (!$isNew && $canDo->get('core.create')) {
			JToolBarHelper::save2copy('format.save2copy');
		}

		if (empty($this->item->id))  {
			JToolBarHelper::cancel('format.cancel');
		}
		else {
			JToolBarHelper::cancel('format.cancel', 'JTOOLBAR_CLOSE');
		}

		JToolBarHelper::divider();
		JToolBarHelper::help('format', $com = true);
	}
}
