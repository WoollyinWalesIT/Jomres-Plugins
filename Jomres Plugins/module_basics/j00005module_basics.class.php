<?php
/**
* Jomres CMS Agnostic Plugin
* @author Woollyinwales IT <sales@jomres.net>
* @version Jomres 9 
* @package Jomres
* @copyright	2005-2015 Woollyinwales IT
* Jomres (tm) PHP files are released under both MIT and GPL2 licenses. This means that you can choose the license that best suits your project.
**/

// ################################################################
defined( '_JOMRES_INITCHECK' ) or die( 'Direct Access to this file is not allowed.' );
// ################################################################

class j00005module_basics
	{
	function __construct()
		{
		$MiniComponents =jomres_getSingleton('mcHandler');
		if ($MiniComponents->template_touch)
			{
			$this->template_touchable=false; return;
			}
		if (file_exists(get_showtime('ePointFilepath').'language'.JRDS.get_showtime('lang').'.php'))
			require_once(get_showtime('ePointFilepath').'language'.JRDS.get_showtime('lang').'.php');
		else
			{
			if (file_exists(get_showtime('ePointFilepath').'language'.JRDS.'en-GB.php'))
				require_once(get_showtime('ePointFilepath').'language'.JRDS.'en-GB.php');
			}

		$property_uid = getDefaultProperty();

        if ($property_uid > 0) {
            $mrConfig = getPropertySpecificSettings($property_uid);

            if ($mrConfig[ 'is_real_estate_listing' ] != '1' && !get_showtime('is_jintour_property') && $mrConfig[ 'singleRoomProperty' ] == 1) {
                $thisJRUser = jomres_singleton_abstract::getInstance('jr_user');
                $jomres_menu = jomres_singleton_abstract::getInstance('jomres_menu');
                if ($thisJRUser->accesslevel >= 70) {
                    $jomres_menu->add_item(80, jr_gettext('_JOMRES_MODULE_BASICS', '_JOMRES_MODULE_BASICS', false), 'module_basics_config', 'fa-list');
                    }
                }
            }
		}

	// This must be included in every Event/Mini-component
	function getRetVals()
		{
		return null;
		}
	}
