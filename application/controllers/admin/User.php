<?php
session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller
{
    function __construct()
    {   //en el constructor cargamos nuestro modelo
        parent::__construct();
        if(!isset($_SESSION['username'])){
            exit('403 acceso denegado');
        }
        if($_SESSION['user_type']!='admin'){
            exit('403 acceso denegado');
        }
        $this->load->model('User_model');
    }

    public function index()
    {
        $this->load->view('admin/home');
    }


    public function users()
    {
        $this->load->view('admin/users');
    }


    public function get_users()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $users = $this->User_model->get_users();
        $json = array();
        $response = array();

        foreach ($users as $user) {
            $json[] = array($user->user_id, $user->username, $user->email, $user->user_type,
                "<button class='btn btn-info btn-sm' onclick=\"edit('$user->user_id')\"><i class='icon-edit'></i> Editar</button>
<button class='btn btn-danger btn-sm' title='eliminar categoria' onclick=\"delete_item($user->user_id)\"><i class='icon-trash-2'></i> Eliminar</button>"
            );
        }

        $response['data'] = $json;
        echo json_encode($response);
    }


    public function delete_user()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        if ($_SESSION['user_type'] == 'admin') {
            $id = $_POST['id'];

            $res = $this->User_model->delete_row($id);

            if ($res > 0) {
                echo "exito";
            } else {
                echo "no se pudo eliminar el usuario";
            }
        } else {
            echo "403 acceso denegado";
        }
    }


    public function user_data()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        if ($_SESSION['user_type'] == 'admin') {
            $id = $_POST['id'];

            $user = $this->User_model->get_user_id($id);

            if ($user) {
                echo "<div>
              <input name='user_id' type='text' hidden value='$user->user_id'>

                        <div class='row'>
                            <div class='col-md-5'>
                             <label>Username</label>
                            <input required class='form-control' type='text' name='username' value='$user->username'>
                            </div>

                             <div class='col-md-7'>
                              <label>Email</label>
                            <input required class='form-control' type='email' name='email' value='$user->email'>
                            </div>




                        </div>
                        <hr>

                        <div class='row'><div class='col-12'>
                            <label>Tipo usuario</label>
                            <select class='form-control' required name='type' id=''>
                            <option value='admin'>admin</option>
                            <option value='free'>free</option>
                            <option value='pro'>pro</option>
                            </select>
                            </div></div>
                        <hr>

                            <div class='row'>
                            <div class='col-12'>
                            <button type='submit' class='btn btn-primary w-100'><i class='icon-ok-1'></i> Actualizar</button>
                        </div>
            </div>

                    </div>";
            }

        } else {
            echo "403 acceso denegado";
        }
    }


    public function  edit_user()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        if ($_SESSION['user_type'] == 'admin') {
            $id = $_POST['user_id'];

            $data = [
                'username' => $_POST['username'],
                'email' => $_POST['email'],
                'user_type' => $_POST['type'],
            ];

            $res = $this->User_model->update_row($id, $data);
            if ($res > 0) {
                echo "exito";
            } else {
                echo "error";
            }

        } else {
            echo "error 403";
        }
    }

}
