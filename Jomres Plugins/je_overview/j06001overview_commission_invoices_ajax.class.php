<?php
/**
 * Core file
 *
 * @author Vince Wooll <sales@jomres.net>
 * @version Jomres 8
 * @package Jomres
 * @copyright	2005-2014 Vince Wooll
 * Jomres (tm) PHP, CSS & Javascript files are released under both MIT and GPL2 licenses. This means that you can choose the license that best suits your project, and use it accordingly.
 **/


// ################################################################
defined( '_JOMRES_INITCHECK' ) or die( '' );
// ################################################################

class j06001overview_commission_invoices_ajax
	{
	function __construct()
		{
		// Must be in all minicomponents. Minicomponents with templates that can contain editable text should run $this->template_touch() else just return
		$MiniComponents = jomres_singleton_abstract::getInstance( 'mcHandler' );
		if ( $MiniComponents->template_touch )
			{
			$this->template_touchable = false;

			return;
			}
		
		$thisJRUser = jomres_singleton_abstract::getInstance( 'jr_user' );
		$defaultProperty=getDefaultProperty();
		$mrConfig=getPropertySpecificSettings($defaultProperty);
		$jrportal_paypal_settings = jomres_singleton_abstract::getInstance( 'jrportal_paypal_settings' );
		$paypal_settings = $jrportal_paypal_settings->get_paypal_settings();

		$rows = array ();
		
		//set the table coulmns, in the exact orcer in which they`re displayed in the table
		$aColumns = array( 'a.id','a.raised_date','b.init_total_inclusive','a.status');
		
		//set columns count
		$n = count($aColumns);

        /*
         * Paging
         */
        $sLimit = '';
        if (isset($_GET['start']) && $_GET['start'] != '-1') 
			{
            $sLimit = 'LIMIT '.(int)$_GET['start'].', '.(int)$_GET['length'];
			}

        /*
         * Ordering
         */
        $sOrder = '';
        if (isset($_GET['jr_order'])) 
			{
            $sOrder = 'ORDER BY ';
			for ($i = 0; $i < $n; ++$i) 
				{
				if (isset($_GET['jr_order'][$i]['column'])) 
					{
					$column_id = (int)$_GET['jr_order'][$i]['column'];
					$sOrder .= ''.$aColumns[$column_id].' '.($_GET['jr_order'][$i]['dir'] === 'asc' ? 'ASC' : 'DESC').', ';
					}
				}
			if ($sOrder == 'ORDER BY ') 
				{
				$sOrder = '';
				} 
			else 
				{
				$sOrder = rtrim($sOrder, ', ');
				}
			}

        /*
         * Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */
        $sWhere = '';
		$search = jomresGetParam($_GET, 'jr_search', array());
        if (isset($search['value']) && $search['value'] != '') 
			{
            $sWhere = 'AND (';
            for ($i = 0; $i < $n; ++$i) 
				{
                $sWhere .= ''.$aColumns[$i]." LIKE '%".$search['value']."%' OR ";
				}
			$sWhere = rtrim($sWhere, ' OR ');
            $sWhere .= ')';
			}
		
		/*
		 * Prefilter
		 */
		
		$clause = "WHERE a.property_uid IN (0," . implode( ',',$thisJRUser->authorisedProperties ) . ") ";
			
		//booking/commission/subscription invoices
		if ( $thisJRUser->accesslevel > 50 ) //higher than receptionist
			$clause .= "AND ( a.is_commission = 1 AND a.cms_user_id = ".(int)$thisJRUser->id." ) ";
		
		//status
		$clause .=" AND a.status = '3' ";
		
		/*
		 * Build and execute the query
		 */
		
		$query = "SET SQL_BIG_SELECTS=1";
		doInsertSql($query);
		
		$query = "SELECT SQL_CALC_FOUND_ROWS 
					a.id,
					a.status,
					a.raised_date,  
					a.init_total, 
					a.currencycode,
					a.contract_id, 
					a.property_uid,
					a.is_commission, 
					GROUP_CONCAT(DISTINCT b.name SEPARATOR '<br>') AS line_items, 
					SUM( CASE WHEN b.init_total_inclusive < 0 THEN 0 ELSE b.init_total_inclusive END ) AS grand_total  
				FROM #__jomresportal_invoices a 
					JOIN #__jomresportal_lineitems b ON a.id = b.inv_id "
				. $clause 
				. ' ' . $sWhere 
				. " GROUP BY a.id " 
				. $sOrder 
				. ' ' . $sLimit;
		$jomresInvoicesList = doSelectSql( $query );

		/*
         * Total number of rows
         */
        $query = 'SELECT FOUND_ROWS()';
        $mp = (int) doSelectSql($query, 1);
        if ($mp == 0) 
			{
            $output = array(
                'draw' => (int)$_GET['draw'],
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => array(),
                );
            echo json_encode($output);
            exit;
			}

        /*
         * Start building the output array. The columns data should be built in the exact order in which they`ll be displayed in the table.
         */
        $output = array(
            'draw' => (int)$_GET['draw'],
            'recordsTotal' => $mp,
            'recordsFiltered' => $mp,
            'data' => array(),
        );

		foreach ( $jomresInvoicesList as $p )
			{
			$r = array ();
			
			if (!using_bootstrap())
				{
				$jrtbar = jomres_singleton_abstract::getInstance( 'jomres_toolbar' );
				$jrtb = $jrtbar->startTable();
				$jrtb .= $jrtbar->toolbarItem( 'edit', jomresURL( JOMRES_SITEPAGE_URL . '&task=view_invoice' . '&id=' . $p->id ), jr_gettext( 'COMMON_VIEW', 'COMMON_VIEW', false ) );
				$r[] = $jrtb .= $jrtbar->endTable();
				}
			else
				{
				$toolbar = jomres_singleton_abstract::getInstance( 'jomresItemToolbar' );
				$toolbar->newToolbar();
				$toolbar->addItem( 'fa fa-pencil-square-o', 'btn btn-info', '', jomresURL( JOMRES_SITEPAGE_URL . '&task=view_invoice&id=' . $p->id ), jr_gettext( 'COMMON_VIEW', 'COMMON_VIEW', false ) );
				if ((int)$p->contract_id != 0 && (int)$p->status != 1)
					{
					if ($thisJRUser->userIsManager || $thisJRUser->superPropertyManager)
						{
						$toolbar->addSecondaryItem( 'fa fa-check', '', '', jomresURL( JOMRES_SITEPAGE_URL . '&task=mark_booking_invoice_paid&id=' . $p->id ), jr_gettext( '_JOMRES_INVOICE_MARKASPAID', '_JOMRES_INVOICE_MARKASPAID', false ) );
						$toolbar->addSecondaryItem( 'fa fa-pencil-square-o', '', '', jomresURL( JOMRES_SITEPAGE_URL . '&task=edit_booking&contract_uid=' . $p->contract_id ), jr_gettext( '_JOMCOMP_MYUSER_VIEWBOOKING', '_JOMCOMP_MYUSER_VIEWBOOKING', false ) );
						}
					}
				$toolbar->addSecondaryItem( 'fa fa-print', '', '', jomresURL( JOMRES_SITEPAGE_URL . '&task=view_invoice&popup=1&id=' . $p->id . '&tmpl='.get_showtime("tmplcomponent")), jr_gettext( 'COMMON_PRINT', 'COMMON_PRINT', false ) );
				$r[]=$toolbar->getToolbar();
				}

			$r[] = $p->id;
			$r[] = $p->raised_date;
			$r[] = output_price($p->grand_total,$p->currencycode);

			//paypal stuff
			if ( (int)$p->is_commission == 1 && (int)$p->status == 3 && $paypal_settings[ 'email' ] != "")
				$r[] = '<a href="' . JOMRES_SITEPAGE_URL . '&task=immediatepay&id=' . $p->id . '"><img src = "' . JOMRES_IMAGES_RELPATH.'btn_paynow_SM.gif" /></a>';
			else
				$r[] = '';
			
			$output['data'][] = $r;
			}
		
		/*
		 * Return the json encoded data to populate the table rows
		 */
		echo json_encode( $output );
		exit;
		}


	// This must be included in every Event/Mini-component
	function getRetVals()
		{
		return null;
		}
	}
