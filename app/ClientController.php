<?php 
include_once  "config.php";

#CRUD
if(isset($_POST['action'])){
    switch($_POST['action']){
        case 'create':

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

            $id = strip_tags($_POST['id']);
            $name = strip_tags($_POST['name']);
            $email = strip_tags($_POST['email']);
            $password=strip_tags($_POST['password']);
            $phone_number = strip_tags($_POST['phone_number']);
            $is_suscribed = strip_tags($_POST['is_suscribed']);
            $level = 1;
            
            $cliente = new ClientController;

            $cliente->editProduct($name, $email,$password, $phone_number, $is_suscribed,$level, $id);

        break;

        case 'remove':

            $id = strip_tags($_POST['id']);
            $cliente = new ClientController;
            $cliente->remove($id);

        break;     
    }
}


class ClientController{

    #Llamar a todos los clientes:
    public function getClientes(){
        $curl = curl_init();
        $token = $_SESSION['token'];
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




    
}


?>