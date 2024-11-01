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
defined( '_JOMRES_INITCHECK' ) or die( '' );
// ################################################################

class plugin_info_bootstrap_5_property_types_display
	{
	function __construct()
		{
		$this->data=array(
			"name"=>"bootstrap_5_property_types_display",
			"category"=>"Site Building Tools",
			"version"=>(float)"1.7",
			"description"=> 'Shows images for various property types in a row. Remember to visit Admin > Settings > Media centre and upload images for property types (new in 10.1.2). Has optional ability to only show properties from X region and Y country. See Shortcodes page in admin area for arguments to be used with this plugin',
			"type"=>"module",
			"lastupdate"=>"2022/11/08",
			"min_jomres_ver"=>"10.6.0",
			"manual_link"=>'',
			'change_log'=>'v1.1 b5ptc_property_type_uids argument is now optional 1.2 shortcode updated v1.3 Markup significantly improved. v1.4 Added a new alternate template with numbers at the side. b5ptc_alternate_template option 1. v1.5 Added new carousel template. Set template option b5ptc_alternate_template to 2 v1.6 Documentation updated v1.7 Improved behavour & markup',
			'highlight'=>'',
			'image'=>'',
			'demo_url'=>'',
            'compatability'=>['Bootstrap 5'],
			"author"=>"Vince Wooll",
			"authoremail"=>"sales@jomres.net",
			"authorurl"=>"http://www.jomres.net",
			);
		}
	}