<?php 

include_once  "config.php";

#CRUD
if(isset($_POST['action'])){
    switch($_POST['action']){
        case 'create':

            $id = $_POST['id'];
            $description = $_POST['description'];
            $code = $_POST['code'];
            $weight_in_grams = $_POST['weight_in_grams'];
            $status = $_POST['status'];
            $stock = $_POST['stock'];
            $stock_min = $_POST['stock_min'];
            $stock_max = $_POST['stock_max'];
            $product_id = $_POST['product_id'];
            #Funcion de  precio...

            $imagen = $pres->consImg($_FILES['uploadedfile']);

            $pres = new PresController();

            $pres->create( $id,$description,$code, $weight_in_grams, $status, $stock, $stock_min, $stock_max, $product_id,$imagen);   
            break;
            
            case 'update':

                $description = strip_tags($_POST['description']);
                $code = strip_tags($_POST['code']);
                $weight_in_grams = strip_tags($_POST['weight_in_grams']);
                $status = strip_tags($_POST['status']);
                $stock = strip_tags($_POST['stock']);
                $stock_max = strip_tags($_POST['stock_max']);
                $stock_min = strip_tags($_POST['stock_min']);
                $product_id = strip_tags($_POST['product_id']);

                break;

                case 'remove':
                    $id = strip_tags($_POST['id']);
                    $pres = new PresController;
                    $pres->remove($id);
                break;

                case 'update_p':
                    $id = strip_tags($_POST['id']);
                    $monto = strip_tags($_POST['amount']);
                    $pres = new PresController;
                    $pres -> upPrice($id);
                break;
        
    }
}



class PresController{

    #Arrastrar el cover:
    public function consImg($arch){
        $target_path  = '.public/presImage/';
        $target_path = $target_path . basename( $_FILES['uploadedfile']['name']); 
        if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
            echo "El archivo ".  basename( $_FILES['uploadedfile']['name']). 
            " ha sido subido";
        } else{
            echo "Ha ocurrido un error, trate de nuevo!";
        }
        return $target_path;
    }

    #Precio:
    public function consPrecio($id){

    }

    #Get Presentacion:
    public function getPres(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/presentations/product/1',
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
        return $response;

    }

    #Get Especific Presentacion:
    public function getEspP($id){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/presentations/1',
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
        return $response;
    }

    #Crear presentacion:
    public function create($id,$description,$code, $weight_in_grams, $status, $stock, $stock_min, $stock_max, $product_id,$imagen){

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
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => 'description' => $description ,'code'=> $code,'weight_in_grams'=>$weight_in_grams,'status'=> $status,'stock'=>$stock,'stock_min'=>$stock_min,'stock_max'=>$stock_max,'product_id'=>$product_id,'cover'=> NEW CURLFile($imagen),
          CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$_SESSION['token']
            ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        echo $response;
        $response = json_decode($response);

        var_dump($response);
    
    }


    #Editar Presentacion:
    public function editProduct($id,$description,$code, $weight_in_grams, $status, $stock, $stock_min, $stock_max, $product_id,$imagen)
    {
        $$curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://crud.jonathansoto.mx/api/presentations',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS => 'description=' . $description.'&code='.$code.'&weight_in_grams='.$weight_in_grams.'&status='.$status.'&stock='.$stock.'stock_min='.$stock_min.'&stock_max='.$stock_max.'&product_id='.$product_id,
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
        return true;
      } else {
        return false;
      }
    }



    #Elminar pres por ID:
    public function remove($id){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/products/'.$id,
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
        if (isset ($response->code) && $response->code > 0) {
            return true;
        } else {
            return false;
        }
    } 


    #Funcion Update price:
    public function upPrice($id,$monto){
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
    echo $response;
    $response = json_decode($response);
    return $response;
        }

}


?>