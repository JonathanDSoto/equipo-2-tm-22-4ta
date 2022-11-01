<?php 

include_once  "config.php";
include_once  "PresController.php";
include_once "OrderController.php";
include_once "CuponController.php";

#CRUD
if(isset($_POST['action'])){
    if (isset($_POST['global_token']) && $_POST['global_token'] == $_SESSION['global_token']){
    switch($_POST['action']){
        case 'crear':
            $folio = strip_tags($_POST['folio']);
            $is_paid = strip_tags($_POST['paid']);
            $client_id = strip_tags($_POST['idClient']);
            $address_id = strip_tags($_POST['idAddress']);
            $order_status_id = strip_tags($_POST['order_status_id']);
            $payment_type_id = strip_tags($_POST['payment_type_id']);
            $idProducts = $_POST['productName'];
            $quantity = $_POST['quantity'];
            $order = new OrderController();
            $coupon_id=strip_tags($_POST['coupon_id']);

            if($order->isValid($folio, $is_paid, $client_id, $address_id, $order_status_id, $payment_type_id,$coupon_id,$quantity,$idProducts)){
                $total = $order->getTotal($coupon_id,$quantity,$idProducts);
                $order -> create($folio, $total, $is_paid, $client_id, $address_id, $order_status_id, $payment_type_id, $coupon_id,$quantity,$idProducts);
            }
            
        break;
            
        case 'actualizar':

            $id = strip_tags($_POST['id']);
            $order_status_id = strip_tags($_POST['order_status_id']);

            $order = new OrderController();
            $order->editPres($id, $order_status_id);

        break;

        case 'eliminar':

            $id = strip_tags($_POST['id']);
            $order = new OrderController;
            $order->remove($id);
        break;


        case 'check_date':

            $fecha_1 = strip_tags($_POST['fecha_1']);
            $fecha_2 = strip_tags($_POST['fecha_2']);
            $order = new OrderController;
            $order->getPerDates($fecha_1, $fecha_2);
        break;
        
        }
    }
}

class OrderController{

    public function isValid($folio, $is_paid, $client_id, $address_id, $order_status_id, $payment_type_id,$coupon_id,$quantity,$idProducts,)
    {
        $presentation = new PresController();  
        $coupon = new CuponController();
        
        $intPres = array_map('floatval',$idProducts);
        $intQuantity = array_map('floatval',$quantity); 
        
        $productsAmount = 0;
        $productsPrice = 0;

        if(!empty($folio)&&
        !empty($is_paid)&&!empty($client_id)&&
        !empty($address_id)&&!empty($order_status_id)&&
        !empty($payment_type_id)){

            if (!preg_match("/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ]*$/",$folio)){
                $_SESSION['errorMessage'] = "Invalid data";
                header('location: '.BASE_PATH.'orders?error=false');
            }else{
                for ($i=0; $i <count($intQuantity) ; $i++) { 
                    if ($intQuantity[$i]<1) {
                        $_SESSION['errorMessage'] = "Invalid product quantity";
                        header('location: '.BASE_PATH.'orders?error=false');
                    }
                }
                for ($i=0; $i < count($intPres); $i++) {
                    $pres = $presentation->getEspP($intPres[$i]); 
                    
                    if($pres->stock<$intQuantity[$i]){  
                        $_SESSION['errorMessage'] = "Not enough stock";
                        header('location: '.BASE_PATH.'orders?error=false');
                    }
                }
                
                if($coupon_id!=0){
                    
                    $cupon = $coupon->getEspecificCoupon($coupon_id);
                    if ($cupon->count_uses>=$cupon->max_uses) {
                        $_SESSION['errorMessage'] = "Invalid coupon";
                        header('location: '.BASE_PATH.'orders?error=false');
                    }

                    for ($i=0; $i < count($intQuantity); $i++) {
                        $pres = $presentation->getEspP($intPres[$i]);  
                        $productsAmount += $intQuantity[$i];
                        $productsPrice += ($pres->current_price->amount)*($intQuantity[$i]);
                        
                    }
                    
                    if($cupon->min_amount_required>$productsPrice){
                        $_SESSION['errorMessage'] = "Minimum requirements to use this coupon are not meet";
                        header('location: '.BASE_PATH.'orders?error=false');

                    }else if($cupon->min_product_required>$productsAmount){
                        $_SESSION['errorMessage'] = "Minimum requirements to use this coupon are not meet";
                        
                        header('location: '.BASE_PATH.'orders?error=false');
                    }else {
                        return true;
                    }

                }else{
                    return true;
                }
                
            }
        }else{
            $_SESSION['errorMessage'] = "Missing data";
            header('location: '.BASE_PATH.'orders?error=false');
        }    
    
        
    }



