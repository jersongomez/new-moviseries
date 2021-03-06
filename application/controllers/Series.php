<?php
session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Series extends CI_Controller
{
    function __construct()
    {   //en el constructor cargamos nuestro modelo
        parent::__construct();
        $this->load->model('Category_model');
        $this->load->model('Serie_model');
        $this->load->model('Temporada_model');
        $this->load->helper('url');
        $this->load->library('pagination');


    }


    public function index()
    {
        $categories = $this->Category_model->getCategories();
        $limit = 30;

        $config['base_url'] = base_url('series/');
        $config['total_rows'] = $this->Serie_model->count();
        $config['per_page'] = $limit;

        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'pagina';
        $config["uri_segment"] = 2;
        $config['use_page_numbers'] = TRUE;

        $config['full_tag_open'] = '<div class="mpagination">';
        $config['full_tag_close'] = '</div>';

        $config["first_link"] = "&laquo;";
        $config['first_tag_open'] = '<span>';
        $config['first_tag_close'] = '</span>';
        $config["last_link"] = "&raquo;";
        $config['last_tag_open'] = '<span>';
        $config['last_tag_close'] = '</span>';


        $config['prev_link'] = '&lt;';
        $config['prev_tag_open'] = '<span>';
        $config['prev_tag_close'] = '</span>';

        $config['next_link'] = '&gt;';
        $config['next_tag_open'] = '<span>';
        $config['next_tag_close'] = '</span>';


        $config['cur_tag_open'] = '<span style="background-color: #f40f4b; color: #fff;">';
        $config['cur_tag_close'] = '</span>';
        $config['num_tag_open'] = '<span>';
        $config['num_tag_close'] = '</span>';


        $this->pagination->initialize($config);
        $categories = $this->Category_model->getCategories();
        if (isset($_GET['pagina'])) {
            $offset = ($this->input->get('pagina') - 1) * $limit;
        } else {
            $offset = 0;
        }

        $series = $this->Serie_model->get_limit_offset($limit, $offset);


        $page_links = $this->pagination->create_links();

        $this->load->view('series', ['categorias' => $categories, 'series' => $series, 'pages' => $page_links]);
    }


    public function series_categoria($id)
    {

        $id = urldecode($id);
        $limit = 30;
        $config['base_url'] = base_url('series/categoria/' . $id) . '/';
        $config['total_rows'] = $this->Serie_model->count_by_categoty($id);
        $config['per_page'] = $limit;
        $config["uri_segment"] = 2;

        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'pagina';
        $config['use_page_numbers'] = TRUE;

        $config['full_tag_open'] = '<div class="mpagination">';
        $config['full_tag_close'] = '</div>';

        $config["first_link"] = "&laquo;";
        $config['first_tag_open'] = '<span>';
        $config['first_tag_close'] = '</span>';
        $config["last_link"] = "&raquo;";
        $config['last_tag_open'] = '<span>';
        $config['last_tag_close'] = '</span>';


        $config['prev_link'] = '&lt;';
        $config['prev_tag_open'] = '<span>';
        $config['prev_tag_close'] = '</span>';

        $config['next_link'] = '&gt;';
        $config['next_tag_open'] = '<span>';
        $config['next_tag_close'] = '</span>';

        $config['cur_tag_open'] = '<span style="background-color: #f40f4b; color: #fff;">';
        $config['cur_tag_close'] = '</span>';
        $config['num_tag_open'] = '<span>';
        $config['num_tag_close'] = '</span>';


        $categories = $this->Category_model->getCategories();
        $categories = $this->Category_model->getCategories();
        if (isset($_GET['pagina'])) {
            $offset = ($this->input->get('pagina') - 1) * $limit;
        } else {
            $offset = 0;
        }
        $series = $this->Serie_model->get_series_category_limit_offset($id, $limit, $offset);


        $this->pagination->initialize($config);
        $page_links = $this->pagination->create_links();

        $this->load->view('series', ['categorias' => $categories, 'series' => $series, 'pages' => $page_links, 'category_name' => $id]);
    }

    public function calificar()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $data = [
            'user_id' => $_POST['user_id'],
            'serie_id' => $_POST['serie_id'],
            'score' => $_POST['score']
        ];
        $res = $this->Serie_model->calificar($data);
        echo $res;
    }


    function get_temporada()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        $id = $_POST['id'];
        $number = $_POST['number'];
        $serie_name = $_POST['serie_name'];
        $capitulos = $this->Temporada_model->get_capitulos_temporada($id);


        echo "<div class=' table-responsive'><table class=\"table\" style=\"-webkit-box-shadow: 5px 9px 12px -4px rgba(0,0,0,0.75);
