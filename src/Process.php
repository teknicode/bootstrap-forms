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
        return $this->transmit();
      }else{
        //output error
        return [
          "status" => "failed",
          "error" => "Required Attributes Missing"
        ];
      }
    }
  }

  private function compile(){
    //compile the data
    $this->compiled="";
    foreach( $_POST as $k => $v ){
      $this->compiled .= "<p><b>$k</b><br/>$v</p>";
    }
  }

  private function transmit(){
    //send or save
    switch( $this->method ){
      case "mail":
        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
        try{
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

          if( !empty($this->get("from")) ){
            $mail->setFrom($this->get("from")['address'],$this->get("from")['name']);
          }
          if( is_array($this->get("recipient")) ){
            foreach( $this->get("recipient") as $r ){
                $mail->addAddress( $r );
            }
          }else{
            $mail->addAddress( $this->get("recipient") );
          }
          $mail->isHTML(true);
          $mail->Subject = ( !empty($this->get("subject")) ? $this->get("subject") : 'Web Form Message');
          $mail->Body    = $this->compiled;
          $mail->AltBody = strip_tags(str_replace(["<br/>","<br>"],"\n",$this->compiled));
          $mail->send();

          return [
            "status" => "success"
          ];
        }catch(\PHPMailer\PHPMailer\Exception $e){
          return [
            "status" => "failed",
            "error" => $e->errorMessage()
          ];
        }

      break;

      case "sms":

      break;
    }
  }
}
