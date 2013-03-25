<?
define('ROOT_DIR', dirname(__FILE__));
require_once(ROOT_DIR . '/../config/bootstrap.php');
require_once(ROOT_DIR . '/../vendors/twilio-php/Services/Twilio.php');
require_once(ROOT_DIR . '/../vendors/postmark/Postmark.php');

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
    protected function _createJSON(){

        $xml = array();

        foreach($this->actions as $action_key => $action_val){
            if($action_key % 2 == 0){
                $xml[] = array('Say' => $action_val);
            } else {
                $xml[] = array('Pause' => $action_val);
            }
        }

        // Just as a precaution.
        $xml[] = array('Pause' => 4);

        return json_encode($xml);

    }

    /*
     *  Make a request to the twilio API to read from a specific xml file
     */
    protected function _request(){

        $json = $this->_createJSON();

        $client = new Services_Twilio($this->sid, $this->token);
        $client->account->calls->create($this->from, "+1" . $this->phone, PrankioConfig::get('Url.hooks_voice_file') . "?json=" . urlencode($json), array(
            "IfMachine" => "Hangup",
            "Record" => true,
            "Method" => "GET",
            "StatusCallbackMethod" => "GET",
            "StatusCallback" => PrankioConfig::get('Url.record_send_email_file') . "?email=" . $this->email
        ));

        $this->_writeToLogs($json);

    }

    protected function _writeToLogs($json){

        $file = ROOT_DIR . '/../logs/' . date('Y-m-d') . '_' . date('H_i_s') . '.json';
        file_put_contents($file, $json, FILE_APPEND);

    }

}