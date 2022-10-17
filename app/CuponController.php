<?php

include_once  "config.php";

#CRUD
if(isset($_POST['action'])){
  if (isset($_POST['global_token']) && $_POST['global_token'] == $_SESSION['global_token']){
    switch($_POST['action']){
      case 'create':
        #Isset pendiente (Validacion de Existencia de las Variables...)
        $name = strip_tags($_POST['name']);
        $code = strip_tags($_POST['code']);
        $percentage_discount = strip_tags($_POST['percentage_discount']);
        $amount_discount = strip_tags($_POST['amount_discount']);
        $min_amount_required = strip_tags($_POST['min_amount_required']);
        $min_product_required = strip_tags($_POST['min_product_required']);
        $start_date = strip_tags($_POST['start_date']);
        $end_date = strip_tags($_POST['end_date']);
        $max_uses = strip_tags($_POST['max_uses']);
        $count_uses = strip_tags($_POST['count_uses']);
        $valid_only_first_purchase = strip_tags($_POST['valid_only_first_purchase']);
        $status = strip_tags($_POST['status']);
        $couponable_type = strip_tags($_POST['couponable_type']);
        $branch_id = strip_tags($_POST['branch_id']);

        $cupon = new CuponController();

        $min_product_required = strip_tags($_POST['min_product_required']);
        $cupon->create($name, $code, $percentage_discount,$amount_discount,$min_amount_required,$min_product_required,$start_date,$end_date,$max_uses,$count_uses,$valid_only_first_purchase,$status,$couponable_type,$branch_id); 

      break;
      case 'update':
        #Isset pendiente (Validacion de Existencia de las Variables...)
        $id = strip_tags($_POST['id']);
        $name = strip_tags($_POST['name']);
        $code = strip_tags($_POST['code']);
        $percentage_discount = strip_tags($_POST['percentage_discount']);
        $amount_discount = strip_tags($_POST['amount_discount']);
        $min_amount_required = strip_tags($_POST['min_amount_required']);
        $min_product_required = strip_tags($_POST['min_product_required']);
        $start_date = strip_tags($_POST['start_date']);
        $end_date = strip_tags($_POST['end_date']);
        $max_uses = strip_tags($_POST['max_uses']);
        $count_uses = strip_tags($_POST['count_uses']);
        $valid_only_first_purchase = strip_tags($_POST['valid_only_first_purchase']);
        $status = strip_tags($_POST['status']);
        $couponable_type = strip_tags($_POST['couponable_type']);
        $branch_id = strip_tags($_POST['branch_id']);

        $cupon = new CuponController;

        $cupon->editTag($id,$name, $code, $percentage_discount,$amount_discount,$min_amount_required,$min_product_required,$start_date,$end_date,$max_uses,$count_uses,$valid_only_first_purchase,$status,$couponable_type,$branch_id);

      break;
      case 'remove':
        #Isset pendiente (Validacion de Existencia de las Variables...)
        $id = strip_tags($_POST['id']);

        $cupon = new CuponController;

        $cupon->remove($id);

      break;
      }
  }
}

class CuponController{

    #Get de todos los cupones:
    public static function getCupons(){
        
        $token = $_SESSION['token'];
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/coupons',
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
        $response = json_decode ($response);
        
        if ( isset($response->code) && $response->code > 0) {
            
            return $response->data;
        }else{
        
            return array();
        }
    }

     #Crear los cupones:
     public function create($name, $code, $percentage_discount,$amount_discount,$min_amount_required,$min_product_required,$start_date,$end_date,$max_uses,$count_uses,$valid_only_first_purchase,$status,$couponable_type,$branch_id){

        $token = $_SESSION['token'];    
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/coupons',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('name'=>$name, 'code'=>$code, 'percentage_discount'=>$percentage_discount,'amount_discount'=>$amount_discount,'min_amount_required'=>$min_amount_required,'min_product_required'=>$min_product_required,'start_date'=>$start_date,'end_date'=>$end_date,'max_uses'=>$max_uses,'count_uses'=>$count_uses,'valid_only_first_purchase'=>$valid_only_first_purchase,'status'=>$status,'couponable_type'=>$couponable_type,'branch_id'=>$branch_id),
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$token
        ),
         ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode ($response);
        header('location: '.BASE_PATH.'products');
        var_dump($response);
      
      }


    #Editar cupones:
    public function editTag($id,$name, $code, $percentage_discount,$amount_discount,$min_amount_required,$min_product_required,$start_date,$end_date,$max_uses,$count_uses,$valid_only_first_purchase,$status,$couponable_type,$branch_id)
    {
        $token = $_SESSION['token'];
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/coupons',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'PUT',
        CURLOPT_POSTFIELDS => 'name='.$name. '&code='.$code. '&percentage_discount='.$percentage_discount.'&amount_discount='.$amount_discount.'&min_amount_required='.$min_amount_required.'&min_product_required='.$min_product_required.'&start_date='.$start_date.'&end_date='.$end_date.'&max_uses='.$max_uses.'&count_uses='.$count_uses.'&valid_only_first_purchase='.$valid_only_first_purchase.'&status='.$status.'&couponable_type='.$couponable_type.'&branch_id='.$branch_id,
        CURLOPT_HTTPHEADER => array(
          'Authorization: Bearer '.$_SESSION['token']
        ),
      ));
      $response = curl_exec($curl);
  
      curl_close($curl);
      $response = json_decode ($response);
      if (isset ($response->code) && $response->code > 0){
        header('location: '.BASE_PATH.'products');
      } else {
        header('location: '.BASE_PATH.'products?error=false');
      }
    }


    #Elminar cupones por ID:
    public function remove($id){
      
        $token = $_SESSION['token'];
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/coupons/'.$id,
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
          header('location: '.BASE_PATH.'products');
        } else {
          header('location: '.BASE_PATH.'products?error=false');
        }
    } 

    #Get cupon en especifico:
    public function getEspecificTag($id){

        $token = $_SESSION['token'];
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/coupons/'.$id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer ' . $_SESSION['token']),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $response = json_decode($response);
        if (isset ($response->code) && $response->code > 0){
            return $response->data;
        } else {
            return array();
        }
    }

}
?>