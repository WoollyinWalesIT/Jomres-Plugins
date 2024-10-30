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

class j06000show_cart
	{
	function __construct()
		{
		// Must be in all minicomponents. Minicomponents with templates that can contain editable text should run $this->template_touch() else just return 
		$MiniComponents =jomres_getSingleton('mcHandler');
		if ($MiniComponents->template_touch)
			{
			$this->template_touchable=true; 
			$this->shortcode_data = array (
				"task" => "show_cart",
				"info" => "_JOMRES_SHORTCODES_06000SHOW_CART",
				"arguments" => array ()
				);
			return;
			}
		
		$tmpBookingHandler =jomres_getSingleton('jomres_temp_booking_handler');
		
		$jomres_currency_conversion = jomres_singleton_abstract::getInstance('jomres_currency_conversion');
		
		$paypal_settings = jomres_singleton_abstract::getInstance( 'jrportal_paypal_settings' );
		$paypal_settings->get_paypal_settings();
		$gateway_currency_code = $paypal_settings->paypalConfigOptions[ 'currencycode' ];
		
		if (empty($tmpBookingHandler->cart_data))
			{
			echo jr_gettext('_JOMRES_CART_NOBOOKINGS_SAVED','_JOMRES_CART_NOBOOKINGS_SAVED');
			}
		else
			{
			$siteConfig = jomres_singleton_abstract::getInstance('jomres_config_site_singleton');
			$jrConfig=$siteConfig->get();
		
			$delete_image = JOMRES_IMAGES_RELPATH.'jomresimages/small/Cancel.png';
			if ($mrConfig['wholeday_booking'] == "1") //TODO: NOTICE error
				{
				$output['_JOMRES_COM_MR_VIEWBOOKINGS_ARRIVAL'] = jr_gettext('_JOMRES_COM_MR_VIEWBOOKINGS_ARRIVAL_WHOLEDAY','_JOMRES_COM_MR_VIEWBOOKINGS_ARRIVAL_WHOLEDAY');
				$output['_JOMRES_COM_MR_VIEWBOOKINGS_DEPARTURE'] = jr_gettext('_JOMRES_COM_MR_VIEWBOOKINGS_DEPARTURE_WHOLEDAY','_JOMRES_COM_MR_VIEWBOOKINGS_DEPARTURE_WHOLEDAY');
				}
			else
				{
				$output['_JOMRES_COM_MR_VIEWBOOKINGS_ARRIVAL'] = jr_gettext('_JOMRES_COM_MR_VIEWBOOKINGS_ARRIVAL','_JOMRES_COM_MR_VIEWBOOKINGS_ARRIVAL');
				$output['_JOMRES_COM_MR_VIEWBOOKINGS_DEPARTURE'] = jr_gettext('_JOMRES_COM_MR_VIEWBOOKINGS_DEPARTURE','_JOMRES_COM_MR_VIEWBOOKINGS_DEPARTURE');
				}
			
			$output['_JOMRES_COM_MR_QUICKRES_STEP2_PROPERTYNAME'] = jr_gettext('_JOMRES_COM_MR_QUICKRES_STEP2_PROPERTYNAME','_JOMRES_COM_MR_QUICKRES_STEP2_PROPERTYNAME');
			$output['_JOMRES_COM_MR_EB_PAYM_CONTRACT_TOTAL'] = jr_gettext('_JOMRES_COM_MR_EB_PAYM_CONTRACT_TOTAL','_JOMRES_COM_MR_EB_PAYM_CONTRACT_TOTAL');
			$output['_JOMRES_COM_INVOICE_LETTER_GRANDTOTAL'] = jr_gettext('_JOMRES_COM_INVOICE_LETTER_GRANDTOTAL','_JOMRES_COM_INVOICE_LETTER_GRANDTOTAL');
			$output['_JOMRES_COM_MR_ROOM_DELETE'] = jr_gettext('_JOMRES_COM_MR_ROOM_DELETE','_JOMRES_COM_MR_ROOM_DELETE');
			$output['_JOMRES_CART_INFO'] = jr_gettext('_JOMRES_CART_INFO','_JOMRES_CART_INFO');
			$output['_JOMRES_CART_TITLE'] = jr_gettext('_JOMRES_CART_TITLE','_JOMRES_CART_TITLE');
			$output['_JOMRES_CART_CONFIRM_BOOKINGS'] = jr_gettext('_JOMRES_CART_CONFIRM_BOOKINGS','_JOMRES_CART_CONFIRM_BOOKINGS',false,false);
			$output['CONFIRM_BOOKINGS_LINK'] = JOMRES_SITEPAGE_URL."&task=confirm_bookings";
			// First we need to grab the cart data and rejig it so that it's sorted by arrival date
			
			uasort($tmpBookingHandler->cart_data, "cmp_by_arrivaldate");
			
			$current_property_details =jomres_getSingleton('basic_property_details');
			$grand_total = 0.00;
			
			foreach ($tmpBookingHandler->cart_data as $identifier=>$individual_booking_info)
				{
				$r=array();
				$property_uid =$individual_booking_info['property_uid'];
				$mrConfig=getPropertySpecificSettings($property_uid);
				$r['PROPERTYNAME'] = $current_property_details->get_property_name($property_uid);
				$r['IDENTIFIER'] = $identifier;
				$r['ARRIVAL'] = outputDate( $individual_booking_info['arrivalDate'] );
				if ($mrConfig['showdepartureinput'] == "1")
					$r['DEPARTURE'] = outputDate( $individual_booking_info['departureDate'] );
				else
					$r['DEPARTURE']="N/A";
				
				if ($jrConfig['useGlobalCurrency']=="1")
					$property_currency_code = $jrConfig['globalCurrencyCode'];
				else
					$property_currency_code = $individual_booking_info['property_currencycode'];

				$contract_total = $jomres_currency_conversion->convert_sum((float)$individual_booking_info['contract_total'],$property_currency_code,$gateway_currency_code);
				
				$r['CONTRACT_TOTAL'] = output_price($contract_total,$gateway_currency_code,true);
				
				$grand_total = $grand_total + $contract_total;
				$r['DELETELINK_IMAGE'] = $delete_image;
				$r['DELETELINK'] = JOMRES_SITEPAGE_URL."&task=remove_booking_from_cart&no_html=1&id=".$identifier;
				$rows[]=$r;
				}
			
			$output['GRANDTOTAL'] = output_price($grand_total,$jrConfig['globalCurrencyCode'],false);
			
			$pageoutput[]=$output;
			$tmpl = new patTemplate();
			$tmpl->setRoot( JOMRES_TEMPLATEPATH_FRONTEND );
			$tmpl->addRows( 'pageoutput',$pageoutput);
			$tmpl->addRows('rows',$rows);
			$tmpl->readTemplatesFromInput( 'show_cart.html');
			$tmpl->displayParsedTemplate();
			}
		
		
		
		}
		


	function touch_template_language()
		{
		$output=array();

		$output[]		=jr_gettext('_JOMRES_CART_NOBOOKINGS_SAVED','_JOMRES_CART_NOBOOKINGS_SAVED');
		$output[] = jr_gettext('_JOMRES_CART_INFO','_JOMRES_CART_INFO');
		$output[] = jr_gettext('_JOMRES_CART_TITLE','_JOMRES_CART_TITLE');
		$output[] = jr_gettext('_JOMRES_CART_CONFIRM_BOOKINGS','_JOMRES_CART_CONFIRM_BOOKINGS');
		
		foreach ($output as $o)
			{
			echo $o;
			echo "<br/>";
			}
		}
	// This must be included in every Event/Mini-component
	function getRetVals()
		{
		return null;
		}	
	}
	
function cmp_by_arrivaldate($a, $b) 
	{
	$arr1 = strtotime($a["arrivalDate"]);
	$arr2 = strtotime($b["arrivalDate"]);
	return $arr1 - $arr2;
	}