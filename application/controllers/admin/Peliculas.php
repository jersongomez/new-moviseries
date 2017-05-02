<?php
session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Peliculas extends CI_Controller
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

        $this->load->model('Category_model');
        $this->load->model('Movie_model');

        $new_path = $_SERVER['DOCUMENT_ROOT'] . '/covers/';
        if (!is_dir($new_path)) {
            mkdir($new_path);
        }
    }


    public function index()
    {
        $categories = $this->Category_model->getCategories();
        $this->load->view('admin/peliculas', ['categories' => json_encode($categories)]);
    }


    public function list_movies()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        if ($_SESSION['user_type'] == 'admin') {


            $movies = $this->Movie_model->get_movies();
            $data = array();
            foreach ($movies as $movie) {

                $categories = $this->Category_model->getCategoriasByMovie($movie->movie_id);

                $str = $categories[0]->category_name;
                for ($i = 1; $i < sizeof($categories); $i++) {
                    $str = $str . ", " . $categories[$i]->category_name;
                }
                $url_edit = base_url('admin/editar-pelicula/' . $movie->movie_id);

                $url = base_url('admin/peliculas/enlaces/' . $movie->movie_id);
                $json = array('<img src="' . $movie->cover . '" width="60">',
                    $movie->movie_id, $movie->name,
                    $movie->year,
                    $str,
                    "<a class='btn btn-primary btn-sm w-100' href='$url'><i class='icon-link-1'></i> Enlaces</a>
                <a class='btn btn-info btn-sm w-100' href='$url_edit'><i class='icon-edit'></i> Editar</a>
                <button class='btn btn-danger btn-sm w-100' title='eliminar categoria' onclick=\"delete_item($movie->movie_id)\"><i class='icon-trash-2'></i> Eliminar</button>"
                );

                array_push($data, $json);
            }

            echo json_encode(array('data' => $data));

            // echo json_encode($response);
        }
    }


    public function nueva_pelicula()
    {
        if ($_SESSION['user_type'] == 'admin') {
            $categories = $this->Category_model->getCategories();
            $this->load->view('admin/nueva_pelicula', ['categories' => json_encode($categories)]);
        } else {
            echo "403 no tien permiso para esta pagina";
        }

    }

    public function editar_pelicula($id)
    {
        if ($_SESSION['user_type'] == 'admin') {
            $movie = $this->Movie_model->getById($id);
            $this->load->View('admin/edit_pelicula', ['movie' => $movie]);
        } else {
            echo "403 no tien permiso para esta pagina";
        }
    }


    public function insert_movie()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        //$hora = date("H:i:s");
        //$fecha = date('Y-m-d');
        $created_at = date("Y-m-d H:i:s");
        $updated_at = date("Y-m-d H:i:s");

        $name = $this->input->post('title');
        $year = $this->input->post('year');
        $categories = explode(",", $this->input->post('categories'));
        $img64 = $this->input->post('cover');
        $trailer = $this->input->post('trailer');
        $html = $this->input->post('html');
        $short_description = $this->input->post('short_description');
        $key_words = $this->input->post('key_words');

        $cover_path = null;

        if (isset($img64)) {
            list($type, $data) = explode(';', $img64);
            list(, $data) = explode(',', $data);

            $data = base64_decode($data);
            $filename = 'movie-' . md5(uniqid(rand(), true)) . '.png';
            $cover_path = 'covers/' . $filename;
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/covers/' . $filename, $data);
        }


        $data = array(
            'name' => $name,
            'year' => $year,
            'trailer' => $trailer,
            'cover' =>base_url().$cover_path,
            'description' => $html,
            'short_description' => $short_description,
            'key_words' => $key_words,
            'created_at' => $created_at,
            'updated_at' => $updated_at,
        );


        $id = $this->Movie_model->insert($data);
        if ($id != -1) {

            $this->Movie_model->movie_categories($id, $categories);

            echo $id;
        } else {
            echo -1;
        }


    }


    public function edit_movie()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        //$hora = date("H:i:s");
        //$fecha = date('Y-m-d');
        //$created_at = date("Y-m-d H:i:s");
        $updated_at = date("Y-m-d H:i:s");

        $name = $this->input->post('title');
        $movie_id = $this->input->post('movie_id');
        $year = $this->input->post('year');
        $img64 = $this->input->post('cover');
        $trailer = $this->input->post('trailer');
        $html = $this->input->post('html');
        $short_description = $this->input->post('short_description');
        $key_words = $this->input->post('key_words');

        $cover_path = null;

        if (isset($img64)) {
            list($type, $data) = explode(';', $img64);
            list(, $data) = explode(',', $data);

            $data = base64_decode($data);
            $filename = 'movie-' . md5(uniqid(rand(), true)) . '.png';
            $cover_path = 'covers/' . $filename;
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/covers/' . $filename, $data);
        }


        $data = array(
            'name' => $name,
            'year' => $year,
            'trailer' => $trailer,
            'cover' => base_url().$cover_path,
            'description' => $html,
            'short_description' => $short_description,
            'key_words' => $key_words,
            'updated_at' => $updated_at,
        );


        $res = $this->Movie_model->update_row($movie_id, $data);
        if ($res) {
            echo "exito";
        } else {
            echo "Error";
        }


    }


    public function delete_row()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        $id = $_POST['id'];
        $res = $this->Movie_model->delete_row($id);
        if ($res > 0) {
            echo "exito";
        } else {
            echo "no se pudo eliminar la palicula";
        }

    }

}
