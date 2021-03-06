#!/bin/bash
# $Id: change_version.sh 13338 2006-03-27 15:32:14Z jenst $

NEW_VERSION="1.5.2"

esc=`echo -en "\033"`
tab="${esc}[5G"
clear

if [ -z $1 ] ; then
	echo -e "\nusage :"
	echo "sh update_po_files.sh -all for all .po file"
	echo -e "or sh update_po_files.sh -po <language_COUNTRY> for only one. e.g. sh update_po_files.sh -po de_DE \n" 
	exit
fi

if [ $1 != "-all" ] && [ ! -e ../locale/$2 ]; then
	echo -e "\n$2 does not exist or your paramater was wrong"
	echo -e "\nusage :"
	echo -e "sh update_po_files.sh -po <language_COUNTRY> for only one. e.g. sh update_po_files.sh -po de_DE \n" 
	exit
fi

# Okay, lets start

echo "Trying to update all .po and nls fils to Version: $NEW_VERSION"

read trash

ACTUALPATH=${0%/*}
cd $ACTUALPATH

#find all .po files or use only one

echo -n "checking for .po files ...."
find ../locale/ -iname "??_??*.po" >/dev/null 2>/dev/null || {
	echo $rc_failed	
	echo "$tab No valid .po files found"
	exit 0
}

if [ $1 = "-all" ] ; then
	pofiles=$(find ../locale/ -iname "??_??*.po")
	nlsfiles=$(find ../locale/ -iname "??_??*nls.php")
else
	pofiles=$(find ../locale/$2 -iname "??_??*.po")
	nlsfiles=$(find ../locale/$2 -iname "??_??*nls.php")
fi

for all_po in $pofiles ; do
	echo -e "\nFound : $all_po"
		
	lang1=${all_po%-*}
	lang=${lang1##*/}
	module1=${all_po##*_}
	module=${module1/.po}

	echo "$tab Language = $lang"
	echo "$tab Module = $module"

	echo "$tab Updating ..."
	head -19 $all_po > tmp.po
	echo "#" >> tmp.po
	echo "# @version      $NEW_VERSION" >> tmp.po
	tail +21 $all_po >> tmp.po
	mv tmp.po $all_po
done

for all_nls in $nlsfiles ; do
	echo -e "\nFound : $all_nls"
		
	lang1=${all_nls%-*}
	lang=${lang1##*/}

	echo "$tab Language = $lang"
	echo "$tab Updating ..."
	head -23 $all_nls > tmp.nls
	echo " * @version     $NEW_VERSION" >> tmp.nls
	tail +25 $all_nls >> tmp.nls
	mv tmp.nls $all_nls
done

find ../locale/ -iname "*~" -exec rm {} \;