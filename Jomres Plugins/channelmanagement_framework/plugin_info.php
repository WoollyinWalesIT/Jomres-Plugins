<?php
/**
* Jomres CMS Agnostic Plugin
* @author Woollyinwales IT <sales@jomres.net>
* @version Jomres 9 
* @package Jomres
* @copyright	2005-2020 Vince Wooll
* Jomres (tm) PHP files are released under both MIT and GPL2 licenses. This means that you can choose the license that best suits your project.
**/


// ################################################################
defined( '_JOMRES_INITCHECK' ) or die( '' );
// ################################################################

class plugin_info_channelmanagement_framework
	{
	function __construct()
		{
		$this->data=array(
			"name"=>"channelmanagement_framework",
			"category"=>"Integration",
			"marketing"=>"Plugin that offers framework code for channel management plugins",
			"version"=>(float)"3.0",
			"description"=> "Plugin that offers framework code for channel management plugins",
            "lastupdate"=>"2023/07/31",
            "min_jomres_ver"=>"10.7.2",
			"manual_link"=>'',
			'change_log'=>'v1.1 Added UI functionality to frontend for importing properties via ajax, plus webhook handling updates. v1.2 Variety of changes for jomres2jomres which mean that Rentals United thin plugin will require some refactoring before it can be progressed in dev.  v1.3 Various fixes for jomres2jomres property import. v1.4 Lots of changes, primarily with respect to webhook processing v1.5 Proxy header changed to use hyphens v1.6 A variety of changes to support the Rentals United plugin development. v1.7 Improved how the CMF framework reports import errors 1.8 Resolved an issue where task could not be reliably detected. v1.9 Improved handling of properties to be imported so that it is clearer that some properties without changelog items, or properties that are not completed on the remote server, they cannot be imported (import button is disabled) v2.0 Language files updated v2.1  Fixed issue affecting WordPress forms v2.2 Alter plugin settings table to TEXT, variety of tweaks to provide clarity to whether we are finding local or remote manager id depending on the property uid passed, variety of other tweaks. v2.3 Bootstrap 5 template set added. v2.4 Changed image import to use curl instead of fopen when testing for a file existing. v2.5 Minor tweak to stop sanity checks from throwing a hissy fit if there is nothing wrong. v2.6 BS5 templates added. v2.7 Form templates improved to resolve issue with saving in site config v2.8 Quash a notice. Added check for api_capable flag (set in Jomres Core). Added ability to create a jomres_local_ui Channel and related Oauth2 token so that the UI can call the local CMF REST API endpoints. v2.9 Check to see if the user object is setup when running the 00005 script. v3.0 A whole slew of changes that allow this framework plugin to add and remove properties and managers to the cmf cross reference tables. This opens up using cmf endpoints locally. still under developement.',
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
