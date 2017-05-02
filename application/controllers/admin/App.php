<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * App Class
 *
 * Stop talking and start faking!
 */
class App extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        /*
         *
                // can only be called from the command line
                if (!$this->input->is_cli_request()) {
                    exit('Direct access is not allowed');
                }
         */

        // can only be run in the development environment
        if (ENVIRONMENT !== 'development') {
            exit('Wowsers! You don\'t want to do that!');
        }

        // initiate faker
        $this->faker = Faker\Factory::create();

        // load any required models
        $this->load->model('Movie_model');
        $this->load->model('Serie_model');
        $this->load->model('User_model');
        $this->load->model('Category_model');
    }

    /**
     * seed local database
     */
    function seed()
    {
        // purge existing data
        //$this->_truncate_db();

        // seed users
        //$this->_seed_users(25);

        // call more seeds here...
        $this->_seed_movies(20);
    }

    function seed_series()
    {
        $this->_seed_series(20);
    }


    function seed_users()
    {
        $this->_seed_users(20);
    }


    function _seed_movies($limit)
    {
        echo "seeding $limit movies";
        for ($i = 0; $i < $limit; $i++) {
            echo ".";
            $created_at = date("Y-m-d H:i:s");
            $categories = explode(",", "DC Comics,Anime,Accion");


            $data = array(
                'name' => $this->faker->title,
                'year' => $this->faker->year,
                'trailer' => $this->faker->country,
                'cover' => base_url() . 'covers/movie-7f0f2374a429893049f2d1f7ea80876f.png',
                'description' => $this->faker->text,
                'short_description' => $this->faker->text,
                'key_words' => $this->faker->country,
                'created_at' => $created_at,
                'updated_at' => $created_at,
            );


            $id = $this->Movie_model->insert($data);
            if ($id != -1) {

                $this->Movie_model->movie_categories($id, $categories);

                echo $id;
            } else {
                echo -1;
            }


        }
        echo PHP_EOL;
    }

    function _seed_series($limit)
    {
        echo "seeding $limit series";
        for ($i = 0; $i < $limit; $i++) {
            echo ".";
            $created_at = date("Y-m-d H:i:s");
            $categories = explode(",", "DC Comics,Anime,Accion");


            $data = array(
                'serie_name' => $this->faker->title,
                'year' => $this->faker->year,
                'cover' => base_url() . 'covers/movie-7f0f2374a429893049f2d1f7ea80876f.png',
                'description' => $this->faker->text,
                'short_description' => $this->faker->text,
                'key_words' => $this->faker->country,
                'created_at' => $created_at,
            );


            $id = $this->Serie_model->insert($data);
            if ($id != -1) {

                $this->Serie_model->serie_categories($id, $categories);

                echo $id;
            } else {
                echo -1;
            }


        }
        echo PHP_EOL;
    }


    /**
     * seed users
     *
     * @param int $limit
     */
    function _seed_users($limit)
    {
        echo "seeding $limit users";

        // create a bunch of base buyer accounts
        for ($i = 0; $i < $limit; $i++) {
            echo ".";

            $data = array(
                'username' => $this->faker->unique()->userName, // get a unique nickname
                'password' => 'awesomepassword', // run this via your password hashing function
                'email' => $this->faker->email,
            );

            $this->User_model->insert($data);
        }

        echo PHP_EOL;
    }

    private function _truncate_db()
    {
        //$this->user_model->truncate();
        $this->Movie_model->truncate();
    }
}