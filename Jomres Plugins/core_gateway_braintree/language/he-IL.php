<?php
/**
 * Core file.
 *
 * @author Vince Wooll <sales@jomres.net>
 *
 * @version Jomres 10.5.3
 *
 * @copyright	2005-2022 Vince Wooll
 * Jomres is currently available for use in all personal or commercial projects under both MIT and GPL2 licenses. This means that you can choose the license that best suits your project, and use it accordingly
 **/
//#################################################################
defined('_JOMRES_INITCHECK') or die('');
//#################################################################


	jr_define('BRAINTREE_TITLE',"Braintree");
	jr_define('BRAINTREE_MARKETING',"<h3>הגדל את ההכנסה עם שותף תשלומים גלובלי</h3>
להגיע ליותר קונים ולהניב המרה גבוהה יותר עם פלטפורמת התשלומים היחידה שמספקת PayPal, Venmo (בארה\"ב), כרטיסי אשראי וכרטיסי חיוב וארנקים דיגיטליים פופולריים כמו Apple Pay ו-Google Pay באינטגרציה אחת וחלקה. " );

jr_define('BRAINTREE_MERCHANT_ID',"מזהה סוחר חי");
jr_define('BRAINTREE_MERCHANT_PUBLIC_KEY',"מפתח ציבורי חי");
jr_define('BRAINTREE_MERCHANT_PRIVATE_KEY',"מפתח פרטי חי");

jr_define('BRAINTREE_API_TEST_MODE',"מצב בדיקה");
jr_define('BRAINTREE_API_TEST_MODE_DESC',"אם אתה משתמש במצב בדיקה יהיה לך מזהה סוחר שונה, מפתחות ציבוריים ופרטיים.");

jr_define('BRAINTREE_TEST_MERCHANT_ID',"זיהוי סוחר בדוק");
jr_define('BRAINTREE_TEST_MERCHANT_PUBLIC_KEY',"בדוק מפתח ציבורי");
jr_define('BRAINTREE_TEST_MERCHANT_PRIVATE_KEY',"בדיקת מפתח פרטי");