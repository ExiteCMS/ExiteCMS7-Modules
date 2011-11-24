<?php
/*---------------------------------------------------------------------+
| ExiteCMS Content Management System                                   |
+----------------------------------------------------------------------+
| Copyright 2006-2009 Exite BV, The Netherlands                        |
| for support, please visit http://www.exitecms.org                    |
+----------------------------------------------------------------------+
| Some code derived from PHP-Fusion, copyright 2002 - 2006 Nick Jones  |
+----------------------------------------------------------------------+
| Released under the terms & conditions of v2 of the GNU General Public|
| License. For details refer to the included gpl.txt file or visit     |
| http://gnu.org                                                       |
+----------------------------------------------------------------------+
| $Id:: module_installer.php 2043 2008-11-16 14:25:18Z WanWizard      $|
+----------------------------------------------------------------------+
| Last modified by $Author:: WanWizard                                $|
| Revision number $Rev:: 2043                                         $|
+---------------------------------------------------------------------*/
if (!checkrights("eA") || !defined("iAUTH") || $aid != iAUTH || !defined('INIT_CMS_OK')) fallback(BASEDIR."index.php");

/*---------------------------------------------------+
| Module identification                              |
+----------------------------------------------------*/
$mod_title = "Car Mileage Administration";
$mod_description = "Exite B.V. - Administer company car mileage, compliant with Dutch tax rules<br />Uses Google Maps directions to calculate the distance between start and destination";
$mod_version = "1.2.1";
$mod_developer = "WanWizard";
$mod_email = "wanwizard@exitecms.org";
$mod_weburl = "http://www.exitecms.org/";
$mod_type = "M";

/*---------------------------------------------------+
| Module administration panel installation details   |
+----------------------------------------------------*/

$mod_folder = "mileage";
$mod_admin_image = "mileage.gif";
$mod_admin_panel = "admin.php";
$mod_admin_rights = "eA";
$mod_admin_page = 4;

/*---------------------------------------------------+
| Version and revision control                       |
+----------------------------------------------------*/

// check for a minumum version of the ExiteCMS engine
if (str_replace(".", "", $settings['version']) < 720) {
	$mod_errors .= sprintf($locale['mod001'], '7.20');
}
// check for a maximum version of the ExiteCMS engine
if (str_replace(".", "", $settings['version']) > 730) {
	$mod_errors .= sprintf($locale['mod002'], '7.30');
}
// check for a specific revision number range that is supported
if ($settings['revision'] < 0 || $settings['revision'] > 999999) {
	$mod_errors .= sprintf($locale['mod003'], 0, 999999);
}

/*---------------------------------------------------+
| Menu entries for this module                       |
+----------------------------------------------------*/

$mod_site_links = array();
$mod_site_links[] = array('name' => 'Mileage Registration', 'url' => 'mileage.php', 'panel' => '', 'visibility' => 101);
$mod_site_links[] = array('name' => 'Fuel Registration', 'url' => 'fuel.php', 'panel' => '', 'visibility' => 101);

/*---------------------------------------------------+
| Report entries for this module                     |
+----------------------------------------------------*/

$mod_report_links = array();

/*---------------------------------------------------+
| Search entries for this module                     |
+----------------------------------------------------*/

$mod_search_links = array();

/*---------------------------------------------------+
| locale strings for this module                     |
+----------------------------------------------------*/

