<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class State extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Master/StateMaster');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		
    }

    public function index()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $this->load->view('Master/state_master');
        } 
        else
        {
            redirect('/Auth');
        }
    }

	public function GetStates()
	{
		if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $data = $this->StateMaster->selectAll();
            echo json_encode($data);
        } 
        else
        {
            redirect('/Auth');
        }
	}
	
	public function Create()
	{
		if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
			if ($this->input->is_ajax_request()) 
			{
				$states_exist = array();
				$cid = '';
				$userid = $this->session->userdata('sess_user_id');
				$states = $this->input->POST('state_name');
				$sCount = count($states);
				foreach($states as $val)
				{
					$is_exist = $this->StateMaster->checkStateExists(trim($val));
					if($is_exist)
					{
						$states_exist[] = trim($val);
					}
					else 
					{
						$param = array(
							'state_name' => trim($val),
							'created_by' => $userid,				
						);
						$cid = $this->StateMaster->createState($param);
					}				
				}		
				
				
				if($cid != "")
				{
					if(count($states_exist) > 1 && count($states_exist) != $sCount)
					{
						$st = implode(', ',$states_exist);
						$data = array('code' => 1, 'response' => "State Created succesfully! These states already exist: $st");
					}
					else
					{
						$data = array('code' => 1, 'response' => 'State Created succesfully!');
					}
					
				} 
				else
				{
					if($sCount == count($states_exist))
					{
						$data = array('code' => 3, 'response' => 'No State Inserted! All Exist');
					}
					else
					{
						$data = array('code' => 2, 'response' => 'Something went wrong, Please try again!');
					}
				}
				echo json_encode($data);
			}
			else 
			{
				echo "No direct script access allowed";
			}
        } 
        else
        {
            redirect('/Auth');
        }
	}
}
