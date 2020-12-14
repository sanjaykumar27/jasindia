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
        } else
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
        } else
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
            $is_exist = $this->ManufacturerMaster->checkManufacturerExists(trim($manufacturer),'');
            if ($is_exist)
            {
                $data = array('code' => 3, 'response' => 'This manufacturer already exist');
            } else
            {
                $param = array(
                    'manufacturer_name' => ucwords(trim($manufacturer)),
                    'manufacturer_website' => trim($manufacturer_website),
                    'manufacturer_address' => ucwords(trim($manufacturer_address)),
                    'manufacturer_email' => trim($manufacturer_email),
                    'created_by' => $userid,
                );
                $cid = $this->ManufacturerMaster->createManufacturer($param);
                if ($cid != "")
                {
                    $data = array('code' => 1, 'response' => 'Manufacturer Created succesfully!');
                } else
                {
                    $data = array('code' => 2, 'response' => 'Something went wrong, Please try again!');
                }
            }
            echo json_encode($data);
        } else
        {
            redirect('/Auth');
        }
    }

    function edit()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $manufacturer_id = $this->input->post('edit_id');
            $records = $this->ManufacturerMaster->GetManufacturerName($manufacturer_id);
            if (empty($records))
            {
                $data = array('code' => 2, 'response' => 'Something went wrong, Please try again!');
            } else
            {
                $data = array('code' => 1, 'response' => 'success', 'records' => $records);
            }
            echo json_encode($data);
        } else
        {
            redirect('/Auth');
        }
    }

    function update()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $userid = $this->session->userdata('sess_user_id');
            $manufacturer_name = $this->input->POST('manufacturer_name');
            $manufacturer_email = $this->input->POST('manufacturer_email');
            $manufacturer_address = $this->input->POST('manufacturer_address');
            $manufacturer_website = $this->input->POST('manufacturer_website');
            $manufacturer_id = $this->input->POST('manufacturer_id');
            $is_exist = $this->ManufacturerMaster->checkManufacturerExists(trim($manufacturer_name),$manufacturer_id);
            if ($is_exist)
            {
                $data = array('code' => 3, 'response' => 'This Manufacturer already exist!');
            } else
            {
                $param = array(
                    'manufacturer_name' => ucwords(trim($manufacturer_name)),
                    'manufacturer_email' => $manufacturer_email,
                    'manufacturer_address' => $manufacturer_address,
                    'manufacturer_website' => $manufacturer_website,
                    'updated_by' => $userid,
                    'updated_on' => date('Y-m-d H:i:s')
                );
                $cid = $this->ManufacturerMaster->updateManufacturer($param, $manufacturer_id);
                if ($cid != "")
                {
                    $data = array('code' => 1, 'response' => 'Manufacturer Updated succesfully!');
                } else
                {
                    $data = array('code' => 2, 'response' => 'Something went wrong, Please try again!');
                }
            }
            echo json_encode($data);
        } else
        {
            redirect('/Auth');
        }
    }

}
