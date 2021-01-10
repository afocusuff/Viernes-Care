<?php
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
?>
