<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Category_model extends CI_Model
{
    public function construct()
    {
        parent::__construct();
    }


    public function getCategories()
    {
        $query = $this->db->get('categories');
        return $query->result();
    }

    public function getCategoriasByMovie($movie_id)
    {

        $query = $this->db->query("select category_name from movies_categories where movie_id=$movie_id");
        return $query->result();
    }


    public function getCategoriasBySerie($serie_id)
    {

        $query = $this->db->query("select category_name from categories_series where serie_id=$serie_id");
        return $query->result();
    }


    public function insert($data)
    {
        return $this->db->insert('categories', $data);
    }

    public function delete_row($id)
    {
        return $this->db->delete('categories', array('category_name' => $id));
    }


}