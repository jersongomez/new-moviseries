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


    function last_movies()
    {
        $movies = $this->Movie_model->get_last_movies_android(15);
        $mmovies = array();
        foreach ($movies as $movie) {
            $sql_qualities_movie = "select DISTINCT u.quality from movies_urls as mu, urls as u WHERE mu.movie_id=$movie->movie_id and mu.url_id=u.url_id";
            $query = $this->db->query($sql_qualities_movie);
            $qualities = $query->result();
            $mmovies[] = array('movie' => $movie, 'qualities' => $qualities);
        }

        echo json_encode($mmovies);
    }

    function last_series()
    {
        $series = $this->Serie_model->get_last_series_android(20);
        echo json_encode($series);
    }



    function last_seasons(){
        $seasons = $this->Temporada_model->get_last_android(20);

        echo json_encode($seasons);
    }


    function top_movies(){
        $bmovies = $this->Movie_model->get_movies_by_score_android(20);
        echo json_encode($bmovies);
    }

}