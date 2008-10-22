<?php
/*---------------------------------------------------+
| ExiteCMS Content Management System                 |
+----------------------------------------------------+
| Copyright 2007 Harro "WanWizard" Verton, Exite BV  |
| for support, please visit http://exitecms.exite.eu |
+----------------------------------------------------+
| Released under the terms & conditions of v2 of the |
| GNU General Public License. For details refer to   |
| the included gpl.txt file or visit http://gnu.org  |
+----------------------------------------------------*/
if (!checkrights("I") || !defined("iAUTH") || $aid != iAUTH || !defined('INIT_CMS_OK')) fallback(BASEDIR."index.php");

/*---------------------------------------------------+
| Module identification                              |
+----------------------------------------------------*/
$mod_title = "Shoutbox";
$mod_description = "Shoutbox side panel";
$mod_version = "1.1.1";
$mod_developer = "WanWizard";
$mod_email = "wanwizard@gmail.com";
$mod_weburl = "http://exitecms.exite.eu/";
$mod_type = "P";

/*---------------------------------------------------+
| Module administration panel installation details   |
+----------------------------------------------------*/

$mod_folder = "shoutbox_panel";
$mod_admin_image = "shout.gif";							// icon to be used for the admin panel
$mod_admin_panel = "shoutbox_admin.php";				// name of the admin panel for this module
$mod_admin_rights = "S";								// admin rights code. This HAS to be assigned by ExiteCMS to avoid duplicates!
$mod_admin_page = 2;									// admin page this panel has to be placed on

/*---------------------------------------------------+
| Version and revision control                       |
+----------------------------------------------------*/

// check for a minumum version of the ExiteCMS engine
if (str_replace(".", "", $settings['version']) < 720) {
	$mod_errors .= sprintf($locale['mod001'], '7.20');
}
// check for a maximum version of the ExiteCMS engine
if (str_replace(".", "", $settings['version']) > 720) {
	$mod_errors .= sprintf($locale['mod002'], '7.20');
}
// check for a specific revision number range that is supported
if ($settings['revision'] < 0 || $settings['revision'] > 999999) {
	$mod_errors .= sprintf($locale['mod003'], 0, 999999);
}

/*---------------------------------------------------+
| Menu entries for this module                       |
+----------------------------------------------------*/

$mod_site_links = array();

/*---------------------------------------------------+
| locale strings for this module                     |
+----------------------------------------------------*/

$localestrings = array();

$localestrings['en'] = array();
$localestrings['en']['400'] = "Delete Shouts";
$localestrings['en']['401'] = "Shouts have been deleted";
$localestrings['en']['402'] = "Return to Shoutbox Admin";
$localestrings['en']['403'] = "Return to Admin Index";
$localestrings['en']['404'] = "Delete Shout";
$localestrings['en']['405'] = "Shout deleted";
$localestrings['en']['406'] = "Shout from";
// Edit Shout
$localestrings['en']['420'] = "Edit Shout";
$localestrings['en']['421'] = "Shout Message:";
$localestrings['en']['422'] = "Save Shout";
// Prune Shoutbox
$localestrings['en']['430'] = "Delete Shouts older than";
$localestrings['en']['431'] = " days";
$localestrings['en']['432'] = "Delete Shouts";
// Current Shouts
$localestrings['en']['440'] = "Current Shouts";
$localestrings['en']['441'] = "Edit";
$localestrings['en']['442'] = "Delete";
$localestrings['en']['443'] = "User IP: ";
$localestrings['en']['444'] = "No shouts have been posted.";

$localestrings['nl'] = array();
$localestrings['nl']['400'] = "Shouts verwijderen";
$localestrings['nl']['401'] = "Shouts verwijderd";
$localestrings['nl']['402'] = "Terug naar Shoutbox Beheer";
$localestrings['nl']['403'] = "Terug naar Beheerder Index";
$localestrings['nl']['404'] = "Shout verwijderen";
$localestrings['nl']['405'] = "Shout verwijderd";
// Shout - Wijzigen
$localestrings['nl']['420'] = "Shout wijzigen";
$localestrings['nl']['421'] = "Shout tekst:";
$localestrings['nl']['422'] = "Shout opslaan";
// Shoutbox - Snoeien
$localestrings['nl']['430'] = "Shouts ouder dan";
$localestrings['nl']['431'] = " dagen verwijderen";
$localestrings['nl']['432'] = "Shouts verwijderen";
// Bestaande Shouts
$localestrings['nl']['440'] = "Bestaande Shouts";
$localestrings['nl']['441'] = "Wijzigen";
$localestrings['nl']['442'] = "Verwijderen";
$localestrings['nl']['443'] = "Gebruiker-IP: ";
$localestrings['nl']['444'] = "Er zijn nog geen Shouts geplaatst.";