    #Crear orden (Order):
    public function create($folio, $total, $is_paid, $client_id, $address_id, $order_status_id, $payment_type_id, $coupon_id,$quantity,$idProducts){
        $curl = curl_init();
        $params = array('folio' => $folio,'total' =>$total, 'is_paid' =>$is_paid,'client_id' =>$client_id,'address_id' =>$address_id,'order_status_id' =>$order_status_id,'payment_type_id' =>$payment_type_id);
        
        if ($coupon_id!=0) {
            $params+= array('coupon_id'=>$coupon_id);
        }

        for ($i=0; $i < count($idProducts); $i++) {
            $presentations[$i]['id'] = $idProducts[$i];
            $presentations[$i]['quantity'] = $quantity[$i];
           
        }
        for ($i=0; $i < count($idProducts); $i++) { 
            $params += ["presentations[".$i."][id]" => $presentations[$i]["id"]];
            $params += ["presentations[".$i."][quantity]" => $presentations[$i]["quantity"]];
        }
        
       /*  var_dump($params); */
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://crud.jonathansoto.mx/api/orders',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',                                                                                                                                                                                                 //ESTA PARTE LA DEJE ESTÁTICA DE MOMENTO, SE VA A TENER QUE HACER DINAMICO PARA QUE ACEPTE VARIOS PARAMENTROS, SIMILAR A TAGS O CATEGORIES DE PRODUCTOS
            CURLOPT_POSTFIELDS => $params,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$_SESSION['token'],
            ),
        ));
        
        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);
        
        if (isset ($response->code) && $response->code > 0){
            $presentation = new PresController();
            $coupon = new CuponController();

            $intPres = array_map('intval',$idProducts);
            $intQuantity = array_map('intval',$quantity);

            for ($i=0; $i < count($intPres); $i++) {
                $pres = $presentation->getEspP($intPres[$i]); 
                $presentation->updateStock($pres->stock, $intPres[$i]);
            }
            if ($coupon_id!=0) {
                $cupon = $coupon->getEspecificCoupon($coupon_id);
                $newCount_uses = $cupon->count_uses+1;
                $coupon->updateCountUses($newCount_uses,$coupon_id);
            }
            return header('location: '.BASE_PATH.'orders?success=true');
        } else {
            return header('location: '.BASE_PATH.'orders?error=false');
        }
    }


    #Editar Orden:
    public function editPres($id, $order_status_id)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://crud.jonathansoto.mx/api/orders',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS => 'id='.$id.'&order_status_id='.$order_status_id,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$_SESSION['token'],
                'Content-Type: application/x-www-form-urlencoded',
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);

        if (isset ($response->code) && $response->code > 0){
            header('location: '.BASE_PATH.'orders');
        } else {
            header('location: '.BASE_PATH.'orders?error=false');
        }   
    }

    #Elminar orden por ID:
    public function remove($id){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/orders/'.$id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$_SESSION['token'],
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);

        if (isset ($response->code) && $response->code > 0){
            header('location: '.BASE_PATH.'orders?sucess=true');
          } else {
            header('location: '.BASE_PATH.'orders?error=false');
          }
    }
    
    public function getTotal($coupon_id,$quantity,$idProducts)
    {
        $presentation = new PresController();
        $coupon = new CuponController();

        $intPres = array_map('floatval',$idProducts);
        $intQuantity = array_map('floatval',$quantity);
        $total=0;

        for ($i=0; $i < count($intQuantity); $i++) {
            $pres = $presentation->getEspP($intPres[$i]);
            $total+= ($pres->current_price->amount)*($intQuantity[$i]);
           /*  var_dump($total); */
        }
        if($coupon_id!=0){
            $descuento = $coupon->getDiscount($coupon_id);
            if($descuento[1]==true){
                $desc=$total * ($descuento[0]/100);
                $total-=$desc;
            }else if($descuento[2]==true){
                if(($total)>$descuento[0]) {
                    $total -= $descuento[0];
                }
            }
        }

        number_format((float)$total, 2, '.', '');
        return $total;
    }
    #Get ordenes:
    public function getOrders(){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://crud.jonathansoto.mx/api/orders',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$_SESSION['token']
            ),
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

    #Get Especific Order:
    public function getSpecificOrder($id){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://crud.jonathansoto.mx/api/orders/details/'.$id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$_SESSION['token']
            ),
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

    #Get Especific Order por fechas:
    public function getPerDates($fecha_1, $fecha_2){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://crud.jonathansoto.mx/api/orders/'.$fecha_1.'/'.$fecha_2,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$_SESSION['token']
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);

        if (isset ($response->code) && $response->code > 0){
            $_SESSION['ordersByDates'] = $response->data;
            $_SESSION['date_1'] = $fecha_1;
            $_SESSION['date_2'] = $fecha_2;
            return header('location: '.BASE_PATH.'orders');
        } else {
            return header('location: '.BASE_PATH.'orders/?error=true');
        }
    }
}

?>