<?php
session_start();
session_regenerate_id();
defined('BASEPATH') OR exit('No direct script access allowed');

class Paypal extends CI_Controller
{
    private $apiContext;

    function __construct()
    {   //en el constructor cargamos nuestro modelo
        parent::__construct();
        $this->load->model('User_model');

           }


    public function index()
    {
        $this->load->view('paypal');
    }


    public function pagar()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $user_id = $_POST['user_id'];
        $data = ['user_type' => 'premium'];
        $res = $this->User_model->update_user($user_id, $data);
        if ($res > 0) {
            $_SESSION['user_type']='premium';
            echo "exito";
        } else {
            echo "error";
        }

    }

}