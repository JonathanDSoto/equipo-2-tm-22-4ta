<?php

include_once  "config.php";

#CRUD
if(isset($_POST['action'])){
    switch($_POST['action']){
        case 'create':
            $name = $_POST['name'];
            $description= $_POST['description'];
            $slug = $_POST['slug'];

            $brand = new BrandController();

            $brand->create($id,$name, $description, $slug);   
            break;
            case 'update':
                $id = strip_tags($_POST['id']);
                $name = strip_tags($_POST['name']);
                $description = strip_tags($_POST['description']);
                $slug = strip_tags($_POST['slug']);
                $brand = new BrandController;
                $brand->editProduct($id,$name, $description, $slug);
                break;

                case 'remove':
                    $id = strip_tags($_POST['id']);
                    $brand = new BrandController;
                    $brand->remove($id);
                break;
        
    }
}

class BrandController{

    #Get de todas las brands:
    public static function getMarcas(){
        
        $curl = curl_init();
        
        $token = $_SESSION['token'];
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://crud.jonathansoto.mx/api/brands',
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

     #Crear Marcas (Brands):
     public function create($name, $description, $slug){

      $token = $_SESSION['token'];    
      $curl = curl_init();

      curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://crud.jonathansoto.mx/api/brands',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => array('name' => $name,'description' =>$description,'slug' => $slug),
      CURLOPT_HTTPHEADER => array(
          'Authorization: Bearer '.$token
      ),
  ));
  
  
      $response = curl_exec($curl);
      curl_close($curl);

      header('location: '.BASE_PATH.'view/index.php');
      var_dump($response);
      
      }


    #Editar Marcas (Brands):
    public function editProduct($id,$name, $description, $slug)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/brands',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'PUT',
        CURLOPT_POSTFIELDS => 'name=' . $name.'&slug='.$slug.'&description='.$description.'&id='.$id,
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


    #Elminar  Marcas (Brands) por ID:
    public function remove($id){
      $curl = curl_init();

      curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://crud.jonathansoto.mx/api/brands/'.$id,
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