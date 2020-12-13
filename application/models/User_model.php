<?php
class User_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    function validate_email($email)
    {
        $this->db->select('id');
        $this->db->from('users');
        $this->db->where('email',$email);
        $this->db->where('status','1');
        $this->db->or_where('mobile', $email);

        $data=$this->db->get();

        $num=$data->num_rows();

        if($num ==1)
        {
            $result =$data->result_array();
            if(isset($result[0]))
            {
                return $result[0]['id'];
            }
        }
        else
        {
            return '';
        }
    }

    function validate_user($email,$password)
    {
        $this->db->select('id');
        $this->db->from('users');
        $this->db->where('email',$email);
        $this->db->where('password',$password);
        $this->db->where('status','1');
        $this->db->or_where('mobile',$email);
        $data=$this->db->get();

        $num=$data->num_rows();

        if($num ==1)
        {
            $result =$data->result_array();
            if(isset($result[0]))
            {
                return $result[0]['id'];
            }
        }
        else
        {
            return '';
        }
    }

    function get_validated_user_details($user_id)
    {
        $this->db->select('first_name,last_name,email,mobile,user_type.user_type,users.profile_pic');
        $this->db->from('users');
        $this->db->join('user_type', 'user_type.ID = users.user_type', 'left');
        $this->db->where('users.id',$user_id);
        $result=$this->db->get()->result_array();

        if(isset($result[0]))
        {
            return $result[0];
        }

        else
        {
            return '';
        }
    }

    function get_field_value_condition($table_name, $displaycolumn_name,$wherearr){

        $this->db->select($displaycolumn_name);

        $arr=$this->db->get_where($table_name,$wherearr)->result_array();

        if(isset($arr[0])){

            return $arr[0][$displaycolumn_name];

        }

        else{

            return "";

        }

    }

}

