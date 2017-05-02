<?php

/**
 * Created by PhpStorm.
 * User: DARWIN
 * Date: 26/4/2017
 * Time: 11:46
 */
class Capitulos extends CI_Controller
{
    function __construct()
    {   //en el constructor cargamos nuestro modelo
        parent::__construct();

        $this->load->model('Category_model');
        $this->load->model('Serie_model');
        $this->load->model('Temporada_model');
        $this->load->model('Url_model');

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
        $season_id = $_POST['season_id'];
        $episodio = $_POST['episode'];
        $episodio_nombre = $_POST['episode_name'];


        $data = [
            'file_id' => $link,
            'server' => $server,
            'language_name' => $idioma,
            'quality' => $calidad
        ];

        $url_id = $this->Url_model->insert($data);
        if ($url_id != -1) {
            $res = $this->Url_model->insert_capitulo($season_id, $url_id, $episodio, $episodio_nombre);
            if ($res) {
                $this->Temporada_model->update_at($season_id, ['updated_at' => date("Y-m-d H:i:s")]);
                echo "exito";
            }
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
            echo "no se pudo eliminar el capitulo";
        }

    }

}