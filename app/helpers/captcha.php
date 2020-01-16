<?php

// function for handling the reCAPTCHA api
// basic usage: captcha($_POST['g-recaptcha-response'])
function captcha($formData){

    $url = 'https://www.google.com/recaptcha/api/siteverify';

    $data = array(
        'secret' => '6LdE4c4UAAAAAKPxkgrCAN7SM1OuFsx1lSZStsA5',
        'response' => $formData
    );

    $options = array(
        'http' => array (
            'method' => 'POST',
            'content' => http_build_query($data)
        )
    );

    $context  = stream_context_create($options);
    $verify = file_get_contents($url, false, $context);
    $captcha_result=json_decode($verify);

    if($captcha_result->success == false){
        return false;
    }else if ($captcha_result->success == true) {
        return true;
    }else{
        return false;
    }


}