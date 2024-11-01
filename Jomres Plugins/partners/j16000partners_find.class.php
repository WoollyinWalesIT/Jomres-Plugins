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

class j16000partners_find
	{
	function __construct()
		{
		// Must be in all minicomponents. Minicomponents with templates that can contain editable text should run $this->template_touch() else just return 
		$MiniComponents =jomres_getSingleton('mcHandler');
		if ($MiniComponents->template_touch)
			{
			$this->template_touchable=false; return;
			}
		$search_string	= strtolower(jomresGetParam( $_REQUEST, 'term', '' ));
		$all_users = jomres_cmsspecific_getCMSUsers();
		$results = array();
		foreach ($all_users as $user)
			{
			if (strlen(stristr(strtolower($user['username']),$search_string)) > 0)
				$results[]=$user;
			}
		if (empty($results))
			echo "";
		else
			{
/* 			$return = '<table>';
			foreach ($results as $res)
				{
				$return .='<tr><td><a href="'.JOMRES_SITEPAGE_URL_ADMIN.'&task=partner_show&id='.$res['id'].'">'.$res['username'].'</a></td></tr>';
				}
			$return .='</table>';
			echo $return; */
			$result_array=array();
			foreach ($results as $res)
				{
				$result_array[] =$res['username'];
				}
			echo json_encode($result_array);
			}
		}
		
	// This must be included in every Event/Mini-component
	function getRetVals()
		{
		return null;
		}	
	}