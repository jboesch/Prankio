<?
require_once('../config/bootstrap.php');
require_once('../vendors/twilio-php/Services/Twilio.php');
require_once('../vendors/postmark/Postmark.php');

class PrankioValidationException extends Exception {};

class PrankioRequest {

    public $sid = '';
    public $token = '';
    public $from = '';

    public $phone = '';
    public $email = '';
    public $actions = array();

    /*
     * Setup!
     *
     * @param string $phone The phone number to prank
     * @param string $email The email to get the recording sent to
     * @param array $actions The message and pauses in an array [0] => 'message', [1] => 'pause' etc.
     */
    public function __construct($phone, $email, $actions){

        $this->phone = preg_replace("/[^0-9]/", "", $phone);
        $this->email = $email;
        $this->actions = $actions;

        $this->sid = PrankioConfig::get('Twilio.sid');
        $this->token = PrankioConfig::get('Twilio.token');
        $this->from = PrankioConfig::get('Twilio.from');

        $this->_doValidation();
        $this->_request();

    }

    // @TODO
    protected function _doValidation(){

    }

    /*
     *  Create XML to send over the wire
     */
    protected function _createXML(){

        $xml = '';

        foreach($this->actions as $action_key => $action_val){
            if($action_key % 2 == 0){
                $xml .= '<Say>' . $action_val . '</Say>';
            } else {
                $xml .= '<Pause length="' . $action_val . '"></Pause>';
            }
        }

        // Just as a precaution.
        $xml .= '<Pause length="3"></Pause>';

        return $xml;

    }

    /*
     *  Make a request to the twilio API to read from a specific xml file
     */
    protected function _request(){

        $xml = $this->_createXML();
        $client = new Services_Twilio($this->sid, $this->token);
        $client->account->calls->create($this->from, "+1" . $this->phone, PrankioConfig::get('Url.hooks_voice_file') . "?xml=" . urlencode($xml), array(
            "IfMachine" => "Hangup",
            "Record" => true,
            "Method" => "GET",
            "StatusCallbackMethod" => "GET",
            "StatusCallback" => PrankioConfig::get('Url.record_send_email_file') . "?email=" . $this->email
        ));

    }

}