<?php

include_once  "config.php";

#CRUD
if(isset($_POST['action'])){
  if (isset($_POST['global_token']) && $_POST['global_token'] == $_SESSION['global_token']){
    switch($_POST['action']){
      case 'create':
        #Isset pendiente (Validacion de Existencia de las Variables...)
        $first_name = strip_tags($_POST['first_name']);
        $last_name = strip_tags($_POST['last_name']);
        $street_and_use_number = strip_tags($_POST['street_and_number']);
        $apartment = strip_tags($_POST['apartment']);
        $postal_code = strip_tags($_POST['postal_code']);
        $city = strip_tags($_POST['city']);
        $province = strip_tags($_POST['province']);
        $phone_number = strip_tags($_POST['phone_number']);
        $is_billing_address = strip_tags($_POST['is_billing_address']);
        $client_id = strip_tags($_POST['costumer_id']);

        $address = new AddressController();
        if($address->isValid($first_name, $last_name, $street_and_use_number, $apartment, $postal_code, $city, $province, $phone_number, $is_billing_address,$client_id)){
          $address->create($first_name, $last_name, $street_and_use_number, $apartment, $postal_code, $city, $province, $phone_number, $is_billing_address, $client_id); 
        }
        

      break;
      case 'update':
        #Isset pendiente (Validacion de Existencia de las Variables...)
        $first_name = strip_tags($_POST['first_name']);
        $last_name = strip_tags($_POST['last_name']);
        $street_and_use_number = strip_tags($_POST['street_and_number']);
        $apartment = strip_tags($_POST['apartment']);
        $postal_code = strip_tags($_POST['postal_code']);
        $city = strip_tags($_POST['city']);
        $province = strip_tags($_POST['province']);
        $phone_number = strip_tags($_POST['phone_number']);
        $is_billing_address = strip_tags($_POST['is_billing_address']);
        $client_id = strip_tags($_POST['costumer_id']);
        $id = strip_tags($_POST['id']);

        $address = new AddressController;
        if($address->isValid($first_name, $last_name, $street_and_use_number, $apartment, $postal_code, $city, $province, $phone_number, $is_billing_address,$client_id)){
          $address->editAddress($first_name, $last_name, $street_and_use_number, $apartment, $postal_code, $city, $province, $phone_number, $is_billing_address, $client_id, $id);
        }
      break;
      case 'remove':
        #Isset pendiente (Validacion de Existencia de las Variables...)
        $client_id = strip_tags($_POST['client_id']);
        $id = strip_tags($_POST['id']);

        $address = new AddressController;
        
        $address->remove($client_id, $id);

      break;
      }
  }
}

class AddressController{

    public function isValid($first_name, $last_name, $street_and_use_number, $apartment, $postal_code, $city, $province, $phone_number, $is_billing_address,$client_id)
    {
        if(!empty($first_name)&&
        !empty($last_name)&&
        !empty($street_and_use_number)&&
        !empty($postal_code)&&
        !empty($city)&&
        !empty($province)&&
        !empty($is_billing_address)&&
        !empty($phone_number)){
            if(!preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]*$/",$first_name)||
            !preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]*$/",$last_name)||
            !preg_match("/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ# ]*$/",$street_and_use_number)||
            !preg_match("/^[0-9]*$/",$postal_code)||
            !preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]*$/",$city)||
            !preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]*$/",$province)||
            !preg_match("/^[0-9]*$/",$phone_number)){
                $_SESSION['errorMessage'] = "Invalid data";
                header('location: '.BASE_PATH.'customers/'.$client_id.'?error=false');
            }else{
                return true;
            }
        }else{
            $_SESSION['errorMessage'] = "Missing data";
              header('location: '.BASE_PATH.'customers/'.$client_id.'?error=false');
        }
    }
    #Get de la direccion especifica:
    public static function getAddress($id){
        
        $token = $_SESSION['token'];
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/addresses/'.$id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$token
          ),
        ));$response = curl_exec($curl); 
        curl_close($curl);
        $response = json_decode($response);
        
        if ( isset($response->code) && $response->code > 0) {
            
            return $response->data;
        }else{
        
            return array();
        }
    }

     #Crear direccion:
     public function create($first_name, $last_name, $street_and_use_number, $apartment, $postal_code, $city, $province, $phone_number, $is_billing_address, $client_id){
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://crud.jonathansoto.mx/api/addresses',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => array('first_name' => $first_name,'last_name' => $last_name,'street_and_use_number' => $street_and_use_number,'apartment' => $apartment,'postal_code' => $postal_code,'city' => $city,'province' => $province,'phone_number' => $phone_number,'is_billing_address' => $is_billing_address,'client_id' => $client_id),
          CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer ' . $_SESSION['token']
          ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);

        if (isset($response->code) && $response->code > 0) {
          header('location: '.BASE_PATH.'customers/'.$client_id.'?success=true');
        } else {
          header('location: '.BASE_PATH.'customers/'.$client_id.'?error=false');
        }
      
      }


    #Editar direcciones:
    public function editAddress($first_name, $last_name, $street_and_use_number, $apartment, $postal_code, $city, $province, $phone_number, $is_billing_address, $client_id, $id)
    {
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/addresses',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'PUT',
        CURLOPT_POSTFIELDS => 'first_name='.$first_name.'&last_name='.$last_name.'&street_and_use_number='.$street_and_use_number.'&apartment='.$apartment.'&postal_code='.$postal_code.'&city='.$city.'&province='.$province.'&phone_number='.$phone_number.'&is_billing_address='.$is_billing_address.'&client_id='.$client_id.'&id='.$id,
        CURLOPT_HTTPHEADER => array(
          'Authorization: Bearer ' . $_SESSION['token'],
          'Content-Type: application/x-www-form-urlencoded'
        ),
      ));
      
      $response = curl_exec($curl);
      curl_close($curl);
      $response = json_decode($response);

      if (isset ($response->code) && $response->code > 0){
        header('location: '.BASE_PATH.'customers/'.$client_id.'?success=true');
      } else {
        header('location: '.BASE_PATH.'customers/'.$client_id.'?error=false');
      }
    }


    #Elminar direccion:
    public function remove($client_id, $id){
      
        $token = $_SESSION['token'];

        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/addresses/'.$id,
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
        $response = json_decode($response);

        if (isset ($response->code) && $response->code > 0){
          header('location: '.BASE_PATH.'customers/'.$client_id.'?success=true');
        } else {
          header('location: '.BASE_PATH.'customers/'.$client_id.'?error=false');
        }
        
    } 

}


?>