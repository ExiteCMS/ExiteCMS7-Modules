#!/usr/bin/perl -n
# $Id: transform_fuzzy.pl 3374 2003-07-28 09:49:27Z jefmcg $
#
/^., fuzzy/ and $fuzzy = 1 and next;
/^$/ and $fuzzy = 0;
s/msgstr.*/msgstr ""/ if ($fuzzy);

print $_;

