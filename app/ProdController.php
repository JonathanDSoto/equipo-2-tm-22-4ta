<?php
include_once  "config.php";

#CRUD
if(isset($_POST['action'])){
    if (isset($_POST['global_token']) && $_POST['global_token'] == $_SESSION['global_token']){
            
                switch($_POST['action']){     
                    case 'create':
                        $name = strip_tags($_POST['name']);
                        $slug = strip_tags($_POST['slugProduct']);
                        $description = strip_tags($_POST['description']);
                        $features = strip_tags($_POST['features']);
                        $brand_id = strip_tags($_POST['brand']);
                        $categories = $_POST['categories'];
                        $tags = $_POST['tags'];
                        #Imagen:
                        if(isset($_FILES['cover']) && $_FILES["cover"]["error"] == 0) {
                            $imagen = $_FILES["cover"]["tmp_name"];     
                            $p = new ProdController();
                            if($p->isValid($name, $slug, $description, $features)){
                                $p -> create($name, $slug, $description, $features, $brand_id, $imagen, $categories, $tags);
                            }
                            
                        }else{
                            header('location: '.BASE_PATH.'products?error=false');
                        }  
            
                    break;
            
                    case 'update':
                        $name = strip_tags($_POST['name']);
                        $slug = strip_tags($_POST['slugProduct']);
                        $description = strip_tags($_POST['description']);
                        $features = strip_tags($_POST['features']);
                        $brand_id = strip_tags($_POST['brand']);
                        $categories = $_POST['categories'];
                        $tags = $_POST['tags'];
                        $id = strip_tags($_POST['id']);
                        $p = new ProdController();
                        if($p->isValid($name, $slug, $description, $features)){
                            $p->editProduct($name, $slug, $description, $features, $brand_id, $id, $categories, $tags); 
                        }
                        
                            
                    break;
            
                    case 'remove':
                        $id = strip_tags($_POST['id']);
                        $p = new ProdController;
                        $p->remove($id);
            
                    break;     
                    }
                }
            }
            
class ProdController{

    public function isValid($name,$slug,$description,$features){
        
        if(!empty($name)&&
            !empty($slug)){
                if (!preg_match("/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]*$/",$name)||
                !preg_match("/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ-]*$/",$slug)||
                !preg_match("/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ,. ]*$/",$description)||
                !preg_match("/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ,. ]*$/",$features)) {
                    $_SESSION['errorMessage'] = "Invalid data";
                    header('location: '.BASE_PATH.'products/create/');
                    
                }
                else{
                    return true;
                }
            }else{
                $_SESSION['errorMessage'] = "Missing data";
                header('location: '.BASE_PATH.'products/create/');
            }
    }
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
        $response = json_decode($response);

        if (isset ($response->code) && $response->code > 0){
            return $response->data;
        } else {
            return array();
        }
    }


    #Crear Productos:
    public function create($name, $slug, $description, $features, $brand_id, $imagen, $categories, $tags){

        $token = $_SESSION['token'];    
        $curl = curl_init();

        $params = array('name' => $name,'slug' => $slug,'description' =>$description,'features' => $features,'brand_id' => $brand_id,'cover'=> NEW CURLFile($imagen));

        foreach ($categories as $key => $value) {
            $params += ["categories[".$key."]" => $value];
        }
        foreach ($tags as $key => $value) {
            $params += ["tags[".$key."]" => $value];
        }

        var_dump($params);
    
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://crud.jonathansoto.mx/api/products',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $params,
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


    #Editar Productos:
    public function editProduct($name, $slug, $description, $features, $brand_id, $id, $categories, $tags){

        $token = $_SESSION['token'];
        $curl = curl_init();

        $params = 'name=' . $name.'&slug='.$slug.'&description='.$description.'&features='.$features.'&brand_id='.$brand_id.'&id='.$id;
        foreach ($categories as $key => $value) {
            $params = $params."&categories[".$key."]=".$value;
        }
        foreach ($tags as $key => $value) {
            $params = $params."&tags[".$key."]=".$value;
        }
        
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/products',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'PUT',
        CURLOPT_POSTFIELDS => $params,
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
        curl_close($curl);
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
            header('location: '.BASE_PATH.'products');
        } else {
            header('location: '.BASE_PATH.'products?error=false');
        }
    }
    
    
    #Get producto por ID:
    public function getperId($id){

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