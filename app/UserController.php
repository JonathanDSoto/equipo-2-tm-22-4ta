<?php 
include_once  "config.php";

#CRUD
if(isset($_POST['action'])){
    switch($_POST['action']){
        case 'create':
            
            $name = strip_tags($_POST['name']);
            $slug = strip_tags($_POST['slug']);
            $description = strip_tags($_POST['description']);
            $features = strip_tags($_POST['features']);
            $brand_id = strip_tags($_POST['brand']);

            $user = new UserController();

            $imagen = $user->consImg($_FILES['uploadedfile']);

            $user->create($name, $lastname, $email, $phone_number, $role,$created_at, $updated_at,$imagen);   
        break;
        case 'update':

            $id = strip_tags($_POST['id']);
            $name = strip_tags($_POST['name']);
            $slug = strip_tags($_POST['slug']);
            $description = strip_tags($_POST['description']);
            $features = strip_tags($_POST['features']);
            $brand_id = strip_tags($_POST['brand']);

            $imagen = $user->consImg($_FILES['uploadedfile']);

            $user = new UserController;

            $user->editProduct($name, $lastname, $email, $phone_number, $role,$created_at, $updated_at, $id);

        break;

        case 'remove':

            $id = strip_tags($_POST['id']);
            $user = new UserController;
            $user->remove($id);

        break;     
    }
}

class UserController{

    #Arrastrar el avatar:
    public function consImg($arch){
        $target_path  = '.public/avatar/';
        $target_path = $target_path . basename( $_FILES['uploadedfile']['name']); 
        if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
            echo "El archivo ".  basename( $_FILES['uploadedfile']['name']). 
            " ha sido subido";
        } else{
            echo "Ha ocurrido un error, trate de nuevo!";
        }
        return $target_path;
    }

    #Get todos los usuarios (Users):
    public function getUsers(){
        $curl = curl_init();
        $token = $_SESSION['token'];
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://crud.jonathansoto.mx/api/users',
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
    $response = json_decode ($response);
    return $response;
    
    }
    #Crear usuarios (Users):
    public function create($name, $lastname, $email, $phone_number, $role,$created_at, $updated_at,$imagen){

        $token = $_SESSION['token'];    
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/users',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_POSTFIELDS => array('name' => $name,'lastname' => $lastname,'email' =>$email,'phone_number' => $phone_number,'role' => $role,'created_at,' => $created_at,'updated_at,' => $updated_at,'avatar'=> NEW CURLFile($imagen)),
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$token
        ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $response = json_decode ($response);
    header('location: '.BASE_PATH.'view/index.php');
    var_dump($response);
    }

    #Editar usuarios (Users):
    public function updateUsers($name, $lastname, $email, $phone_number, $role,$created_at, $updated_at,$id){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/users',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'PUT',
          CURLOPT_POSTFIELDS => 'name=' . $name.'&lastname='.$lastname.'&email='.$email.'&phone_number='.$phone_number.'&role='.$role.'&created_at='.$created_at.'&updated_at='.$updated_at.'&$id='.$id.'&avatar='. NEW CURLFile($imagen),
          CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$_SESSION['token']
          ),
        ));
    
        $response = curl_exec($curl);
        $response = json_decode ($response);
        curl_close($curl);
        if (isset ($response->code) && $response->code > 0){
            header('location: '.BASE_PATH.'view/index.php');
          } else {
            header('location: '.BASE_PATH.'view/index.php?error=false');
          }
      }
      #Elminar usuarios (Users) por ID:
      public function remove($id){
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://crud.jonathansoto.mx/api/users/'.$id,
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
?>