<?php
function recaptcha($response)
{
    $CI =& get_instance();
    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
    $secret = $CI->config->item("google_secret");
    $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $secret . '&response=' . $response);
    $recaptcha = json_decode($recaptcha);
    if ($recaptcha->success == TRUE) {
        return $recaptcha->score >= 0.5 ? TRUE : FALSE;
    } else {
        return FALSE;
    }
}