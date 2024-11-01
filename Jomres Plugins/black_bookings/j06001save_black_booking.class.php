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

/**
#
 * Saves a black booking
 #
* @package Jomres
#
 */
class j06001save_black_booking {
	/**
	#
	 * Constructor: Saves a black booking
	#
	 */
	function __construct()
		{
		// Must be in all minicomponents. Minicomponents with templates that can contain editable text should run $this->template_touch() else just return 
		$MiniComponents =jomres_getSingleton('mcHandler');
		if ($MiniComponents->template_touch)
			{
			$this->template_touchable=false; return;
			}
		
		$defaultProperty=getDefaultProperty();
		$start=JSCalConvertInputDates($_POST['start']);
		$end=JSCalConvertInputDates($_POST['end']);
		$bbReason	= getEscaped( jomresGetParam( $_POST, 'bbReason', "" ) );
		$row = jomresGetParam( $_POST, 'idarray', array() );
		if (!empty($row))
			{
			$dateRangeArray= $this->bb_getDateRange($start,$end);
			$okToContinue=TRUE;
			// Now let's double check the chosen rooms
			foreach ($dateRangeArray as $theDate)
				{
				foreach ($row as $room_uid)
					{
					$query="SELECT room_bookings_uid,contract_uid FROM #__jomres_room_bookings WHERE room_uid = '".(int)$room_uid."' AND date = '$theDate'";
					$bookingsList = doSelectSql($query);
					if (!empty($bookingsList))
						$okToContinue=FALSE;
					}
				}
			if (!$okToContinue)
				{
				echo jr_gettext('_JOMRES_FRONT_MR_MENU_ADMIN_BLACKBOOKINGS_STAGE2_ERROR','_JOMRES_FRONT_MR_MENU_ADMIN_BLACKBOOKINGS_STAGE2_ERROR');
				}
			else
				{
				$keeplooking	   = true;
				while ( $keeplooking ):
					$cartnumber = mt_rand( 10000000, 99999999 );
					$query  = "SELECT contract_uid FROM #__jomres_contracts WHERE tag = '" . $cartnumber . "' LIMIT 1";
					$bklist = doSelectSql( $query );
					if ( empty( $bklist ) ) 
						$keeplooking = false;
				endwhile;
		
				$numberOfAdults="0";
				$numberOfChildren="0";
				$arrivalDate=$start;
				$departureDate=$end;
				$dateRangeString=implode(",",$dateRangeArray);
				$guests_uid="0";
				$rates_uid="0";
				$cotRequired="0";
				$rate_rules="0";
				$single_person_suppliment="0";
				$deposit_required="0";
				$contract_total="0";
				$specialReqs=$bbReason;
				$cot_suppliment="0";
				$extras="0";
				$extrasValue="0";

				$query="INSERT INTO #__jomres_contracts (
						`arrival`,`departure`,`rates_uid`,
						`guest_uid`,`contract_total`,`special_reqs`,
						`adults`,`children`,`deposit_paid`,`deposit_required`,
						`date_range_string`,`booked_in`,`booked_out`,`rate_rules`,
						`property_uid`,`single_person_suppliment`,`extras`,`extrasvalue`,`tag`)
						VALUES (
						'$arrivalDate','$departureDate','".(int)$rates_uid."',
						'".(int)$guests_uid."','".(float)$contract_total."','$specialReqs',
						'$numberOfAdults','$numberOfChildren','0','".(float)$deposit_required."',
						'$dateRangeString','0','0','$rate_rules',
						'".(int)$defaultProperty."','".(float)$single_person_suppliment."','$extras','".(float)$extrasValue."' , '".$cartnumber."')";
				$lastID=doInsertSql($query,'');
                
				if ( !$lastID )
					trigger_error ("Unable to insert into contracts table, mysql db failure", E_USER_ERROR);
				else
					{
                    $webhook_notification                               = new stdClass();
                    $webhook_notification->webhook_event                = 'blackbooking_added';
                    $webhook_notification->webhook_event_description    = 'Logs when black bookings are added.';
                    $webhook_notification->webhook_event_plugin         = 'black_bookings';
                    $webhook_notification->data                         = new stdClass();
                    $webhook_notification->data->property_uid           = $defaultProperty;
                    $webhook_notification->data->contract_uid           = $lastID;
                    add_webhook_notification($webhook_notification);
                
					$contract_uid=$lastID;
					set_showtime('last_added_contract_uid' , $contract_uid ); // For the beds24 plugin to add the booking to beds24
					$jomres_messaging =jomres_getSingleton('jomres_messages');
					//$jomres_messaging = new jomres_messages();
					$jomres_messaging->set_message(jr_gettext('_JOMRES_MR_AUDIT_BLACKBOOKING','_JOMRES_MR_AUDIT_BLACKBOOKING',FALSE));
					jomres_audit($query,jr_gettext('_JOMRES_MR_AUDIT_BLACKBOOKING','_JOMRES_MR_AUDIT_BLACKBOOKING',FALSE));
					if ($contract_uid)
						{
						foreach ($row as $room_uid)
							{
							$dateRangeArray=explode(",",$dateRangeString);
							 $query="INSERT INTO #__jomres_room_bookings
								(`room_uid`,
								`date`,
								`contract_uid`,
								`black_booking`,
								`internet_booking`,
								`reception_booking`,
								`property_uid`)
								VALUES ";
							for ($i=0, $n=count($dateRangeArray); $i < $n; $i++)
								{
								$internetBooking=0;
								$receptionBooking=0;
								$blackBooking=1;
								$roomBookedDate=$dateRangeArray[$i];
								// Thanks Netized
								 $query.= ($i>0) ? ', ':'';
								$query.="('".(int)$room_uid."','$roomBookedDate','".(int)$contract_uid."','".(int)$blackBooking."','".(int)$internetBooking."','".(int)$receptionBooking."','".(int)$defaultProperty."')";
								}
							if (!doInsertSql($query,''))
								trigger_error ("Unable to insert into room bookings table, mysql db failure", E_USER_ERROR);
							}
						jomresRedirect( jomresURL(JOMRES_SITEPAGE_URL."&task=list_black_bookings") ,"" );
						}
					else
						trigger_error ("Error after inserting to contracts table, no contract uid returned.", E_USER_ERROR);
					}
				}
			}
			
		else
			echo "Error, no rooms were selected";
		}


	#
	/**
	#
	 * Returns the date range array for the black booking
	#
	 */
	function bb_getDateRange($start,$end)
		{
		$interval=dateDiff("d",$start,$end);
		$dateRangeArray=array();
		$date_elements  = explode("/",$start);
		$unixCurrentDate= mktime(0,0,0,$date_elements[1],$date_elements[2],$date_elements[0]);
		$secondsInDay = 86400;
		$currentUnixDay=$unixCurrentDate;
		$currentDay=$start;
		for ($i=0, $n=$interval; $i < $n; $i++)
			{
			$currentDay=date("Y/m/d",$unixCurrentDate);
			$dateRangeArray[]=$currentDay;
			$unixCurrentDate=strtotime("+1 day",$unixCurrentDate);
			}
		$dateRangeString=implode(",",$dateRangeArray);
		return $dateRangeArray;
		}

	/**
	#
	 * Must be included in every mini-component
	#
	 * Returns any settings the the mini-component wants to send back to the calling script. In addition to being returned to the calling script they are put into an array in the mcHandler object as eg. $mcHandler->miniComponentData[$ePoint][$eName]
	#
	 */
	// This must be included in every Event/Mini-component
	function getRetVals()
		{
		return null;
		}
	}
