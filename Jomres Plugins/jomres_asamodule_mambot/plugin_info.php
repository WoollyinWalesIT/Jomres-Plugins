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

	class plugin_info_jomres_asamodule_mambot
	{
		function __construct()
		{
			$this->data=array(
				"name"=>"jomres_asamodule_mambot",
				"category"=>"Site Building Tools",
				"version"=>(float)"2.6",
				"description"=> "Joomla plugin (aka mambot). See the Jomres admin > Tools > Shortcodes page for information on how to insert Jomres content into pages.",
				"type"=>"mambot",
				"lastupdate"=>"2023/04/25",
				"min_jomres_ver"=>"10.5.6",
				'change_log'=>'v2.2 Updated to work with J4 v2.3 Reset $_REQUEST after the shortcode has been run. v2.4 Modified regex so that we can use WP style shortcodes in Joomla, which simplifies documentation. 2.5 Added flags to indicate if this is a shortcode call. v2.6 Added a special task that will include /jomres/jomres.php. This allows shortcodes to use {jomres cpanel} to access Jomres. It means that we can put Jomres into a hidden menu (i.e. it is not necessary to have a menu item for Jomres in the main menu). Menu items that are limited to, for example, Register users will not then work for normal guests. This is a workaround for that issue. ',
				'highlight'=>'Use the Jomres plugin manager to add it to your system, then use Joomla\'s Discover feature to install it. After that, use the Joomla Plugin Manager to enable the plugin. <p><i>Cannot be uninstalled via the Jomres plugin manager, you must use the Joomla Extension Manager instead.</i></p>',
				"manual_link"=>'http://www.jomres.net/manual/site-managers-guide/15-core-plugins/112-jomres-asamodule-mambot',
				'free'=>true
			);
		}
	}
