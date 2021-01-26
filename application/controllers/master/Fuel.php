<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Fuel extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->library('pagination');
        $this->load->model('Master/Fuel_model');
    }
    
    public function index()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $data['audit_logs'] = $this->Common_model->getLogs();
            $this->load->view('Master/fuel_master',$data);
        } else
        {
            redirect('/Auth');
        }
    }
    
    public function CreateFuel()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $userid = $this->session->userdata('sess_user_id');
            $fuel_name = $this->input->POST('fuel_name');
			$is_exist = $this->Fuel_model->checkFuelExist(trim($fuel_name),'');
            if ($is_exist)
            {
                $data = array('code' => 3, 'response' => 'This fuel already exist');
            } else
            {
                $param = array(
                    'fuel_name' => ucwords(trim($fuel_name)),
                    'created_by' => $userid,
                );
                $cid = $this->Common_model->CommonInsert('m_fuel',$param);
                if ($cid != "")
                {
                    $data = array('code' => 1, 'response' => 'Fuel Created succesfully!');
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
    
    public function getFuels()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $search = array(
                'keyword' => trim($this->input->post('search_key')),
            );
            $limit = 10;
            $offset = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
            $config['base_url'] = site_url('master/fuel/getFuels');
            $config['total_rows'] = $this->Fuel_model->selectAll($limit, $offset, $search, $count = true);
            $config['uri_segment'] = 4;
            $config['num_links'] = 4;
            $this->pagination->initialize($config);
            $total = $config['total_rows'];
            $data['records'] = $this->Fuel_model->selectAll($limit, $offset, $search, $count = false);
            $pagelinks = $this->pagination->create_links();
            
            $i = $offset + 1;
            $html = '<div class="table-responsive"><table class="table m-table m-table--head-bg-success table-striped"><thead><tr><th>#</th><th>Fuel Name</th>'
                    . '<th>Action</th></tr></thead><tbody>';
            if (!empty($data['records']))
            {
                foreach ($data['records'] as $value)
                {
                    $html .= '<tr><td>'.$i.'</td><td class="text-truncate">' . $value->fuel_name . '</td><td>'
                            . '<a href="javascript:void(0)" id="m_editbutton" data-bs-toggle="modal" value="'.$value->fuel_id.'"  data-target="#ModalUpdateFuel" class="btn m-btn--pill btn-outline-success btn-sm"><i class="fa fa-pencil-alt"></i> Edit</a></td>';
                $i++; }
            }
            $html .= '</tbody></table></div><h5>Total Fuels: <span class="font-weight-bold">'.$total.'</span></h5>' . $pagelinks;
            echo $html;
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
            $fuel_id = $this->input->POST('fuel_id');
            $fuel_name = $this->input->POST('fuel_name');
            $is_exist = $this->Fuel_model->checkFuelExist(trim($fuel_name),$fuel_id);
            if ($is_exist)
            {
                $data = array('code' => 3, 'response' => 'This Fuel already exist!');
            } else
            {
                $param = array(
                    'fuel_name' => ucwords(trim($fuel_name)),
                    'updated_by' => $userid,
                    'updated_on' => date('Y-m-d H:i:s')
                );
                $cid = $this->Fuel_model->updateFuel($param, $fuel_id);
                if ($cid != "")
                {
                    $data = array('code' => 1, 'response' => 'Fuel Updated succesfully!');
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
            $fuel_id = $this->input->post('edit_id');
            $records = $this->Fuel_model->GetFuelDetails($fuel_id);
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

}
