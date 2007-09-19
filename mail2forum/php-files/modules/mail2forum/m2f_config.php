<?php
/*---------------------------------------------------+
| Mail2Forum: User configurable parameters
| (these have to be moved to the admin panel some day!)
+----------------------------------------------------*/

// Polling interval for the different M2F processors. Note that this is not the wait time. If a cycle takes 1 minute
//   and 20 seconds, the processor sleeps for 3 minutes and 40 seconds. If the processors needs more time to process
//   than the interval specified here, a warning will be written to the logfile.
//
// default: every 5 minutes
define('M2F_INTERVAL', 5*60);

// Polling threshold. If the last poll more than this number of seconds ago, the M2F processors (that use this value)
//   refuse to run, and die with an error message. A new polltime can be set from the admin module
// This is to prevent sending out thousands of emails after undetected downtime of the processor
//
// default: 806400 seconds ( = 1 week )
define('M2F_POLL_THRESHOLD', 7*24*60*60);

// Number of attachments allowed per post. Any more are discarded. If M2F_SEND_NDR is true, the sender is notified.
//
// note: standard PHP-Fusion only supports one attachment per post. The M2F mail processors support an unlimited
// number of attachments. When more attachments are linked to a single post, viewthread.php will duplicate the
// message for every attachment found, with one of the attachments linked to every message.
//
// The PLi-Fusion engine (which is a highly enhanced version of PHP-Fusion) supports multiple attachments per post.
// If you are interested in the PLi-Fusion version of the forum code, drop us a line...
//
// default: 1
define('M2F_MAX_ATTACHMENTS', 1);

// With this switch you control the from address of outgoing email. The default behaviour is to use the email
//   address from the poster, as defined in the members profile. If the member has elected to hide his email 
//   address from other member (the 'hide email' option set to 'Yes'), the from is composed of the Nick of the
//   the poster, and the forum email address as defined in Mail2Forum.
// When you set this switch to true, email always goes out using the forum email address, regardless of the
//   member setting. This can make it easier for users to define mail filters in their client software
//
// default: false
define('M2F_USE_FORUM_EMAIL', true);

// Allow Mail2Forum posts to a thread, even if it has moved to another forum
// This makes sure replies to a thread will be processed, even if the thread has been moved to a different forum
//   by a moderator or administrator.
//
// CAUTION: activating this could be a risk, as it allows posting to forums the poster doesn't have access to!
//
// default: false
define('M2F_FOLLOW_THREAD', false);

// Allow every member that has post access to the forum, also post by email
// If this switch is set to true, only members that have a subscription on this forum will be allowed to post
// new messages using email
//
// default: true
define('M2F_SUBSCRIBE_REQUIRED', false);

// Send a non-delivery report back to the poster in case an incomming message can not be processed
// NDR's are only send to verified email accounts, email from unknown accounts (SPAM) will be deleted
//
// default: false
define('M2F_SEND_NDR', true);

// Address of the POP3 mailserver. For performance reasons, specify an IP address, and not a hostname.
//
// default: 127.0.0.1 (localhost)
define('M2F_POP3_SERVER', '127.0.0.1');

// TCP poort the POP3 server listens on.
//
// default: 110 (the standard POP3 port)
define('M2F_POP3_PORT', 110);

// Timeout used for socket communications. Specify any value between 2 and 25 seconds.
//
// default: 25 seconds
define('M2F_POP3_TIMEOUT', 25);

// Location of the Mail2Forum logfiles. Default, logfiles will be stored in the directory 'logs' which
//   is a subdirectory of the mail2forum infusion directory. All logfiles start with 'M2F_'
// The exact filename depends on the processor and the type of log:
//   - the process logfile will be called M2F_LOGFILE./M2F_process.log
//   - specific processor logfiles will be called M2F_LOGFILE./<processor>.log
//   - specific processor debug files will be called M2F_LOGFILE./<processor>.debug.log
// Note: Do NOT add a trailing slash to the pathname!!
//
// default: 'logs'
define('M2F_LOGFILE', "logs");

// If true, a process log will be used by all Mail2Forum processor modules, so the state and activity can be tracked
//
// default: true
define('M2F_PROCESS_LOG', true);

// If true, additional SMTP logging will be performed by the SMTP processor, so the interaction with the SMTP server
//   can be monitored.
//
// default: false
define('M2F_SMTP_LOG', true);

// If true, debugging of the POP3 processor is activated. This logs the internal data structures used to process the
//   messages, as well as more detailed processing information.
//
// default: false
define('M2F_POP3_DEBUG', false);

// If true, debugging of message processing is activated. This logs the raw information from MimeDecode, and the 
//   extracted message. This makes it easier to debug MIME decoding errors.
//
// default: false
define('M2F_POP3_MESSAGE_DEBUG', true);

// If true, debugging of the SMTP processor is activated. This logs the internal data structures used to process the
//   messages, as well as more detailed processing information.
//
// default: false
define('M2F_SMTP_DEBUG', true);

?>