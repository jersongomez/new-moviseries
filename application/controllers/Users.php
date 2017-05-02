<?php
session_start();
session_regenerate_id();


defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller
{

    function __construct()
    {   //en el constructor cargamos nuestro modelo
        parent::__construct();
        $this->load->model('User_model');
    }


    public function new_user()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }


        if ($_SESSION['token'] == $_POST['token']) {
            $this->load->helper('security');
            //creamos nuestras reglas de validación,
            //required=campo obligatorio||valid_email=validar correo||xss_clean=evitamos inyecciones de código
            $this->form_validation->set_rules('username', 'Usuario', 'required|xss_clean');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|xss_clean');
            $this->form_validation->set_rules('password', 'Contraseña', 'required|xss_clean');
            //comprobamos si los datos son correctos, el comodín %s nos mostrará el nombre del campo
            //que ha fallado
            $this->form_validation->set_message('required', 'El campo %s es requerido');
            $this->form_validation->set_message('valid_email', 'El %s no es válido');
            //si el formulario no pasa la validación lo devolvemos a la página
            //pero esta vez le mostramos los errores al lado de cada campo
            if ($this->form_validation->run() == FALSE) {
                echo "Error al crear el usuario";
                //en caso de que la validación sea correcta cogemos las variables y las envíamos
                //al modelo
            } else {
                $token = bin2hex(random_bytes(20));
                $username = $this->input->post("username");
                $email = $this->input->post("email");
                $password = password_hash($this->input->post("password"), PASSWORD_DEFAULT);
                $insert = $this->User_model->insert_user($username, $email, $password, $token);
                if ($insert) {

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
                    $url = base_url('activacion/' . urlencode($email) . '/' . $token);
                    $html = "<h1>Activación de cuenta</h1><br>
<img src='http://moviseries.xyz/assets/img/logo.png' alt=''>
<hr><p>Activa tu cuenta <a href='$url'>aquí</a> para comenzar a disfrutar de series y peliculas en hd sin publicidad molesta.</p>";


                    $this->email->from('moviserieshd@gmail.com');
                    $this->email->to($email);
                    $this->email->subject('Moviseries Activación Cuenta');
                    $this->email->message($html);
                    if($this->email->send()){
                        echo "Verifique su email para activar su cuenta";
                    }else{
                        echo "No se pudo enviar el email de verificación, por favor contacta al administrador.";
                    }



                }

            }
        } else {
            echo "Error de seguridad: recarge la pagina e intente de nuevo";
        }
    }

    public function activation($email, $token)
    {
        if ($email != null && $token != null) {
            $user = $this->User_model->get_user(urldecode($email));
            if ($user != null) {
                if ($user->token == $token) {
                    $this->db->set('token', null);
                    $this->db->where('user_id', $user->user_id);
                    $res = $this->db->update('users'); // gives UPDATE mytable SET field = field+1 WHERE id = 2
                    if ($res) {
                        $this->load->view('activated');
                    } else {
                        $this->load->view('error_activated', ['error' => 'No se pudo activar la cuenta']);
                    }
                } else {
                    $this->load->view('error_activated', ['error' => 'El token no es valido']);
                }

            } else {
                $this->load->view('error_activated', ['error' => 'No se encontro la cuenta con el email proporcionado']);
            }
        } else {
            $this->load->view('error_activated', ['error' => 'El email y el token no son validos']);
        }
    }


    public function login()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        if ($_SESSION['token'] == $_POST['token']) {
            $email = $this->input->post("email");
            $password = $this->input->post("password");

            if ($email != null && $password != null) {
                $user = $this->User_model->get_user($email);
                if ($user != null) {
                    if ($user->token == null) {
                        if (password_verify($password, $user->password)) {
                            $_SESSION['username'] = $user->username;
                            $_SESSION['user_id'] = $user->user_id;
                            $_SESSION['user_type'] = $user->user_type;

                            echo "exito";
                        } else {
                            echo "La contraseña ingresada no es correcta";
                        }
                    } else {
                        echo "Verifique su cuenta para iniciar sesión";
                    }

                } else {
                    echo "No se encontro la cuenta con el email ingresado";
                }
            } else {
                echo "datos no validos" . $email;
            }
        } else {
            echo "Error: de seguridad";
        }
    }


    public function logout()
    {
        session_destroy();
        redirect(base_url());
    }


    public function reset_password()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        if ($_SESSION['token'] == $_POST['token']) {
            $email = $_POST['email'];
            $user = $this->User_model->get_user($email);
            if ($user != null) {

                $token = $this->User_model->create_reset_token($user->user_id);
                if ($token) {
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
                    $url = base_url('recuperacion/' . $user->user_id . '/' . $token);
                    $html = "<h1>Recuperación de Contraseña</h1><br>
<img src='http://moviseries.xyz/assets/img/logo.png' alt=''>
<hr><p>Hola para recuperar tu contraseña click <a href='$url'>aquí</a></a></p><hr><b style='color: red;'>Si tu no solicitaste la recuperación de tu contraseña ignora este email.</b>";


                    $this->email->from('moviserieshd@gmail.com');
                    $this->email->to($email);
                    $this->email->subject('Moviseries recuperación de contraseña');
                    $this->email->message($html);
                    if ($this->email->send()) {
                        echo "Revise su email para cambiar su contraseña";
                    } else {
                        echo "Error: no se pudo enviar el email de reinicio, por favor intenta mas tarde o contacta al administrador";
                    }


                } else {
                    echo "Error: no se pudo enviar el email de reinicio, por favor intenta mas tarde o contacta al administrador";
                }

            } else {
                echo "Error: El email ingresado no se encuentra registrado";
            }

        } else {
            echo "Error de seguridad: recarge la pagina e intente de nuevo";
        }
    }


    /**
     * @param $user_id
     * @param $token token de recuperacion
     */
    public function recuperacion($user_id, $token)
    {
        $this->load->view('new_password', ['user_id' => $user_id, 'reset_token' => $token]);
    }


    public function new_password()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        if ($_SESSION['token'] == $_POST['token']) {
            $user_id = $_POST['user_id'];
            $token = $_POST['reset_token'];
            $res = $this->User_model->verify_token($user_id, $token);
            if ($res) {
                $pass = password_hash($_POST['password1'], PASSWORD_DEFAULT);
                $res = $this->User_model->update_user($user_id, ['password' => $pass]);
                if ($res > 0) {
                    $this->User_model->delete_token($user_id);
                    echo "Contraseña cambiada con exito";
                } else {
                    echo "Error al cambiar la contraseña";
                }
            } else {
                echo "El token de recuperación es incorrecto";
            }
        } else {
            echo "No direct script access allowed";
        }
    }

    public function mi_cuenta(){
        if(!isset($_SESSION['username'])){
            exit('403 acceso denegado');
        }
        $user=$this->User_model->get_user_id($_SESSION['user_id']);
        $this->load->view('mi_cuenta',['user'=>$user]);
    }

}
