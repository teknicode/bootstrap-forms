<?php
namespace Teknicode\Form;
class Process{
  private $method; //mail, sms
  private $attributes;
  private $compiled;
  function __construct($method="mail"){
    $this->method=$method;
  }

  public function set(){
      if(func_num_args() == 2) {
          $key = func_get_arg(0);
          $value = func_get_arg(1);
          $this->attributes[$key] = $value;
      }else{
          foreach(func_get_args()[0] as $key => $value){
              $this->attributes[$key]=$value;
          }
      }
      return $this;
  }

  public function get($key){
      return (!empty($this->attributes[$key]) ? $this->attributes[$key] : null);
  }

  public function catch(){
    //check for post
    if( $_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST) ){
      if( is_array($this->attributes) && !empty($this->attributes) ){
        $this->compile();
      }else{
        //output error
        echo "Attributes missing";
      }
    }
  }

  private function compile(){
    //compile the data
    $this->compiled="";
    foreach( $_POST as $k => $v ){
      $this->compiled .= "<p><b>$k</b><br/>$v</p>";
    }
    $this->transmit();
  }

  private function transmit(){
    //send or save
    switch( $this->method ){
      case "mail":
        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
        if( is_array($this->get("smtp")) ){
          $config = $this->get("smtp");
          //load smtp
          $mail->SMTPDebug = 0;                                 // Enable verbose debug output
          $mail->isSMTP();                                      // Set mailer to use SMTP
          $mail->Host = $config['Host'];  // Specify main and backup SMTP servers
          $mail->SMTPAuth = true;                               // Enable SMTP authentication
          $mail->Username = $config['Username'];                 // SMTP username
          $mail->Password = $config['Password'];                           // SMTP password
          $mail->SMTPSecure = (isset($config['SSL'])?$config['SSL']:'tls');                            // Enable TLS encryption, `ssl` also accepted
          $mail->Port = $config['Port'];
        }

        $mail->setFrom('ollie@teknicode.uk', 'Ollie');
        $mail->addAddress( $this->get("recipient") );
        $mail->isHTML(true);
        $mail->Subject = 'Here is the subject';
        $mail->Body    = $this->compiled;
        $mail->AltBody = strip_tags(str_replace(["<br/>","<br>"],"\n",$this->compiled));
        $mail->send();
      break;

      case "sms":

      break;
    }
  }
}