$localestrings = array();
$localestrings['en'] = array();
// fleet overview page
$localestrings['en']['eA_600'] = "Fleet Overview";
$localestrings['en']['eA_601'] = "Registration";
$localestrings['en']['eA_602'] = "Brand and model";
$localestrings['en']['eA_603'] = "Driver";
$localestrings['en']['eA_604'] = "Options";
$localestrings['en']['eA_605'] = "There are currently no cars defined.";
$localestrings['en']['eA_606'] = "Add a car";
$localestrings['en']['eA_607'] = "Are you sure you want to delete this car and all it's history?";
$localestrings['en']['eA_608'] = "Edit car info";
$localestrings['en']['eA_609'] = "Delete this car";
$localestrings['en']['eA_610'] = "None assigned";
$localestrings['en']['eA_611'] = "Out of service";
$localestrings['en']['eA_612'] = "Update";
// drivers
$localestrings['en']['eA_620'] = "Add a new driver to";
$localestrings['en']['eA_621'] = "Edit driver of";
$localestrings['en']['eA_622'] = "Driverslist of";
$localestrings['en']['eA_623'] = "There are currently no drivers assigned to this car.";
$localestrings['en']['eA_624'] = "Driver";
$localestrings['en']['eA_625'] = "From";
$localestrings['en']['eA_626'] = "Until";
$localestrings['en']['eA_627'] = "not defined";
$localestrings['en']['eA_628'] = "Edit driver";
$localestrings['en']['eA_629'] = "Remove this driver";
$localestrings['en']['eA_630'] = "Are you sure you want to delete this driver and all history for this car?";
$localestrings['en']['eA_631'] = "Add new driver";
// add/exit panel
$localestrings['en']['eA_650'] = "Add a car";
$localestrings['en']['eA_651'] = "Start mileage";
$localestrings['en']['eA_652'] = "Mileage registered in";
$localestrings['en']['eA_653'] = "Kilometers";
$localestrings['en']['eA_654'] = "Miles";
$localestrings['en']['eA_655'] = "Report type";
$localestrings['en']['eA_656'] = "Yearly report";
$localestrings['en']['eA_657'] = "Save car information";
$localestrings['en']['eA_658'] = "Delivery address";
$localestrings['en']['eA_659'] = "Or add a new address";
$localestrings['en']['eA_660'] = "Identified by";
$localestrings['en']['eA_661'] = "Address";
$localestrings['en']['eA_662'] = "Postcode";
$localestrings['en']['eA_663'] = "City";
$localestrings['en']['eA_664'] = "Country";
$localestrings['en']['eA_665'] = "km";
$localestrings['en']['eA_666'] = "ml";
$localestrings['en']['eA_667'] = "Delivered on";
$localestrings['en']['eA_668'] = "Out of service on";
$localestrings['en']['eA_671'] = "Edit a auto";
$localestrings['en']['eA_672'] = "Initial fuel load";
$localestrings['en']['eA_673'] = "Liter";
$localestrings['en']['eA_674'] = "Imperial gallon";
$localestrings['en']['eA_675'] = "U.S. Gallon";
// data entry panels
$localestrings['en']['eA_700'] = "Select a car";
$localestrings['en']['eA_701'] = "There are no cars defined that you can select.";
$localestrings['en']['eA_702'] = "Select";
$localestrings['en']['eA_703'] = "Travel history of ";
$localestrings['en']['eA_710'] = "Add a trip to ";
$localestrings['en']['eA_711'] = "There is no travel registered for this car.";
$localestrings['en']['eA_712'] = "Add a new trip";
$localestrings['en']['eA_720'] = "Date traveled";
$localestrings['en']['eA_721'] = "Mileage at departure";
$localestrings['en']['eA_722'] = "For privacy reasons, the destination is optional for personal travel.";
$localestrings['en']['eA_723'] = "Total distance";
$localestrings['en']['eA_724'] = "Description";
$localestrings['en']['eA_725'] = "Address";
$localestrings['en']['eA_726'] = "Business";
$localestrings['en']['eA_727'] = "Personal";
$localestrings['en']['eA_728'] = "Destination";
$localestrings['en']['eA_729'] = "Nature of this trip";
$localestrings['en']['eA_730'] = "If you have deviated from the 'normal' route on this trip, explain here why.";
$localestrings['en']['eA_731'] = "Detour mileage";
$localestrings['en']['eA_732'] = "Nature of the detour";
$localestrings['en']['eA_733'] = "Explain why this detour";
$localestrings['en']['eA_734'] = "Note that for privacy reasons, the explanation is optional when the detour is made for personal reasons.";
$localestrings['en']['eA_735'] = "Add this trip";
$localestrings['en']['eA_736'] = "Update this trip";
$localestrings['en']['eA_737'] = "Leaving from";
$localestrings['en']['eA_738'] = "Total";
$localestrings['en']['eA_739'] = "Date of trip";
$localestrings['en']['eA_740'] = "Edit trip info";
$localestrings['en']['eA_741'] = "Delete this trip";
$localestrings['en']['eA_742'] = "Are you sure you want to delete this trip? It might affect your entire administration";
$localestrings['en']['eA_743'] = "Print";
$localestrings['en']['eA_744'] = "Edit a trip of";
$localestrings['en']['eA_745'] = "Recommended";
$localestrings['en']['eA_746'] = "Save as the default mileage for this route";
$localestrings['en']['eA_747'] = "Manual planning";
$localestrings['en']['eA_748'] = "Save as the default detour for this route";
$localestrings['en']['eA_749x'] = "Fuel registration for ";
$localestrings['en']['eA_750x'] = "Refuel date";
$localestrings['en']['eA_751x'] = "Amount of fuel";
$localestrings['en']['eA_752x'] = "Edit refuel info";
$localestrings['en']['eA_753x'] = "Delete this refueling";
$localestrings['en']['eA_754x'] = "There is no refueling registered for this car.";
$localestrings['en']['eA_755x'] = "Are you sure you want to delete this refueling? It might affect your entire administration";
$localestrings['en']['eA_756x'] = "Add a new refueling";
$localestrings['en']['eA_757x'] = "New refueling for ";
$localestrings['en']['eA_758x'] = "Edit refueling for ";
$localestrings['en']['eA_759x'] = "Add this refueling";
$localestrings['en']['eA_760x'] = "Update this refueling";
$localestrings['en']['eA_761'] = "Fuel uplift";
$localestrings['en']['eA_762'] = "Optional, fill this in only when you have refueled on this trip";
// print
$localestrings['en']['eA_800'] = "Print report of ";
$localestrings['en']['eA_801'] = "Period of your report:";
$localestrings['en']['eA_802'] = "Travel administration for ";
$localestrings['en']['eA_803'] = "Report period";
$localestrings['en']['eA_804'] = "Address information for each trip";
$localestrings['en']['eA_805'] = "Mileage";
$localestrings['en']['eA_806'] = "Date";
$localestrings['en']['eA_807'] = "From";
$localestrings['en']['eA_808'] = "To";
$localestrings['en']['eA_809'] = "Mileage at the start";
$localestrings['en']['eA_810'] = "Mileage at the end";
$localestrings['en']['eA_811'] = "Driven this period";
$localestrings['en']['eA_812'] = "For personal use";
$localestrings['en']['eA_813'] = "Different<br />driver";
$localestrings['en']['eA_814'] = "Driver:";
$localestrings['en']['eA_815'] = "The ExiteCMS mileage module uses the services of Google Maps to calculate the correct distance of the route driven. It is up to the driver to correctly use it.";
$localestrings['en']['eA_816'] = "TripNo";
$localestrings['en']['eA_817'] = "Report options:";
$localestrings['en']['eA_818'] = "- None -";
$localestrings['en']['eA_819'] = "Add refuelings";
$localestrings['en']['eA_820'] = "Guestimate fuel usage";
$localestrings['en']['eA_821'] = "Liter per 100km";
$localestrings['en']['eA_822'] = "Miles to the Gallon";
$localestrings['en']['eA_823'] = "Fuel consumption between %01.2f and %01.2f";
$localestrings['en']['eA_824'] = "In this report period:";
$localestrings['en']['eA_825'] = "The average fuel consumption is calculated from the first up until the last refueling in this report period.";
$localestrings['en']['eA_826'] = "Only trips that include refueling";
$localestrings['en']['eA_827'] = "Dutch tax-office approved form";
$localestrings['en']['eA_828'] = "Assigned from";
$localestrings['en']['eA_829'] = "Assigned until";
$localestrings['en']['eA_830'] = "Citizen service number";
$localestrings['en']['eA_831'] = "Start<br />odometer";
$localestrings['en']['eA_832'] = "End<br />odometer";
$localestrings['en']['eA_833'] = "Mileage";
$localestrings['en']['eA_834'] = "Start address";
$localestrings['en']['eA_835'] = "End address";
$localestrings['en']['eA_836'] = "Route deviation";
$localestrings['en']['eA_837'] = "Type of trip";
$localestrings['en']['eA_838'] = "Other details";
$localestrings['en']['eA_839'] = " and partly ";
$localestrings['en']['eA_840'] = "between %d and %d";
// error messages
$localestrings['en']['eA_900'] = "You have to fill in the car registration number";
$localestrings['en']['eA_901'] = "You have to fill in the car make and model";
$localestrings['en']['eA_902'] = "The new car is succesfully added";
$localestrings['en']['eA_903'] = "The car information is succesfully updated";
$localestrings['en']['eA_904'] = "The requested car id can not be located";
$localestrings['en']['eA_905'] = "The car and all it's history is succesfully deleted";
$localestrings['en']['eA_906'] = "Select a delivery address from the list, or provide a new address";
$localestrings['en']['eA_910'] = "You have to fill in the mileage traveled on this trip (may be zero in some cases)";
$localestrings['en']['eA_911'] = "Select a destination address from the list, or provide a new address";
$localestrings['en']['eA_912'] = "The date selected is invalid. Please provide a valid date";
$localestrings['en']['eA_913'] = "Please provide an explanation for this business detour";
$localestrings['en']['eA_914'] = "The detour driven can not be longer than the total distance traveled";
$localestrings['en']['eA_915'] = "The new trip is succesfully added";
$localestrings['en']['eA_916'] = "The requested travel id can not be located";
$localestrings['en']['eA_917'] = "The new trip is succesfully updated";
$localestrings['en']['eA_918'] = "No travel found for this car and driver";
$localestrings['en']['eA_919'] = "The server doesn't support the cURL extension";
$localestrings['en']['eA_920'] = "Unable to calculate a route. Use manual routing";
$localestrings['en']['eA_921'] = "You have to fill in the initial fuel load of the car";
$localestrings['en']['eA_922'] = "The amount of fuel must be larger than zero!";
$localestrings['en']['eA_923x'] = "You have to fill in the amount you have refuelled for";
$localestrings['en']['eA_924x'] = "The new refueling has been registered";
$localestrings['en']['eA_925x'] = "The refuel registration has been modified";
$localestrings['en']['eA_926x'] = "Amount must be larger than zero!";

