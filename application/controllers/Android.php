<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Android extends CI_Controller
{


    function __construct()
    {   //en el constructor cargamos nuestro modelo
        parent::__construct();
        $this->load->model('Movie_model');
        $this->load->model('Serie_model');
        $this->load->model('Temporada_model');
        $this->load->model('Category_model');
        $this->load->model('Url_model');
        $this->load->model('User_model');
    }


    function login()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        if (isset($email) && isset($password)) {
            $user = $this->User_model->get_user($email);
            if ($user != null) {
                if ($user->token == null) {
                    if (password_verify($password, $user->password)) {
                        $json = array('result_code' => 200,
                            'username' => $user->username,
                            'user_id' => $user->user_id,
                            'user_type' => $user->user_type,
                            'email' => $user->email);
                        echo json_encode($json);
                    } else {
                        $json = array('result_code' => 202, 'error' => 'La contraseña ingresada no es correcta');
                        echo json_encode($json);
                    }
                } else {
                    $json = array('result_code' => 202, 'error' => 'Verifique su cuenta para iniciar sesión');
                    echo json_encode($json);
                }

            } else {
                $json = array('result_code' => 202, 'error' => 'No se encontro el usuario');
                echo json_encode($json);
            }
        } else {
            $json = array('result_code' => 202, 'error' => 'datos nulos');
            echo json_encode($json);
        }


    }


    function last_movies($limit, $offset)
    {
        $movies = $this->Movie_model->get_last_movies_android($limit, $offset);
        $mmovies = array();
        foreach ($movies as $movie) {
            $sql_qualities_movie = "select DISTINCT u.quality from movies_urls as mu, urls as u WHERE mu.movie_id=$movie->movie_id and mu.url_id=u.url_id";
            $query = $this->db->query($sql_qualities_movie);
            $qualities = $query->result();
            $mmovies[] = array('movie' => $movie, 'qualities' => $qualities);
        }

        echo json_encode($mmovies);
    }


     function last_movies_letra($limit, $offset,$letra)
    {
        $movies = $this->Movie_model->get_last_movies_android_letra($limit, $offset,$letra);
        $mmovies = array();
        foreach ($movies as $movie) {
            $sql_qualities_movie = "select DISTINCT u.quality from movies_urls as mu, urls as u WHERE mu.movie_id=$movie->movie_id and mu.url_id=u.url_id";
            $query = $this->db->query($sql_qualities_movie);
            $qualities = $query->result();
            $mmovies[] = array('movie' => $movie, 'qualities' => $qualities);
        }

        echo json_encode($mmovies);
    }


    function movies_category($category, $limit, $offset)
    {
        $movies = $this->Movie_model->get_movies_category_android(urldecode($category), $limit, $offset);
        $mmovies = array();
        foreach ($movies as $movie) {
            $sql_qualities_movie = "select DISTINCT u.quality from movies_urls as mu, urls as u WHERE mu.movie_id=$movie->movie_id and mu.url_id=u.url_id";
            $query = $this->db->query($sql_qualities_movie);
            $qualities = $query->result();
            $mmovies[] = array('movie' => $movie, 'qualities' => $qualities);
        }

        echo json_encode($mmovies);
    }


     function movies_category_letra($category, $limit, $offset,$letra)
    {
        $movies = $this->Movie_model->get_movies_category_android_letra(urldecode($category), $limit, $offset,$letra);
        $mmovies = array();
        foreach ($movies as $movie) {
            $sql_qualities_movie = "select DISTINCT u.quality from movies_urls as mu, urls as u WHERE mu.movie_id=$movie->movie_id and mu.url_id=u.url_id";
            $query = $this->db->query($sql_qualities_movie);
            $qualities = $query->result();
            $mmovies[] = array('movie' => $movie, 'qualities' => $qualities);
        }

        echo json_encode($mmovies);
    }


    function series_category($category, $limit, $offset)
    {
        $series = $this->Serie_model->get_series_category_android(urldecode($category), $limit, $offset);

        echo json_encode($series);
    }

    function series_category_letra($category, $limit, $offset,$letra)
    {
        $series = $this->Serie_model->get_series_category_android_letra(urldecode($category), $limit, $offset,$letra);

        echo json_encode($series);
    }


    function last_series($limit, $offset)
    {
        $series = $this->Serie_model->get_last_series_android($limit, $offset);
        echo json_encode($series);
    }


    function last_series_letra($limit, $offset,$letra)
    {
        $series = $this->Serie_model->get_last_series_android_letra($limit, $offset,$letra);
        echo json_encode($series);
    }



    function last_seasons()
    {
        $seasons = $this->Temporada_model->get_last_android(20);

        echo json_encode($seasons);
    }


    public function season($id)
    {
        $capitulos = $this->Temporada_model->get_capitulos_temporada($id);
        echo json_encode($capitulos);
    }

    function top_movies()
    {
        $bmovies = $this->Movie_model->get_movies_by_score_android(20);
        echo json_encode($bmovies);
    }


    public function movie($id)
    {
        $movie = $this->Movie_model->movie_score_android($id);

        if ($movie) {
            $urls = $this->Url_model->getUrlsByMovie($id);
            $mega_urls = $this->Url_model->getUrlsMEGAByMovie($id);
            echo json_encode(['movie' => $movie, 'urls' => $urls, 'mega_urls' => $mega_urls]);
        } else {

        }
    }


    public function serie($id)
    {
        $serie = $this->Serie_model->serie_score_android($id);

        if ($serie) {
            $temporadas = $this->Temporada_model->get_temporadas_serie($id);
            $mega_urls = $this->Url_model->getUrlsMEGABySerie($id);
            echo json_encode(['serie' => $serie, 'seasons' => $temporadas, 'mega_urls' => $mega_urls]);
        } else {

        }
    }


    public function categorias()
    {
        $categories = $this->Category_model->getCategories();
        echo json_encode($categories);
    }


    public function search_movie($q)
    {

        $movies = $this->Movie_model->search_movie(urldecode($q));
        $mmovies = array();
        foreach ($movies as $movie) {
            $sql_qualities_movie = "select DISTINCT u.quality from movies_urls as mu, urls as u WHERE mu.movie_id=$movie->movie_id and mu.url_id=u.url_id";
            $query = $this->db->query($sql_qualities_movie);
            $qualities = $query->result();
            $mmovies[] = array('movie' => $movie, 'qualities' => $qualities);
        }

        echo json_encode($mmovies);
    }



    public function search_serie($q)
    {

        $series = $this->Serie_model->search_serie(urldecode($q));

        echo json_encode($series);
    }


}