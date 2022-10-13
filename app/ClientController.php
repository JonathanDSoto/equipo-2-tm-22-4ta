<?php 
include_once  "config.php";
#CRUD
if(isset($_POST['action'])){
    switch($_POST['action']){
        case 'create':
            $name = $_POST['name'];
            $lastname = $_POST['lastname'];
            $email= $_POST['email'];
            $phone_number = $_POST['phone_number'];
            $role = $_POST['role'];
            $created_at = $_POST['created_at'];
            $updated_at = $_POST['updated_at'];

            $user = new UserController();

            $imagen = $user->consImg($_FILES['uploadedfile']);

            $user->create($name, $lastname, $email, $phone_number, $role,$created_at, $updated_at,$imagen);   
            break;
            case 'update':
                $name = strip_tags($_POST['name']);
                $slug = strip_tags($_POST['slug']);
                $description = strip_tags($_POST['description']);
                $features = strip_tags($_POST['features']);
                $brand_id = strip_tags($_POST['brand']);
                $id = strip_tags($_POST['id']);
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

class ClientController{
    #Llamar a todos los clientes:
    public function getClientes(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/clients',
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
}


?>