$localestrings['da'] = array();
$localestrings['da']['400'] = "Slet replikker";
$localestrings['da']['401'] = "Replikkerne er slettet";
$localestrings['da']['402'] = "Tilbage til administration af replikboks";
$localestrings['da']['403'] = "Tilbage til administrationsside";
$localestrings['da']['404'] = "Slet replik";
$localestrings['da']['405'] = "Replikken er slettet";
// Edit Shout
$localestrings['da']['420'] = "Rediger replik";
$localestrings['da']['421'] = "Repliktekst:";
$localestrings['da']['422'] = "Gem replik";
// Prune Shoutbox
$localestrings['da']['430'] = "Slet replikker ældre end";
$localestrings['da']['431'] = " dage";
$localestrings['da']['432'] = "Slet replikker";
// Current Shouts
$localestrings['da']['440'] = "Aktuelle replikker";
$localestrings['da']['441'] = "Rediger";
$localestrings['da']['442'] = "Slet";
$localestrings['da']['443'] = "Brugers IP-adresse: ";
$localestrings['da']['444'] = "der er ikke skrevet replikker.";

$localestrings['fr'] = array();
$localestrings['da']['400'] = "Supprimer des messages";
$localestrings['da']['401'] = "messages effacés";
$localestrings['da']['402'] = "Retour à l'administration boîte de dialogue";
$localestrings['da']['403'] = "Retour à l'administration du site";
$localestrings['da']['404'] = "Supprimer un message";
$localestrings['da']['405'] = "Message effacé";
// Edit Shout
$localestrings['da']['420'] = "Editer un message";
$localestrings['da']['421'] = "Message:";
$localestrings['da']['422'] = "Sauvegarder";
// Prune Shoutbox
$localestrings['da']['430'] = "Supprimer les messages antérieurs à";
$localestrings['da']['431'] = " jours";
$localestrings['da']['432'] = "Supprimer les messages";
// Current Shouts
$localestrings['da']['440'] = "Messages actuels";
$localestrings['da']['441'] = "Editer";
$localestrings['da']['442'] = "Supprimer";
$localestrings['da']['443'] = "IP utilisateur: ";
$localestrings['da']['444'] = "Aucun message.";

$localestrings['de'] = array();
$localestrings['de']['400'] = "Shouts löschen";
$localestrings['de']['401'] = "Shouts wurden gelöscht";
$localestrings['de']['402'] = "Zurück zum Shoutbox Admin";
$localestrings['de']['403'] = "Zurück zum Admin Index";
$localestrings['de']['404'] = "Shout löschen";
$localestrings['de']['405'] = "Shout gelöscht";
// Edit Shout
$localestrings['de']['420'] = "Shout bearbeiten";
$localestrings['de']['421'] = "Shout Nachricht:";
$localestrings['de']['422'] = "Shout speichern";
// Prune Shoutbox
$localestrings['de']['430'] = "Shouts löschen die älter als";
$localestrings['de']['431'] = " Tage sind";
$localestrings['de']['432'] = "Shouts löschen";
// Current Shouts
$localestrings['de']['440'] = "Momentane Shouts";
$localestrings['de']['441'] = "Bearbeiten";
$localestrings['de']['442'] = "Löschen";
$localestrings['de']['443'] = "User IP: ";
$localestrings['de']['444'] = "Es wurden keine Shouts eingereicht.";

