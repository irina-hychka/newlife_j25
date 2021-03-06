<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * HTML View class for the HelloWorld Component
 */
class K2AjaxSearchViewK2AjaxSearch extends JView
{
    // Overwriting JView display method
    function display($tpl = null)
    {
        // Assign data to the view
        $this->items = $this->get('Data');
        $this->fields = $this->get('ExtraFields');

        // Check for errors.
        if (count($errors = $this->get('Errors')))
        {
            JLog::add(implode('<br />', $errors), JLog::WARNING, 'jerror');
            return false;
        }

        $session = JFactory::getSession();
        $this->view_mode = $session->get('view_mode', 'short');

        // Display the view
        parent::display($tpl);
    }
}