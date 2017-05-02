<?php
session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Series extends CI_Controller
{
    function __construct()
    {   //en el constructor cargamos nuestro modelo
        parent::__construct();

        if($_SESSION['user_type']!='admin'){
            exit('403 acceso denegado');
        }

        $this->load->model('Category_model');
        $this->load->model('Serie_model');
        $this->load->model('Url_model');
        $this->load->model('Temporada_model');

        $new_path = $_SERVER['DOCUMENT_ROOT'] . '/covers/';
        if (!is_dir($new_path)) {
            mkdir($new_path);
        }
    }


    public function index()
    {
        $categories = $this->Category_model->getCategories();
        $this->load->view('admin/series', ['categories' => json_encode($categories)]);
    }



    public function mega($serie_id)
    {
        $this->load->view('admin/enlaces_mega_series',
            ['serie' => $this->Serie_model->getById($serie_id)]);
    }



    public function temporadas($serie_id)
    {
        if ($_SESSION['user_type'] == 'admin') {
            $serie = $this->Serie_model->getById($serie_id);
            if ($serie) {
                $this->load->view('admin/temporadas', ['serie' => $serie]);
            } else {
                echo "404 pagina no encontrada";
            }
        } else {
            echo "403 acceso denegado";
        }
    }


    public function get_temporadas_serie()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        if ($_SESSION['user_type'] == 'admin') {

            $serie_id = $_POST['id'];
            $temporadas = $this->Temporada_model->get_temporadas_serie($serie_id);
            $data = array();
            foreach ($temporadas as $temp) {
                $url_web = base_url('series/' . $serie_id . '/temporada/' . $temp->season_id);
                $url_admin = base_url('admin/serie/' . $serie_id . '/temporada/' . $temp->season_id);
                $json = array($temp->season_id, $temp->number, $temp->trailer, $temp->updated_at,
                    "<a target='_blank' class='btn btn-primary btn-sm' style='min-width: 100px' href='$url_web'><i class='icon-list'></i> ver en la web</a>
<a  class='btn btn-info active btn-sm' style='min-width: 100px' href='$url_admin'><i class='icon-list'></i> Capitulos</a>
                <button class='btn btn-danger btn-sm' style='min-width: 100px' title='eliminar categoria' onclick=\"delete_item($temp->season_id)\"><i class='icon-trash-2'></i> Eliminar</button>"
                );

                array_push($data, $json);
            }

            echo json_encode(array('data' => $data));
        }
    }


    public function list_series()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        if ($_SESSION['user_type'] == 'admin') {


            $series = $this->Serie_model->get_all();
            $data = array();
            foreach ($series as $serie) {

                $categories = $this->Category_model->getCategoriasBySerie($serie->serie_id);

                $str = $categories[0]->category_name;
                for ($i = 1; $i < sizeof($categories); $i++) {
                    $str = $str . ", " . $categories[$i]->category_name;
                }
                $url_edit = base_url('admin/editar-serie/' . $serie->serie_id);
                $url_mega = base_url('admin/series/mega/' . $serie->serie_id);

                $url_temp = base_url('admin/series/' . $serie->serie_id.'/temporadas');
                $json = array('<img src="' . $serie->cover . '" width="60">',
                    $serie->serie_id,
                    $serie->serie_name,
                    $serie->year,
                    $serie->created_at,
                    $str,
                    "<a class='btn btn-primary btn-sm w-100' href='$url_temp'><i class='icon-link-1'></i> Temporadas</a>
                <a class='btn btn-info btn-sm w-100' href='$url_mega'><i class='icon-edit'></i> MEGA</a>
                <a class='btn btn-info btn-sm w-100' href='$url_edit'><i class='icon-edit'></i> Editar</a>
                <button class='btn btn-danger btn-sm w-100' title='eliminar categoria' onclick=\"delete_item($serie->serie_id)\"><i class='icon-trash-2'></i> Eliminar</button>"
                );

                array_push($data, $json);
            }

            echo json_encode(array('data' => $data));

            // echo json_encode($response);
        }
    }


    public function nueva_serie()
    {
        if ($_SESSION['user_type'] == 'admin') {
            $categories = $this->Category_model->getCategories();
            $this->load->view('admin/nueva_serie', ['categories' => json_encode($categories)]);
        } else {
            echo "403 no tien permiso para esta pagina";
        }

    }

    public function editar_serie($id)
    {
        if ($_SESSION['user_type'] == 'admin') {
            $serie = $this->Serie_model->getById($id);
            $this->load->View('admin/edit_serie', ['serie' => $serie]);
        } else {
            echo "403 no tien permiso para esta pagina";
        }
    }


    public function insert_serie()
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
        $html = $this->input->post('html');
        $short_description = $this->input->post('short_description');
        $key_words = $this->input->post('key_words');

        $cover_path = null;

        if (isset($img64)) {
            list($type, $data) = explode(';', $img64);
            list(, $data) = explode(',', $data);

            $data = base64_decode($data);
            $filename = 'serie-' . md5(uniqid(rand(), true)) . '.png';
            $cover_path = 'covers/' . $filename;
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/covers/' . $filename, $data);
        }


        $data = array(
            'serie_name' => $name,
            'year' => $year,
            'cover' => base_url().$cover_path,
            'description' => $html,
            'short_description' => $short_description,
            'key_words' => $key_words,
            'created_at' => $created_at
        );


        $id = $this->Serie_model->insert($data);
        if ($id != -1) {

            $this->Serie_model->serie_categories($id, $categories);

            echo $id;
        } else {
            echo -1;
        }


    }


    public function edit_serie()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }


        $name = $this->input->post('title');
        $serie_id = $this->input->post('serie_id');
        $year = $this->input->post('year');
        $img64 = $this->input->post('cover');
        $html = $this->input->post('html');
        $short_description = $this->input->post('short_description');
        $key_words = $this->input->post('key_words');

        $cover_path = null;

        if (isset($img64)) {
            list($type, $data) = explode(';', $img64);
            list(, $data) = explode(',', $data);

            $data = base64_decode($data);
            $filename = 'serie-' . md5(uniqid(rand(), true)) . '.png';
            $cover_path = 'covers/' . $filename;
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/covers/' . $filename, $data);
        }


        $data = array(
            'serie_name' => $name,
            'year' => $year,
            'cover' => base_url().$cover_path,
            'description' => $html,
            'short_description' => $short_description,
            'key_words' => $key_words,
        );


        $res = $this->Serie_model->update_row($serie_id, $data);
        if ($res) {
            echo "exito";
        } else {
            echo "Error";
        }


    }


    public function eliminar_serie()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $id = $_POST['serie_id'];
        $res = $this->Serie_model->eliminar_serie($id);
        if ($res > 0) {
            echo "exito";
        } else {
            echo "no se pudo eliminar la serie";
        }

    }


    public function nueva_temporada()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        $serie_id = $_POST['serie_id'];
        $updated_at = date("Y-m-d H:i:s");
        $number = $this->input->post('number');
        $img64 = $this->input->post('cover');
        $trailer = $this->input->post('trailer');
        $key_words = $this->input->post('key_words');

        $cover_path = null;

        if (isset($img64)) {
            list($type, $data) = explode(';', $img64);
            list(, $data) = explode(',', $data);

            $data = base64_decode($data);
            $filename = 'temporada-' . md5(uniqid(rand(), true)) . '.png';
            $cover_path = 'covers/' . $filename;
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/covers/' . $filename, $data);
        }


        $data = array(
            'number' => $number,
            'trailer' => $trailer,
            'cover' => base_url().$cover_path,
            'key_words' => $key_words,
            'updated_at' => $updated_at,
            'serie_id' => $serie_id,
        );


        $id = $this->Temporada_model->insert($data);
        if ($id != -1) {
            echo "exito";
        } else {
            echo "no se pudo crear la temporada";
        }
    }


    public function capitulos($serie_id, $temporada_id)
    {
        $serie = $this->Serie_model->getById($serie_id);
        $temporada = $this->Temporada_model->get_temporada($temporada_id);
        $this->load->view('admin/capitulos', ['serie' => $serie, 'temporada' => $temporada]);
    }


    public function get_capitulos_temporada()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        if ($_SESSION['user_type'] == 'admin') {

            $temp_id = $_POST['temp_id'];

            $capitulos = $this->Temporada_model->get_capitulos_temporada($temp_id);
            $data = array();
            foreach ($capitulos as $cap) {
                $json = array(
                    $cap->url_id,
                    $cap->episode,
                    $cap->episode_name,
                    $cap->file_id,
                    $cap->language_name,
                    $cap->quality,
                    $cap->server,
                    "
                <button class='btn btn-danger btn-sm w-100' title='eliminar categoria' onclick=\"delete_item($cap->url_id)\"><i class='icon-trash-2'></i> Eliminar</button>"
                );

                array_push($data, $json);
            }

            echo json_encode(array('data' => $data));
        }

    }


    public function eliminar_temporada()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $id = $_POST['id'];

        $res = $this->Temporada_model->delete_row($id);
        if ($res > 0) {
            echo "exito";
        } else {
            echo "no se pudo eliminar la temporadas";
        }
    }


    public function get_mega_urls()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        if ($_SESSION['user_type'] == 'admin') {

            $serie_id = $_POST['id'];
            $urls = $this->Url_model->getUrlsMEGABySerie($serie_id);
            $data = array();

            foreach ($urls as $url) {
                $url_web = base_url('series/' . $serie_id);

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


    public function insert_mega()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        $link = $_POST['link'];
        $server = $_POST['url'];
        $idioma = $_POST['idioma'];
        $note = $_POST['note'];
        $movie_id = $_POST['serie_id'];


        $data = [
            'name' => $link,
            'url' => $server,
            'language_name' => $idioma,
            'note'=>$note,
            'serie_id' => $movie_id
        ];

        $url_id = $this->Url_model->insert_mega_serie($data);
        if ($url_id != -1) {
            echo "exito";
        } else {
            echo "error al crear el link";
        }

    }


    public function delete_row_mega()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $url_id = $_POST['id'];

        $res = $this->Url_model->delete_row_mega_serie($url_id);
        if ($res > 0) {
            echo "exito";
        } else {
            echo "no se pudo eliminar el enlace";
        }

    }

}