$localestrings['hu'] = array();
$localestrings['hu']['400'] = "Üzenetek törlése";
$localestrings['hu']['401'] = "Régebbi üzenetek törölve";
$localestrings['hu']['402'] = "Vissza az üzenõfal adminisztrációjára";
$localestrings['hu']['403'] = "Vissza az adminisztrátor fõoldalra";
$localestrings['hu']['404'] = "Üzenet törlése";
$localestrings['hu']['405'] = "Üzenet sikeresen törölve";
// Üzenetek szerkesztése
$localestrings['hu']['420'] = "Üzenet szerkesztése";
$localestrings['hu']['421'] = "Üzenet:";
$localestrings['hu']['422'] = "Mentés";
// Rövidítés
$localestrings['hu']['430'] = "";
$localestrings['hu']['431'] = " napnál régebbi üzenetek törlése";
$localestrings['hu']['432'] = "Üzenetek törlése";
// Jelenlegi üzenetek
$localestrings['hu']['440'] = "Jelenlegi üzenetek";
$localestrings['hu']['441'] = "Szerkesztés";
$localestrings['hu']['442'] = "Törlés";
$localestrings['hu']['443'] = "IP: ";
$localestrings['hu']['444'] = "Még nincs hozzászólás az üzenõfalon";

$localestrings['it'] = array();
$localestrings['it']['400'] = "Elimina Messaggi";
$localestrings['it']['401'] = "Messaggi sono stati eliminati";
$localestrings['it']['402'] = "Ritorna ad Amministrazione Shoutbox";
$localestrings['it']['403'] = "Ritorna ad Home Page Amministratore";
$localestrings['it']['404'] = "Elimina Messaggi";
$localestrings['it']['405'] = "Messaggio Eliminato";
// Edit Shout
$localestrings['it']['420'] = "Modifica Messaggio";
$localestrings['it']['421'] = "Messaggio:";
$localestrings['it']['422'] = "Salva Messaggio";
// Prune Shoutbox
$localestrings['it']['430'] = "Elimina Messaggi più vecchi di";
$localestrings['it']['431'] = " giorni";
$localestrings['it']['432'] = "Elimina Messaggi";
// Current Shouts
$localestrings['it']['440'] = "Messaggi Correnti";
$localestrings['it']['441'] = "Modifica";
$localestrings['it']['442'] = "Elimina";
$localestrings['it']['443'] = "IP Utente: ";
$localestrings['it']['444'] = "Non sono stati scritti messaggi";

$localestrings['no'] = array();
$localestrings['no']['400'] = "Slett replikker";
$localestrings['no']['401'] = "Replikkene er slettet";
$localestrings['no']['402'] = "Tilbake til administrasjon av skrabbleblokk";
$localestrings['no']['403'] = "Tilbake til administrasjonsside";
$localestrings['no']['404'] = "Slett replikk";
$localestrings['no']['405'] = "Replikken er slettet";
// Edit Shout
$localestrings['no']['420'] = "Rediger replikk";
$localestrings['no']['421'] = "Replikktekst:";
$localestrings['no']['422'] = "Lagre replikk";
// Prune Shoutbox
$localestrings['no']['430'] = "Slett replikker eldre enn";
$localestrings['no']['431'] = " dager";
$localestrings['no']['432'] = "Slett replikker";
// Current Shouts
$localestrings['no']['440'] = "Eksisterende replikker";
$localestrings['no']['441'] = "Rediger";
$localestrings['no']['442'] = "Slett";
$localestrings['no']['443'] = "Brukers IP-adresse: ";
$localestrings['no']['444'] = "Det er ikke skrevet replikker.";

$localestrings['li'] = array();
$localestrings['li']['400'] = "Trinti þinutes";
$localestrings['li']['401'] = "Þinutës iðtrintos";
$localestrings['li']['402'] = "Gráþti á ðaukyklos administracijà";
$localestrings['li']['403'] = "Gráþti á administracijos panelæ";
$localestrings['li']['404'] = "Trinti þinutæ";
$localestrings['li']['405'] = "Þinutë iðtrinta";
// Edit Shout
$localestrings['li']['420'] = "Redaguoti þinutæ";
$localestrings['li']['421'] = "Raðyti þinutæ:";
$localestrings['li']['422'] = "Iðsaugoti þinutæ";
// Prune Shoutbox
$localestrings['li']['430'] = "Trinti þinutes, senesnes nei";
$localestrings['li']['431'] = " dienø";
$localestrings['li']['432'] = "Trinti þinutes";
// Current Shouts
$localestrings['li']['440'] = "Esamos þinutës";
$localestrings['li']['441'] = "Redaguoti";
$localestrings['li']['442'] = "Trinti";
$localestrings['li']['443'] = "Vartotojo IP: ";
$localestrings['li']['444'] = "Nëra þinuèiø.";

