<?php 
include_once  "config.php";

#CRUD
if(isset($_POST['action'])){
    if (isset($_POST['global_token']) && $_POST['global_token'] == $_SESSION['global_token']){
    switch($_POST['action']){
        case 'create':
            #Isset pendiente (Validacion de Existencia de las Variables...)
            $name = strip_tags($_POST['name']);
            $email = strip_tags($_POST['email']);
            $password=strip_tags($_POST['password']);
            $phone_number = strip_tags($_POST['phone_number']);
            $is_suscribed = strip_tags($_POST['is_suscribed']);
            $level = 1;

            $cliente = new ClientController();

            $cliente->create($name, $email,$password, $phone_number, $is_suscribed,$level);   

        break;
        case 'update':
            #Isset pendiente (Validacion de Existencia de las Variables...)
            $id = strip_tags($_POST['id']);
            $name = strip_tags($_POST['name']);
            $email = strip_tags($_POST['email']);
            $password=strip_tags($_POST['password']);
            $phone_number = strip_tags($_POST['phone_number']);
            $is_suscribed = strip_tags($_POST['is_suscribed']);
            $level = 1;
            
            $cliente = new ClientController;

            $cliente->editClient($name, $email,$password, $phone_number, $is_suscribed,$level, $id);

        break;

        case 'remove':
            #Isset pendiente (Validacion de Existencia de las Variables...)
            $id = strip_tags($_POST['id']);
            $cliente = new ClientController;
            $cliente->remove($id);

        break;     
        }
    }
}


class ClientController{

    #Llamar a todos los clientes:
    public function getClientes(){

        $token = $_SESSION['token'];
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/clients',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer ".$token
       ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);
        if( isset($response->code) &&  $response->code > 0) {
            return $response -> data;
        } else {
            return array();
        }}


        #Crear Clientes:
        public function create($name, $email,$password, $phone_number, $is_suscribed,$level){

            $token = $_SESSION['token'];    
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://crud.jonathansoto.mx/api/clients',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('name' => $name,'email' => $email,'password' =>$password,'phone_number' => $phone_number,'is_suscribed' => $is_suscribed,'level,' => $level),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$token
            ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            $response = json_decode ($response);
            if (isset ($response->code) && $response->code > 0){
                header('location: '.BASE_PATH.'client');
              } else {
                header('location: '.BASE_PATH.'client?error=false');
              }
        }

        #Editar Cliente:
        public function editClient($name, $email,$password, $phone_number, $is_suscribed,$level, $id){
            
            $token = $_SESSION['token'];
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://crud.jonathansoto.mx/api/clients',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS => 'name=' . $name.'&email='.$email.'&password='.$password.'&phone_number='.$phone_number.'&is_suscribed='.$is_suscribed.'&level='.$level.'&$id='.$id,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$_SESSION['token']
            ),
        ));
            $response = curl_exec($curl);
            $response = json_decode ($response);
            curl_close($curl);
            if (isset ($response->code) && $response->code > 0){
                header('location: '.BASE_PATH.'client');
              } else {
                header('location: '.BASE_PATH.'client?error=false');
              }
          }


        #Elminar usuarios (Users) por ID:
        public function remove($id){

            $token = $_SESSION['token'];
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://crud.jonathansoto.mx/api/clients/'.$id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $_SESSION['token']
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            $response = json_decode ($response);
            if (isset ($response->code) && $response->code > 0){
                header('location: '.BASE_PATH.'client');
            } else {
                header('location: '.BASE_PATH.'client?error=false');
            }
        } 
}


?>