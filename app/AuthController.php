<?php

include_once "config.php";

if(isset($_POST['accion'])){
    if (isset($_POST['global_token']) && $_POST['global_token'] == $_SESSION['global_token']){
        switch($_POST['accion']){
        case 'access':
            $authController =new AuthController();
            $email=strip_tags($_POST['email']);
            $password=strip_tags($_POST['password']);
            $authController -> login($email,$password);
            break;    
        } 
    }
     
}

class AuthController{
    #Login:
    public function login($email, $password){

        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/login',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('email' => $email,'password' => $password),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response=json_decode($response);
        
        
        if(isset($response->code) && $response->code>0)
        {
            $_SESSION['name']=$response->data->name;
            $_SESSION['lastname']=$response->data->lastname;
            $_SESSION['avatar']=$response->data->avatar;
            $_SESSION['token']=$response->data->token;
            var_dump($response);
            header('location: '.BASE_PATH.'index.php');
        }else{
            var_dump($response);
            header('location: '.BASE_PATH.'?error=true');
        }
    }

    #Log Out:
    public function logout($email,$password){
        $curl = curl_init();
        $token = $_SESSION['token'];
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/logout',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('email' => $email),
        CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer ".$token
        ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        //echo $response;
        if(isset($response->code) && $response->code>0)
        {
            var_dump($response);
            header('location: '.BASE_PATH);
        }else{
            var_dump($response);
            header('location: '.BASE_PATH.'?error=true');
        }
}

    }



#'jeju_19@alu.uabcs.mx'
#O338lXPk!5k8I6
#OZ4KIABLHJThlRwxS1epezqL37XQAVQjy0oIF5ZI
?>