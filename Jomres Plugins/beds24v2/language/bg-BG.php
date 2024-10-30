<?php
/**
 * Core file.
 *
 * @author Vince Wooll <sales@jomres.net>
 *
 * @version Jomres 9.24.0
 *
 * @copyright	2005-2021 Vince Wooll
 * Jomres (tm) PHP, CSS & Javascript files are released under both MIT and GPL2 licenses. This means that you can choose the license that best suits your project, and use it accordingly
 **/
//#################################################################
defined('_JOMRES_INITCHECK') or die('');
//#################################################################
// Because the server may be using a proxy for outgoing calls it's better to call the Jomres App server and ask it to respond with this server's IP address. Once we know that, then we are able to give the documentation the correct IP number to configure in Beds24's API Key N field(s)
$cURLConnection = curl_init();

curl_setopt($cURLConnection, CURLOPT_URL, 'https://api.ipify.org?format=json');
curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
curl_setopt($cURLConnection, CURLOPT_CONNECTTIMEOUT, 1);
curl_setopt($cURLConnection, CURLOPT_TIMEOUT, 1);

$ip_number_response = curl_exec($cURLConnection);
curl_close($cURLConnection);

$jsonArrayResponse = json_decode($ip_number_response);

if (isset( $jsonArrayResponse->ip)) {
    $this_servers_ip_number = $jsonArrayResponse->ip;
} else {
    $this_servers_ip_number = 'Unknown, ask your server hosts support team';
}

jr_define ('BEDS24V2_CHANNEL_MANAGEMENT', 'Управление на канали (Beds24)');

jr_define ('BEDS24V2_WEBHOOKS_AUTH_METHOD', 'Beds24');
jr_define ('BEDS24V2_WEBHOOKS_AUTH_METHOD_NOTES', 'Ако имате акаунт в Beds24 и искате да актуализирате Beds24, когато имате резервация, моля, изберете тази опция. Задайте URL адреса на https://www.beds24.com/api/json/');
jr_define ('BEDS24V2_ERROR_USER_NO_KEY', 'Този потребител няма зададени API ключове, така че не може да продължи. Моля, посетете тяхната страница в страницата Управление на потребители> Мениджъри на имоти и създайте нов ключ за тях, като използвате връзката, предоставена на тази страница.');
jr_define ('BEDS24V2_ERROR_USER_NO_PROPERTIES', 'Този потребител няма свойства на Jomres, които да присвои на свойствата Beds24 или обратно');
jr_define ('BEDS24V2_NOT_SUBSCRIBED', "Мениджърът, в който сте влезли, не изглежда да има акаунт с Beds24, така че първо ще трябва да се регистрирате за тяхната услуга, след което да запишете този API ключ на <a href = 'https://www.beds24.com/control2.php?pagetype=accountpassword' target='_blank'> Уебсайта на Beds24 тук. </a> ");
jr_define ('BEDS24V2_NOT_SUBSCRIBED_KEY', "Копирайте и поставете този API ключ в полето LINK във вашия Beds24 акаунт, за да продължите.");
jr_define ('BEDS24V2_NOT_SUBSCRIBED_RELOAD', "Когато направите това, моля, кликнете върху бутона по -долу, за да продължите.");
jr_define ('BEDS24V2_DISPLAY_PROPERTIES_TITLE', "Свързване на свойство Beds24");
jr_define ('BEDS24V2_DISPLAY_PROPERTIES_INFO', "Тази страница ви позволява да видите свойствата, до които имате достъп в тази система, плюс тези, които съществуват в диспечера на канали. Също така ви позволява да импортирате свойства от диспечера на канали в тази система или да експортирате съществуващи свойства към диспечера на канали. <br/> Ако имате свойства както в тази система, така и в Beds24 и искате да ги свържете помежду си, можете да използвате апикера на свойството, за да направите това. Посетете Beds24> Настройки> Свойства (уверете се, че избраното свойство в падащото меню е същото като това, което искате да свържете) след това в подменюто Link запазете apikey на свойството в полето propKey в Beds24. След като направите това, презаредете страницата. Тази система ще вижте, че двете свойства са свързани с един и същ ключ и създайте необходимите асоциации. След като двете свойства са свързани, не забравяйте да посетите страницата View Property, да намерите URL адреса на известието и да го поставите в полето Notify Url на страницата с връзки. Че ще уверете се, че Beds24 използва правилната връзка, за да синхронизира резервациите с това свойство, когато получава резервации. ");
jr_define ('BEDS24V2_DISPLAY_PROPERTIES_NO_PROPERTIES', "Грешка: Няма свойства, към които можете да се свържете в Beds24. Това може да се дължи на това, че всички имоти, на които имате права, вече са свързани с друг акаунт в тази система.");
jr_define ('BEDS24V2_DISPLAY_PROPERTIES_PROPERTY_UID', "Идентификатор на свойството");
jr_define ('BEDS24V2_DISPLAY_PROPERTIES_PROPERTY_NAME', "Име на имота");
jr_define ('BEDS24V2_DISPLAY_PROPERTIES_BEDS24_PROPERTY_UID', "Beds24 Property Uid");
jr_define ('BEDS24V2_DISPLAY_PROPERTIES_BEDS24_PROPERTY_NAME', "Име на имота Beds24");
jr_define ('BEDS24V2_DISPLAY_PROPERTY_APIKEY', "apikey на свойството");
jr_define ('BEDS24_LISTPROPERTIES_IMPORT', "Импортиране");
jr_define ('BEDS24_LISTPROPERTIES_ASSOCIATE_ROOM_TYPES', "Конфигуриране на типове стаи");
jr_define ('BEDS24_LISTPROPERTIES_ASSOCIATE_ROOM_TYPES_DESC', "Тук трябва да свържете типове стаи във вашия акаунт Beds24 с тези, съхранявани в тази система.");
jr_define ('_BEDS24_DISPLAY_BOOKINGS_JOMRESROOMS_BEDS24TYPENAME', "Тип стая Beds24");

