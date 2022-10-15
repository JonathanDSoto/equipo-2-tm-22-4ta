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
        $street_and_use_number = strip_tags($_POST['street_and_use_number']);
        $apartment = strip_tags($_POST['apartment']);
        $postal_code = strip_tags($_POST['postal_code']);
        $city = strip_tags($_POST['city']);
        $province = strip_tags($_POST['province']);
        $phone_number = strip_tags($_POST['phone_number']);
        $is_billing_address = strip_tags($_POST['is_billing_address']);
        $client_id = strip_tags($_POST['client_id']);
        $client = strip_tags($_POST['client']);

        $Address = new AddressController();
        $Address->create($first_name, $last_name, $street_and_use_number,$apartment,$postal_code,$city,$province,$phone_number,$is_billing_address,$client_id,$client); 

      break;
      case 'update':
        #Isset pendiente (Validacion de Existencia de las Variables...)
        $id = strip_tags($_POST['id']);
        $first_name = strip_tags($_POST['first_name']);
        $last_name = strip_tags($_POST['last_name']);
        $street_and_use_number = strip_tags($_POST['street_and_use_number']);
        $apartment = strip_tags($_POST['apartment']);
        $postal_code = strip_tags($_POST['postal_code']);
        $city = strip_tags($_POST['city']);
        $province = strip_tags($_POST['province']);
        $phone_number = strip_tags($_POST['phone_number']);
        $is_billing_address = strip_tags($_POST['is_billing_address']);
        $client_id = strip_tags($_POST['client_id']);
        $client = strip_tags($_POST['client']);

        $Address = new AddressController;

        $Address->editAddress($id,$first_name, $last_name, $street_and_use_number,$apartment,$postal_code,$city,$province,$phone_number,$is_billing_address,$client_id,$client);

      break;
      case 'remove':
        #Isset pendiente (Validacion de Existencia de las Variables...)
        $id = strip_tags($_POST['id']);

        $Address = new AddressController;

        $Address->remove($id);

      break;
      }
  }
}

class AddressController{

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
     public function create($first_name, $last_name, $street_and_use_number,$apartment,$postal_code,$city,$province,$phone_number,$is_billing_address,$client_id,$client){

        $token = $_SESSION['token'];    
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
        CURLOPT_POSTFIELDS => array('first_name' => $first_name,'last_name' => $last_name,'street_and_use_number' => $street_and_use_number,'postal_code' => $postal_code,'city' => $city,'province' => $province,'phone_number' => $phone_number,'is_billing_address' => $is_billing_address,'client_id' => $client_id),
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$token
        ),
         ));
        $response = curl_exec($curl);
        curl_close($curl);

        header('location: '.BASE_PATH.'products');
        var_dump($response);
      
      }


    #Editar direcciones:
    public function editAddress($id,$first_name, $last_name, $street_and_use_number,$apartment,$postal_code,$city,$province,$phone_number,$is_billing_address,$client_id,$client)
    {
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
        CURLOPT_CUSTOMREQUEST => 'PUT',
        CURLOPT_POSTFIELDS => 'first_name='.$first_name. '&last_name='.$last_name. '&street_and_use_number='.$street_and_use_number.'&apartment='.$apartment.'&postal_code='.$postal_code.'&city='.$city.'&province='.$province.'&phone_number='.$phone_number.'&is_billing_address='.$is_billing_address.'&client_id='.$client_id.'&client='.$client,
        CURLOPT_HTTPHEADER => array(
          'Authorization: Bearer '.$_SESSION['token']
        ),
      ));
      $response = curl_exec($curl);
  
      curl_close($curl);
      if (isset ($response->code) && $response->code > 0){
        header('location: '.BASE_PATH.'products');
      } else {
        header('location: '.BASE_PATH.'products?error=false');
      }
    }


    #Elminar direccion:
    public function remove($id){
      
        $token = $_SESSION['token'];

        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/addresses/14',
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
        if (isset ($response->code) && $response->code > 0) {
            return true;
        } else {
            return false;
        }
    } 

}

?>