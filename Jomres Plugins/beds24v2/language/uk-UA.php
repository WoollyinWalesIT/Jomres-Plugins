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
jr_define ('BEDS24V2_CHANNEL_MANAGEMENT', 'Керування каналами (Beds24)');

jr_define ('BEDS24V2_WEBHOOKS_AUTH_METHOD', 'Ліжка24');
jr_define ('BEDS24V2_WEBHOOKS_AUTH_METHOD_NOTES', 'Якщо у вас є обліковий запис Beds24 і ви хочете оновити Beds24 під час бронювання, будь ласка, виберіть цей параметр. Встановіть URL -адресу https://www.beds24.com/api/json/');
jr_define ('BEDS24V2_ERROR_USER_NO_KEY', 'Цей користувач не має встановлених ключів API, тому не може продовжувати. Будь ласка, відвідайте його сторінку на сторінці "Керування користувачами"> "Менеджери властивостей" та створіть для них новий ключ API за посиланням, наданим на цій сторінці. ');
jr_define ('BEDS24V2_ERROR_USER_NO_PROPERTIES', 'Цей користувач не має властивостей Джомреса, які він може призначити властивостям Beds24, або навпаки');
jr_define ('BEDS24V2_NOT_SUBSCRIBED', "Адміністратор, у якому ви ввійшли, схоже, не має облікового запису з Beds24, тому вам потрібно буде спочатку зареєструватися для їх обслуговування, а потім зберегти цей ключ API на <a href = 'https:/ /www.beds24.com/control2.php?pagetype=accountpassword 'target =' _ blank '> Веб -сайт Beds24 тут. </a> ");
jr_define ('BEDS24V2_NOT_SUBSCRIBED_KEY', "Скопіюйте та вставте цей ключ API у поле LINK у своєму обліковому записі Beds24, щоб продовжити.");
jr_define ('BEDS24V2_NOT_SUBSCRIBED_RELOAD', "Коли ви це зробите, натисніть кнопку нижче, щоб продовжити.");
jr_define ('BEDS24V2_DISPLAY_PROPERTIES_TITLE', "Зв'язування властивостей Beds24");
jr_define ('BEDS24V2_DISPLAY_PROPERTIES_INFO', 'Ця сторінка дозволяє переглядати властивості, до яких ви маєте доступ у цій системі, а також ті, що існують у Менеджері каналів. Вона також дозволяє імпортувати властивості з Менеджера каналів у цю систему або експортувати наявних властивостей до Менеджера каналів. <br/> Якщо у вас є властивості як у цій системі, так і в Beds24, і ви хочете зв’язати їх між собою, ви можете скористатися апікером властивостей для цього. Перейдіть у Beds24> Налаштування> Властивості (переконайтесь, що властивість, вибрана у випадаючому списку, така ж, як і те, яку ви хочете зв’язати), потім у підменю Посилання збережіть "apikey властивості" у полі "propKey" у Beds24. Після цього перезавантажте сторінку. побачити, що ці дві властивості пов’язані з одним ключем, і створити необхідні асоціації. Після того, як ці дві властивості зв’язані, не забудьте відвідати сторінку "Перегляд властивостей", знайти URL -адресу сповіщення та вставити її у поле "Повідомляти URL -адресу" сторінки. Що буде переконайтеся, що Beds24 використовує правильне посилання для синхронізації бронювань із цією властивістю, коли вона отримує бронювання. ');
jr_define ('BEDS24V2_DISPLAY_PROPERTIES_NO_PROPERTIES', "Помилка: Немає властивостей, до яких можна зв’язати посилання24. Це може бути пов'язано з тим, що всі властивості, на які ви маєте права, вже були пов’язані з іншим обліковим записом у цій системі.");
jr_define ('BEDS24V2_DISPLAY_PROPERTIES_PROPERTY_UID', "Ідентифікатор властивості");
jr_define ('BEDS24V2_DISPLAY_PROPERTIES_PROPERTY_NAME', "Назва власності");
jr_define ('BEDS24V2_DISPLAY_PROPERTIES_BEDS24_PROPERTY_UID', "Beds24 Property Uid");
jr_define ('BEDS24V2_DISPLAY_PROPERTIES_BEDS24_PROPERTY_NAME', "Назва власності Beds24");
jr_define ('BEDS24V2_DISPLAY_PROPERTY_APIKEY', "apikey власності");
jr_define ('BEDS24_LISTPROPERTIES_IMPORT', "Імпорт");
jr_define ('BEDS24_LISTPROPERTIES_ASSOCIATE_ROOM_TYPES', "Налаштувати типи кімнат");
jr_define ('BEDS24_LISTPROPERTIES_ASSOCIATE_ROOM_TYPES_DESC', "Тут вам потрібно зв’язати типи кімнат у вашому обліковому записі Beds24 з тими, що зберігаються в цій системі.");
jr_define ('_BEDS24_DISPLAY_BOOKINGS_JOMRESROOMS_BEDS24TYPENAME', "Тип кімнати для ліжок24");