jr_define ('BEDS24_LISTPROPERTIES_IMPORT_CANNOT_NOAPIKEY', "Това свойство все още не може да се импортира, тъй като не сте задали ключа на свойството на страницата Свързване на собственост.");
jr_define ('BEDS24_LISTPROPERTIES_IMPORT_CANNOT_NOROOMS', "Все още не може да се импортира тази собственост, тъй като няма стаи. Моля, създайте една или повече стаи (стаите в Beds24 са същите като типовете стаи в Jomres) и не забравяйте да зададете минималната цена) . След като направите това, можете да импортирате типа стая в Jomres и да ги свържете с текущите типове стаи в Jomres. След това ще можете да променяте тарифите, но трябва да зададете минимална цена. ");
jr_define ('_BEDS24_SUGGESTED_KEY', "Предлагаме ви да използвате този API ключ. Когато сте направили това, презаредете тази страница.");
jr_define ('BEDS24_LISTPROPERTIES_EXPORT', "Експорт");
jr_define ('BEDS24V2_REST_API_INTRO', "Тук можете да видите вашата двойка ключове REST API и пътя към API. Ако запазите тези данни в профила си на Beds24, тогава Beds24 24 ще може да се свърже с този сайт чрез неговия API.");
jr_define ('BEDS24V2_REST_API_CLIENT_ID', "Идентификатор на клиента");
jr_define ('BEDS24V2_REST_API_CLIENT_SECRET', "Клиентска тайна");
jr_define ('BEDS24V2_REST_API_ENDPOINT', "URI (крайна точка)");
jr_define ('BEDS24_LISTPROPERTIES_CONFIGURE', "Преглед на собствеността");
jr_define ('BEDS24_ROOM_TYPES_TITLE', "Асоциации тип стая");

