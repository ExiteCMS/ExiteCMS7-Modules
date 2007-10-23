<?php
// panel titles
$locale['ads400'] = "Add an advertisement";
$locale['ads401'] = "Edit an advertisement";
$locale['ads402'] = "Advertisements";
$locale['ads403'] = "Expired advertisements";
$locale['ads404'] = "Advertising client";
$locale['ads405'] = "Upload an advertisement image";
$locale['ads406'] = "Advertisement image management";
$locale['ads407'] = "Advertisement image preview";
$locale['ads408'] = " for client ";
$locale['ads409'] = "Please visit our sponsor";

// add - edit advertisement
$locale['ads410'] = "Client name";
$locale['ads411'] = "Contract based on";
$locale['ads412'] = "Contract start date";
$locale['ads413'] = "Contract end date";
$locale['ads414'] = "Ads currently purchased";
$locale['ads415'] = "Modify purchased amount";
$locale['ads416'] = "Ad location";
$locale['ads417'] = "Ad image";
$locale['ads418'] = "Advert click URL";
$locale['ads419'] = "Enable this advert";
$locale['ads420'] = "Increase by";
$locale['ads421'] = "Decrease by";
$locale['ads422'] = "No";
$locale['ads423'] = "Yes";
$locale['ads424'] = "Advert priority";
$locale['ads425'] = "Move to a new client";

// contract information
$locale['ads430'] = "Open ended period";
$locale['ads431'] = "Fixed time period";
$locale['ads432'] = "Number of displays";
$contract_types = array(0 => $locale['ads430'], 1 => $locale['ads431'], 2 => $locale['ads432']);

// buttons
$locale['ads440'] = "Save";
$locale['ads441'] = "Back";
$locale['ads442'] = "Expire";
$locale['ads443'] = "Activate";
$locale['ads444'] = "Change URL";
$locale['ads445'] = "Email statistics";
$locale['ads446'] = "Email All statistics";
$locale['ads447'] = "Add a new client";
$locale['ads448'] = "Advert image management";
$locale['ads449'] = "Upload image";

// advertisement location and type. 
// Don't forget to add new ones to the array! And don't change the order!!!
$locale['ads450'] = "Logo - left side panel";			// location = 0
$locale['ads451'] = "Banner - Discussion Forum";		// location = 1
$locale['ads452'] = "Banner - Forum index only";		// location = 2
$locale['ads453'] = "Banner - Thread index only";		// location = 3
$ad_locations = array(0 => $locale['ads450'], 1 => $locale['ads451'], 2 => $locale['ads452'], 3 => $locale['ads453']);
asort($ad_locations);	// sort the locations alphabetically

// maximum dimensions for each advertisement location
// Don't forget to add new ones to the array! And keep in sync with the locations!!!
$ad_dimensions = array(0 => "160x65", 1 => "468x60", 2 => "468x60", 3 => "468x60");

// current - finished advertisement
$locale['ads460'] = "ID";
$locale['ads461'] = "Client name";
$locale['ads462'] = "Advertisment type";
$locale['ads463'] = "Contract information";
$locale['ads464'] = "Clicks";
$locale['ads465'] = "Clicks %";
$locale['ads466'] = "Options";
$locale['ads467'] = "Enable";
$locale['ads468'] = "Disable";
$locale['ads469'] = "Edit";
$locale['ads470'] = "Delete";
$locale['ads471'] = "ends";
$locale['ads472'] = "starts";
$locale['ads473'] = "ended";
$locale['ads474'] = "Advertisements";
$locale['ads475'] = "Contact email";
$locale['ads476'] = "Remove this client";
$locale['ads477'] = "left";
$locale['ads478'] = "";
$locale['ads479'] = "Displayed";

// advertising statistics
$locale['ads500'] = "Advertising Statistics";
$locale['ads501'] = "Prio";
$locale['ads502'] = "Guest";

// client information - email messages
$locale['ads510'] = "Following are the complete stats for all your advertising investments at ".$settings['sitename'].":";
$locale['ads511'] = "Following are the complete stats for your advertising investment with ID %s at ".$settings['sitename'].":";
$locale['ads512'] = "Statistics report generated on %s\r\n\r\n";
$locale['ads513'] = "Ads still available";

// advertisement - image upload
$locale['ads530'] = "Image filename";

// advertisement - image management
$locale['ads540'] = "View";
$locale['ads541'] = "Delete";
$locale['ads542'] = "Dimensions";
$locale['ads543'] = "Options";
$locale['ads544'] = "Used";

// messages
$locale['ads900'] = "The following errors are detected while validating your input:";
$locale['ads901'] = "The requested advertisement can not be found in the database.";
$locale['ads902'] = "The advertisement has been deleted.";
$locale['ads903'] = "The amount purchased must be numeric.";
$locale['ads904'] = "The total amount sold to this client can not be negative.";
$locale['ads905'] = "Are you sure you want to delete this?";
$locale['ads906'] = "The advertisement is succesfully added.";
$locale['ads907'] = "The advertisement is succesfully updated.";
$locale['ads908'] = "This client doesn't have any active advertisements.";
$locale['ads909'] = "You are about to remove '%s' as an advertising client.<br />This also removes all advertisements, and any images that belong to his client!<br /><br />Are you sure?";
$locale['ads910'] = "This client and all the clients advertisements have been removed.";
$locale['ads911'] = "This client doesn't have any expired advertisements.";
$locale['ads912'] = "The selected image is to big for the selected location.<br />The maximum size for this location is %s, the image selected is %s.";
$locale['ads913'] = "Advertisement with ID %s has been enabled.";
$locale['ads914'] = "Advertisement with ID %s has been disabled.";

// messages - moving an advert to a new client
$locale['ads920'] = "Advertisement succesfully moved from %s to %s.";
$locale['ads921'] = "The selected Advertisement can not be found.";
$locale['ads922'] = "Invalid Advertisement ID passed. Is this a hacking attempt?";
$locale['ads923'] = "The selected new Client record can not be found.";
$locale['ads924'] = "Invalid client ID passed. Is this a hacking attempt?";

// messages - advertising statistics
$locale['ads950'] = "%s, You do not appear to be an advertising client.<br /><br />Please <a href='/contact.php'>contact us</a> for more information on becoming a client.";
$locale['ads951'] = "The URL for the advertisement with ID %s has been updated.";
$locale['ads952'] = "Detailed statistics for the advertisement with ID %s have been emailed to you.";
$locale['ads953'] = "Detailed statistics for all your advertisements have been emailed to you.";
$locale['ads954'] = "%s, There are no advertisements defined for you in this category.";
$locale['ads955'] = "Please <a href='/contact.php'>contact us</a> if you feel this is not correct.";

// messages - image uploading
$locale['ads960'] = "Upload file does not have an approved file extension (.jpg, .gif or .png)!";
$locale['ads961'] = "Upload file is not a valid image!";
$locale['ads962'] = "Hacking attempt! This is not an uploaded file!";

// messages - image management
$locale['ads970'] = "There are no uploaded advertisement images";
$locale['ads971'] = "The advertisement image has been deleted.";
?>