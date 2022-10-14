<?php 
include_once  "config.php";

#CRUD
if(isset($_POST['action'])){
    if (isset($_POST['global_token']) && $_POST['global_token'] == $_SESSION['global_token']){
    switch($_POST['action']){
        case 'create':
            if(isset($_POST['name'])&& isset($_POST['lastname'])&& isset($_POST['email'])&& isset($_POST['phone_number'])&& isset($_POST['role'])&& isset($_POST['created_at'])&& isset($_POST['updated_at'])){
                $name = strip_tags($_POST['name']);
                $lastname = strip_tags($_POST['lastname']);
                $email = strip_tags($_POST['email']);
                $phone_number = strip_tags($_POST['phone_number']);
                $role = strip_tags($_POST['role']);
                $created_at = strip_tags($_POST['created_at']);
                $updated_at = strip_tags($_POST['updated_at']);

                #Imagen:
                if(isset($_FILES['avatar']) && $_FILES["avatar"]["error"] == 0) {
                    $imagen = $_FILES["avatar"]["tmp_name"];
                
                    $user = new UserController();
                    $user -> create($name, $lastname, $email, $phone_number, $role,$created_at, $updated_at,$imagen);
                }else{
                    header('location: '.BASE_PATH.'users?error=false');
                }
            }   
        break;
        case 'update':
            if(isset($_POST['id'])&&isset($_POST['name'])&& isset($_POST['lastname'])&& isset($_POST['email'])&& isset($_POST['phone_number'])&& isset($_POST['role'])&& isset($_POST['created_at'])&& isset($_POST['updated_at'])){
                $id = strip_tags($_POST['id']);
                $name = strip_tags($_POST['name']);
                $slug = strip_tags($_POST['slug']);
                $description = strip_tags($_POST['description']);
                $features = strip_tags($_POST['features']);
                $role = strip_tags($_POST['brand']);

                $imagen = $user->consImg($_FILES['uploadedfile']);

                $user = new UserController;

                $user->editProduct($name, $lastname, $email, $phone_number, $role,$created_at, $updated_at, $id);
            }
        break;

        case 'remove':
            if(isset($_POST['id'])){
                $id = strip_tags($_POST['id']);
                $user = new UserController;
                $user->remove($id);
            }
        break;     
        }
    }
}

class UserController{

    #Get todos los usuarios (Users):
    public function getUsers(){
        
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
         CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer ".$token
    ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $response = json_decode ($response);

    if (isset ($response->code) && $response->code > 0){
        return $response->$data;
      } else {
        return array();
      }

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
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('name' => $name,'lastname' => $lastname,'email' =>$email,'phone_number' => $phone_number,'role' => $role,'created_at,' => $created_at,'updated_at,' => $updated_at,'avatar'=> NEW CURLFile($imagen)),
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$token
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode ($response);

        if (isset ($response->code) && $response->code > 0){
            header('location: '.BASE_PATH.'users?success=true');
          } else {
            header('location: '.BASE_PATH.'users?error=false');
          }
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
        curl_close($curl);
        $response = json_decode ($response);
        if (isset ($response->code) && $response->code > 0){
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
            'Authorization: Bearer ' . $_SESSION['token']
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $response = json_decode ($response);
        if (isset ($response->code) && $response->code > 0){
            header('location: '.BASE_PATH.'users?success=true');
          } else {
            header('location: '.BASE_PATH.'users?error=false');
          }
    } 
}
?>