jr_define ('BEDS24_ROOM_TYPES_INFO', "Тази страница ви позволява да свържете типовете стаи с тези, съхранявани в сървърите Beds24.");
jr_define ('BEDS24_ROOM_TYPES_INFO2', "Докато типовете стаи не са свързани, не можете да получавате информация за резервации, изпратена от Beds24. Ако вашата собственост е била импортирана/експортирана към или от Beds24, ние сме създали автоматично връзки за вас, но ако добавите нов тип стая или изтрийте такава, тогава тази страница може да се използва, за да се гарантира, че типът стая е правилно свързан. ");
jr_define ('BEDS24_ROOM_TYPES_INFO3', "Изберете типовете стаи Beds24, които искате да свържете с типовете стаи в тази система, и когато сте готови, щракнете върху Запазване, за да актуализирате промените в Beds24.");
jr_define ('BEDS24_ROOM_TYPES_YOURS', "Вашите типове стаи");
jr_define ('BEDS24_ROOM_TYPES_BEDS24', "Типове стаи Beds24");
jr_define ('BEDS24_ROOM_TYPES_NONE', "Този имот няма никакви типове стаи, така че не може да бъде свързан с никакви типове стаи Beds24. Искате ли да импортирате типове стаи от Beds24?");
jr_define ('BEDS24_IMPORT_ROOMS', "Импортиране на стаи");
jr_define ('BEDS24_EXPORT_BOOKINGS', "Експортиране на резервации");
jr_define ('BEDS24_IMPORT_BOOKINGS', "Импортиране на резервации");
jr_define ('BEDS24_IMPORT_EXPORT', "Можете да импортирате и експортирате съществуващи резервации от и в Beds24 с едно натискане на бутон. Резервации, импортирани от Beds24, се внасят от вчера и ще включват всички резервации за следващата година. Трябва да използвате тези бутони само след първо импортиране или експортиране на имота в системата. След настройката импортирането и/или експортирането ще се извърши автоматично. ");
jr_define ('_BEDS24_CHANNEL_MANAGEMENT_UPDATE_PRICING_YESNO', "Актуализиране на цените на Beds24?");
jr_define ('_BEDS24_CHANNEL_MANAGEMENT_UPDATE_PRICING_YESNO_DESC', "Можете да изберете да актуализирате Beds24 само с наличност или както с наличност, така и с цени. Ако използвате определени ситуации, в които искате да използвате контролния панел Beds24 за задаване на конкретни цени за конкретни канали, трябва да оставите тази настройка на Не.");
jr_define ('_BEDS24_CONTROL_PANEL_DIRECT', "Директна връзка");
jr_define ('BEDS24_IMPORT_NOTIFICATION_URLS', "Ако сте импортирали тази собственост в Jomres, ще трябва ръчно да промените URL адреса за уведомяване във вашите Beds24 -> Property -> Link settings на следното:");
jr_define ('BEDS24V2_ERROR_KEYS_SHOULD_BE_REGENERATED', "Понастоящем нямате никакви свойства, свързани с Beds24 свойства. Трябва да нулирате API ключовете на вашия мениджър, преди да позволите на вашите мениджъри да се опитат да се свържат с Beds24. Това ще гарантира, че всички те имат уникални ключове.");
jr_define ('BEDS24V2_ERROR_KEYS_REBUILD', "Нулиране на API ключовете на мениджъра сега");
jr_define ('BEDS24V2_ERROR_KEYS_DISMISS', "Пренебрегване на предупреждението");
jr_define ('BEDS24V2_ERROR_KEYS_DONE', "Ключовете за API на мениджъра са нулирани");

jr_define ('BEDS24V2_ADMINISTRATOR_LINKS_TITLE', "Връзки към имоти Beds24");
jr_define ('BEDS24_ASSIGN_MANAGER', "Beds24 Change Manager");
jr_define ('BEDS24_ASSIGN_MANAGER_DESC', "Когато мениджърът преглежда страницата за управление на канали (Bed24) във фронтенда, всички свойства, които споделят API ключ както в Jomres, така и в Beds24, се свързват автоматично в Jomres. По същия начин всички свойства, импортирани или експортирани от мениджъра Можете да промените мениджъра, с който е свързан имот, като промените падащото меню на мениджъра на тази страница, след което щракнете върху Запазване. ");
jr_define ('BEDS24V2_TARIFFS_TITLE', "Износ на тарифи");
jr_define ('BEDS24V2_TARIFF_EXPORT_DESC', "Можете да експортирате създадените от вас тарифи в Beds24 към определена дневна ставка. Ако ще използвате тази функция, трябва да зададете опцията \"Актуализиране на цените на Beds24?\" в Конфигурацията на имота на Не. Вие може да се наложи също да конфигурирате вашия имот в контролния панел на Beds24, така че да можете да имате няколко дневни тарифи. За да направите това, отидете в Настройки> Свойства> Стаи> Дневни цени и конфигурирайте Брой дневни цени на броя цени, които искате . След като направите това, ще можете да щракнете върху един от бутоните P, за да зададете тази дневна ставка. ");
jr_define ('BEDS24V2_TARIFF_EXPORT_TARIFFNAME', "Име на тарифата");
jr_define ('BEDS24V2_TARIFF_EXPORT_TARIFF_ROOM_TYPE', "Тип стая");
jr_define ('BEDS24V2_BOOKING_RESEND', "Изпращане на известие отново");
jr_define ('BEDS24V2_BOOKING_DATA_AT_B24', "Това е информацията за резервацията, съхранявана на Beds24. Освен ако не сте сигурни, че данните са неправилни, не трябва да изпращате резервацията отново на Beds24.");
jr_define ('BEDS24V2_BOOKING_NO_DATA_AT_B24', "Тази резервация изглежда не е свързана с резервация на Beds24. Можете да използвате бутона за повторно изпращане, за да експортирате тази резервация в beds24.");