jr_define ('BEDS24_LISTPROPERTIES_IMPORT_CANNOT_NOAPIKEY', "Неможливо імпортувати цю властивість, оскільки ви не встановили ключ власності на сторінці посилання на властивості.");
jr_define ('BEDS24_LISTPROPERTIES_IMPORT_CANNOT_NOROOMS', "Поки що не вдається імпортувати цю власність, оскільки у ній немає кімнат. Будь ласка, створіть одну або кілька кімнат (кімнати на ліжках 24 такі ж, як типи номерів у Джомресі) і не забудьте встановити мінімальну ціну) . Після того, як ви це зробите, ви можете імпортувати тип кімнати в Jomres та пов’язати їх із поточними типами номерів Jomres. Після цього ви зможете змінювати тарифи, але потрібно встановити мінімальну ціну. ");
jr_define ('_BEDS24_SUGGESTED_KEY', "Ми пропонуємо вам використовувати цей ключ API. Після цього перезавантажте цю сторінку.");
jr_define ('BEDS24_LISTPROPERTIES_EXPORT', "Експорт");
jr_define ('BEDS24V2_REST_API_INTRO', "Тут ви можете побачити пару ключів API REST та шлях до API. Якщо ви збережете ці дані у своєму обліковому записі на Beds24, Beds24 24 зможе зв’язатися з цим сайтом через його API.");
jr_define ('BEDS24V2_REST_API_CLIENT_ID', "Ідентифікатор клієнта");
jr_define ('BEDS24V2_REST_API_CLIENT_SECRET', "Секрет клієнта");
jr_define ('BEDS24V2_REST_API_ENDPOINT', "URI (кінцева точка)");
jr_define ('BEDS24_LISTPROPERTIES_CONFIGURE', "Переглянути властивість");
jr_define ('BEDS24_ROOM_TYPES_TITLE', "Асоціації типу кімнати");
    
    jr_define ('BEDS24_ROOM_TYPES_INFO', "Ця сторінка дозволяє асоціювати типи кімнат з тими, що зберігаються на серверах Beds24.");
