<?php
session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: DARWIN
 * Date: 25/4/2017
 * Time: 1:33
 */
class Categorias extends CI_Controller
{

    function __construct()
    {   //en el constructor cargamos nuestro modelo
        parent::__construct();
        $this->load->model('Category_model');

    }

    public function index()
    {
        $this->load->view('admin/generos');
    }

    public function insert()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $nombre = $_POST['name'];
        $data = ['category_name' => $nombre];

        $res = $this->Category_model->insert($data);
        if ($res) {
            echo "exito";
        } else {
            echo "no se pudo crear la categoria";
        }
    }


    public function get_categorias()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $generos = $this->Category_model->getCategories();
        echo "<div class='row'>";
        foreach ($generos as $genero) {
            echo "<div class='col-md-3 p-3' style='border: 2px solid #d2d2d2;'><b>$genero->category_name</b><br>
            <button class='btn btn-danger mt-2' onclick=\"delete_item('$genero->category_name')\">ELIMINAR</button></div>";
        }
        echo "</div>";

    }


    public function delete()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $id = $_POST['id'];

        $res = $this->Category_model->delete_row($id);
        if ($res > 0) {
            echo "exito";
        } else {
            echo "no se pudo eliminar";
        }

    }
}