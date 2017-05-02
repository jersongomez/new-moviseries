<?php
session_start();
session_regenerate_id();
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{


    function __construct()
    {   //en el constructor cargamos nuestro modelo
        parent::__construct();
        $this->load->model('Movie_model');
        $this->load->model('Serie_model');
        $this->load->model('Temporada_model');
        $this->load->model('Category_model');
        $this->load->model('Url_model');
    }

    public function index()
    {

        $movies = $this->Movie_model->get_last_movies();
        $mmovies = array();

        foreach ($movies as $movie) {
            $sql_qualities_movie = "select DISTINCT u.quality from movies_urls as mu, urls as u WHERE mu.movie_id=$movie->movie_id and mu.url_id=u.url_id";
            $query = $this->db->query($sql_qualities_movie);
            $qualities = $query->result();
            $mmovies[] = array('movie' => $movie, 'qualities' => $qualities);
        }


        $series = $this->Serie_model->get_last_series(18);
        $seasons = $this->Temporada_model->get_last(18);
        $bmovies = $this->Movie_model->get_movies_by_score(18);


        $this->load->view('home', ['last_movies' => $mmovies, 'last_series' => $series, 'last_seasons' => $seasons,'best_movies'=>$bmovies]);


    }


    public function movie($id)
    {
        $movie = $this->Movie_model->movie_score($id);
        if ($movie) {
            $urls = $this->Url_model->getUrlsByMovie($id);
            $this->load->view('movie', ['movie' => $movie, 'urls' => $urls]);
        } else {
            echo "404 pagina no encontrada";
        }
    }


    public function serie($id)
    {
        $serie = $this->Serie_model->serie_score($id);
        if ($serie) {


            $temporadas = $this->Temporada_model->get_temporadas_serie($id);
            $temporadas_capitulos = array();

            foreach ($temporadas as $temp) {
                $temporadas_capitulos[] = ['temporada' => $temp, 'capitulos' => $this->Temporada_model->get_capitulos_temporada($temp->season_id)];
            }


            $this->load->view('serie', ['serie' => $serie, 'temporadas_capitulos' => $temporadas_capitulos]);
        } else {
            echo "404 pagina no encontrada";
        }
    }


    public function movie_url($movie_id, $url_id)
    {
        $movie = $this->Movie_model->getById($movie_id);
        $url = $this->Url_model->get_url($url_id);

        //$file_id = $url->file_id;


        // $link = $this->stream_moe_download_link($file_id);
        $this->load->view('view_movie', ['movie' => $movie, 'url' => $url]);


    }

    public function stream_moe_download()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $file_id = $_POST['file_id'];
        echo $this->stream_moe_download_link($file_id);
    }


    public function stream_moe_download_link($file_id)
    {
        $url_video = null;


        $url_stream = "https://stream.moe/$file_id";
        if ($this->urlExists($url_stream)) {

            $html = file_get_contents($url_stream);
            //Create a new DOM document
            $dom = new DOMDocument;

//Parse the HTML. The @ is used to suppress any parsing errors
//that will be thrown if the $html string isn't valid XHTML.
            @$dom->loadHTML($html);

//Get all links. You could also use any other tag name here,
//like 'img' or 'table', to extract other tags.
            $links = $dom->getElementsByTagName('a');

//Iterate over the extracted links and display their URLs
            foreach ($links as $link) {
                //Extract and show the "href" attribute.
                if ($link->nodeValue == '(download)') {
                    $url_video = $link->getAttribute('href');
                }
            }

        }


        return $url_video;
    }


    public function urlExists($url)
    {

        if (!@ file_get_contents($url)) {
            return false;
        } else {
            return true;
        }

    }


    public function suggestions()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }


        $q = $_GET['query'];


        $data = array();

        if (!empty($q)) {
            $sql = "select * from movies WHERE name LIKE '%" . $q . "%' ";
            $query = $this->db->query($sql);
            $movies = $query->result();
            foreach ($movies as $movie) {
                $data[] = ['type' => 'movie', 'name' => $movie->name, 'id' => $movie->movie_id];
            }


            $sql = "select * from series WHERE serie_name LIKE '%" . $q . "%' ";
            $query = $this->db->query($sql);
            $series = $query->result();
            foreach ($series as $serie) {
                $data[] = ['type' => 'serie', 'name' => $serie->serie_name, 'id' => $serie->serie_id];
            }
        }

        echo json_encode($data);

    }
}
