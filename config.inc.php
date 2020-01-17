<?php
namespace MRBS;

// $Id$

/**************************************************************************
 *   MRBS Configuration File
 *   Configure this file for your site.
 *   You shouldn't have to modify anything outside this file.
 *
 *   This file has already been populated with the minimum set of configuration
 *   variables that you will need to change to get your system up and running.
 *   If you want to change any of the other settings in systemdefaults.inc.php
 *   or areadefaults.inc.php, then copy the relevant lines into this file
 *   and edit them here.   This file will override the default settings and
 *   when you upgrade to a new version of MRBS the config file is preserved.
 **************************************************************************/

/**********
 * Timezone
 **********/
 
// The timezone your meeting rooms run in. It is especially important
// to set this if you're using PHP 5 on Linux. In this configuration
// if you don't, meetings in a different DST than you are currently
// in are offset by the DST offset incorrectly.
//
// Note that timezones can be set on a per-area basis, so strictly speaking this
// setting should be in areadefaults.inc.php, but as it is so important to set
// the right timezone it is included here.
//
// When upgrading an existing installation, this should be set to the
// timezone the web server runs in.  See the INSTALL document for more information.
//
// A list of valid timezones can be found at http://php.net/manual/timezones.php
// The following line must be uncommented by removing the '//' at the beginning
$timezone = "America/Sao_Paulo";


/*******************
 * Database settings
 ******************/
// Which database system: "pgsql"=PostgreSQL, "mysql"=MySQL
$dbsys = "mysql";
// Hostname of database server. For pgsql, can use "" instead of localhost
// to use Unix Domain Sockets instead of TCP/IP. For mysql "localhost"
// tells the system to use Unix Domain Sockets, and $db_port will be ignored;
// if you want to force TCP connection you can use "127.0.0.1".
$db_host = "localhost";
// If you need to use a non standard port for the database connection you
// can uncomment the following line and specify the port number
// $db_port = 1234;
// Database name:
$db_database = "mrbsic_dev";
// Schema name.  This only applies to PostgreSQL and is only necessary if you have more
// than one schema in your database and also you are using the same MRBS table names in
// multiple schemas.
//$db_schema = "public";
// Database login user name:
$db_login = "root";
// Database login password:
$db_password = 'efc2505xx';
// Prefix for table names.  This will allow multiple installations where only
// one database is available
$db_tbl_prefix = "mrbs_";
// Set $db_persist to TRUE to use PHP persistent (pooled) database connections.  Note
// that persistent connections are not recommended unless your system suffers significant
// performance problems without them.   They can cause problems with transactions and
// locks (see http://php.net/manual/en/features.persistent-connections.php) and although
// MRBS tries to avoid those problems, it is generally better not to use persistent
// connections if you can.
$db_persist = FALSE;


/* Add lines from systemdefaults.inc.php and areadefaults.inc.php below here
   to change the default configuration. Do _NOT_ modify systemdefaults.inc.php
   or areadefaults.inc.php.  */

$mrbs_admin = "Reservas";
$mrbs_admin_email = "ismael@ic.unicamp.br";
$mrbs_company = "Instituto de Computação - UNICAMP";   // This line must always be uncommented ($mrbs_company is used in various places)
$mrbs_company_logo = "ic.gif";    // name of your logo file.   This example assumes it is in the MRBS directory
$mrbs_company_url = "http://www.ic.unicamp.br/";

$unicode_encoding = 1;
$strftime_format['daymonth'] = "%d %b";
$twentyfourhour_format = 1;

$ldap_host = "ldap2.ic.unicamp.br";
$ldap_port = 389;
$ldap_v3 = true;
$ldap_tls = true;
$ldap_base_dn = "ou=People,dc=ic,dc=unicamp,dc=br";
$ldap_user_attrib = "uid";
$ldap_filter = "|(gidNumber=1312)(gidNumber=1104)(gidNumber=600)(uid=fabio.povoa)(lab=reservas)(&(gidNumber=500)(uid=testert))";
$ldap_debug = TRUE;
$ldap_perm_groups = array(500=>'spec',600=>'admic',1312=>'admsis',1104=>'staff',706=>'grad');

