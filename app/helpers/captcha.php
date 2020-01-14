<?php

// function for handling the reCAPTCHA api
// basic usage: captcha($_POST['g-recaptcha-response'])
function captcha($formData){

    $key = '6LdE4c4UAAAAAKPxkgrCAN7SM1OuFsx1lSZStsA5';
    $reCaptcha = new \ReCaptcha\ReCaptcha($key);
    $response = null;

    if($formData){
        // verify the captcha
        $response = $reCaptcha->verify($_SERVER['REMOTE_ADDR'], $formData);

        if($response){
            return true;
        }else{
            return false;
        }

    }else{
        return false;
    }

}