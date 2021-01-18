<?php
require 'vendor/autoload.php';
use Twilio\Rest\Client;
    //PDO with Prepared Statements
    function  validateUserLoginPDO($context, $email,$pass){
        $statment = $context->prepare("SELECT * FROM usuario WHERE email= :email");
        $statment->bindParam(":email", $email);
        $statment->execute();
        $count=$statment->rowCount();
        //si el usuario con el email existe procesamos a validar la contraseña
        if($count ==1){
            $userData=$statment->fetch(PDO::FETCH_OBJ);

            /*si al contraseña es ecriptada usaremos la funcion password_verfiy
            para comparar las dos contraseñas. Esta funcion devuelve true o false*/
            //$isPassValid = password_verify($pass, $userData->pass);

            //Si la contraseña no esta ecriptada o sea plana usaremos la funcion strcmp.
            //Esta funcion Devuelve < 0 si el primer string es menor que segundo string;
            // > 0 si primer string es mayor que egundo string y devuelve 0 si son iguales.
            $isPassValid = strcmp($pass, $userData->pass);

            //si la contraseña es valida devolvemos el usuario, si no devolvemos null
            if($isPassValid == 0){
                return $userData; 
            }else{
                return null;
            }
        }
        else{
            return null;
        }
    }

    //Verificar rol y ir a pagina correspondiente
    function GoToPage($rol){
        switch(strtolower($rol)) {
            case "admin":
                header("Location: ./admin.php");
                break;
            case "rastreador":
                header("Location: ./rastreador.php");
                break;
            case "medico":
                header("Location: ./medico.php");
                break;
        }
    }
    
    function callAPI($method, $url, $data){
        $curl = curl_init();
        switch ($method){
           case "POST":
              curl_setopt($curl, CURLOPT_POST, 1);
              if ($data)
                 curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
              break;
           case "PUT":
              curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
              if ($data)
                 curl_setopt($curl, CURLOPT_POSTFIELDS, $data);			 					
              break;
           default:
              if ($data)
                 $url = sprintf("%s?%s", $url, http_build_query($data));
        }
        // OPTIONS:
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        // EXECUTE:
        $result = curl_exec($curl);
        if(!$result){die("Connection Failure");}
        curl_close($curl);
        return $result;
     }

    //function pra validar email
    function validateEmail($context, $email){
        $statment = $context->prepare("SELECT * FROM usuario WHERE email= :email");
        $statment->bindParam(":email", $email);
        $statment->execute();
        $count=$statment->rowCount();
        
        if($count ==1){
            //Trear datos de usuario
            $usuario=$statment->fetch(PDO::FETCH_OBJ);
            //si el email existe generamos un token y lo guardamos en la base datos y luego enviarselo por email.
            $token =  generar_token_seguro(40);
            
            //Insertamos token
            $stat = $context->prepare("INSERT INTO login_token (usuario_id, token) VALUES (:usuario_id, :token)");
            $stat->bindParam(":usuario_id", $usuario->id);
            $stat->bindParam(":token", $token);
            $stat->execute();
            $rowAffected=$stat->rowCount();

            //si se ha insertado los datos enviaremos el email con los datos.
            if($rowAffected == 1){
                SendEmail($token, $email,$usuario->id);
                return true;
            }
        }
        else{
            return false;
        }
    }

    //function para generar un token
    function generar_token_seguro($longitud)
    {
        if ($longitud < 4) {
            $longitud = 4;
        }
    
        return bin2hex(random_bytes(($longitud - ($longitud % 2)) / 2));
    }

     //function pra validar email
    function SendEmail($token, $email,$id)
    {
        
        $html = "<html>
       <head></head>
       <body>
       <h2>Hola ". $email."</h2>
           <p>Se ha recibido una solicitud para cambiar la contraseña de su cuenta.<br>
           <a href='http://localhost/viernes/ut1893/viernes-care/web/restablecer_contrasena.php?token=$token&id=$id'>Restablecer cOntraseña</a>
           </p>
           
       </body>
       </html>";

        // Create the Transport
        $transport = (new Swift_SmtpTransport('smtp.sendgrid.net', 587))
        ->setUsername('apikey')
        ->setPassword('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')
        ;
        
        // Create the Mailer using your created Transport
        $mailer = new Swift_Mailer($transport);
        
        // Create a message
        $message = (new Swift_Message('Restablecer Contraseña'))
        ->setFrom(['khalo_2@hotmail.com' => 'khalifa boulbayem'])
        ->setTo([$email])
        ->setBody($html, 'text/html')
        ;
        
        // Send the message
        $mailer->send($message);
    }
    
    function sendSMS($tel){
        // Required if your environment does not handle autoloading
        

        // Use the REST API Client to make requests to the Twilio REST API
        

        // Your Account SID and Auth Token from twilio.com/console
        $sid = '**********';
        $token = '*******';
        $client = new Client($sid, $token);

        // Use the client to do fun stuff like send text messages!
        $client->messages->create(
            // the number you'd like to send the message to
            "+".$tel,
            [
                // A Twilio phone number you purchased at twilio.com/console
                'from' => '+18304606174',
                // the body of the text message you'd like to send
                'body' => 'Has sido dado de alta en viernes care'
            ]
        );
    }

?>