//$auth["type"] = "ldap";
$auth["admin"][] = "camila";
$auth["admin"][] = "isaac";
$auth["admin"][] = "william";
$auth["admin"][] = "ismael";
$auth["admin"][] = "serafim";
$auth["admin"][] = "rubensjr";
$auth["admin"][] = "pasergio";
$auth["admin"][] = "everton";
//RESERVAS ATUAL
/**
$auth["admin"][] = "127.0.0.1";     // localhost IP address. Useful with IP sessions.
$auth["admin"][] = "camila"; // A user name from the user list. Useful 
$auth["admin"][] = "capeleto"; // A user name from the user list. Useful 
$auth["admin"][] = "cris_mcamargo"; // A user name from the user list. Useful 
$auth["admin"][] = "vera"; // A user name from the user list. Useful 
$auth["admin"][] = "denise"; // A user name from the user list. Useful 
$auth["admin"][] = "wbagni"; // A user name from the user list. Useful 
$auth["admin"][] = "flavio"; // A user name from the user list. Useful 
$auth["admin"][] = "michel"; // A user name from the user list. Useful 
$auth["admin"][] = "rosana"; // A user name from the user list. Useful 
$auth["admin"][] = "estag-cpg"; // Conforme RT # 36741
$auth["admin"][] = "estag-cpg2"; // Conforme RT # 36741
$auth["admin"][] = "denilson"; // Conforme RT # 39499
$auth["admin"][] = "pollini"; // Conforme RT # 41927
$auth["admin"][] = "fabio.povoa";
$auth["admin"][] = "branquinho"; // Conforme RT # 42299



**/

//unset($booking_types);    // Include this line when copying to config.inc.php
$booking_types[] = "A";
$vocab_override["en"]["type.A"] = "Aula";
$booking_types[] = "B";
$vocab_override["en"]["type.B"] = "Palestra";
$booking_types[] = "C";
$vocab_override["en"]["type.C"] = "Reunião";
$booking_types[] = "D";
$vocab_override["en"]["type.D"] = "Tese/Dissertação";
$booking_types[] = "F";
$vocab_override["en"]["type.F"] = "Congregação";
$booking_types[] = "G";
$vocab_override["en"]["type.G"] = "Concurso";
$booking_types[] = "H";
$vocab_override["en"]["type.H"] = "Feriado";
$booking_types[] = "J";

/*
BOOKING TYPES ATUAL
$typel["A"] = "Aula";
$typel["B"] = "Palestra";
$typel["C"] = "Reunião";
$typel["D"] = "Tese/Dissertação";
$typel["E"] = get_vocab("external");
$typel["F"] = "Congregação";
$typel["G"] = "Concurso";
$typel["H"] = "Feriado";
$typel["I"] = get_vocab("internal");
$typel["J"] = "EQ";


*/

//override mail configs

$mail_settings['admin_on_bookings']      = TRUE;  // the addresses defined by $mail_settings['recipients'] below
$mail_settings['area_admin_on_bookings'] = TRUE;  // the area administrator
$mail_settings['room_admin_on_bookings'] = TRUE;  // the room administrator
$mail_settings['booker']                 = TRUE;  // the person making the booking
$mail_settings['book_admin_on_approval'] = TRUE;  // the booking administrator when booking approval is enabled
                                                   // (which is the MRBS admin, but this setting allows MRBS
                                                   // to be extended to have separate booking approvers)     


$mail_settings['domain'] = '@ic.unicamp.br ';
 
$mail_settings['on_new']    = TRUE;   // when an entry is created
$mail_settings['on_delete'] = TRUE;  // when an entry is deleted

$mail_settings['details']   = TRUE; // Set to TRUE if you want full booking details;
                                     // otherwise you just get a link to the entry
