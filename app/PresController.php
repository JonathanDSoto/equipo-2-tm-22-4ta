<?php 

include_once  "config.php";

#CRUD
if(isset($_POST['action'])){
    if (isset($_POST['global_token']) && $_POST['global_token'] == $_SESSION['global_token'] ){
    switch($_POST['action']){
        case 'create':
            #Isset pendiente (Validacion de Existencia de las Variables...)
            $description = strip_tags($_POST['description']);
            $code = strip_tags($_POST['code']);
            $weight_in_grams = strip_tags($_POST['weight_in_grams']);
            $status = strip_tags($_POST['statusPresentation']);
            $stock = strip_tags($_POST['stock']);
            $stock_max = strip_tags($_POST['stock_max']);
            $stock_min = strip_tags($_POST['stock_min']);
            $product_id = strip_tags($_POST['id']);
            $amount = strip_tags($_POST['amount']);

            #Imagen:
            if(isset($_FILES['coverPresentation']) && $_FILES["coverPresentation"]["error"] == 0) {
                $imagen = $_FILES["coverPresentation"]["tmp_name"];
            
                $pres = new PresController();
                if($pres->isValid($description,$code, $weight_in_grams, $status, $stock, $stock_min, $stock_max, $product_id,$imagen, $amount)){
                    $pres -> create($description,$code, $weight_in_grams, $status, $stock, $stock_min, $stock_max, $product_id,$imagen, $amount);
                }
            }else{
                header('location: '.BASE_PATH.'products?error=false');
            }

        break;
            
        case 'update':
            #Isset pendiente (Validacion de Existencia de las Variables...)
            $id = strip_tags($_POST['id']);
            $description = strip_tags($_POST['description']);
            $code = strip_tags($_POST['code']);
            $weight_in_grams = strip_tags($_POST['weight_in_grams']);
            $status = strip_tags($_POST['statusPresentation']);
            $stock = strip_tags($_POST['stock']);
            $stock_max = strip_tags($_POST['stock_max']);
            $stock_min = strip_tags($_POST['stock_min']);
            $product_id = strip_tags($_POST['product_id']);
            $amount = strip_tags($_POST['amount']);

            $pres = new PresController();
            if($pres->isValid($description,$code, $weight_in_grams, $status, $stock, $stock_min, $stock_max, $product_id,$imagen, $amount)){
                $pres->editPres($description, $code, $weight_in_grams, $status, $stock, $stock_min, $stock_max, $product_id, $id, $amount);
            }
        break;
            
        case 'remove':
            #Isset pendiente (Validacion de Existencia de las Variables...)
            $id = strip_tags($_POST['id']);
            $pres = new PresController;
            $pres->remove($id);

        break;
            
        case 'update_p':
            #Isset pendiente (Validacion de Existencia de las Variables...)
            $id = strip_tags($_POST['idPresentation']);
            $monto = strip_tags($_POST['amount']);
            var_dump($id);
            var_dump($monto);
            $pres = new PresController;
            
            $pres -> upPrice($id,$monto);
            
        break;
        
        }
    }
}


class PresController{
    
    public function isValid($description,$code, $weight_in_grams, $status, $stock, $stock_min, $stock_max, $product_id,$imagen, $amount){
        if(!empty($description)&&
        !empty($code)&&
        !empty($weight_in_grams)&&
        !empty($status)&&
        !empty($stock)&&
        !empty($stock_min)&&
        !empty($stock_max)&&
        !empty($product_id)&&
        !empty($imagen)&&
        !empty($amount)){
            if (!preg_match("/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ,. ]*$/",$description)||
                !preg_match("/^[0-9]*$/",$weight_in_grams)||
                !preg_match("/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ]*$/",$code)||
                !preg_match("/^[0-9]*$/",$stock_min)||
                !preg_match("/^[0-9]*$/",$stock_max)||
                !preg_match("/^[0-9]*$/",$stock)||
                !preg_match("/^[0-9]*$/",$stock)||
                !preg_match("/^[0-9]*$/",$amount)) {
                    $_SESSION['errorMessage'] = "Invalid data";
                    header('location: '.BASE_PATH.'products/?error=false');
                }
        }else{
            $_SESSION['errorMessage'] = "Missing data";
            header('location: '.BASE_PATH.'products/?error=false');
        }
    }
    #Get Presentacion:
    public function getPres($id){

        $token = $_SESSION['token'];
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/presentations/product/'.$id,
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
        $response = json_decode($response);

        if (isset ($response->code) && $response->code > 0){
            return $response->data;
        } else {
            return array();
        }

    }

    #Get Especific Presentacion:
    public function getEspP($id){

        $token = $_SESSION['token'];
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/presentations/'.$id,
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
        $response = json_decode($response);

        if (isset ($response->code) && $response->code > 0){
            return $response->data;
        } else {
            return array();
        }
    }

    #Crear presentacion:
    public function create($description,$code, $weight_in_grams, $status, $stock, $stock_min, $stock_max, $product_id, $imagen, $amount){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/presentations',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('description' => $description,'code' => $code, 'weight_in_grams' => $weight_in_grams,'status' => $status,'cover'=> new CURLFILE($imagen),'stock' => $stock,'stock_min' => $stock_min,'stock_max' => $stock_max,'product_id' => $product_id, 'amount' => $amount),
        
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$_SESSION['token']
        ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);
        var_dump($response);

        if (isset ($response->code) && $response->code > 0){
            $_SESSION['errorMessage'] = "";
            header('location: '.BASE_PATH.'products?success=true');
        } else {
            header('location: '.BASE_PATH.'products?error=false');
        }
    }


    #Editar Presentacion:
    public function editPres($description, $code, $weight_in_grams, $status, $stock, $stock_min, $stock_max, $product_id, $id, $amount)
    {

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
            CURLOPT_POSTFIELDS => 'description='.$description.'&code='.$code.'&weight_in_grams='.$weight_in_grams.'&status='.$status.'&stock='.$stock.'&stock_min='.$stock_min.'&stock_max='.$stock_max.'&product_id='.$product_id.'&id='.$id.'&amount='.$amount,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer 1215|7FaczaWqbE0sy444bREnXpDY8y2Ze5rYwW3ipnmv',
                'Content-Type: application/x-www-form-urlencoded',
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);

        if (isset ($response->code) && $response->code > 0){
            $_SESSION['errorMessage'] = "";
            header('location: '.BASE_PATH.'products?success=true');
        } else {
            header('location: '.BASE_PATH.'products?error=false');
        }
    }



    #Elminar pres por ID:
    public function remove($id){        
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://crud.jonathansoto.mx/api/presentations/'.$id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$_SESSION['token']
            ),
        ));
        
        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);

        if (isset ($response->code) && $response->code > 0){
            header('location: '.BASE_PATH.'products?success=true');
        } else {
            header('location: '.BASE_PATH.'products?error=false');
        }
          
          
    } 


    #Funcion Update price:
    public function upPrice($id,$monto){

        $token = $_SESSION['token'];
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://crud.jonathansoto.mx/api/presentations/set_new_price',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS => 'id='.$id.'&amount='.$monto,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$token
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);
        var_dump($response);
        
        if (isset ($response->code) && $response->code > 0){
            header('location: '.BASE_PATH.'products?success=true');
        } else {
            header('location: '.BASE_PATH.'products?error=false');
        }
    }

}



?>