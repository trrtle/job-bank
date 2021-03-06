<?php
/**
 * helpers/session_helper.php -
 * Starts a session & session related stuff that does not fit anywhere else
 *
 * @package    TurtleMVC-Addons
 * @subpackage TurtleMVC-Helpers
 * @license    https://opensource.org/licenses/BSD-3-Clause
 * @author     Micky Aarnoudse
 * @copyright  2020 Micky Aarnoudse
 */

// start and generate a new session id
session_start();
session_regenerate_id(true);

/**
 * Flash class
 *
 * Shows flash messages using the $_SESSION['flash'] variable.
 * @uses Bootstrap4 Alerts to show flash messages.
 * unsets the flash message after it has been shown.
 *
 * @property string $message - Message that must be alerted.
 * @property string (optional) $type - type of Bootstrap4 alert
 * @return string - div tag with Bootstrap4 alert class
 */
class Flash
{
    private $message;
    private $type;

    public function __construct($message, $type = 'alert alert-success')
    {
        $this->message = $message;
        $this->type = $type;
    }


    public function show()
    {
        echo '<div class="' . $this->type . '" role="alert">' . $this->message . '</div>';
        unset($_SESSION['flash']);
    }

}

function isLoggedIn(){
    if(comp_isLoggedIn() || user_isLoggedIn() || admin_isLoggedIn() ){
        return true;
    }else{
        return false;
    }
}
function comp_isLoggedIn(){
    if(isset($_SESSION['comp_id']) && isset($_SESSION['comp_email'])){
        return true;
    }else{
        return false;
    }
}
function user_isLoggedIn(){
    if(isset($_SESSION['id']) && isset($_SESSION['email'])){
        return true;
    }else{
        return false;
    }
}

function admin_isLoggedIn(){
    if(isset($_SESSION['admin_id']) && isset($_SESSION['username'])){
        return true;
    }else{
        return false;
    }
}