<?php 

include_once  "config.php";

#CRUD
if(isset($_POST['action'])){
    if (isset($_POST['global_token']) && $_POST['global_token'] == $_SESSION['global_token']){
    switch($_POST['action']){
        case 'create':
            #Isset pendiente (Validacion de Existencia de las Variables...)
            $folio = strip_tags($_POST['folio']);
            $total = strip_tags($_POST['total']);
            $is_paid = strip_tags($_POST['is_paid']);
            $client_id = strip_tags($_POST['client_id']);
            $address_id = strip_tags($_POST['address_id']);
            $order_status_id = strip_tags($_POST['order_status_id']);
            $payment_type_id = strip_tags($_POST['payment_type_id']);
            $coupon_id = strip_tags($_POST['coupon_id']);
            $fecha_1 = strip_tags($_POST['fecha_1']);
            $fecha_2 = strip_tags($_POST['fecha_2']);
            #Funcion de  precio...

            #Imagen:
            if(isset($_FILES['cover']) && $_FILES["cover"]["error"] == 0) {
                $imagen = $_FILES["cover"]["tmp_name"];
            
                $order = new OrderController();
                $order -> create($folio,$total,$is_paid,$client_id,$address_id,$order_status_id,$payment_type_id,$coupon_id);
            }else{
                header('location: '.BASE_PATH.'orders?error=false');
            }

        break;
            
        case 'update':
            #Isset pendiente (Validacion de Existencia de las Variables...)
            $id = strip_tags($_POST['id']);
            $folio = strip_tags($_POST['folio']);
            $total = strip_tags($_POST['total']);
            $is_paid = strip_tags($_POST['is_paid']);
            $client_id = strip_tags($_POST['client_id']);
            $address_id = strip_tags($_POST['address_id']);
            $order_status_id = strip_tags($_POST['order_status_id']);
            $payment_type_id = strip_tags($_POST['payment_type_id']);
            $coupon_id = strip_tags($_POST['coupon_id']);

            #Imagen:
            if(isset($_FILES['cover']) && $_FILES["cover"]["error"] == 0) {
                $imagen = $_FILES["cover"]["tmp_name"];
            
                $order = new OrderController();
                $order->editPres($id,$folio,$total,$is_paid,$client_id,$address_id,$order_status_id,$payment_type_id,$coupon_id);
            }else{
                header('location: '.BASE_PATH.'orders?error=false');
            }

        break;

        case 'remove':
            #Isset pendiente (Validacion de Existencia de las Variables...)
            $id = strip_tags($_POST['id']);
            $order = new OrderController;
            $order->remove($id);

        break;


        case 'check_date':
            #Isset pendiente (Validacion de Existencia de las Variables...)
            $id = strip_tags($_POST['id']);
            $fecha_1 = strip_tags($_POST['fecha_1']);
            $fecha_2 = strip_tags($_POST['fecha_2']);
            $order = new OrderController;
            $order->remove($id);

        break;
        
        }
    }
}



class OrderController{

    #Get ordenes:
    public function getOrder(){

        $token = $_SESSION['token'];
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
            'Authorization: Bearer '.$token
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
        $response = json_decode($response);
        if (isset ($response->code) && $response->code > 0){
            return $response->data;
          } else {
            return array();
          }

    }

    #Get Especific Order:
    public function grtEspOrd($id){

        $token = $_SESSION['token'];
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/orders/'.$id,
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
        echo $response;
        $response = json_decode($response);
        if (isset ($response->code) && $response->code > 0){
            return $response->data;
          } else {
            return array();
          }
    }

    #Crear orden (Order):
    public function create($folio,$total,$is_paid,$client_id,$address_id,$order_status_id,$payment_type_id,$coupon_id){

        $token = $_SESSION['token'];    
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/orders',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',                                                                                                                                                                                                                   #Ver como implementar luego.......................................................................................................
        CURLOPT_POSTFIELDS => array('folio' => $folio,'total' => $total,'is_paid' => $is_paid,'client_id' => $client_id,'address_id' => $address_id,'order_status_id' => $order_status_id,'payment_type_id' => $payment_type_id,'coupon_id' => $coupon_id,'presentations[0][id]' => '1','presentations[0][quantity]' => '2','presentations[1][id]' => '2','presentations[1][quantity]' => '2'),
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$_SESSION['token']
            ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        echo $response;
        $response = json_decode($response);

        if (isset($response->code) && $response->code > 0) {
            header('location: '.BASE_PATH.'orders?success=true');
          } else {
            header('location: '.BASE_PATH.'orders?error=false');
          }
    
    }


    #Editar Orden:
    public function editPres($id,$folio,$total,$is_paid,$client_id,$address_id,$order_status_id,$payment_type_id,$coupon_id)
    {
        $token = $_SESSION['token'];
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://crud.jonathansoto.mx/api/presentations',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS => 'id=' .$id.'&folio=' . $folio.'&total='.$total.'&is_paid='.$is_paid.'&client_id='.$client_id.'&address_id='.$address_id.'order_status_id='.$order_status_id.'&payment_type_id='.$payment_type_id.'&coupon_id='.$coupon_id,
            CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$_SESSION['token']
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
  
        $response = curl_exec($curl);
        $response = json_decode($response);
    
        curl_close($curl);
        if (isset ($response->code) && $response->code > 0){
            header('location: '.BASE_PATH.'products');
        } else {
            header('location: '.BASE_PATH.'orders?error=false');
        }
    }



    #Elminar orden por ID:
    public function remove($id){
        $token = $_SESSION['token'];
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
            'Authorization: Bearer '.$token
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        echo $response;
        $response = json_decode($response);
        if (isset ($response->code) && $response->code > 0){
            header('location: '.BASE_PATH.'products');
          } else {
            header('location: '.BASE_PATH.'orders?error=false');
          }
    }

    #Get Especific Order por fechas:
    public function getPerDates($fecha_1,$fecha_2){

            $token = $_SESSION['token'];
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
                'Authorization: Bearer '.$token
            ),
            ));
            $response = curl_exec($curl);
    
            curl_close($curl);
            echo $response;
            $response = json_decode($response);
            if (isset ($response->code) && $response->code > 0){
                return $response->data;
              } else {
                return array();
              }
        }

}


?>