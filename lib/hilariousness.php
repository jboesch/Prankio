<?
error_reporting(E_ALL);
ini_set('display_errors', 1);

require('Prankio.php');

$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$actions = isset($_POST['actions']) ? $_POST['actions'] : array();

try {
    new PrankioRequest($phone, $email, $actions);
    echo json_encode(array('status' => 'success', 'message' => 'Worked!'));
} catch(Exception $e){
    echo json_encode(array('status' => 'error', 'message' => $e->getMessage()));
}
