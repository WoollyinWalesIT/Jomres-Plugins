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

class plugin_info_property_details_standalone_map
	{
	function __construct()
		{
		$this->data=array(
			"name"=>"property_details_standalone_map",
			"category"=>"Site Building Tools",
			"marketing"=>"Generates a map that can be used in a sidebar (or other area).",
			"version"=>(float)"1.5",
			"description"=> "This plugin allows you to add a map to something like a sidebar. It will only show on the 'viewproperty' page. Use Jomres ASAModule, set the task to 'property_details_standalone_map' and the arguments to '&mapwidth=100&mapheight=200' or set some other width and height values that suit your requirements.",
            "lastupdate"=>"2021/10/25",
			"min_jomres_ver"=>"9.9.10",
			"manual_link"=>'http://www.jomres.net/manual/site-managers-guide/15-core-plugins/314-property-details-standalone-map',
			'change_log'=>'v1.0 PHP7 related maintenance. v1.1 Changed how a variable is detected. v1.2 Shortcode info added v1.3 French language file added v1.4 Italian language file added, thanks Nicola v1.5 Language files updated',
			'highlight'=>'',
			'image'=>'https://snippets.jomres.net/plugin_screenshots/jr_house.png',
			'demo_url'=>'',
			"author"=>"Vince Wooll",
			"authoremail"=>"sales@jomres.net",
			"authorurl"=>"http://www.jomres.net",
			);
		}
	}
