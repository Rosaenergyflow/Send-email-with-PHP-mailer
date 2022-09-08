<?php 
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('content-type: application/json; charset=utf-8');


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPmailer/PHPMailer/src/Exception.php';
require 'PHPmailer/PHPMailer/src/PHPMailer.php';
require 'PHPmailer/PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

try {
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
            )
        );
        
    //Server settings
    $mail->SMTPDebug = 2;
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      
    $mail->isSMTP();                                            
    $mail->Host       = 'smtp.gmail.com';                    
    $mail->SMTPAuth   = true;                                   
    $mail->Username   = 'yourEmail...';                     
    $mail->Password   = 'yourPassword...';                               
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         
    $mail->Port       = 587;                                   
    
    //Recipients
    $mail->setFrom('email@gmail.com', 'title');
    $mail->addAddress('email@gmail.com', 'title');   
    
    
    // $mail->addAddress('anyemail@gmail.com@gmail.com');               
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');
    
    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    
    
    $data=json_decode(file_get_contents('php://input'), true);
    
    //Content
    $mail->isHTML(true);                                 
    $mail->Subject = 'Your subject';
    $mail->Body    = 'Nombre: <br>' . $data['name'] . '<br><br>Asunto: <br>' . $data['subject'] . '<br><br>Mensaje: <br>' . $data['message'] . '<br><br>Email del remitente: <br>' . $data['email'] . '<br><br>';
    $mail->AltBody = 'your text';

    if($data){
        $mail->send();
        echo 'Message has been sent';
    }
    
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

?>