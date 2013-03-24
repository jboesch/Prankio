<?
require_once('../config/bootstrap.php');
require('../vendors/postmark/Postmark.php');

// Create a "server" in your "rack", then copy it's API key
define('POSTMARKAPP_API_KEY', PrankioConfig::get('Postmark.api_key'));

// Create a "Sender signature", then use the "From Email" here.
// POSTMARKAPP_MAIL_FROM_NAME is optional, and can be overridden
// with Mail_Postmark::fromName()
define('POSTMARKAPP_MAIL_FROM_ADDRESS', PrankioConfig::get('Postmark.mail_from_address'));
define('POSTMARKAPP_MAIL_FROM_NAME', PrankioConfig::get('Postmark.mail_from_name'));

$recording_url = $_REQUEST['RecordingUrl'];
// Create a message and send it
Mail_Postmark::compose()
    ->addTo($_REQUEST['email'])
    ->subject('Prankio Recording')
    ->messagePlain("You're so funny! Listen to this prank call: " . $recording_url)
    ->send();