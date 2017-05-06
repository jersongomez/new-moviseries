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
        $bseries = $this->Serie_model->get_series_by_score(18);


        $this->load->view('home', ['last_movies' => $mmovies, 'last_series' => $series, 'last_seasons' => $seasons, 'best_movies' => $bmovies, 'best_series' => $bseries]);


    }


    public function movie($id)
    {
        $movie = $this->Movie_model->movie_score($id);

        if ($movie) {
            $urls = $this->Url_model->getUrlsByMovie($id);
            $mega_urls = $this->Url_model->getUrlsMEGAByMovie($id);
            $this->load->view('movie', ['movie' => $movie, 'urls' => $urls, 'mega_urls' => $mega_urls]);
        } else {
            echo "404 pagina no encontrada";
        }
    }


    public function serie($id)
    {
        $serie = $this->Serie_model->serie_score($id);
        if ($serie) {

            $series = $this->Serie_model->get_last_series(8);
            $temporadas = $this->Temporada_model->get_temporadas_serie($id);

            $mega_urls = $this->Url_model->getUrlsMEGABySerie($id);

            $this->load->view('serie', ['last_series' => $series, 'serie' => $serie, 'temporadas' => $temporadas, 'mega_urls' => $mega_urls]);
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


    public function test_stream_moe__link($file_id)
    {
        $url_video = null;


        $url_stream = "https://wabbit.moecdn.io/$file_id";
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
                echo $link->getAttribute('href') . '<br>';
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


    public function android()
    {
        $this->load->view('android');
    }


    public function premium()
    {
        $this->load->view('premium');
    }


    public function link_roto()
    {
        $this->load->view('reporte');
    }


    public function busqueda()
    {
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

            $this->load->view('busqueda', ['movies' => $movies, 'series' => $series]);

        } else
            echo "el parametro de busqueda no es correcto";

    }


    public function send_report()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $email = $_POST['email'];
        $asunto = $_POST['subject'];
        $sms = 'Remitente: ' . $email . '<br>Asunto:' . $asunto . '<br>Mensaje: ' . $_POST['msg'];

        //cargamos la libreria email de ci
        $this->load->library("email");
        //configuracion para gmail
        $configGmail = array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_port' => 465,
            'smtp_user' => 'moviserieshd@gmail.com',
            'smtp_pass' => 'gkrqdhjfsbtueinb',
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        );

        //cargamos la configuración para enviar con gmail
        $this->email->initialize($configGmail);


        $this->email->from('moviserieshd@gmail.com');
        $this->email->to('dsmr.apps@gmail.com');
        $this->email->subject($asunto);
        $this->email->message($sms);
        if ($this->email->send()) {
            echo "Se ha enviado tu reporte exitosamente, lo revisaremos lo más pronto posible. GRACIAS POR TU AYUDA";
        } else {
            echo "Error no se pudo enviar el reporte, por favor intenta nuevamente recargando la página.";
        }

    }






}
