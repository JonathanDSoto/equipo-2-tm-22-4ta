<?php 
include_once  "config.php";

#CRUD
if(isset($_POST['action'])){
  if (isset($_POST['global_token']) && $_POST['global_token'] == $_SESSION['global_token']) {
    switch ($_POST['action']) {
      case 'create':
        if (isset($_POST['name']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['phone_number']) && isset($_POST['role']) && isset($_POST['password']) && isset($_FILES['avatar'])) {
          $name = strip_tags($_POST['name']);
          $lastname = strip_tags($_POST['lastname']);
          $email = strip_tags($_POST['email']);
          $phone_number = strip_tags($_POST['phone_number']);
          $role = strip_tags($_POST['role']);
          $created_by = $_SESSION['name'].' '. $_SESSION['lastname'];
          $password = strip_tags($_POST['password']);
          
          #Imagen:
          if (isset($_FILES['avatar']) && $_FILES["avatar"]["error"] == 0) {
            $imagen = $_FILES["avatar"]["tmp_name"];
            
            $user = new UserController();
            if($user->isValid($name, $lastname, $email, $phone_number, $created_by, $role, $password, $imagen)){
              $user->create($name, $lastname, $email, $phone_number, $created_by, $role, $password, $imagen);
            }
          } else {
            header('location: '.BASE_PATH.'users?error=false');
          }
        } else {
          header('location: '.BASE_PATH.'users?error=false');
        }
      break;

      case 'update':
        if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['phone_number']) && isset($_POST['created_by']) && isset($_POST['role']) && isset($_POST['created_by']) && isset($_POST['password'])) {
          $id = strip_tags($_POST['id']);
          $name = strip_tags($_POST['name']);
          $lastname = strip_tags($_POST['lastname']);
          $email = strip_tags($_POST['email']);
          $phone_number = strip_tags($_POST['phone_number']);
          $created_by = strip_tags($_POST['created_by']);
          $role = strip_tags($_POST['role']);
          $password = strip_tags($_POST['password']);
          
          $user = new UserController();
          if($user->isValid($name, $lastname, $email, $phone_number, $created_by, $role, $password)){
            $user->updateUsers($id, $name, $lastname, $email, $phone_number, $created_by, $role, $password);
          }
        } else {
          header('location: '.BASE_PATH.'users?error=false');
        }
      break;
    
      case 'updateImage':
        if(isset($_POST['id'])){
          $id = strip_tags($_POST['id']);

          if(isset($_FILES['avatar']) && $_FILES["avatar"]["error"] == 0) {
            $imagen = $_FILES["avatar"]["tmp_name"];
        
            $user = new UserController;
            $user->UpdateImage($id, $imagen);
          }else{
            header('location: '.BASE_PATH.'users/'.$id.'?error=false');
          }  
        } else {
          header('location: '.BASE_PATH.'users/'.$id.'?error=false');
        } 
      break;

      case 'remove':
        if (isset($_POST['id'])) {
          $id   = strip_tags($_POST['id']);
          $user = new UserController;
          $user->remove($id);
        } else {
          header('location: '.BASE_PATH.'users?error=false');
        }
      break;
    }
  }
}

class UserController{

  public function isValid($name, $lastname, $email, $phone_number, $created_by, $role, $password)
  {
    if(!empty($name)&&
        !empty($lastname)&&!empty($email)&&
        !empty($phone_number)&&!empty($created_by)&&
        !empty($role)&&!empty($password)){
          
          if(!preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]*$/",$name)||
            !preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]*$/",$lastname)||
            !preg_match("/^[0-9]*$/",$phone_number)||
            !filter_var($email, FILTER_VALIDATE_EMAIL)||
            !preg_match("/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ!#$%&']*$/",$password)){
                $_SESSION['errorMessage'] = "Invalid data";
                header('location: '.BASE_PATH.'users?error=false');
            }else{
                return true;
            }

        }else{
          $_SESSION['errorMessage'] = "Missing data";
          header('location: '.BASE_PATH.'users?error=false');
      }
  }
  #Get todos los usuarios (Users):
  public function getUsers(){
    $token = $_SESSION['token'];
    $curl  = curl_init();
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
      )
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $response = json_decode($response);
    
    if (isset($response->code) && $response->code > 0) {
      return $response->data;
    } else {
      return array();
    }
  } 

  #Crear usuarios (Users):
  public function create($name, $lastname, $email, $phone_number, $created_by, $role, $password, $imagen) {
    
    $token = $_SESSION['token'];
    $curl  = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://crud.jonathansoto.mx/api/users',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => array('name' => $name,'lastname' => $lastname,'email' =>$email,'phone_number' => $phone_number,'created_by' => $created_by, 'role' => $role,'password' => $password,'profile_photo_file' => new CURLFILE($imagen)),
      CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer '.$token
      ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $response = json_decode($response);
    
    if (isset($response->code) && $response->code > 0) {
      header('location: '.BASE_PATH.'users?success=true');
    } else {
      header('location: '.BASE_PATH.'users?error=false');
    }
  }

  #Editar usuarios (Users):
  #Editar usuarios (Users):
  public function updateUsers($id, $name, $lastname, $email, $phone_number, $created_by, $role, $password){
    $token = $_SESSION['token'];
    $curl  = curl_init();
    
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://crud.jonathansoto.mx/api/users',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'PUT',
      CURLOPT_POSTFIELDS => 'name='.$name.'&lastname='.$lastname.'&email='.$email.'&phone_number='.$phone_number.'&created_by='.$created_by.'&role='.$role.'&password='.$password.'&id='.$id,
      CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer ' . $token,
        'Content-Type: application/x-www-form-urlencoded'
      )
    ));
    
    $response = curl_exec($curl);
    curl_close($curl);
    $response = json_decode($response);
    if (isset($response->code) && $response->code > 0) {
      if($_SESSION['id']==$id){
        $_SESSION['name']=$response->data->name;
        $_SESSION['lastname']=$response->data->lastname;
        $_SESSION['created_by']=$response->data->created_by;
        $_SESSION['phone_number']=$response->data->phone_number;
      }
      header('location: '.BASE_PATH.'users?success=true');
    } else {
      header('location: '.BASE_PATH.'users?error=false');
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
        'Authorization: Bearer '.$_SESSION['token']
      )
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $response = json_decode($response);

    if (isset($response->code) && $response->code > 0) {
      header('location: '.BASE_PATH.'users?success=true');
    } else {
      header('location: '.BASE_PATH.'users?error=false');
    }
  }

  #Get user especifico:
  public function getEspecificUser($id){

    $token = $_SESSION['token'];
    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://crud.jonathansoto.mx/api/users/'.$id,
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
    $response = json_decode ($response);

    if (isset ($response->code) && $response->code > 0){
      return $response->data;
    } else {
      return array();
    }
  }

  #Update Profile Imagen:
  public function UpdateImage($id,$imagen){


    $token = $_SESSION['token'];
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://crud.jonathansoto.mx/api/users/avatar',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => array('id' => $id,'profile_photo_file'=> new CURLFILE($imagen)),
    CURLOPT_HTTPHEADER => array(
      'Authorization: Bearer ' . $_SESSION['token']),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $response = json_decode ($response);
    if (isset ($response->code) && $response->code > 0){
      $_SESSION['avatar'] = $response->data->avatar;
      header('location: '.BASE_PATH.'users/'.$id.'?success=true');
    } else {
      header('location: '.BASE_PATH.'users/'.$id.'?error=false');
    }
  }
}
?>