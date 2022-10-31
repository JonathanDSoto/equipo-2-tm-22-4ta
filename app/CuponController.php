<?php

include_once  "config.php";

#CRUD
if(isset($_POST['action'])){
  if (isset($_POST['global_token']) && $_POST['global_token'] == $_SESSION['global_token']){
    switch($_POST['action']){
      case 'create':

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
        $status = strip_tags($_POST['statusCoupon']);
        $couponable_type = strip_tags($_POST['couponable_type']);

        $cupon = new CuponController();
        if($cupon->isValid($name, $code, $percentage_discount, $amount_discount, $min_amount_required, 
        $min_product_required, $start_date, $end_date, $max_uses, $valid_only_first_purchase, $status, $couponable_type))
        {
            $cupon->create($name, $code, $percentage_discount, $amount_discount, $min_amount_required, $min_product_required, $start_date, $end_date, $max_uses, $count_uses, $valid_only_first_purchase, $status, $couponable_type); 
        }
      break;
      case 'update':

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
        $status = strip_tags($_POST['statusCoupon']);
        $couponable_type = strip_tags($_POST['couponable_type']);
        $id = strip_tags($_POST['id']);

        $cupon = new CuponController;
        if($cupon->isValid($name, $code, $percentage_discount, $amount_discount, $min_amount_required, 
        $min_product_required, $start_date, $end_date, $max_uses, $valid_only_first_purchase, $status, $couponable_type))
        {
           $cupon->editCoupon($name, $code, $percentage_discount, $amount_discount, $min_amount_required, $min_product_required, $start_date, $end_date, $max_uses, $count_uses, $valid_only_first_purchase, $status, $couponable_type, $id);
        }
      break;
      case 'remove':
        
        $id = strip_tags($_POST['id']);

        $cupon = new CuponController;
        $cupon->remove($id);

      break;
      }
  }
}

class CuponController{