jr_define ('BEDS24_ROOM_TYPES_INFO2', "Поки типи номерів не будуть пов'язані, ви не зможете отримувати інформацію про бронювання, надіслану Beds24. Якщо ваша нерухомість імпортована/експортована на або з Beds24, ми автоматично створили для вас посилання, однак, якщо ви додасте новий тип кімнати або видалити її, то цю сторінку можна використовувати, щоб переконатися, що тип кімнати правильно пов’язаний. ");
jr_define ('BEDS24_ROOM_TYPES_INFO3', "Виберіть типи кімнат Beds24, які потрібно пов'язати з типами кімнат у цій системі, а після завершення натисніть Зберегти, щоб оновити зміни до Beds24.");
jr_define ('BEDS24_ROOM_TYPES_YOURS', "Ваші типи номерів");
jr_define ('BEDS24_ROOM_TYPES_BEDS24', "Типи кімнат Ліжка24 ");
jr_define ('BEDS24_ROOM_TYPES_NONE', "Ця властивість не має типів кімнат, тому не може бути пов'язана з будь -якими типами номерів Beds24. Хочете імпортувати типи кімнат з Beds24? ");
jr_define ('BEDS24_IMPORT_ROOMS', "Імпорт кімнат");
jr_define ('BEDS24_EXPORT_BOOKINGS', "Експорт бронювань");
jr_define ('BEDS24_IMPORT_BOOKINGS', "Імпортувати бронювання");
jr_define ('BEDS24_IMPORT_EXPORT', "Ви можете імпортувати та експортувати наявні бронювання з та на ліжка24 одним натисканням кнопки. Замовлення, імпортовані з ліжок 24, імпортуються з вчорашнього дня та включатимуть усі бронювання на наступний рік. Ці кнопки слід використовувати лише після спочатку імпортувати або експортувати майно в систему. Після налаштування імпорт та/або експорт здійснюватиметься автоматично. ");
jr_define ('_BEDS24_CHANNEL_MANAGEMENT_UPDATE_PRICING_YESNO', "Оновити ціни до ліжок 24?");
jr_define ('_BEDS24_CHANNEL_MANAGEMENT_UPDATE_PRICING_YESNO_DESC', "Ви можете оновити Beds24 лише з наявністю або доступністю та цінами. Якщо ви використовуєте певні ситуації, коли ви хочете використовувати панель керування Beds24 для встановлення конкретних цін для конкретних каналів, залиште цей параметр на Немає.");
jr_define ('_BEDS24_CONTROL_PANEL_DIRECT', "Пряме посилання");
jr_define ('BEDS24_IMPORT_NOTIFICATION_URLS', "Якщо ви імпортували цю властивість у Jomres, вам потрібно буде вручну змінити URL -адресу сповіщення у ваших Beds24 -> Властивість -> Налаштування посилання на таке:");
jr_define ('BEDS24V2_ERROR_KEYS_SHOULD_BE_REGENERATED', "Наразі у вас немає властивостей, пов'язаних із властивостями Beds24. Перш ніж дозволити вашим менеджерам намагатися підключитися до Beds24, потрібно скинути ключі API вашого менеджера. Це гарантує, що всі вони мають унікальні ключі.");
jr_define ('BEDS24V2_ERROR_KEYS_REBUILD', "Скинути ключі API менеджера зараз");
jr_define ('BEDS24V2_ERROR_KEYS_DISMISS', "Ігнорувати попередження");
jr_define ('BEDS24V2_ERROR_KEYS_DONE', "Ключі API менеджера скинуто");

jr_define ('BEDS24V2_ADMINISTRATOR_LINKS_TITLE', "Посилання на властивості Beds24");
jr_define ('BEDS24_ASSIGN_MANAGER', "Менеджер змін Beds24");
jr_define ('BEDS24_ASSIGN_MANAGER_DESC', "Коли менеджер переглядає сторінку Керування каналами (Bed24) у зовнішньому інтерфейсі, будь -які властивості, які мають спільний ключ API як в Jomres, так і в Beds24, автоматично зв'язуються в Jomres. Аналогічно, будь -які властивості, імпортовані або експортовані менеджером) Ви можете змінити менеджера, з яким пов’язана властивість, змінивши спадне меню менеджера на цій сторінці, а потім натиснувши Зберегти. ");
jr_define ('BEDS24V2_TARIFFS_TITLE', "Експорт тарифів");
jr_define ('BEDS24V2_TARIFF_EXPORT_DESC', "Ви можете експортувати створені вами тарифи в Beds24 за певною денною ставкою. Якщо ви збираєтеся використовувати цю функцію, ви повинні встановити параметр Оновити ціни до Beds24? у Конфігурації власності на Ні. Ви Можливо, вам також доведеться налаштувати вашу власність на панелі керування Beds24, щоб ви могли мати кілька денних тарифів. Для цього перейдіть у Налаштування> Властивості> Кімнати> Ціни за день і налаштуйте параметр Кількість денних цін на потрібну вам ціну. Як тільки ви це зробите, ви зможете натиснути одну з кнопок Р, щоб встановити цю денну норму. ");
jr_define ('BEDS24V2_TARIFF_EXPORT_TARIFFNAME', "Назва тарифу");
jr_define ('BEDS24V2_TARIFF_EXPORT_TARIFF_ROOM_TYPE', "Тип кімнати");
jr_define ('BEDS24V2_BOOKING_RESEND', "Повторно надіслати сповіщення");
jr_define ('BEDS24V2_BOOKING_DATA_AT_B24', "Це інформація про бронювання, яка зберігається на Beds24. Якщо ви не впевнені, що дані неправильні, вам не потрібно повторно надсилати бронювання на Beds24.");
jr_define ('BEDS24V2_BOOKING_NO_DATA_AT_B24', "Це бронювання, схоже, не пов'язане з бронюванням на ліжках24. Ви можете скористатися кнопкою Надіслати повторно, щоб експортувати це бронювання на ліжка24.");

