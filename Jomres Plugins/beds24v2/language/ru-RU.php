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
jr_define ('BEDS24V2_CHANNEL_MANAGEMENT', 'Управление каналом (Beds24)');

jr_define ('BEDS24V2_WEBHOOKS_AUTH_METHOD', 'Кровати24');
jr_define ('BEDS24V2_WEBHOOKS_AUTH_METHOD_NOTES', 'Если у вас есть учетная запись Beds24 и вы хотите обновить Beds24 при бронировании, выберите этот вариант. Установите URL-адрес https://www.beds24.com/api/json/');
jr_define ('BEDS24V2_ERROR_USER_NO_KEY', 'У этого пользователя не заданы ключи API, поэтому продолжить нельзя. Посетите его страницу на странице "Управление пользователями> Менеджеры свойств" и создайте для него новый ключ API, используя ссылку, указанную на этой странице.');
jr_define ('BEDS24V2_ERROR_USER_NO_PROPERTIES', 'У этого пользователя нет свойств Jomres, которые они могут назначить свойствам Beds24, или наоборот');
jr_define ('BEDS24V2_NOT_SUBSCRIBED', "Менеджер, под которым вы вошли, похоже, не имеет учетной записи в Beds24, поэтому вам нужно сначала зарегистрироваться для его службы, а затем сохранить этот ключ API на <a href='https://www.beds24.com/control2.php?pagetype=accountpassword' target='_blank'> веб-сайт Beds24 здесь. </a> ");
jr_define ('BEDS24V2_NOT_SUBSCRIBED_KEY', "Скопируйте и вставьте этот ключ API в поле LINK в своей учетной записи Beds24, чтобы продолжить.");
jr_define ('BEDS24V2_NOT_SUBSCRIBED_RELOAD', "Когда вы это сделаете, нажмите кнопку ниже, чтобы продолжить.");
jr_define ('BEDS24V2_DISPLAY_PROPERTIES_TITLE', "Связывание свойств Beds24");
jr_define ('BEDS24V2_DISPLAY_PROPERTIES_INFO', "Эта страница позволяет вам просматривать свойства, к которым у вас есть доступ в этой системе, а также те, которые существуют в диспетчере каналов. Она также позволяет вам импортировать свойства из диспетчера каналов в эту систему или экспортировать существующие свойства в диспетчере каналов. <br/> Если у вас есть свойства как в этой системе, так и в Beds24, и вы хотите связать их друг с другом, вы можете использовать для этого Property apikey. Посетите Beds24> Настройки> Свойства (убедитесь, что свойство, выбранное в раскрывающемся списке, совпадает с тем, которое вы хотите связать), затем в подменю \"Ссылка\" сохраните \"Свойство apikey\" в поле \"propKey\" в Beds24. Как только вы это сделаете, перезагрузите страницу. Эта система будет убедитесь, что два свойства связаны с одним и тем же ключом, и создайте необходимые связи. После связывания двух свойств не забудьте посетить страницу \"Просмотр свойств\", найти URL-адрес уведомления и вставить его в поле \"URL-адрес уведомления\" на странице ссылки. Что будет убедитесь, что Beds24 использует правильную ссылку для синхронизации бронирований с этим отелем при получении заказов. ");
jr_define ('BEDS24V2_DISPLAY_PROPERTIES_NO_PROPERTIES', "Ошибка: в Beds24 нет свойств, на которые можно ссылаться. Это может быть связано с тем, что все свойства, на которые у вас есть права, уже были связаны с другой учетной записью в этой системе.");
jr_define ('BEDS24V2_DISPLAY_PROPERTIES_PROPERTY_UID', "Свойство uid");
jr_define ('BEDS24V2_DISPLAY_PROPERTIES_PROPERTY_NAME', "Название свойства");
jr_define ('BEDS24V2_DISPLAY_PROPERTIES_BEDS24_PROPERTY_UID', "Uid свойства Beds24");
jr_define ('BEDS24V2_DISPLAY_PROPERTIES_BEDS24_PROPERTY_NAME', "Название свойства Beds24");
jr_define ('BEDS24V2_DISPLAY_PROPERTY_APIKEY', "Свойство apikey");
jr_define ('BEDS24_LISTPROPERTIES_IMPORT', "Импорт");
jr_define ('BEDS24_LISTPROPERTIES_ASSOCIATE_ROOM_TYPES', "Настроить типы комнат");
jr_define ('BEDS24_LISTPROPERTIES_ASSOCIATE_ROOM_TYPES_DESC', "Здесь вам нужно связать типы комнат в вашей учетной записи Beds24 с теми, которые хранятся в этой системе.");
jr_define ('_BEDS24_DISPLAY_BOOKINGS_JOMRESROOMS_BEDS24TYPENAME', "Тип номера Beds24");

