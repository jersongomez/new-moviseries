<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function construct()
    {
        parent::__construct();
    }


    function get_users()
    {
        $query = $this->db->query("SELECT * FROM users");
        return $query->result();  // this returns an object of all results
    }


    function get_user_id($id)
    {
        $query = $this->db->query("SELECT * FROM users WHERE user_id=$id");
        $res = $query->result();  // this returns an object of all results

        if ($res) {
            return $res[0];
        } else {
            return null;
        }
    }

    function insert_user($username, $email, $password, $token)
    {
        $hora = date("H:i:s");
        $fecha = date('Y-m-d');

        $data = array(
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'token' => $token
        );
        return $this->db->insert('users', $data);
    }

    function insert($data)
    {
        return $this->db->insert('users', $data);
    }


    /**
     * @param $email
     * @return mixed usuario con el email indicado
     */
    function get_user($email)
    {
        $query = $this->db->query("SELECT * FROM users WHERE email='$email'");
        $res = $query->result();  // this returns an object of all results

        if ($res) {
            return $res[0];
        } else {
            return null;
        }
    }


    public function delete_row($id)
    {
        return $this->db->delete('users', array('user_id' => $id));
    }


    public function update_row($id, $data)
    {
        return $this->db->update('users', $data, array('user_id' => $id));
    }


    public function update_user($id, $data)
    {
        return $this->db->update('users', $data, array('user_id' => $id));
    }


    public function delete_token($user_id)
    {
        return $this->db->delete('passwords_reset', array('user_id' => $user_id));
    }


    public function create_reset_token($user_id)
    {
        $this->delete_token($user_id);

        $token = bin2hex(random_bytes(15));;
        $data = array(
            'user_id' => $user_id,
            'token' => $token
        );
        $res = $this->db->insert('passwords_reset', $data);
        if ($res) {
            return $token;
        } else {
            return null;
        }
    }


    public function verify_token($user_id, $token)
    {
        $query = $this->db->query("SELECT * FROM passwords_reset WHERE user_id=$user_id and token='$token'");
        $res = $query->result();  // this returns an object of all results

        if ($res) {
            if (sizeof($res) > 0)
                return true;
            else return false;

        } else {
            return false;
        }
    }

}