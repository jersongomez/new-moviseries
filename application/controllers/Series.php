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
        $this->load->helper('url');
        $this->load->library('pagination');


    }


    public function index()
    {
        $categories = $this->Category_model->getCategories();
        $limit = 24;

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
        $limit = 24;
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
        $res=$this->Serie_model->calificar($data);
        echo $res;
    }




}