jr_define ('BEDS24_LISTPROPERTIES_IMPORT_CANNOT_NOAPIKEY', "Невозможно импортировать это свойство, поскольку вы не установили ключ свойства на странице ссылки на свойство.");
jr_define ('BEDS24_LISTPROPERTIES_IMPORT_CANNOT_NOROOMS', "Невозможно импортировать это свойство, так как в нем нет комнат. Создайте одну или несколько комнат (комнаты в Beds24 такие же, как и типы комнат в Джомресе) и не забудьте установить минимальную цену . Как только вы это сделаете, вы можете импортировать тип комнаты в Jomres и связать их с текущими типами комнат Jomres. После этого вы сможете изменять тарифы, но необходимо установить минимальную цену. ");
jr_define ('_BEDS24_SUGGESTED_KEY', "Мы предлагаем вам использовать этот ключ API. Когда вы это сделаете, перезагрузите эту страницу.");
jr_define ('BEDS24_LISTPROPERTIES_EXPORT', "Экспорт");
jr_define ('BEDS24V2_REST_API_INTRO', "Здесь вы можете увидеть свою пару ключей REST API и путь к API. Если вы сохраните эти данные в своей учетной записи на Beds24, тогда Beds24 24 сможет связаться с этим сайтом через свой API.");
jr_define ('BEDS24V2_REST_API_CLIENT_ID', "Идентификатор клиента");
jr_define ('BEDS24V2_REST_API_CLIENT_SECRET', "Секрет клиента");
jr_define ('BEDS24V2_REST_API_ENDPOINT', "URI (конечная точка)");
jr_define ('BEDS24_LISTPROPERTIES_CONFIGURE', "Просмотр свойства");
jr_define ('BEDS24_ROOM_TYPES_TITLE', "Связи типов комнат");

jr_define ('BEDS24_ROOM_TYPES_INFO', "Эта страница позволяет вам связать типы ваших комнат с теми, которые хранятся на серверах Beds24.");
jr_define ('BEDS24_ROOM_TYPES_INFO2', "Пока типы номеров не связаны, вы не можете получать информацию о бронировании, отправленную Beds24. Если ваша собственность была импортирована / экспортирована на Beds24 или с нее, мы автоматически создали ссылки для вас, однако если вы добавите новый тип комнаты или удалить один, тогда эту страницу можно использовать для проверки правильности привязки типа комнаты. ");
jr_define ('BEDS24_ROOM_TYPES_INFO3', "Выберите типы комнат Beds24, которые вы хотите связать с типами комнат в этой системе, и, когда закончите, нажмите \"Сохранить\", чтобы обновить изменения в Beds24.");
jr_define ('BEDS24_ROOM_TYPES_YOURS', "Типы ваших комнат");
jr_define ('BEDS24_ROOM_TYPES_BEDS24', "Типы номеров Beds24");
jr_define ('BEDS24_ROOM_TYPES_NONE', "Это свойство не имеет типов номеров, поэтому его нельзя связать ни с какими типами номеров Beds24. Хотите импортировать типы номеров из Beds24?");
jr_define ('BEDS24_IMPORT_ROOMS', "Импортировать комнаты");
jr_define ('BEDS24_EXPORT_BOOKINGS', "Экспорт бронирований");
jr_define ('BEDS24_IMPORT_BOOKINGS', "Импорт бронирований");
jr_define ('BEDS24_IMPORT_EXPORT', "Вы можете импортировать и экспортировать существующие бронирования из Beds24 и обратно одним нажатием кнопки. Бронирования, импортированные из Beds24, импортируются со вчерашнего дня и будут включать все бронирования следующего года. Вы должны использовать эти кнопки только после первый импорт или экспорт свойства в систему. После настройки импорт и / или экспорт будут выполнены автоматически. ");
jr_define ('_BEDS24_CHANNEL_MANAGEMENT_UPDATE_PRICING_YESNO', "Обновить цены до Beds24?");
jr_define ('_BEDS24_CHANNEL_MANAGEMENT_UPDATE_PRICING_YESNO_DESC', "Вы можете выбрать обновление Beds24, указав только наличие или наличие и цены одновременно. Если у вас есть определенные ситуации, когда вы хотите использовать панель управления Beds24 для установки конкретных цен для определенных каналов, вы должны оставить этот параметр, чтобы Нет.");
jr_define ('_BEDS24_CONTROL_PANEL_DIRECT', "Прямая ссылка");
jr_define ('BEDS24_IMPORT_NOTIFICATION_URLS', "Если вы импортировали это свойство в Jomres, вам нужно будет вручную изменить URL-адрес уведомления в Beds24 -> Свойство -> Настройки ссылки на следующее:");
jr_define ('BEDS24V2_ERROR_KEYS_SHOULD_BE_REGENERATED', "В настоящее время у вас нет никаких свойств, связанных со свойствами Beds24. Вы должны сбросить ключи API вашего менеджера, прежде чем позволить вашим менеджерам пытаться подключиться к Beds24. Это гарантирует, что все они будут иметь уникальные ключи.");
jr_define ('BEDS24V2_ERROR_KEYS_REBUILD', "Сбросить ключи API менеджера сейчас");
jr_define ('BEDS24V2_ERROR_KEYS_DISMISS', "Игнорировать предупреждение");
jr_define ('BEDS24V2_ERROR_KEYS_DONE', "Ключи API Менеджера сброшены");

