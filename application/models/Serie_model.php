<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Serie_model extends CI_Model
{
    public $table = 'series';

    public function construct()
    {
        parent::__construct();
    }


    public function count()
    {
        return $this->db->count_all("series");
    }

    public function count_by_categoty($category_name)
    {
        $this->db->where('category_name', $category_name);
        $this->db->from("categories_series");
        return $this->db->count_all_results();
    }

    public function get_all()
    {
        $this->db->order_by("created_at", "desc");
        $query = $this->db->get($this->table);
        return $query->result();
    }


    public function get_limit_offset($limit, $offset)
    {
        $this->db->order_by('created_at','desc');
        $query = $this->db->get($this->table, $limit, $offset);
        return $query->result();
    }

    public function get_series_by_score($limit)
    {
        $sql = "SELECT m.*, COALESCE((SELECT AVG(ms.score) FROM series_score as ms WHERE serie_id=m.serie_id),0) score from series as m order by score DESC LIMIT $limit";
        $query = $this->db->query($sql);
        return $query->result();  // this returns an object of all results
    }


    public function get_series_category_limit_offset($category_name,$limit, $offset){
        $this->db->select('serie_id');
        $this->db->from('categories_series');
        $this->db->where('category_name',$category_name);
        $subQuery = $this->db->get_compiled_select();


        $this->db->order_by('created_at','desc');
        $this->db->limit($limit, $offset);
        $this->db->select("*");
        $this->db->where("`serie_id` IN ( $subQuery)", NULL, FALSE);
        $query = $this->db->get('series');
        return $query->result();  // this returns an object of all results
    }


    public function get_last_series($limit)
    {
        $this->db->order_by("created_at", "desc");
        $query = $this->db->get($this->table,$limit);
        return $query->result();
    }


    public function get_last_series_android($limit, $offset)
    {
        $this->db->order_by("created_at", "desc");
        $this->db->limit($limit, $offset);
        $this->db->select('serie_id,serie_name,year,cover,short_description,created_at');
        $query = $this->db->get($this->table,$limit);
        return $query->result();
    }


    public function get_series_category_android($category,$limit, $offset){
        $this->db->select('serie_id');
        $this->db->from('categories_series');
        $this->db->where('category_name', $category);
        $subQuery = $this->db->get_compiled_select();


        $this->db->order_by('created_at', 'desc');
        $this->db->limit($limit, $offset);
        $this->db->select('serie_id,serie_name,year,cover,short_description,created_at');
        $this->db->where("`serie_id` IN ( $subQuery)", NULL, FALSE);
        $query = $this->db->get('series');
        return $query->result();  // this returns an object of all results
    }

    function getById($id)
    {
        $query = $this->db->query("SELECT * FROM series WHERE serie_id=$id");
        $res = $query->result();  // this returns an object of all results

        if ($res) {
            return $res[0];
        } else {
            return null;
        }
    }

    public function calificar($data)
    {
        return $this->db->insert('series_score', $data);
    }


    public function serie_score($id)
    {
        $this->db->select('serie_id');
        $this->db->from('series_score');
        $this->db->where('serie_id', $id);
        $num=$this->db->count_all_results();

        $sql = "SELECT m.*, COALESCE((SELECT AVG(ms.score) FROM series_score as ms WHERE serie_id=m.serie_id),0) score, $num votos from series as m WHERE m.serie_id=$id";
        $query = $this->db->query($sql);
        $res = $query->result();  // this returns an object of all results
        if ($res) {
            return $res[0];
        } else {
            return null;
        }
    }



    public function serie_score_android($id)
    {
        $this->db->select('serie_id');
        $this->db->from('series_score');
        $this->db->where('serie_id', $id);
        $num=$this->db->count_all_results();

        $sql = "SELECT m.serie_id,m.serie_name,m.year,m.cover,m.short_description,m.created_at, COALESCE((SELECT AVG(ms.score) FROM series_score as ms WHERE serie_id=m.serie_id),0) score, $num votos from series as m WHERE m.serie_id=$id";
        $query = $this->db->query($sql);
        $res = $query->result();  // this returns an object of all results
        if ($res) {
            return $res[0];
        } else {
            return null;
        }
    }

    public function insert($data)
    {
        $result = $this->db->insert($this->table, $data);
        if ($result) {
            return $this->db->insert_id();
        }
        return -1;
    }


    public function serie_categories($serie_id, $categories)
    {
        $this->load->model('Category_model');

        foreach ($categories as $category) {
            $data = array('serie_id' => $serie_id,
                'category_name' => $category);
            $this->db->insert('categories_series', $data);
        }


    }


    public function eliminar_serie($id)
    {
        $item = $this->getById($id);
        if ($item->cover != null) {
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . $item->cover)) {
                unlink($_SERVER['DOCUMENT_ROOT'] . $item->cover);
            }
        }

        return $this->db->delete('series', array('serie_id' => $id));
    }


    public function update_row($id, $data)
    {
        $row = $this->getById($id);
        if ($row->cover != null) {
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . $row->cover)) {
                unlink($_SERVER['DOCUMENT_ROOT'] . $row->cover);
            }
        }

        return $this->db->update($this->table, $data, array('serie_id' => $id));
    }


}