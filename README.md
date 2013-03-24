# Prankio!
A prank calling app built on top of the Twilio API.

## Requirements

* PHP 5+
* Postmark email account
* Twilio account
* Public web server that Twilio can hit with some data

## Setting it up on your own server

* Open up config/config.php and fill in the proper config values
* Visit the project root and you should see it come up
* If all is well, now upload it to your public web server so Twilio can hit your callback URLs (specified in config/config.php with 'Url.' prefix)

## But I don't have a Postmark email account, can I use something else?
Absolutely, just follow these steps:

* Add your mailer lib to vendors
* Modify hooks/record_send_email.php to use your own mailer
* Cleanup: Get rid of config keys prefixed with 'Postmark.' in config/config.php and delete vendors/postmark