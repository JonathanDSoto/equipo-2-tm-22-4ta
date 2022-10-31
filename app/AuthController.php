<?php

include_once "config.php";

if(isset($_POST['accion'])){
    if (isset($_POST['global_token']) && $_POST['global_token'] == $_SESSION['global_token']){
        switch($_POST['accion']){

        case 'access':
            if(isset($_POST['email'])&& isset($_POST['password'])){
                $email=strip_tags($_POST['email']);
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $_SESSION['errorMessage'] = "Invalid data.";
                    header('location: '.BASE_PATH.'login');
                }
                else{
                    $authController =new AuthController();

                    $password=strip_tags($_POST['password']);
                    $authController -> login($email,$password);
                }


                
            }
            break;    
        case 'salir':
                $authController =new AuthController();

                $email=strip_tags($_POST['email']);
                $authController -> logout($email);
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
            $_SESSION['id']=$response->data->id;
            $_SESSION['name']=$response->data->name;
            $_SESSION['lastname']=$response->data->lastname;
            $_SESSION['avatar']=$response->data->avatar;
            $_SESSION['token']=$response->data->token;
            $_SESSION['created_by']=$response->data->created_by;
            $_SESSION['email']=$response->data->email;
            $_SESSION['phone_number']=$response->data->phone_number;
            $_SESSION['role']=$response->data->role;
            $_SESSION['errorMessage'] = "";
            var_dump($response);
            header('location: '.BASE_PATH.'products');
        }else{
            
            var_dump($response);
            header('location: '.BASE_PATH.'?error=true');
        }
    }

    #Log Out:
    public function logout($email){
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
        $response=json_decode($response);
        var_dump($response);
        if(isset($response->code) && $response->code>0)
        {
            var_dump($response);
            session_destroy();
            header('location: '.BASE_PATH.'logout');
        }else{
            var_dump($response);
            header('location: '.BASE_PATH.'?error=true');
        }
    }
}
?>