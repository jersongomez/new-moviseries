<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Url_model extends CI_Model
{
    public function construct()
    {
        parent::__construct();
    }

    function get_url($id)
    {
        $query = $this->db->query("SELECT * FROM urls WHERE url_id=$id");
        $res = $query->result();  // this returns an object of all results

        if ($res) {
            return $res[0];
        } else {
            return null;
        }
    }

    public function getUrlsByMovie($movie_id)
    {
        $query = $this->db->query("select u.* from urls as u where u.url_id in (select mu.url_id from movies_urls as mu where mu.movie_id=$movie_id)");
        return $query->result();
    }

    public function getUrlsMEGAByMovie($movie_id)
    {
        $query = $this->db->query("select * from mega_movies where movie_id=$movie_id");
        return $query->result();
    }


    public function getUrlsMEGABySerie($serie_id)
    {
        $query = $this->db->query("select * from mega_series where serie_id=$serie_id");
        return $query->result();
    }


    public function insert($url)
    {
        $result = $this->db->insert('urls', $url);
        if ($result) {
            return $this->db->insert_id();
        }
        return -1;
    }


    public function insert_mega_movie($url)
    {
        $result = $this->db->insert('mega_movies', $url);
        if ($result) {
            return $this->db->insert_id();
        }
        return -1;
    }


    public function insert_mega_serie($url)
    {
        $result = $this->db->insert('mega_series', $url);
        if ($result) {
            return $this->db->insert_id();
        }
        return -1;
    }


    public function delete_row($id)
    {
        return $this->db->delete('urls', array('url_id' => $id));
    }


    public function delete_row_mega_movie($id)
    {
        return $this->db->delete('mega_movies', array('mega_id' => $id));
    }


    public function delete_row_mega_serie($id)
    {
        return $this->db->delete('mega_series', array('mega_id' => $id));
    }


    public function insert_movie_url($movie_id, $url_id)
    {
        return $this->db->insert('movies_urls', ['movie_id' => $movie_id, 'url_id' => $url_id]);
    }


    public function insert_capitulo($serie_id, $url_id, $episode, $episode_name)
    {
        return $this->db->insert('seasons_urls',
            [
                'season_id' => $serie_id,
                'url_id' => $url_id,
                'episode' => $episode,
                'episode_name' => $episode_name
            ]);
    }


}