<?php

defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Kolkata');

class Auth extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function index()
	{
		$this->load->view('login');
    }
    
    public function login()
    {
        $email = $this->input->POST('email');
        $pass = md5($this->input->POST('password'));
        $check_email_exist = $this->User_model->validate_email($email);
        if ($check_email_exist != '')
        {
            $validated_user = $this->User_model->validate_user($email, $pass);
            if ($validated_user != '')
            {
                $get_valid_user_details = $this->User_model->get_validated_user_details($validated_user);
                $sessdata = array(
                    'sess_user_id' => $validated_user,
                    'sess_users_name' => $get_valid_user_details['first_name'] . ' ' . $get_valid_user_details['last_name'],
                    'sess_users_email' => $get_valid_user_details['email'],
                    'sess_utype' => $get_valid_user_details['user_type'],
                    'is_logged_in' => 1,
                );
                
                $this->session->set_userdata($sessdata);
                $url = base_url() ."dashboard";
                $data = array('code' => 1, 'response' => 'success', 'home' => $url);
            }
            else
            {
                $ruwid = $this->User_model->get_field_value_condition('users', 'id', array('email' => $email));
                $data = array('code' => 0, 'response' => "Incorrect password. Don't remember your password?");
            }
        }
        else
        {
            $data = array("code" => 2, "response" => "Email or Mobile has not been registerd with us. <a href='javascript:;' id='sign_up_now' class='m-link m-link--focus m-login__account-link'>Sign Up Now</a>");
        }
        echo json_encode($data);
    }

    public function logout()
    {
        $this->session->sess_destroy();
        $url = '/Auth';
        redirect($url);
        exit;
    }
}