$localestrings['po'] = array();
$localestrings['po']['400'] = "Usuñ Wpisy";
$localestrings['po']['401'] = "Wpisy Zosta³y Usuniête";
$localestrings['po']['402'] = "Powrót do Zarz±dzania Shoutboxem";
$localestrings['po']['403'] = "Powrót do Panelu Admina";
$localestrings['po']['404'] = "Usuñ Wpis";
$localestrings['po']['405'] = "Wpis Usuniêty";
// Edit Shout
$localestrings['po']['420'] = "Edytuj Wpis";
$localestrings['po']['421'] = "Tre¶æ Wpisu:";
$localestrings['po']['422'] = "Zapisz Wpis";
// Prune Shoutbox
$localestrings['po']['430'] = "Usuñ Wpisy starsze ni¿";
$localestrings['po']['431'] = " dni";
$localestrings['po']['432'] = "Usuñ Wpisy";
// Current Shouts
$localestrings['po']['440'] = "Obecne Wpisy";
$localestrings['po']['441'] = "Edycja";
$localestrings['po']['442'] = "Usuñ";
$localestrings['po']['443'] = "IP U¿ytkownika: ";
$localestrings['po']['444'] = "Brak Wpisów.";

$localestrings['ro'] = array();
$localestrings['ro']['400'] = "&#350;terge shout-urile";
$localestrings['ro']['401'] = "Shout-urile au fost &#351;terse";
$localestrings['ro']['402'] = "Revenire la Administrare shoutbox";
$localestrings['ro']['403'] = "Revenire la Index Administrare";
$localestrings['ro']['404'] = "&#350;terge shout";
$localestrings['ro']['405'] = "Shout &#351;ters";
// Edit Shout
$localestrings['ro']['420'] = "Editeaz&#259; shout";
$localestrings['ro']['421'] = "Scrie shout:";
$localestrings['ro']['422'] = "Salveaz&#259; shout";
// Prune Shoutbox
$localestrings['ro']['430'] = "&#350;terge shouturile mai vechi de";
$localestrings['ro']['431'] = " zile";
$localestrings['ro']['432'] = "&#350;terge shouturi";
// Current Shouts
$localestrings['ro']['440'] = "Shouturile actuale";
$localestrings['ro']['441'] = "Editeaz&#259;";
$localestrings['ro']['442'] = "&#350;terge";
$localestrings['ro']['443'] = "IP utilizator: ";
$localestrings['ro']['444'] = "Nici un shout postat.";

$localestrings['sp'] = array();
$localestrings['sp']['400'] = "Borrar Shouts";
$localestrings['sp']['401'] = "Shouts han sido borrados";
$localestrings['sp']['402'] = "Volver a la Administración de Shoutbox";
$localestrings['sp']['403'] = "Volver Indice de Administración";
$localestrings['sp']['404'] = "Borrar Shout";
$localestrings['sp']['405'] = "Shout Borrado";
// Edit Shout
$localestrings['sp']['420'] = "Editar Shout";
$localestrings['sp']['421'] = "Mensaje:";
$localestrings['sp']['422'] = "Guardar";
// Prune Shoutbox
$localestrings['sp']['430'] = "Borrar Shouts que tengan más de";
$localestrings['sp']['431'] = " días";
$localestrings['sp']['432'] = "Borrar";
// Current Shouts
$localestrings['sp']['440'] = "Shouts Actuales";
$localestrings['sp']['441'] = "Editar";
$localestrings['sp']['442'] = "Borrar";
$localestrings['sp']['443'] = "IP Usuario: ";
$localestrings['sp']['444'] = "No se han enviado shouts.";