jr_define ('BEDS24V2_ADMINISTRATOR_LINKS_TITLE', "Ссылки на свойства Beds24");
jr_define ('BEDS24_ASSIGN_MANAGER', "Менеджер смены Beds24");
jr_define ('BEDS24_ASSIGN_MANAGER_DESC', "Когда менеджер просматривает страницу управления каналами (Bed24) во внешнем интерфейсе, любые свойства, имеющие общий ключ API как в Jomres, так и в Beds24, автоматически связываются в Jomres. Аналогично, любые свойства, импортированные или экспортированные менеджером связаны. Вы можете изменить менеджера, с которым связано свойство, изменив раскрывающийся список менеджеров на этой странице и нажав Сохранить. ");
jr_define ('BEDS24V2_TARIFFS_TITLE', "Экспорт тарифа");
jr_define ('BEDS24V2_TARIFF_EXPORT_DESC', "Вы можете экспортировать тарифы, которые вы создали в Beds24, на определенную дневную ставку. Если вы собираетесь использовать эту функцию, вы должны установить для параметра \"Обновить цены на Beds24?\" в конфигурации собственности значение \"Нет\". также может потребоваться настроить свой объект на панели управления Beds24, чтобы у вас было несколько дневных ставок. Для этого перейдите в \"Настройки\"> \"Свойства\"> \"Номера\"> \"Ежедневные цены\" и настройте \"Количество дневных цен\" на желаемое количество цен. . Как только вы это сделаете, вы сможете щелкнуть одну из кнопок P, чтобы установить дневную ставку. ");
jr_define ('BEDS24V2_TARIFF_EXPORT_TARIFFNAME', "Название тарифа");
jr_define ('BEDS24V2_TARIFF_EXPORT_TARIFF_ROOM_TYPE', "Тип комнаты");
jr_define ('BEDS24V2_BOOKING_RESEND', "Отправить уведомление повторно");
jr_define ('BEDS24V2_BOOKING_DATA_AT_B24', "Это информация о бронировании, хранящаяся на Beds24. Если вы не уверены, что данные неверны, вам не нужно повторно отправлять бронирование на Beds24.");
jr_define ('BEDS24V2_BOOKING_NO_DATA_AT_B24', "Похоже, это бронирование не связано с бронированием на Beds24. Вы можете использовать кнопку \"Отправить повторно\", чтобы экспортировать это бронирование на bed24.");
    
    jr_define ('BEDS24V2_GDPR_ANONYMISE_GUESTS', "Анонимизировать гостей?");