jr_define ('BEDS24V2_GDPR_ANONYMISE_GUESTS', "Анонимни гости?");
jr_define ('BEDS24V2_GDPR_ANONYMISE_GUESTS_DESC', "Когато резервациите се изпращат до мениджъра на канала, препоръчваме ви да анонимизирате данните за госта. Ако зададете тази опция на \"да\", когато информацията за резервацията се изпраща до мениджъра на канала, името на госта, имейл адресът не са . OTA ще имат точен запис на вашата наличност, без да се налага да споделяте повече информация, отколкото е необходимо. Това означава, че сте в съответствие с GDPR, защото ако гостът по -късно трябва да избере да изтрие данните си в тази система (не сте уведомени, когато това се случи), техните данни не се оставят на други администратори на данни, върху които нямате контрол. Ако е необходимо, все още можете да препращате резервации в тази система с тези в мениджъра на канала, страницата с подробности за резервацията ще ви покаже номера на резервацията за тази резервация, тъй като се съхранява в мениджъра на канала. ");
jr_define ('BEDS24V2_MASTER_APIKEY', "ЕКСПЕРИМЕНТАЛНА ХАРАКТЕРИСТИКА - API ключ на Master Beds24");
jr_define ('BEDS24V2_MASTER_APIKEY_DESC', "АКО ВЕЧЕ ИМАТЕ ИНСТАЛАЦИЯ НА ЖОМРЕС С ИМОТИ, СВЪРЗАНИ КЪМ ЛЕГЛА24 ПРОЧЕТЕТЕ ПЪЛНОТО ОПИСАНИЕ ТУК. По подразбиране Jomres е проектиран да бъде собствена платформа за резервации на няколко доставчици, които могат да импортират Mana24. имоти до и от легло24 сигурно. Тази настройка ви позволява да замените тази функционалност, като имате един ключ за API за всички имоти. Това означава, че имате нужда само от един акаунт с Beds24, но също така означава, че всички такси ще бъдат начислени от този един акаунт. Всеки мениджър с достъп до имот ще може да изпраща актуализации на имота на сървърите на bed24. Оставете празно, за да игнорирате тази настройка и да принудите мениджърите на имоти да използват своите собствени акаунти в Beds24. API ключът може да приеме всяка форма, която искате, толкова дълго тъй като ключът тук съвпада с този в <a href='https://www.beds24.com/control2.php?pagetype=accountpassword' target='_blank'> <em> API ключ 1 </em> </ a> поле. АКО ВЕЧЕ ИМАТЕ ИНСТАЛАЦИЯ ОТ JOMRES С ИМОТИ, СВЪРЗАНИ КРЕДА24: Можете да преминете към използване на тази функция, но това ще изисква първо да отрежете (изпразните) тези таблици, да изтриете съществуващите свойства, които вече са в Jomres, и след това да импортирате отново свойствата от Beds24 в Jomres. XXXXX_jomres_beds24_contract_booking_number_xref, XXXXX_jomres_beds24_property_uid_xref, XXXXX_jomres_beds24_rest_api_key_xref, XXXXX_jomres_beds24_room_type_xref. <br/> <br/> Когато задавате своя API ключ в секцията <em> API Key N </em> на страницата за достъп до акаунта на Beds24, е жизненоважно да зададете полето <em> API Key Access </em> на  Разрешаване на IP само на белия списък и задавате IP номера на <strong>". $this_servers_ip_number."</strong> Това важи еднакво за конфигурацията на главния API ключ тук, както и във интерфейса, ако мениджърът на имоти конфигурира своя собствен индивидуален API ключове. ");
jr_define ('BEDS24V2_WHITELIST_WARNING', "Ако вашите имоти вече са свързани с Beds24, имайте предвид, че Beds24 наскоро въведоха политика, при която всички сървъри, свързани с вашия акаунт, трябва да бъдат включени в белия списък. Можете да направите това на страницата за достъп до акаунта, където Вашият ключ за достъп е въведен. Изберете падащия списък Whitelist IP и задайте IP номера на ");