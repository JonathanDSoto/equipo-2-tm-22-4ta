<?php

include_once "config.php";


if(isset($_POST['accion'])){
    if (isset($_POST['global_token']) && $_POST['global_token'] == $_SESSION['global_token']){
        
    }
    switch($_POST['accion']){
        case 'access':
            $authController =new authController();
            $email=strip_tags($_POST['email']);
            $password=strip_tags($_POST['password']);
            $authController -> login($email,$password);
            break;
        
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
        echo $response;
        $response=json_decode($response);
        
        
        if(isset($response->code) && $response->code>0)
        {
            session_start();
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

    #Crear usuario:
    public function login($email, $password){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/register',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',                                                                                                                                                                                                 #,'profile_photo_file'=> new CURLFILE('/C:/Users/jsoto/Downloads/avatar.jpg')                   
        CURLOPT_POSTFIELDS => array('name' => 'Jonathan','lastname' => 'Soto','email' => 'jonathansoto4@fakemail.com','phone_number' => '6120000000','created_by' => 'jonathan soto','role' => 'Administrador','password' => 'password123'),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        echo $response;

        if(isset($response->code) && $response->code>0)
        {
            session_start();
            $_SESSION['name']=$response->data->name;
            $_SESSION['lastname']=$response->data->lastname;
            $_SESSION['avatar']=$response->data->avatar;
            $_SESSION['token']=$response->data->token;
            var_dump($response);
            header('location: '.BASE_PATH);
        }else{
            var_dump($response);
            header('location: '.BASE_PATH.'?error=true');
        }
    }

    
    #Log Out:
    public function logout($email,$password){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/logout',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('email' => 'jsoto@uabcs.mx'),
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer 49|Fe0K8JKVeW2hzY9103KmWvpCNebEkfchDuMjQrkS',
            'Cookie: XSRF-TOKEN=eyJpdiI6ImU5TkIzeVhEQTNDQk8yQWlZQ1NBeWc9PSIsInZhbHVlIjoibit4VEZmelFVZVV1K2F5cWMvK2UxK1FRMTY2a2lnRmNOblpmR0NFTHlBSSttVFVvNmlHTTIwS2ZtY2FCVXdpSm9FZTZPZVNjZDN4c1Y2djArbGIxaHVwR2d5WkZFRVRWNlpNOEFCMktacDY5TzQ3cFNKMzMrdlpXUTlGanpqMjAiLCJtYWMiOiI1NWE1MTUxMDg4MWQ5NmQ5YWU0NGQzNjdhZDg1YWM3YTExMDIwMjNkNmM4NzBmOGU3NWY1YTFiMTdlNTFhNDU2IiwidGFnIjoiIn0%3D; laravel_session=eyJpdiI6ImVWQnFpbUp1QTdFMUhzVUVzMUkweWc9PSIsInZhbHVlIjoiUXFqeGdWRTRjbzA5R3pyQU9kckl1WkJ1YXNSdXF4dWJBQURxNy9tRk9qbk5RcUNER0k5L2t6NzR1SmlmOVk5TDFwdGNIYW5aM1pid3JDQ05QbWhHWUNBZXFSeDlWYkxYaTJXTllmalcvRUZLb2t5Rk1PMnNzVXNjODFQWXFBRXAiLCJtYWMiOiIzMDJmNGQzNjY4ZWY1Zjg2MjUyYWM1ODc3NzZhZmE5YmM2NWViMmQ0NDc5NGU0ZTI5MmY1YTdlNzI3NjlmZDkwIiwidGFnIjoiIn0%3D'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
        if(isset($response->code) && $response->code>0)
        {
            session_start();
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