<?php
session_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Peliculas extends CI_Controller
{
    function __construct()
    {   //en el constructor cargamos nuestro modelo
        parent::__construct();
        $this->load->model('Category_model');
        $this->load->model('Movie_model');
        $this->load->helper('url');
        $this->load->library('pagination');


    }


    public function index()
    {
        $categories = $this->Category_model->getCategories();
        $total = $this->Movie_model->count();
        $limit = 24;

        $config['base_url'] = base_url('peliculas/');
        $config['total_rows'] = $total;
        $config['per_page'] = $limit;

        $config['page_query_string'] = TRUE;
        $config['use_page_numbers'] = TRUE;
        $config['query_string_segment'] = 'pagina';
        $offset = $this->uri->segment(3);


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

        if (isset($_GET['pagina'])) {
            $offset = ($this->input->get('pagina') - 1) * $limit;
        } else {
            $offset = 0;
        }

        $movies = $this->Movie_model->get_movies_limit_offset($limit, $offset);
        $mmovies = array();

        foreach ($movies as $movie) {
            $sql_qualities_movie = "select DISTINCT u.quality from movies_urls as mu, urls as u WHERE mu.movie_id=$movie->movie_id and mu.url_id=u.url_id";
            $query = $this->db->query($sql_qualities_movie);
            $qualities = $query->result();
            $mmovies[] = array('movie' => $movie, 'qualities' => $qualities);
        }

        $page_links = $this->pagination->create_links();

        $this->load->view('peliculas', ['categorias' => $categories, 'movies' => $mmovies, 'pages' => $page_links]);
    }


    public function peliculas_categoria($id)
    {
        $id = urldecode($id);
        $total = $this->Movie_model->count_by_categoty($id);
        $limit = 24;

        $config['base_url'] = base_url('peliculas/categoria/' . $id) . '/';
        $config['total_rows'] = $total;
        $config['per_page'] = $limit;
        $config["uri_segment"] = 3;

        $config['page_query_string'] = TRUE;
        $config['use_page_numbers'] = TRUE;
        $config['query_string_segment'] = 'pagina';


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
        if (isset($_GET['pagina'])) {
            $offset = ($this->input->get('pagina') - 1) * $limit;
        } else {
            $offset = 0;
        }
        $movies = $this->Movie_model->get_movies_category_limit_offset($id, $limit, $offset);
        $mmovies = array();

        foreach ($movies as $movie) {
            $sql_qualities_movie = "select DISTINCT u.quality from movies_urls as mu, urls as u WHERE mu.movie_id=$movie->movie_id and mu.url_id=u.url_id";
            $query = $this->db->query($sql_qualities_movie);
            $qualities = $query->result();
            $mmovies[] = array('movie' => $movie, 'qualities' => $qualities);
        }


        $this->pagination->initialize($config);
        $page_links = $this->pagination->create_links();

        $this->load->view('peliculas', ['categorias' => $categories, 'movies' => $mmovies, 'pages' => $page_links, 'category_name' => $id]);
    }


    public function calificar()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $data = [
            'user_id' => $_POST['user_id'],
            'movie_id' => $_POST['movie_id'],
            'score' => $_POST['score']
        ];
        $res=$this->Movie_model->calificar($data);
        echo $res;
    }

}
