<?php

include_once  "config.php";

#CRUD
if(isset($_POST['action'])){
  if (isset($_POST['global_token']) && $_POST['global_token'] == $_SESSION['global_token']){

    switch($_POST['action']){

      case 'create':
        #Isset pendiente (Validacion de Existencia de las Variables...)
        $name = strip_tags($_POST['name']);
        $description = strip_tags($_POST['description']);
        $slug = strip_tags($_POST['slugCategory']);
        $category_id = strip_tags($_POST['category_id']);

        $cath = new CathController();
        if($cath->isValid($name,$slug,$description)){
            $cath->create($name, $description, $slug,$category_id); 
        }
       

      break;
      case 'update':
        #Isset pendiente (Validacion de Existencia de las Variables...)
        $id = strip_tags($_POST['id']);
        $name = strip_tags($_POST['name']);
        $description = strip_tags($_POST['description']);
        $slug = strip_tags($_POST['slugCategory']);
        $category_id = strip_tags($_POST['category_id']);

        $cath = new CathController;
        if($cath->isValid($name,$slug,$description)){
            $cath->editCath($id,$name, $description, $slug,$category_id);
        }
      break;
      case 'remove':
        #Isset pendiente (Validacion de Existencia de las Variables...)
        $id = strip_tags($_POST['id']);

        $cath = new CathController;

        $cath->remove($id);

      break;
      }
  }
}

class CathController{

    public function isValid($name,$slug,$description){
      #Validacion de contenido en input
      if(!empty($name)&&
          !empty($slug)&&
          !empty($description)){
              if (!preg_match("/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]*$/",$name)||
              !preg_match("/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ-]*$/",$slug)||
              !preg_match("/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ,. ]*$/",$description)) {
                  $_SESSION['errorMessage'] = "Invalid data";
                  header('location: '.BASE_PATH.'categories/?error=false');
                  
              }
              else{
                  return true;
              }
          }else{
              $_SESSION['errorMessage'] = "Missing data";
              header('location: '.BASE_PATH.'categories/?error=false');
          }
    }

    #Get de todas las categorias:
    public static function getCath(){
        
        $token = $_SESSION['token'];
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/categories',
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

     #Crear Categorias:
     public function create($name, $description, $slug,$category_id){

        $token = $_SESSION['token'];    
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/categories',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('name' => $name,'description' =>$description,'slug' => $slug,'category_id' =>$category_id),
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$token
        ),
         ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);

        if (isset ($response->code) && $response->code > 0){
          $_SESSION['errorMessage'] = "";
          header('location: '.BASE_PATH.'categories?success=true');
        } else {
          header('location: '.BASE_PATH.'categories?error=false');
        }
      }


    #Editar tags:
    public function editCath($id,$name, $description, $slug,$category_id)
    {
        $token = $_SESSION['token'];
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/categories',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'PUT',
        CURLOPT_POSTFIELDS => 'name=' . $name.'&slug='.$slug.'&description='.$description.'&id='.$id.'&category_id='.$category_id,
        CURLOPT_HTTPHEADER => array(
          'Authorization: Bearer '.$_SESSION['token']
        ),
      ));
      $response = curl_exec($curl);
      curl_close($curl);
      $response = json_decode($response);

      if (isset ($response->code) && $response->code > 0){
        $_SESSION['errorMessage'] = "";
        header('location: '.BASE_PATH.'categories/?success=true');
      } else {
        header('location: '.BASE_PATH.'categories/?error=false');
      }
    }


    #Elminar categorias por ID:
    public function remove($id){
      
        $token = $_SESSION['token'];
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/categories/'.$id,
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
        $response = json_decode($response);

        if (isset ($response->code) && $response->code > 0){
          header('location: '.BASE_PATH.'categories/?success=true');
        } else {
          header('location: '.BASE_PATH.'categories/?error=false');
        }
    } 

    #Get categoria especifica:
    public function getSSpecifCath($id){

        $token = $_SESSION['token'];
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/categories/'.$id,
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