$mail_settings['html']      = TRUE; // Set to true if you want HTML mail

$sendmail_settings['path'] = '/usr/sbin/sendmail';
$mail_settings['from'] = $mrbs_admin_email;
$mail_settings['recipients'] = $mrbs_admin_email;

// Set the language used for emails (choose an available lang.* file).
$mail_settings['admin_lang'] = 'pt-br';   // Default is 'en'.










/**
MAIL SETTINGS ATUAL
// Set to TRUE if you want to be notified when entries are booked. Default is
// FALSE
define ("MAIL_ADMIN_ON_BOOKINGS", TRUE);

// Set to TRUE if you want AREA ADMIN to be notified when entries are booked.
// Default is FALSE. Area admin emails are set in room_area admin page.
define ("MAIL_AREA_ADMIN_ON_BOOKINGS", FALSE);

// Set to TRUE if you want ROOM ADMIN to be notified when entries are booked.
// Default is FALSE. Room admin emails are set in room_area admin page.
define ("MAIL_ROOM_ADMIN_ON_BOOKINGS", TRUE);

// Set to TRUE if you want ADMIN to be notified when entries are deleted. Email
// will be sent to mrbs admin, area admin and room admin as per above settings,
// as well as to booker if MAIL_BOOKER is TRUE (see below).
define ("MAIL_ADMIN_ON_DELETE", TRUE);

// Set to TRUE if you want to be notified on every change (i.e, on new entries)
// but also each time they are edited. Default is FALSE (only new entries)
define ("MAIL_ADMIN_ALL", TRUE);

// Set to TRUE is you want to show entry details in email, otherwise only a
// link to view_entry is provided. Irrelevant for deleted entries. Default is
// FALSE.
define ("MAIL_DETAILS", TRUE);

// Set to TRUE if you want BOOKER to receive a copy of his entries as well any
// changes (depends of MAIL_ADMIN_ALL, see below). Default is FALSE. To know
// how to set mrbs to send emails to users/bookers, see INSTALL.
define ("MAIL_BOOKER", TRUE);

// If MAIL_BOOKER is set to TRUE (see above) and you use an authentication
// scheme other than 'auth_db', you need to provide the mail domain that will
// be appended to the username to produce a valid email address (ie.
// "@domain.com").
define ("MAIL_DOMAIN", '@ic.unicamp.br');

// If you use MAIL_DOMAIN above and username returned by mrbs contains extra
// strings appended like domain name ('username.domain'), you need to provide
// this extra string here so that it will be removed from the username.
define ("MAIL_USERNAME_SUFFIX", '');

// Set the name of the Backend used to transport your mails. Either "mail",
// "smtp" or "sendmail". Default is 'mail'. See INSTALL for more details.
define ("MAIL_ADMIN_BACKEND", "smtp");

// Set the language used for emails (choose an available lang.* file).
// Default is 'en'.
define ("MAIL_ADMIN_LANG", 'pt-br');

// Set the email address of the From field. Default is $mrbs_admin_email
define ("MAIL_FROM", $mrbs_admin_email);

// Set the recipient email. Default is $mrbs_admin_email. You can define
// more than one recipient like this "john@doe.com,scott@tiger.com"
define ("MAIL_RECIPIENTS", $mrbs_admin_email);

// Set email address of the Carbon Copy field. Default is ''. You can define
// more than one recipient (see MAIL_RECIPIENTS)
define ("MAIL_CC", '');


**/


$vocab_override["en"]["type.J"] = "EQ";
$vocab_override["en"]["entry.hasVideoConf"]="Will it have video conference?";
$vocab_override["pt-br"]["entry.hasVideoConf"]="Terá vídeo conferência?";
$vocab_override["en"]["entry.hasRecording"]="Will it have recording/streaming?";
$vocab_override["pt-br"]["entry.hasRecording"]="Terá gravação/streaming?";

//mrbs_admin_email is used in the settings of: mail_from and mail_recipients
