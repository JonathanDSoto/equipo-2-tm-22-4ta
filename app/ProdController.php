<?php
include_once  "config.php";

#CRUD
if(isset($_POST['action'])){
    if (isset($_POST['global_token']) && $_POST['global_token'] == $_SESSION['global_token']){
    switch($_POST['action']){
        case 'create':
            #Isset pendiente (Validacion de Existencia de las Variables...)
            $name = strip_tags($_POST['name']);
            $slug = strip_tags($_POST['slug']);
            $description = strip_tags($_POST['description']);
            $features = strip_tags($_POST['features']);
            $brand_id = strip_tags($_POST['brand']);

            #Imagen:
            if(isset($_FILES['cover']) && $_FILES["cover"]["error"] == 0) {
                $imagen = $_FILES["cover"]["tmp_name"];
            
                $p = new ProdController();
                $p -> create($name, $slug, $description, $features, $brand);
            }else{
                header('location: '.BASE_PATH.'products?error=false');
            }  

        break;

        case 'update':
            #Isset pendiente (Validacion de Existencia de las Variables...)
            $id = strip_tags($_POST['id']);
            $name = strip_tags($_POST['name']);
            $slug = strip_tags($_POST['slug']);
            $description = strip_tags($_POST['description']);
            $features = strip_tags($_POST['features']);
            $brand_id = strip_tags($_POST['brand']);

            #Imagen:
            if(isset($_FILES['cover']) && $_FILES["cover"]["error"] == 0) {
                $imagen = $_FILES["cover"]["tmp_name"];
            
                $p = new ProdController();
                $p->editProduct($name, $slug, $description, $features, $brand, $id);
            }else{
                header('location: '.BASE_PATH.'products?error=false');
            }  
                
        break;

        case 'remove':
            #Isset pendiente (Validacion de Existencia de las Variables...)
            $id = strip_tags($_POST['id']);
            $p = new ProdController;
            $p->remove($id);

        break;     
        }
    }
}



class ProdController{

    #Get todos los productos:
    public function getTodo(){

        $token = $_SESSION['token'];
        $curl = curl_init();
        #echo $token;
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/products',
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
        if (isset ($response->code) && $response->code > 0){
            return $response->$data;
          } else {
            return array();
          }
    }


    #Crear Productos:
    public function create($name, $slug, $description, $features, $brand_id, $imagen){

        $token = $_SESSION['token'];    
        $curl = curl_init();
    
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/products',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('name' => $name,'slug' => $slug,'description' =>$description,'features' => $features,'brand_id' => $brand_id,'cover'=> NEW CURLFile($imagen)),
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$token
        ),
    ));
    
    
    $response = curl_exec($curl);
    curl_close($curl);

    header('location: '.BASE_PATH.'view/index.php');
    var_dump($response);
    
    }


    #Editar Productos:
    public function editProduct($name, $slug, $description, $features, $brand_id, $id){

        $token = $_SESSION['token'];
        $curl = curl_init();
  
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/products',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'PUT',
        CURLOPT_POSTFIELDS => 'name=' . $name.'&slug='.$slug.'&description='.$description.'&features='.$features.'&brand_id='.$brand_id.'&id='.$id,
        CURLOPT_HTTPHEADER => array(
          'Authorization: Bearer '.$_SESSION['token']
        ),
      ));
  
      $response = curl_exec($curl);
      curl_close($curl);
      if (isset ($response->code) && $response->code > 0){
        header('location: '.BASE_PATH.'view/index.php');
      } else {
        header('location: '.BASE_PATH.'view/index.php?error=false');
      }

    }

    

    #Get Producto por Slug
    public static function getPslug($slug){

        $token = $_SESSION['token'];    
        $curl = curl_init();    
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/products/slug/'.$slug,
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
        $response = json_decode($response);

        if ( isset($response->code) && $response->code > 0) {
    
            return $response->data;
        }else{
        
            return array();
        }

    }

    #Elminar producto por ID:
    public function remove($id){

        $token = $_SESSION['token'];
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
            'Authorization: Bearer ' . $_SESSION['token']
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $response = json_decode ($response);
        if (isset ($response->code) && $response->code > 0){
            header('location: '.BASE_PATH.'view/index.php');
          } else {
            header('location: '.BASE_PATH.'view/index.php?error=false');
          }
    } 
        
    }
    
#'jeju_19@alu.uabcs.mx'
#O338lXPk!5k8I6
#143|x9b5qQBIpJIehXKkKYmwz63kLObrG86yCsCeC2JN
?>

