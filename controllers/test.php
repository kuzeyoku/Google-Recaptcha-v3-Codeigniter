<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {
  public function __construct()
  {
    parent::__construct();
  }

  public function control()
  {
    $recaptcha = recaptcha(trim($this->input->post("recaptcha")));
    if ($recaptcha == TRUE) {
      echo "Doğrulama Başarılı";
    } else {
      echo "Doğrulama Başarısız";
    } 
  }

}
