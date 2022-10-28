<?php

include_once  "config.php";

#CRUD
if(isset($_POST['action'])){
  if (isset($_POST['global_token']) && $_POST['global_token'] == $_SESSION['global_token']){
    switch($_POST['action']){
      case 'create':
        $name = strip_tags($_POST['name']);
        $description = strip_tags($_POST['description']);
        $slug = strip_tags($_POST['slugTag']);

        $tag = new TagController();
        if($tag->isValid($name,$slug,$description)){
           $tag->create($name, $description, $slug); 
        }
        

      break;
      case 'update':
        $id = strip_tags($_POST['id']);
        $name = strip_tags($_POST['name']);
        $description = strip_tags($_POST['description']);
        $slug = strip_tags($_POST['slugTag']);

        $tag = new TagController;
        if($tag->isValid($name,$slug,$description)){
           $tag->editTag($id,$name, $description, $slug);
        }
      break;
      case 'remove':
        $id = strip_tags($_POST['id']);

        $tag = new TagController;

        $tag->remove($id);

      break;
      }
   }
}

class TagController{

    public function isValid($name,$slug,$description){
      #Validacion de contenido en input
      if(!empty($name)&&
          !empty($slug)&&
          !empty($description)){
              if (!preg_match("/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]*$/",$name)||
              !preg_match("/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ-]*$/",$slug)||
              !preg_match("/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ,. ]*$/",$description)) {
                  $_SESSION['errorMessage'] = "Invalid data";
                  header('location: '.BASE_PATH.'tags/?error=false');
                  
              }
              else{
                  return true;
              }
          }else{
              $_SESSION['errorMessage'] = "Missing data";
              header('location: '.BASE_PATH.'tags/?error=false');
          }
    }
  
    #Get de todos los tags:
    public static function getTags(){
        
        $token = $_SESSION['token'];
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/tags',
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

     #Crear tags:
     public function create($name, $description, $slug){

        $token = $_SESSION['token'];    
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/tags',
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
        $response = json_decode($response);
        
        if (isset ($response->code) && $response->code > 0){
          $_SESSION['errorMessage'] = "";
          header('location: '.BASE_PATH.'tags?success=true');
        } else {
          header('location: '.BASE_PATH.'tags?error=false');
        }
      
      }


    #Editar tags:
    public function editTag($id,$name, $description, $slug)
    {
        $token = $_SESSION['token'];
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/tags',
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
      $response = json_decode($response);

      if (isset ($response->code) && $response->code > 0){
        $_SESSION['errorMessage'] = "";
        header('location: '.BASE_PATH.'tags?success=true');
      } else {
        header('location: '.BASE_PATH.'tags?error=false');
      }
    }


    #Elminar  tags por ID:
    public function remove($id){
      
        $token = $_SESSION['token'];
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/tags/'.$id,
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
          header('location: '.BASE_PATH.'tags?success=true');
        } else {
          header('location: '.BASE_PATH.'tags?error=false');
        }
    } 

    #Get Tag especifico:
    public function getEspecificTag($id){

        $token = $_SESSION['token'];
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/tags/'.$id,
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