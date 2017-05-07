<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Temporada_model extends CI_Model
{
    public function construct()
    {
        parent::__construct();
    }


    public function get_last($limit)
    {
        $query = $this->db->query("SELECT s.*, se.serie_name FROM seasons as s, series as se WHERE se.serie_id=s.serie_id ORDER by updated_at desc LIMIT $limit");
        return $query->result();
    }


    public function get_last_android($limit)
    {
        $query = $this->db->query("SELECT s.number, s.season_id, s.cover, s.trailer, se.serie_name, se.serie_id FROM seasons as s, series as se WHERE se.serie_id=s.serie_id ORDER by updated_at desc LIMIT $limit");
        return $query->result();
    }

    function get_temporada($id)
    {
        $query = $this->db->query("SELECT * FROM seasons WHERE season_id=$id");
        $res = $query->result();  // this returns an object of all results

        if ($res) {
            return $res[0];
        } else {
            return null;
        }
    }

    public function get_temporadas_serie($serie_id)
    {
        $query = $this->db->query("select * from seasons where serie_id=$serie_id ORDER by number");
        return $query->result();
    }


    public function insert($data)
    {
        $result = $this->db->insert('seasons', $data);
        if ($result) {
            return $this->db->insert_id();
        }
        return -1;
    }


    public function delete_row($id)
    {

        $item = $this->get_temporada($id);
        if ($item->cover != null) {
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . $item->cover)) {
                unlink($_SERVER['DOCUMENT_ROOT'] . $item->cover);
            }
        }

        return $this->db->delete('seasons', array('season_id' => $id));
    }


    public function get_capitulos_temporada($temp_id)
    {
        $query = $this->db->query("select u.*, su.episode, su.episode_name from urls as u, seasons_urls as su where u.url_id=su.url_id and season_id=$temp_id ORDER by su.episode");
        return $query->result();
    }


    public function update_at($id, $data)
    {

        return $this->db->update('seasons', $data, array('serie_id' => $id));
    }

}