jr_define ('BEDS24V2_GDPR_ANONYMISE_GUESTS', "Анонімізувати гостей?");
jr_define ('BEDS24V2_GDPR_ANONYMISE_GUESTS_DESC', "Коли бронювання надсилається менеджеру каналу, ми рекомендуємо анонімізувати дані гостя. Якщо ви встановите цей параметр на Так , коли інформація про бронювання надсилається менеджеру каналу, ім'я гостя, адреса електронної пошти не є . OTA матимуть точний запис вашої доступності без необхідності передавати більше інформації, ніж необхідно. Це означає, що ви відповідаєте GDPR, тому що якщо гість пізніше вирішить видалити свої дані в цій системі (ви не отримаєте повідомлення ), їхні дані не передаються іншим контролерам даних, над якими ви не контролюєте. За необхідності ви все ще можете перехресне посилання на бронювання в цій системі з тими, що є в менеджері каналу, на сторінці Інформація про бронювання буде показано номер бронювання для це бронювання, оскільки воно зберігається в менеджері каналу. ");
jr_define ('BEDS24V2_MASTER_APIKEY', "ЕКСПЕРИМЕНТАЛЬНА ФУНКЦІЯ - ключ API Master Beds24");
jr_define ('BEDS24V2_MASTER_APIKEY_DESC', "ЯКЩО ВИ ВЖЕ ВСТАНОВЛИЛИ ДЖОМРЕС З ВЛАСНІСТЯМИ, ЗВ'ЯЗАНИМИ НА ЛІЖКИ24. ПРОЧИТАЙТЕ ВСЕ ОПИС ТУТ. За замовчуванням Jomres призначений для власних платформ для бронювання облікових записів Mana24. властивості на та з ліжок24 надійно. Це налаштування дозволяє вам змінити цю функціональність, маючи єдиний ключ API для всіх властивостей. Це означає, що вам потрібен лише один обліковий запис із ліжками24, однак це також означає, що всі витрати будуть нараховуватися цим одним обліковим записом. Будь -який менеджер, який має доступ до власності, зможе надсилати оновлення до власності на серверах beds24. Залиште поле порожнім, щоб проігнорувати це налаштування та змусити менеджерів власності використовувати власні облікові записи Beds24. Ключ API може мати будь -яку форму, так довго оскільки ключ тут відповідає ключу в <a href='https://www.beds24.com/control2.php?pagetype=accountpassword' target='_blank'> <em> ключі API 1 </em> </ a> поле. ЯКЩО ВИ ВЖЕ МАЄТЕ ВСТАНОВЛЕННЯ З ДЖОМРЕСУ З ВЛАСТИВОСТЯМИ, ЗВ'ЯЗАНИМИ З ЛІЖКАМИ24: Ви можете перейти до використання цієї функції, проте для цього потрібно спочатку урізати (очистити) ці таблиці, видалити наявні властивості, які вже є у Джомресі, а потім повторно імпортувати властивості від Beds24 до Jomres. XXXXX_jomres_beds24_contract_booking_number_xref, XXXXX_jomres_beds24_property_uid_xref, XXXXX_jomres_beds24_rest_api_key_xref, XXXXX_jomres_beds24_room_type_xref. <br/> <br/> Під час встановлення ключа API у розділі <em> Ключ API N </em> на сторінці доступу до облікового запису Beds24 важливо встановити для поля <em> Доступ до ключа API </em> значення  Дозволити лише IP -адреси з білого списку , і ви встановите для IP -номера значення ". $this_servers_ip_number." </strong> Це однаково стосується конфігурації ключа головного API тут, а також у зовнішній частині, якщо менеджер власності налаштовує свій власний індивідуальний API ключі. ");
jr_define ('BEDS24V2_WHITELIST_WARNING', "Якщо ваші властивості вже підключені до Beds24, майте на увазі, що Beds24 нещодавно запровадила політику, згідно з якою всі сервери, що підключаються до вашого облікового запису, повинні бути в білому списку. Це можна зробити на сторінці доступу до облікового запису, де Ваш ключ доступу введено. Виберіть спадне меню IP -адреса білого списку та встановіть номер IP на ");