$localestrings['nl'] = array();
// fleet overview page
$localestrings['nl']['eA_600'] = "Fleet Overzicht";
$localestrings['nl']['eA_601'] = "Kenteken";
$localestrings['nl']['eA_602'] = "Merk, model en type";
$localestrings['nl']['eA_603'] = "Bestuurder";
$localestrings['nl']['eA_604'] = "Opties";
$localestrings['nl']['eA_605'] = "Er zijn momenteel geen auto's gedefinieerd.";
$localestrings['nl']['eA_606'] = "Auto toevoegen";
$localestrings['nl']['eA_607'] = "Weet u zeker dat u deze auto en al zijn kilometer historie wilt verwijderen?";
$localestrings['nl']['eA_608'] = "Auto aanpassen";
$localestrings['nl']['eA_609'] = "Auto verwijderen";
$localestrings['nl']['eA_610'] = "Geen toegewezen";
$localestrings['nl']['eA_611'] = "Uit dienst genomen";
$localestrings['nl']['eA_612'] = "Aanpassen";
// drivers
$localestrings['nl']['eA_620'] = "Nieuwe bestuurder toewijzen aan";
$localestrings['nl']['eA_621'] = "Bestuurder aanpassen van";
$localestrings['nl']['eA_622'] = "Bestuurderslijst van";
$localestrings['nl']['eA_623'] = "Er zijn momentel geen bestuurders aan deze auto toegewezen.";
$localestrings['nl']['eA_624'] = "Bestuurder";
$localestrings['nl']['eA_625'] = "Van";
$localestrings['nl']['eA_626'] = "Tot";
$localestrings['nl']['eA_627'] = "onbekend";
$localestrings['nl']['eA_628'] = "Bestuurder aanpassen";
$localestrings['nl']['eA_629'] = "Bestuurder verwijderen";
$localestrings['nl']['eA_630'] = "Weet u zeker dat u deze bestuurder, en al zijn historie voor deze auto, wilt verwijderen?";
$localestrings['nl']['eA_631'] = "Nieuwe bestuurder toevoegen";
// add/exit panel
$localestrings['nl']['eA_650'] = "Een auto toevoegen";
$localestrings['nl']['eA_651'] = "Stand bij aflevering";
$localestrings['nl']['eA_652'] = "Tellerstand is in";
$localestrings['nl']['eA_653'] = "Kilometer";
$localestrings['nl']['eA_654'] = "Mile";
$localestrings['nl']['eA_655'] = "Rapport type";
$localestrings['nl']['eA_656'] = "Jaarrapport";
$localestrings['nl']['eA_657'] = "Auto informatie oplaan";
$localestrings['nl']['eA_658'] = "Aflever adres";
$localestrings['nl']['eA_659'] = "of geef een nieuw adres";
$localestrings['nl']['eA_660'] = "Identificatie";
$localestrings['nl']['eA_661'] = "Adres";
$localestrings['nl']['eA_662'] = "Postcode";
$localestrings['nl']['eA_663'] = "Plaats";
$localestrings['nl']['eA_664'] = "Land";
$localestrings['nl']['eA_665'] = "km";
$localestrings['nl']['eA_666'] = "ml";
$localestrings['nl']['eA_667'] = "Afgeleverd op";
$localestrings['nl']['eA_668'] = "Ingeleverd op";
$localestrings['nl']['eA_671'] = "Een auto aanpassen";
$localestrings['nl']['eA_672'] = "Hoeveelheid brandstof";
$localestrings['nl']['eA_673'] = "Liter";
$localestrings['nl']['eA_674'] = "Imperial gallon";
$localestrings['nl']['eA_675'] = "U.S. OHGallon";
// data entry panels
$localestrings['nl']['eA_700'] = "Selecteer een auto";
$localestrings['nl']['eA_701'] = "Er zijn geen auto's definieerd die u kunt selecteren.";
$localestrings['nl']['eA_702'] = "Selecteer";
$localestrings['nl']['eA_703'] = "Gebruikshistorie van ";
$localestrings['nl']['eA_710'] = "Nieuwe rit voor";
$localestrings['nl']['eA_711'] = "Er zijn geen reizen voor deze auto bekend.";
$localestrings['nl']['eA_712'] = "Nieuwe reis toevoegen";
$localestrings['nl']['eA_720'] = "Reisdatum";
$localestrings['nl']['eA_721'] = "Begin kilometerstand";
$localestrings['nl']['eA_722'] = "In verband met privacy redenen is het einddoel voor persoonlijke reizen optioneel.";
$localestrings['nl']['eA_723'] = "Totale afstand";
$localestrings['nl']['eA_724'] = "Omschrijving";
$localestrings['nl']['eA_725'] = "Adres";
$localestrings['nl']['eA_726'] = "Zakelijk";
$localestrings['nl']['eA_727'] = "Privé";
$localestrings['nl']['eA_728'] = "Einddoel";
$localestrings['nl']['eA_729'] = "Reden van de reis";
$localestrings['nl']['eA_730'] = "Als u van de 'normale' route bent afgeweken, geef dan hier de reden en het aantal kilometers.";
$localestrings['nl']['eA_731'] = "Omrijkilometers";
$localestrings['nl']['eA_732'] = "Reden van de afwijking";
$localestrings['nl']['eA_733'] = "Afwijkende route";
$localestrings['nl']['eA_734'] = "In verband met uw privacy is de uitleg optioneel indien de afwijking een Privé reden had.";
$localestrings['nl']['eA_735'] = "Reis toevoegen";
$localestrings['nl']['eA_736'] = "Reis bijwerken";
$localestrings['nl']['eA_737'] = "Vertrekken van";
$localestrings['nl']['eA_738'] = "Totaal";
$localestrings['nl']['eA_739'] = "Reisdatum";
$localestrings['nl']['eA_740'] = "Reis aanpassen";
$localestrings['nl']['eA_741'] = "Reis verwijderen";
$localestrings['nl']['eA_742'] = "Weet u zeker dat u deze reis wilt verwijderen? Hierdoor kan uw administratie niet meer kloppen!";
$localestrings['nl']['eA_743'] = "Afdrukken";
$localestrings['nl']['eA_744'] = "Rit aanpassen voor";
$localestrings['nl']['eA_745'] = "Geadviseerd";
$localestrings['nl']['eA_746'] = "Opslaan als de standard afstand voor deze route";
$localestrings['nl']['eA_747'] = "Handmatig berekenen";
$localestrings['nl']['eA_748'] = "Opslaan als de standard afwijking voor deze route";
$localestrings['nl']['eA_749'] = "Brandstof registratie voor ";
$localestrings['nl']['eA_750'] = "Datum tankbeurt";
$localestrings['nl']['eA_751'] = "Hoeveelheid";
$localestrings['nl']['eA_752x'] = "Tankbeurt aanpassen";
$localestrings['nl']['eA_753x'] = "Tankbeurt verwijderen";
$localestrings['nl']['eA_754x'] = "Er zijn geen tankbeurten geregistreerd voor deze auto.";
$localestrings['nl']['eA_755x'] = "Weet u zeker dat u deze tankbeurt wilt verwijderen? Hierdoor kan uw administratie niet meer kloppen!";
$localestrings['nl']['eA_756x'] = "Nieuwe tankbeurt toevoegen";
$localestrings['nl']['eA_757x'] = "Nieuwe tankbeurt voor";
$localestrings['nl']['eA_758x'] = "Tankbeurt aanpassen voor";
$localestrings['nl']['eA_759x'] = "Tankbeurt toevoegen";
$localestrings['nl']['eA_760x'] = "Tankbeurt aanpassen";
$localestrings['nl']['eA_761'] = "Getankte brandstof";
$localestrings['nl']['eA_762'] = "Optioneel, alleen invullen als u tijdens deze rit heeft getankt";
// print
$localestrings['nl']['eA_800'] = "Rapport afdrukken voor ";
$localestrings['nl']['eA_801'] = "Periode voor uw rapport:";
$localestrings['nl']['eA_802'] = "Ritten administratie voor ";
$localestrings['nl']['eA_803'] = "Rapportage periode";
$localestrings['nl']['eA_804'] = "Adres informatie voor elke rit";
$localestrings['nl']['eA_805'] = "Tellerstanden";
$localestrings['nl']['eA_806'] = "Datum";
$localestrings['nl']['eA_807'] = "Van";
$localestrings['nl']['eA_808'] = "Naar";
$localestrings['nl']['eA_809'] = "Beginstand";
$localestrings['nl']['eA_810'] = "Eindstand";
$localestrings['nl']['eA_811'] = "Gereden in deze periode";
$localestrings['nl']['eA_812'] = "Privé gebruik";
$localestrings['nl']['eA_813'] = "Andere<br />bestuurder";
$localestrings['nl']['eA_814'] = "Bestuurder:";
$localestrings['nl']['eA_815'] = "De ExiteCMS mileage module gebruikt de diensten van Google Maps om de juiste afstand van de gereden route te berekenen.<br />Het is de verantwoordelijkheid van de bestuurder om dit juist toe te passen.";
$localestrings['nl']['eA_816'] = "RitNr.";
$localestrings['nl']['eA_817'] = "Rapport opties:";
$localestrings['nl']['eA_818'] = "- Geen -";
$localestrings['nl']['eA_819'] = "Tankbeurten vermelden";
$localestrings['nl']['eA_820'] = "Brandstofverbruik schatten";
$localestrings['nl']['eA_821'] = "Liter per 100km";
$localestrings['nl']['eA_822'] = "Mijl per Gallon";
$localestrings['nl']['eA_823'] = "Brandstof verbruik tussen %01.2f en %01.2f";
$localestrings['nl']['eA_824'] = "Over deze periode:";
$localestrings['nl']['eA_825'] = "De verbruikscijfers zijn berekend vanaf de eerste tot en met de laatste tankbeurt in deze rapportage periode.";
$localestrings['nl']['eA_826'] = "Alleen ritten waarop is getankt";
$localestrings['nl']['eA_827'] = "Goedgekeurde rittenregistratie Belastingdienst";
$localestrings['nl']['eA_828'] = "Ter beschikking vanaf";
$localestrings['nl']['eA_829'] = "Ter beschikking tot";
$localestrings['nl']['eA_830'] = "Burgerservicenummer";
$localestrings['nl']['eA_831'] = "Beginstand<br />kilometerteller";
$localestrings['nl']['eA_832'] = "Eindstand<br />kilometerteller";
$localestrings['nl']['eA_833'] = "Aantal<br />kilometers";
$localestrings['nl']['eA_834'] = "Beginadres rit";
$localestrings['nl']['eA_835'] = "Eindadres rit";
$localestrings['nl']['eA_836'] = "Afwijkende route";
$localestrings['nl']['eA_837'] = "Karakter<br />van de rit";
$localestrings['nl']['eA_838'] = "Bijzonderheden";
$localestrings['nl']['eA_839'] = " en deels ";
$localestrings['nl']['eA_840'] = "tussen %d en %d";