$localestrings['sv'] = array();
$localestrings['sv']['400'] = "Radera meddelanden";
$localestrings['sv']['401'] = "Meddelandena är raderade";
$localestrings['sv']['402'] = "Tillbaka till administration av Klotterplanket";
$localestrings['sv']['403'] = "Tillbaka till administrationspanelen";
$localestrings['sv']['404'] = "Radera meddelande";
$localestrings['sv']['405'] = "Meddelandet raderat";
// Edit Shout
$localestrings['sv']['420'] = "Redigera meddelande";
$localestrings['sv']['421'] = "Meddelandets innehåll:";
$localestrings['sv']['422'] = "Spara meddelande";
// Prune Shoutbox
$localestrings['sv']['430'] = "Radera meddelanden äldre än";
$localestrings['sv']['431'] = " dagar";
$localestrings['sv']['432'] = "Radera meddelanden";
// Current Shouts
$localestrings['sv']['440'] = "Aktuella meddelanden";
$localestrings['sv']['441'] = "Redigera";
$localestrings['sv']['442'] = "Radera";
$localestrings['sv']['443'] = "Användares IP - nummer: ";
$localestrings['sv']['444'] = "Det finns inga meddelanden.";

$localestrings['tr'] = array();
$localestrings['tr']['400'] = "Kýsa Mesajlarý Sil";
$localestrings['tr']['401'] = "Kýsa Mesajlar Silindi";
$localestrings['tr']['402'] = "Kýsa Mesajlar Yönetimine Geri Dön";
$localestrings['tr']['403'] = "Site Yönetimine Geri Dön";
$localestrings['tr']['404'] = "Kýsa Mesaj Sil";
$localestrings['tr']['405'] = "Kýsa Mesaj Silindi";
// Edit Shout
$localestrings['tr']['420'] = "Kýsa Mesaj Düzenle";
$localestrings['tr']['421'] = "Kýsa Mesaj Metni:";
$localestrings['tr']['422'] = "Kýsa Mesajý Kaydet";
// Prune Shoutbox
$localestrings['tr']['430'] = "Geçmiþ Kýsa Mesajlarý Sil";
$localestrings['tr']['431'] = " günler";
$localestrings['tr']['432'] = "Kýsa Mesajlarý Sil";
// Current Shouts
$localestrings['tr']['440'] = "Geçerli Kýsa Mesajlar";
$localestrings['tr']['441'] = "Düzenle";
$localestrings['tr']['442'] = "Sil";
$localestrings['tr']['443'] = "Üye IP: ";
$localestrings['tr']['444'] = "Henüz Kýsa Mesaj Gönderilmemiþ.";

/*---------------------------------------------------+
| commands to execute when installing this module    |
+----------------------------------------------------*/

$mod_install_cmds = array();
$mod_install_cmds[] = array('type' => 'db', 'value' => "CREATE TABLE ##PREFIX##shoutbox (
  shout_id smallint(5) unsigned NOT NULL auto_increment,
  shout_name varchar(50) NOT NULL default '',
  shout_message varchar(200) NOT NULL default '',
  shout_datestamp int(10) unsigned NOT NULL default '0',
  shout_ip varchar(20) NOT NULL default '0.0.0.0',
  PRIMARY KEY  (shout_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

/*---------------------------------------------------+
| commands to execute when uninstalling this module  |
+----------------------------------------------------*/

$mod_uninstall_cmds = array();
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DROP TABLE ##PREFIX##shoutbox");

/*---------------------------------------------------+
| function to upgrade from a previous revision       |
+----------------------------------------------------*/
if (!function_exists('module_upgrade')) {
	function module_upgrade($current_version) {

		global $db_prefix, $locale;

		switch($current_version) {
			case "0.0.1":
				// pre-release version, no database or other changes
			case "1.0.0":
				// ExiteCMS v7.0. no upgrade actions for this release
			case "1.1.0":
				// upgrade to ExiteCMS v7.1. no upgrade actions for this release
			case "1.1.1":
				// upgrade to ExiteCMS v7.2. no upgrade actions for this release
				$result = dbquery("CREATE TABLE IF NOT EXISTS ".$db_prefix."shoutbox (
						shout_id smallint(5) unsigned NOT NULL auto_increment,
						shout_name varchar(50) NOT NULL default '',
						shout_message varchar(200) NOT NULL default '',
						shout_datestamp int(10) unsigned NOT NULL default '0',
						shout_ip varchar(20) NOT NULL default '0.0.0.0',
						PRIMARY KEY  (shout_id)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8");
			default:
				// do this at every upgrade
		}
	}
}
?>