jr_define ('BEDS24V2_GDPR_ANONYMISE_GUESTS_DESC', "Когда заказы отправляются менеджеру канала, мы рекомендуем вам анонимизировать данные гостя. Если вы установите для этого параметра значение \"Да\", когда информация о бронировании отправляется менеджеру канала, имя гостя, адрес электронной почты не . OTA будут вести точный учет вашей доступности без необходимости предоставлять дополнительную информацию, чем необходимо. Это означает, что вы соблюдаете GDPR, потому что, если гость позже решит удалить свои данные в этой системе (вы не будете уведомлены, когда это происходит), их данные не передаются другим контроллерам данных, над которыми вы не можете контролировать. При необходимости вы все равно можете сопоставить бронирования в этой системе с данными в диспетчере каналов, на странице сведений о бронировании будет показан номер бронирования для это бронирование, как оно хранится в диспетчере каналов. ");
jr_define ('BEDS24V2_MASTER_APIKEY', "ЭКСПЕРИМЕНТАЛЬНАЯ ФУНКЦИЯ - API-ключ Master Beds24");
jr_define ('BEDS24V2_MASTER_APIKEY_DESC', "ЕСЛИ У ВАС УЖЕ ИМЕЕТСЯ УСТАНОВКА JOMRES С СВЯЗАННЫМИ СВОЙСТВАМИ24, ПРОЧИТАЙТЕ ВСЕ ОПИСАНИЕ ЗДЕСЬ. По умолчанию Jomres предназначен для использования в качестве платформы для бронирования мест от нескольких поставщиков. Менеджеры24 могут иметь свои собственные учетные записи для бронирования кроватей. Менеджеры24 могут иметь собственные учетные записи для бронирования кроватей. properties на кровати24 и обратно. Этот параметр позволяет вам переопределить эту функцию, имея один ключ API для всех свойств. Это означает, что вам нужна только одна учетная запись на Beds24, однако это также означает, что все расходы будут начислены с этой одной учетной записи. Любой менеджер, имеющий доступ к ресурсу, сможет отправлять обновления для этого ресурса на серверах bed24. Оставьте поле пустым, чтобы игнорировать этот параметр и заставить менеджеров собственности использовать свои собственные аккаунты Beds24. Ключ API может принимать любую желаемую форму, пока поскольку здесь ключ соответствует ключу в <a href='https://www.beds24.com/control2.php?pagetype=accountpassword' target='_blank'> <em> Ключ API 1 </em> </ a>. ЕСЛИ У ВАС УЖЕ ЕСТЬ УСТАНОВКА ON OF JOMRES С СВОЙСТВАМИ, СВЯЗАННЫМИ С BEDS24: вы можете переключиться на использование этой функции, однако для этого потребуется сначала усечь (очистить) эти таблицы, удалить существующие свойства, которые уже находятся в Jomres, а затем повторно импортировать свойства. из Beds24 в Jomres. XXXXX_jomres_beds24_contract_booking_number_xref, XXXXX_jomres_beds24_property_uid_xref, XXXXX_jomres_beds24_rest_api_key_xref, XXXXX_jomres_beds24_room_type_xref. <br/> <br/> При установке ключа API в разделе <em> API Key N </em> на странице доступа к аккаунту Beds24 жизненно важно, чтобы вы установили в поле <em> API Key Access </em> значение Разрешить только IP-адреса в белом списке, и вы устанавливаете IP-адрес на <strong>". $this_servers_ip_number. "</strong> Это в равной степени относится к конфигурации главного ключа API здесь и во внешнем интерфейсе, если менеджер свойств настраивает свой собственный индивидуальный API. ключи. ");
jr_define ('BEDS24V2_WHITELIST_WARNING', "Если ваши объекты уже были подключены к Beds24, имейте в виду, что Beds24 недавно ввел политику, согласно которой все серверы, подключающиеся к вашей учетной записи, должны быть внесены в белый список. Вы можете сделать это на странице доступа к учетной записи, где ваш ключ доступа введен. Выберите раскрывающийся список IP-адресов в белом списке и установите для IP-адреса значение ");