// error messages
$localestrings['nl']['eA_900'] = "U moet deze auto een kenteken geven";
$localestrings['nl']['eA_901'] = "U moet het merk, model en type van deze auto invullen";
$localestrings['nl']['eA_902'] = "De nieuwe auto is toegevoegd";
$localestrings['nl']['eA_903'] = "De informatie van de auto is aanpast";
$localestrings['nl']['eA_904'] = "Het ID van de vraagde auto kan niet worden gevonden";
$localestrings['nl']['eA_905'] = "De auto en alle ritadministratie is verwijderd";
$localestrings['nl']['eA_906'] = "Selecteer een afleveradres uit de lijst, of geef een nieuw adres in";
$localestrings['nl']['eA_910'] = "U moet de afgelegde afstand voor deze reis invullen (kan nul zijn in sommige gevallen)";
$localestrings['nl']['eA_911'] = "Selecteer een einddoel uit de lijst, of geef een nieuw adres in";
$localestrings['nl']['eA_912'] = "De geselecteerde datum is foutief. Geef een correcte datum in";
$localestrings['nl']['eA_913'] = "Geef een reden voor de zakelijke omrijkilometers";
$localestrings['nl']['eA_914'] = "De omrijkilometers kunnen niet meer zijn dan de totaal afgelegde afstand";
$localestrings['nl']['eA_915'] = "De nieuwe reis is toegevoerd";
$localestrings['nl']['eA_916'] = "Het ID van de reis kan niet worden gevonden";
$localestrings['nl']['eA_917'] = "De reis is succesvol bijgewerkt";
$localestrings['nl']['eA_918'] = "Geen ritten gevonden voor deze bestuurder en auto";
$localestrings['nl']['eA_919'] = "De server heeft geen ondersteuning van de cURL extensie";
$localestrings['nl']['eA_920'] = "Route kon niet worden berekend. Gebruik handmatig berekenen";
$localestrings['nl']['eA_921'] = "U moet de initiele hoeveelheid brandstof invullen";
$localestrings['nl']['eA_922'] = "Hoeveelheid moet groter zijn dan nul!";
$localestrings['nl']['eA_923x'] = "U moet de hoeveelheid van uw tankbeurt invullen";
$localestrings['nl']['eA_924x'] = "De nieuwe tankbeurt is toegevoerd";
$localestrings['nl']['eA_925x'] = "De tankbeurt is succesvol bijgewerkt";
$localestrings['nl']['eA_926x'] = "Hoeveelheid moet groter zijn dan nul!";

