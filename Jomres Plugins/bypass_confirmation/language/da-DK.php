<?php
/**
 * Core file.
 *
 * @author Vince Wooll <sales@jomres.net>
 *
 * @version Jomres 9.24.0
 *
 * @copyright	2005-2021 Vince Wooll
 * Jomres is currently available for use in all personal or commercial projects under both MIT and GPL2 licenses. This means that you can choose the license that best suits your project, and use it accordingly
 **/
//#################################################################
defined('_JOMRES_INITCHECK') or die('');
//#################################################################


jr_define ('_BYPASS_CONFIRMATION_TITLE', "Reservationsside for omgåelse af anmeldelse");
jr_define ('_BYPASS_CONFIRMATION_DESC', "Når dette er aktiveret, vises gennemgangsreservationssiden ikke længere, og i stedet føres gæsterne direkte til betaling, eller hvis ingen gateways er aktiveret, indsættes reservationen direkte.");