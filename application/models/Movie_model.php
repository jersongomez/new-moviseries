<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Movie_model extends CI_Model
{
    public $table = 'movies';

    public function construct()
    {
        parent::__construct();
    }

    public function count()
    {
        return $this->db->count_all("movies");
    }

    public function count_by_categoty($category_name)
    {
        $this->db->where('category_name', $category_name);
        $this->db->from("movies_categories");
        return $this->db->count_all_results();
    }

    public function get_movies()
    {
        $this->db->order_by("created_at", "desc");
        $query = $this->db->get('movies');
        return $query->result();
    }


    public function get_movies_limit_offset_letra($limit, $offset,$letra)
    {
        $this->db->order_by('updated_at', 'desc');
        $this->db->like('name', $letra, 'after');
        $query = $this->db->get('movies', $limit, $offset);
        return $query->result();
    }



    public function get_movies_limit_offset($limit, $offset)
    {
        $this->db->order_by('updated_at', 'desc');
        $query = $this->db->get('movies', $limit, $offset);
        return $query->result();
    }


    public function get_last_movies()
    {
        $this->db->order_by("updated_at", "desc");
        $query = $this->db->get('movies', 15);
        return $query->result();
    }


    public function get_last_movies_android($limit, $offset)
    {
        $this->db->order_by("updated_at", "desc");
        $this->db->limit($limit, $offset);
        $this->db->select('movie_id,name,year,cover,trailer,short_description,created_at,updated_at');
        $query = $this->db->get('movies');
        return $query->result();
    }

    
    public function get_last_movies_android_letra($limit, $offset,$letra)
    {
        $this->db->order_by("updated_at", "desc");
        $this->db->like('name', $letra, 'after');
        $this->db->limit($limit, $offset);
        $this->db->select('movie_id,name,year,cover,trailer,short_description,created_at,updated_at');
        $query = $this->db->get('movies');
        return $query->result();
    }

    public function get_movies_category($category_name)
    {
        $query = $this->db->query("SELECT m.* FROM movies as m WHERE m.movie_id in (select mc.movie_id from movies_categories as mc WHERE mc.category_name='$category_name')");
        return $query->result();  // this returns an object of all results
    }

    public function get_movies_category_android($category, $limit, $offset)
    {
        $this->db->select('movie_id');
        $this->db->from('movies_categories');
        $this->db->where('category_name', $category);
        $subQuery = $this->db->get_compiled_select();


        $this->db->order_by('updated_at', 'desc');
        $this->db->limit($limit, $offset);
        $this->db->select('movie_id,name,year,cover,trailer,short_description,created_at,updated_at');
        $this->db->where("`movie_id` IN ( $subQuery)", NULL, FALSE);
        $query = $this->db->get('movies');
        return $query->result();  // this returns an object of all results
    }


    public function get_movies_category_android_letra($category, $limit, $offset,$letra)
    {
        $this->db->select('movie_id');
        $this->db->from('movies_categories');
        $this->db->where('category_name', $category);
        $subQuery = $this->db->get_compiled_select();


        $this->db->order_by('updated_at', 'desc');
        $this->db->like('name', $letra, 'after');
        $this->db->limit($limit, $offset);
        $this->db->select('movie_id,name,year,cover,trailer,short_description,created_at,updated_at');
        $this->db->where("`movie_id` IN ( $subQuery)", NULL, FALSE);
        $query = $this->db->get('movies');
        return $query->result();  // this returns an object of all results
    }



    public function get_movies_category_limit_offset($category_name, $limit, $offset)
    {

        $this->db->select('movie_id');
        $this->db->from('movies_categories');
        $this->db->where('category_name', $category_name);
        $subQuery = $this->db->get_compiled_select();


        $this->db->order_by('updated_at', 'desc');
        $this->db->limit($limit, $offset);
        $this->db->select("*");
        $this->db->where("`movie_id` IN ( $subQuery)", NULL, FALSE);
        $query = $this->db->get('movies');
        return $query->result();  // this returns an object of all results
    }


    public function get_movies_by_score($limit)
    {
        $sql = "SELECT m.*, COALESCE((SELECT AVG(ms.score) FROM movies_score as ms WHERE movie_id=m.movie_id),0) score from movies as m order by score DESC LIMIT $limit";
        $query = $this->db->query($sql);
        return $query->result();  // this returns an object of all results
    }


    public function get_movies_by_score_android($limit)
    {
        $sql = "SELECT m.movie_id, m.name, m.year, m.cover, m.trailer, m.short_description, m.created_at, m.updated_at, COALESCE((SELECT AVG(ms.score) FROM movies_score as ms WHERE movie_id=m.movie_id),0) score from movies as m order by score DESC LIMIT $limit";
        $query = $this->db->query($sql);
        return $query->result();  // this returns an object of all results
    }


    public function movie_score($id)
    {
        $this->db->select('movie_id');
        $this->db->from('movies_score');
        $this->db->where('movie_id', $id);
        $num = $this->db->count_all_results();

        $sql = "SELECT m.*, COALESCE((SELECT AVG(ms.score) FROM movies_score as ms WHERE movie_id=m.movie_id),0) score, $num votos from movies as m WHERE m.movie_id=$id";
        $query = $this->db->query($sql);
        $res = $query->result();  // this returns an object of all results
        if ($res) {
            return $res[0];
        } else {
            return null;
        }
    }


    public function movie_score_android($id)
    {
        $this->db->select('movie_id');
        $this->db->from('movies_score');
        $this->db->where('movie_id', $id);
        $num = $this->db->count_all_results();

        $sql = "SELECT m.movie_id, m.name, m.year, m.cover, m.trailer, m.short_description, m.created_at, m.updated_at, COALESCE((SELECT AVG(ms.score) FROM movies_score as ms WHERE movie_id=m.movie_id),0) score, $num votos from movies as m WHERE m.movie_id=$id";
        $query = $this->db->query($sql);
        $res = $query->result();  // this returns an object of all results
        if ($res) {
            return $res[0];
        } else {
            return null;
        }
    }


    function getById($id)
    {
        $query = $this->db->query("SELECT * FROM movies WHERE movie_id=$id");
        $res = $query->result();  // this returns an object of all results

        if ($res) {
            return $res[0];
        } else {
            return null;
        }
    }


    public function insert($movie)
    {
        $result = $this->db->insert('movies', $movie);
        if ($result) {
            return $this->db->insert_id();
        }
        return -1;
    }


    public function calificar($data)
    {
        return $this->db->insert('movies_score', $data);
    }


    public function movie_categories($movie_id, $categories)
    {
        $this->load->model('Category_model');

        foreach ($categories as $category) {
            $data = array('movie_id' => $movie_id,
                'category_name' => $category);
            $this->db->insert('movies_categories', $data);
        }


    }


    public function delete_row($id)
    {

        $item = $this->getById($id);
        if ($item->cover != null) {
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . $item->cover)) {
                unlink($_SERVER['DOCUMENT_ROOT'] . $item->cover);
            }
        }

        return $this->db->delete($this->table, array('movie_id' => $id));
    }


    public function update_row($id, $data)
    {
        $row = $this->getById($id);
        if ($row->cover != null) {
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . $row->cover)) {
                unlink($_SERVER['DOCUMENT_ROOT'] . $row->cover);
            }
        }

        return $this->db->update('movies', $data, array('movie_id' => $id));
    }

    public function update_at($id, $data)
    {

        return $this->db->update('movies', $data, array('movie_id' => $id));
    }


    public function search_movie($q)
    {
        $sql = "select m.movie_id,m.name,m.year,m.cover,m.trailer,m.short_description,m.created_at,m.updated_at from movies as m WHERE m.name LIKE '%" . $q . "%' or m.short_description LIKE '%" . $q . "%' ";
        $query = $this->db->query($sql);
        return $query->result();

    }


}