/*---------------------------------------------------+
| commands to execute when installing this module    |
+----------------------------------------------------*/

$mod_install_cmds = array();							// commands to execute when installing this module

// Car registration table
$mod_install_cmds[] = array('type' => 'db', 'value' => "CREATE TABLE ##PREFIX##mileage_car (
  car_id smallint(5) unsigned NOT NULL auto_increment,
  car_registration varchar(15) NOT NULL default '',
  car_description varchar(50) NOT NULL default '',
  car_start_from mediumint(8) unsigned NOT NULL default '0',
  car_start_date int(10) unsigned NOT NULL default '0',
  car_end_date int(10) unsigned NOT NULL default '0',
  car_mileage int(11) unsigned NOT NULL default '0',
  car_mileage_unit enum('K','M') NOT NULL default 'K',
  car_report_type tinyint(3) unsigned NOT NULL default '0',
  car_fuel float NOT NULL default '0',
  car_fuel_type enum('L','UG','IG') NOT NULL default 'L',
  PRIMARY KEY  (car_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

// Drivers table
$mod_install_cmds[] = array('type' => 'db', 'value' => "CREATE TABLE ##PREFIX##mileage_drivers (
  driver_car_id smallint(5) unsigned NOT NULL default '0',
  driver_user_id mediumint(8) unsigned NOT NULL default '0',
  driver_start_date int(10) unsigned NOT NULL default '0',
  driver_end_date int(10) unsigned NOT NULL default '0',
  driver_mileage_unit enum('K','M') NOT NULL default 'K',
  PRIMARY KEY (driver_car_id, driver_user_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

// Address registration table
$mod_install_cmds[] = array('type' => 'db', 'value' => "CREATE TABLE ##PREFIX##mileage_address (
  adr_id mediumint(8) unsigned NOT NULL auto_increment,
  adr_driver_id mediumint(8) unsigned NOT NULL default '0',
  adr_description varchar(50) NOT NULL default '',
  adr_address varchar(50) NOT NULL default '',
  adr_postcode varchar(15) NOT NULL default '',
  adr_city varchar(50) NOT NULL default '',
  adr_country varchar(2) NOT NULL default '',
  adr_type enum('B','P') NOT NULL default 'B',
  PRIMARY KEY  (adr_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

// Travel registration table
$mod_install_cmds[] = array('type' => 'db', 'value' => "CREATE TABLE ##PREFIX##mileage_travel (
  travel_id mediumint(8) unsigned NOT NULL auto_increment,
  travel_car_id smallint(5) unsigned NOT NULL default '0',
  travel_driver_id mediumint(8) unsigned NOT NULL default '0',
  travel_to mediumint(8) unsigned NOT NULL default '0',
  travel_type enum('B','P','H') NOT NULL default 'B',
  travel_mileage smallint(5) unsigned NOT NULL default '0',
  travel_date int(10) unsigned NOT NULL default '0',
  travel_detour smallint(5) unsigned NOT NULL default '0',
  travel_detour_type enum('B','P') NOT NULL default 'P',
  travel_detour_reason mediumtext NOT NULL,
  travel_details mediumtext NOT NULL,
  travel_fuel float NOT NULL default '0',
  travel_fuel_type enum('L','UG','IG') NOT NULL default 'L',
   PRIMARY KEY  (travel_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

// Travel distance table
$mod_install_cmds[] = array('type' => 'db', 'value' => "CREATE TABLE ##PREFIX##mileage_distance (
  distance_from mediumint(8) unsigned NOT NULL default '0',
  distance_to mediumint(8) unsigned NOT NULL default '0',
  distance_mileage smallint(5) unsigned NOT NULL default '0',
  distance_detour_type enum(' ','B','P') NOT NULL default ' ',
  distance_detour smallint(5) unsigned NOT NULL default '0',
  distance_detour_reason mediumtext NOT NULL,
  PRIMARY KEY (distance_from, distance_to)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

/*---------------------------------------------------+
| commands to execute when uninstalling this module  |
+----------------------------------------------------*/

$mod_uninstall_cmds = array();							// commands to execute when uninstalling this module

// delete the tables
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DROP TABLE ##PREFIX##mileage_car");
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DROP TABLE ##PREFIX##mileage_drivers");
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DROP TABLE ##PREFIX##mileage_address");
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DROP TABLE ##PREFIX##mileage_travel");
$mod_uninstall_cmds[] = array('type' => 'db', 'value' => "DROP TABLE ##PREFIX##mileage_distance");

/*---------------------------------------------------+
| function for special installations                 |
+----------------------------------------------------*/
if (!function_exists('install_mileage')) {
	function install_mileage() {
	}
}
/*---------------------------------------------------+
| function for special de-installations              |
+----------------------------------------------------*/
if (!function_exists('uninstall_mileage')) {
	function uninstall_mileage() {
	}
}

/*---------------------------------------------------+
| function to upgrade from a previous revision       |
+----------------------------------------------------*/
if (!function_exists('module_upgrade')) {
	function module_upgrade($current_version) {
		global $db_prefix;

		switch ($current_version) {
			// development version
			case "0.0.1":

			// first release version
			case "1.0.0":
				// create the new table
				$result = dbquery("CREATE TABLE ".$db_prefix."mileage_drivers (
					driver_car_id smallint(5) unsigned NOT NULL default '0',
					driver_user_id mediumint(8) unsigned NOT NULL default '0',
					driver_start_date int(10) unsigned NOT NULL default '0',
					driver_end_date int(10) unsigned NOT NULL default '0',
					driver_mileage_unit enum('K','M') NOT NULL default 'K',
  					PRIMARY KEY (driver_car_id, driver_user_id)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8");
				// select all car, driver combo's + mileage unit from the cars table, and add them to the drivers table
				$result = dbquery("SELECT DISTINCT car_id, car_driver_id, car_start_date, car_mileage_unit FROM cms_mileage_car");
				while ($data = dbarray($result)) {
					$result2 = dbquery("INSERT INTO ".$db_prefix."mileage_drivers (driver_car_id, driver_user_id, driver_start_date, driver_mileage_unit) VALUES('".$data['car_id']."', '".$data['car_driver_id']."', '".$data['car_start_date']."', '".$data['car_mileage_unit']."')");
				}
				// remove car_driver_id from the car table
				$result = dbquery("ALTER TABLE ".$db_prefix."mileage_car DROP car_driver_id");
				// add car_end_date to the car table
				$result = dbquery("ALTER TABLE ".$db_prefix."mileage_car ADD car_end_date INT(10) UNSIGNED NOT NULL AFTER car_start_date");
				break;

			// allow multiple drivers per car
			case "1.0.1":

			// links to Google Maps for route and distance calculations
			case "1.0.2":
			case "1.0.3":

			// added the trip numbers to the list and the report
			case "1.0.4":
				// add the detour fields to the distance table
				$result = dbquery("ALTER TABLE ".$db_prefix."mileage_distance
					ADD distance_detour_type ENUM(' ', 'B', 'P') NOT NULL,
					ADD distance_detour SMALLINT(5) NOT NULL,
					ADD distance_detour_reason MEDIUMTEXT NOT NULL");

			// added the option to save detour mileage and description as default
			case "1.0.5":

			// added a fuel registration option
			case "1.1.0":
				$result = dbquery("ALTER TABLE ".$db_prefix."mileage_car
					ADD car_fuel FLOAT NOT NULL DEFAULT '0',
					ADD car_fuel_type ENUM( 'L', 'UG', 'IG' ) NOT NULL DEFAULT 'L'");
				$result = dbquery("ALTER TABLE ".$db_prefix."mileage_travel
					ADD travel_fuel FLOAT NOT NULL DEFAULT '0',
					ADD travel_fuel_type ENUM( 'L', 'UG', 'IG' ) NOT NULL DEFAULT 'L'");

			// added the option to only print trips with refueling
			case "1.1.1":

			// new report layout and text fixes
			case "1.1.2":
			case "1.1.3":
			case "1.1.4":

			// support for the official dutch tax office form
			case "1.1.5":
				// add the travel_details field
				$result = dbquery("ALTER TABLE ".$db_prefix."mileage_travel ADD travel_details MEDIUMTEXT AFTER travel_detour_reason");

			// support for a driver social security number
			case "1.1.6":
				// add the travel_details field
				$result = dbquery("ALTER TABLE ".$db_prefix."mileage_drivers ADD driver_ssn VARCHAR(25) AFTER driver_mileage_unit");

			// added new fuel report to replace the old report 3
			case "1.1.7":

			// moved to v7.3, several updates and fixes
			case "1.1.8":

			// bugfixes for the report, start date can not be earlier than purchase date
			case "1.2.0":

			// need a break at the end to avoid falling into default
			case "break":
				break;

			default:
				terminate("invalid current version number passed to module_upgrade()!");
		}
	}
}
?>
