<?php
/**
 * Core file.
 *
 * @author Vince Wooll <sales@jomres.net>
 *
 *  @version Jomres 10.3.1
 *
 * @copyright	2005-2022 Vince Wooll
 * Jomres (tm) PHP, CSS & Javascript files are released under both MIT and GPL2 licenses. This means that you can choose the license that best suits your project, and use it accordingly
 **/

// ################################################################
defined('_JOMRES_INITCHECK') or die('');
// ################################################################
	
	/**
	 * @package Jomres\Core\Minicomponents
	 *
	 * Includes the get_booking_url.php function script. Identified as a function that is regularly modified by users, it is delivered in this format so that  you don't need to be a coder to create your own version of this function. 
	 * 
	 */

class j00001functioncall_get_booking_url
{	
	/**
	 *
	 * Constructor
	 * 
	 * Main functionality of the Minicomponent 
	 *
	 * 
	 * 
	 */
	 
	public function __construct()
	{
		// Must be in all minicomponents. Minicomponents with templates that can contain editable text should run $this->template_touch() else just return
		$MiniComponents = jomres_singleton_abstract::getInstance('mcHandler');
		if ($MiniComponents->template_touch) {
			$this->template_touchable = false;

			return;
		}
		$ePointFilepath = get_showtime('ePointFilepath');

		$siteConfig = jomres_singleton_abstract::getInstance('jomres_config_site_singleton');
		$jrConfig = $siteConfig->get();

		if (!isset($jrConfig['nbe_booking_form_override_local_form'])) {
			$jrConfig['nbe_booking_form_override_local_form'] = false;
		}

		if ( (bool)$jrConfig['nbe_booking_form_override_local_form'] === true ) {
			require_once $ePointFilepath.'get_booking_url.php';
		} else {
			require_once JOMRES_FUNCTIONS_ABSPATH.'get_booking_url.php';
		}

	}

	public function getRetVals()
	{
		return null;
	}
}