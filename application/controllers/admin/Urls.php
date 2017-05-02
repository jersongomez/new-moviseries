<?php
session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Urls extends CI_Controller
{


    function __construct()
    {   //en el constructor cargamos nuestro modelo
        parent::__construct();
        if ($_SESSION['user_type'] != 'admin') {
            exit('403 acceso denegado');
        }
        $this->load->model('Category_model');
        $this->load->model('Movie_model');
        $this->load->model('Url_model');
    }


    public function index($movie_id)
    {
        $this->load->view('admin/enlaces_peliculas',
            ['movie' => $this->Movie_model->getById($movie_id)
            ]);
    }


    public function mega($movie_id)
    {
        $this->load->view('admin/enlaces_mega_peliculas',
            ['movie' => $this->Movie_model->getById($movie_id)]);
    }


    public function get_urls()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        if ($_SESSION['user_type'] == 'admin') {

            $movie_id = $_POST['id'];
            $urls = $this->Url_model->getUrlsByMovie($movie_id);
            $data = array();
            foreach ($urls as $url) {
                $url_web = base_url('peliculas/' . $movie_id);
                $json = array($url->url_id, $url->file_id, $url->server, $url->language_name, $url->quality,
                    "<a target='_blank' class='btn btn-primary btn-sm w-100' href='$url_web'><i class='icon-link-1'></i> Ver en la web</a>
                <button class='btn btn-danger btn-sm w-100' title='eliminar categoria' onclick=\"delete_item($url->url_id)\"><i class='icon-trash-2'></i> Eliminar</button>"
                );

                array_push($data, $json);
            }

            echo json_encode(array('data' => $data));

            // echo json_encode($response);
        }
    }


    public function get_mega_urls()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        if ($_SESSION['user_type'] == 'admin') {

            $movie_id = $_POST['id'];
            $urls = $this->Url_model->getUrlsMEGAByMovie($movie_id);
            $data = array();
            foreach ($urls as $url) {
                $url_web = base_url('peliculas/' . $movie_id);

                $json = array($url->mega_id, $url->name, $url->language_name,
                    "<a target='_blank' class='btn btn-info btn-sm' href='$url->url'><i class='icon-link-1'></i> Ver en MEGA</a>
                    <a target='_blank' class='btn btn-primary btn-sm' href='$url_web'><i class='icon-link-1'></i> Ver en la web</a>
                <button class='btn btn-danger btn-sm' title='eliminar categoria' onclick=\"delete_item($url->mega_id)\"><i class='icon-trash-2'></i> Eliminar</button>"
                );

                array_push($data, $json);
            }

            echo json_encode(array('data' => $data));

            // echo json_encode($response);
        }
    }

    public function insert()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        $link = $_POST['link'];
        $server = $_POST['servidor'];
        $idioma = $_POST['idioma'];
        $calidad = $_POST['calidad'];
        $movie_id = $_POST['movie_id'];


        $data = [
            'file_id' => $link,
            'server' => $server,
            'language_name' => $idioma,
            'quality' => $calidad
        ];

        $url_id = $this->Url_model->insert($data);
        if ($url_id != -1) {
            $res = $this->Url_model->insert_movie_url($movie_id, $url_id);
            $this->Movie_model->update_at($movie_id, ['updated_at' => date("Y-m-d H:i:s")]);
            if ($res) {
                echo "exito";
            }
        } else {
            echo "error al crear el link";
        }

    }


    public function insert_mega()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        $link = $_POST['link'];
        $server = $_POST['url'];
        $idioma = $_POST['idioma'];
        $movie_id = $_POST['movie_id'];
        $note = $_POST['note'];

        $data = [
            'name' => $link,
            'url' => $server,
            'language_name' => $idioma,
            'note' => $note,
            'movie_id' => $movie_id
        ];

        $url_id = $this->Url_model->insert_mega_movie($data);
        if ($url_id != -1) {
            echo "exito";
        } else {
            echo "error al crear el link";
        }

    }


    public function delete_row()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $url_id = $_POST['id'];

        $res = $this->Url_model->delete_row($url_id);
        if ($res > 0) {
            echo "exito";
        } else {
            echo "no se pudo eliminar el enlace";
        }

    }


    public function delete_row_mega()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $url_id = $_POST['id'];

        $res = $this->Url_model->delete_row_mega_movie($url_id);
        if ($res > 0) {
            echo "exito";
        } else {
            echo "no se pudo eliminar el enlace";
        }

    }


}