-moz-box-shadow: 5px 9px 12px -4px rgba(0,0,0,0.75);
box-shadow: 5px 9px 12px -4px rgba(0,0,0,0.75);\">
                        <thead class=\"table-inverse\" style=\"background-color: #E91E63;\">
                        <tr class=\"text-center\">
                            <th class=\"text-center\" style=\"color: white;\">Capitulo #</th>
                            <th class=\"text-center\" style=\"color: white;\">Título</th>
                            <th class=\"text-center\" style=\"color: white;\">Audio</th>
                            <th class=\"text-center\" style=\"color: white;\">Calidad</th>
                            <th class=\"text-center\" style=\"color: white;\">Servidor</th>
                            <th class=\"text-center\" style=\"color: white;\">Ver online</th>
                            <th class=\"text-center\" style=\"color: white;\">Descarga</th>
                            <th class=\"text-center\" style=\"color: white;\">Enlace Caido?</th>

                        </tr>
                        </thead>";

        foreach ($capitulos as $cap) {

            $enlace_caido = base_url('enlace-caido?msg=' . urlencode('SERIE: ' . $serie_name . ' - temporada  ' . $number . ' - cap ' . $cap->episode) . '&url_id=' . $cap->url_id);
            echo " <tr class=\"text-center\" style=\"background-color: #f4f4f4;\">
                                <th class=\"text-center\" scope=\"row\">$cap->episode</th>
                                <th class=\"text-center\" scope=\"row\">$cap->episode_name</th>
                                <th class=\"text-center\" scope=\"row\">$cap->language_name</th>
                                <th class=\"text-center\" scope=\"row\">$cap->quality</th>
                                <th class=\"text-center\" scope=\"row\">$cap->server</th>

                                <th class=\"text-center\" scope=\"row\">
                                    <button class=\"btn btn-sm btn-primary play-video\"
                                            onclick=\"play_video('$cap->file_id','$cap->server',$number,'$cap->episode_name',$cap->episode)\">
                                        <i class=\"icon-play-4\"></i> VER
                                        ONLINE
                                    </button>
                                </th>
                                 <th class=\"text-center\" scope=\"row\">";

if ($cap->server == 'openload') {
    $urld="https://openload.co/f/$cap->file_id";
} else if ($cap->server == 'stream.moe') {
    $urld="https://stream.moe/$cap->file_id";
} else if ($cap->server == 'google drive') {
    $urld="https://drive.google.com/file/d/$cap->file_id/view";
} else if ($cap->server == 'rapidvideo') {
    $urld="https://www.rapidvideo.com/v/$cap->file_id";
} else if ($cap->server == 'nowvideo') {
   $urld="https://www.nowvideo.sx/mobile/video.php?id=$cap->file_id";
}


            echo "

<a target=\"_blank\" class=\"btn-sm  btn btn-info active w-100\"
       href=\"$urld\"
    ><i class=\"icon-download\"></i>
        DESCARGAR
    </a>

             </th>
                                <th class=\"text-center\" scope=\"row\">
                                    <a target=\"_blank\" class=\"btn btn-secondary\" href=\"$enlace_caido\">REPORTAR</a>
                                </th>
                                  </tr>
            ";


        }

        echo "</table></div>";


    }

}
