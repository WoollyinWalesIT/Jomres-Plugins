<?php
/**
* Jomres CMS Agnostic Plugin
* @author Woollyinwales IT <sales@jomres.net>
* @version Jomres 10.6
* @package Jomres
* @copyright	2005-2023 Woollyinwales IT
* Jomres (tm) PHP files are released under both MIT and GPL2 licenses. This means that you can choose the license that best suits your project.
**/


// ################################################################
defined( '_JOMRES_INITCHECK' ) or die( '' );
// ################################################################

class plugin_info_search_form_elements
	{
	function __construct()
		{
		$this->data=array(
			"name"=>"search_form_elements",
			"category"=>"Search tools",
			"marketing"=>"",
			"version"=>"1.3",
			"description"=> "",
            "lastupdate"=>"2023/05/24",
            "min_jomres_ver"=>"10.7",
			"manual_link"=>'',
			'change_log'=>'v0.2 Added placeholders and fontawesome icons v0.3 Changed z-index of adult and child buttons so that they do not show through calendars. v0.4 Changed how the initial arrival and departure dates are calculated. Removed "disabled" from select lists so that options can be unselected. v0.5 Added hidden fields shortcode. See plugin info for details. v0.6 Allow for prefiltering of features by property type. v0.7 Added onchange templates (see property information plugin for details). v0.8 Added {FORM_ID} to various templates to ensure that adult and child buttons work correctly. v0.9 Improved how arrival and departure dates are initialised. v1.0 Resolved some notices. v1.1 Removed some input classes, we will let a 00001 script configure them. See Blowan j00001template_start.class.php for details. v1.2  Select list markup changes. v1.3 Changed how the countries/regions/towns are passed to search functionality in 10.7 so that the set search selections script can transpose them and they will be stored in the session and used by ajax search composite.',
			'highlight'=>'',
			'image'=>'',
			'demo_url'=>'',
            'free'=>true,
            'compatability'=>['Bootstrap 2','Bootstrap 3','Bootstrap 5'],
			"author"=>"Vince Wooll",
			"authoremail"=>"sales@jomres.net",
			"authorurl"=>"http://www.jomres.net",
			);
		}
	}