    public function isValid($name, $code, $percentage_discount, $amount_discount, $min_amount_required, 
    $min_product_required, $start_date, $end_date, $max_uses, $valid_only_first_purchase, $status, $couponable_type)
    {
      if(!empty($name)&&
        !empty($code)&&(!empty($percentage_discount) || !empty($amount_discount))&&!empty($min_amount_required)&&
        !empty($min_product_required)&&!empty($start_date)&&!empty($end_date)&&!empty($max_uses)
        &&!empty($status)&&!empty($couponable_type)){
          if (!preg_match("/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]*$/",$name)||
              !preg_match("/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ-]*$/",$code)||
              !preg_match("/^[0-9]*$/",$percentage_discount)||
              !preg_match("/^[0-9]*$/",$amount_discount)||
              !preg_match("/^[0-9]*$/",$min_amount_required)||
              !preg_match("/^[0-9]*$/",$min_product_required)||
              !preg_match("/^[0-9]*$/",$max_uses)) {
                  $_SESSION['errorMessage'] = "Invalid data";
                  header('location: '.BASE_PATH.'coupons?error=false'); 
              }
              else{
                  return true;
              }
      }else{
          $_SESSION['errorMessage'] = "Missing data";
          //header('location: '.BASE_PATH.'coupons?error=false');
      }
    }

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
        ));
        $response = curl_exec($curl); 
        curl_close($curl);
        $response = json_decode ($response);
        
        if ( isset($response->code) && $response->code > 0) {
            return $response->data;
        }else{
            return array();
        }
    }

     #Crear los cupones:
     public function create($name, $code, $percentage_discount, $amount_discount, $min_amount_required, $min_product_required, $start_date, $end_date, $max_uses, $count_uses, $valid_only_first_purchase, $status, $couponable_type){
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
        CURLOPT_POSTFIELDS => array('name' => $name,'code' => $code,'percentage_discount' => $percentage_discount,'amount_discount' => $amount_discount,'min_amount_required' => $min_amount_required,'min_product_required' => $min_product_required,'start_date' => $start_date,'end_date' => $end_date,'max_uses' => $max_uses,'count_uses' => $count_uses,'valid_only_first_purchase' => $valid_only_first_purchase,'status' => $status,'couponable_type' => $couponable_type),
        CURLOPT_HTTPHEADER => array(
          'Authorization: Bearer '.$_SESSION['token']
        ),
      ));

      $response = curl_exec($curl);
      curl_close($curl);
      $response = json_decode ($response);

      if (isset ($response->code) && $response->code > 0){
        header('location: '.BASE_PATH.'coupons?success=true');
      } else {
        header('location: '.BASE_PATH.'coupons?error=false');
      }
    }


    #Editar cupones:
    public function editCoupon($name, $code, $percentage_discount, $amount_discount, $min_amount_required, $min_product_required, $start_date, $end_date, $max_uses, $count_uses, $valid_only_first_purchase, $status, $couponable_type, $id)
    {
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
        CURLOPT_POSTFIELDS => 'name='.$name.'&code='.$code.'&percentage_discount='.$percentage_discount.'&amount_discount='.$amount_discount.'&min_amount_required='.$min_amount_required.'&min_product_required='.$min_product_required.'&start_date='.$start_date.'&end_date='.$end_date.'&max_uses='.$max_uses.'&count_uses='.$count_uses.'&valid_only_first_purchase='.$valid_only_first_purchase.'&status='.$status.'&couponable_type='.$couponable_type.'&id='.$id,
        CURLOPT_HTTPHEADER => array(
          'Authorization: Bearer '.$_SESSION['token'],
          'Content-Type: application/x-www-form-urlencoded'
        ),
      ));
      
      $response = curl_exec($curl);
      curl_close($curl);
      $response = json_decode ($response);
      
      if (isset ($response->code) && $response->code > 0){
        header('location: '.BASE_PATH.'coupons?success=true');
      } else {
        header('location: '.BASE_PATH.'coupons?error=false');
      }
    }

    public function updateCountUses($count_uses, $id)
    {
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
        CURLOPT_POSTFIELDS => 'count_uses='.$count_uses.'&id='.$id,
        CURLOPT_HTTPHEADER => array(
          'Authorization: Bearer '.$_SESSION['token'],
          'Content-Type: application/x-www-form-urlencoded'
        ),
      ));
      
      $response = curl_exec($curl);
      curl_close($curl);
      $response = json_decode ($response);
      
      if (isset ($response->code) && $response->code > 0){
        return true;
      } else {
        return false;
      }
    }

    #Elminar cupones por ID:
    public function remove($id){
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
          header('location: '.BASE_PATH.'coupons?success=true');
        } else {
          header('location: '.BASE_PATH.'coupons?error=false');
        }
    } 

    #Get cupon en especifico:
    public function getEspecificCoupon($id){
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
  
  #Get total de descuento:
  public function getDiscount($id) {
    $couponTemporal = new CuponController();
    $coupon = $couponTemporal->getEspecificCoupon($id);
    $couponValue = 0;
    $totalDiscount = 0;
    $percentage = false; 
    $amount = false;
    
    if(isset($coupon->couponable_type)) {
      if($coupon->couponable_type=="Cupon de descuento fijo") {
        $couponValue = (float)$coupon->amount_discount;
        $amount = true;
      } else if($coupon->couponable_type=="Cupon de descuento") {
        $couponValue = (float)$coupon->percentage_discount;
        $percentage = true;
      }
    } else {
      if(isset($coupon->amount_discount)||isset($coupon->percentage_discount)) {
          if(isset($coupon->amount_discount)&&$coupon->amount_discount!='0'){
            $couponValue = (float)$coupon->amount_discount;
            $amount = true;
          } else if(isset($coupon->percentage_discount)&&$coupon->percentage_discount!='0') {
            $couponValue = (float)$coupon->percentage_discount;
            $percentage = true;
          }
      }
    }
    
    $cuponcito = array($couponValue,$percentage,$amount);
    return $cuponcito;
  }

  public function getTotalDiscount($id) {
    $couponTemporal = new CuponController();
    $coupon = $couponTemporal->getEspecificCoupon($id);
    $couponValue = 0;
    $totalDiscount = 0;
    $percentage = false; 
    $amount = false;
    
    if(isset($coupon->couponable_type)) {
      if($coupon->couponable_type=="Cupon de descuento fijo") {
        $couponValue = (float)$coupon->amount_discount;
        $amount = true;
      } else if($coupon->couponable_type=="Cupon de descuento") {
        $couponValue = (float)$coupon->percentage_discount;
        $percentage = true;
      }
    } else {
      if(isset($coupon->amount_discount)||isset($coupon->percentage_discount)) {
          if(isset($coupon->amount_discount)&&$coupon->amount_discount!='0'){
            $couponValue = (float)$coupon->amount_discount;
            $amount = true;
          } else if(isset($coupon->percentage_discount)&&$coupon->percentage_discount!='0') {
            $couponValue = (float)$coupon->percentage_discount;
            $percentage = true;
          }
      }
    }
    foreach ($coupon->orders as $value) {
      if($percentage) {
        $totalDiscount += (((float)$value->total)*$couponValue)/100;
      } else if($amount) {
        if(((float)$value->total)<=$couponValue) {
          $totalDiscount += (float)$value->total;
        } else {
          $totalDiscount += $couponValue;
        }
      }
    }
    return $totalDiscount;
  }

  #Get veces utilizado en orders:
  public function getCountUses($id) {
    $couponTemporal = new CuponController();
    $coupon = $couponTemporal->getEspecificCoupon($id);
    if(isset($coupon)) {
      return count($coupon->orders);
    } else {
      return 0;
    }
    
  }

}
?>