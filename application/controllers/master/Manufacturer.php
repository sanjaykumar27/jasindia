<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manufacturer extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Master/ManufacturerMaster');
    }

    public function index()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $this->load->view('Master/manufacturer_master');
        } 
        else
        {
            redirect('/Auth');
        }
    }

	public function GetManufacturers()
	{
		if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $data['records'] = $this->ManufacturerMaster->selectAll();
            echo json_encode($data['records']);
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
			$userid = $this->session->userdata('sess_user_id');
			$manufacturer = $this->input->POST('manufacturer_name');
			$manufacturer_website = $this->input->POST('manufacturer_website');
			$manufacturer_address = $this->input->POST('manufacturer_address');
			$manufacturer_email = $this->input->POST('manufacturer_email');
            $is_exist = $this->ManufacturerMaster->checkManufacturerExists(trim($manufacturer));
            if($is_exist)
            {
                $data = array('code' => 3, 'response' => 'This manufacturer already exist');
            }
            else 
            {
                $param = array(
                    'manufacturer_name' => trim($manufacturer),
					'manufacturer_website' => trim($manufacturer_website),
					'manufacturer_address' => trim($manufacturer_address),
					'manufacturer_email' => trim($manufacturer_email),
                    'created_by' => $userid,				
                );
                $cid = $this->ManufacturerMaster->createManufacturer($param);
                if($cid != "")
                {
                    $data = array('code' => 1, 'response' => 'Manufacturer Created succesfully!');
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
            redirect('/Auth');
        }
	}
}
