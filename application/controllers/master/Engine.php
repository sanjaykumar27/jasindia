<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Engine extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Master/Engine_model');
        $this->load->model('Master/ManufacturerMaster');
        $this->load->library('pagination');
    }
    
    public function index()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $this->load->view('Master/engine_master');
        } else
        {
            redirect('/Auth');
        }
    }
    
    public function CreateEngine()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $userid = $this->session->userdata('sess_user_id');
            $engine_name = $this->input->POST('engine_name');
            $manufacturer_id = $this->input->POST('manufacturer_id');
			$is_exist = $this->Engine_model->checkEngineExist(trim($engine_name),'',$manufacturer_id);
            if ($is_exist)
            {
                $data = array('code' => 3, 'response' => 'This engine already exist');
            } else
            {
                $param = array(
                    'engine_name' => ucwords(trim($engine_name)),
                    'manufacturer_id' => trim($manufacturer_id),
                    'created_by' => $userid,
                );
                $cid = $this->Engine_model->createEngine($param);
                if ($cid != "")
                {
                    $data = array('code' => 1, 'response' => 'Engine Created succesfully!');
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
    
    public function getEngine()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $search = array(
                'keyword' => trim($this->input->post('search_key')),
            );
            $limit = 10;
            $offset = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
            $config['base_url'] = site_url('master/engine/getEngine');
            $config['total_rows'] = $this->Engine_model->selectAll($limit, $offset, $search, $count = true);
            $config['uri_segment'] = 4;
            $config['num_links'] = 4;
            $this->pagination->initialize($config);
            $total = $config['total_rows'];
            $data['records'] = $this->Engine_model->selectAll($limit, $offset, $search, $count = false);
            $pagelinks = $this->pagination->create_links();
            
            $i = $offset + 1;
            $html = '<div class="table-responsive"><table class="table m-table m-table--head-bg-success table-striped"><thead><tr><th>#</th><th>Engine Name</th>'
                    . '<th>Manufacturer</th><th>Action</th></tr></thead><tbody>';
            if (!empty($data['records']))
            {
                foreach ($data['records'] as $value)
                {
                    $html .= '<tr><td>'.$i.'</td><td class="text-truncate">' . $value->engine_name . '</td><td class="text-truncate">' . $value->manufacturer_name . '</td><td>'
                            . '<a href="javascript:void(0)" id="m_editbutton" data-toggle="modal" value="'.$value->manufacturer_id.'"  data-target="#ModalUpdateCompany" class="btn m-btn--pill btn-outline-success btn-sm"><i class="fa fa-pencil-alt"></i> Edit</a></td>';
                $i++; }
            }
            $html .= '</tbody></table></div><h5>Total Engines: <span class="font-weight-bold">'.$total.'</span></h5>' . $pagelinks;
            echo $html;
        } else
        {
            redirect('/Auth');
        }
    }
    
    function allManufacturer()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $data = $this->ManufacturerMaster->getAllManufacturer();
            //print_r($data);die;
            $html = '<option value="">Select Manufacturer</option>';
            if (!empty($data))
            {
                $i = 1;
                foreach ($data as $value)
                {
                    $html .= '<option value='.$value['manufacturer_id'].'>'.$value['manufacturer_name'].'</option>';
                    $i++;
                }
            } 
            echo $html;
        } else
        {
            redirect('/Auth');
        }
    }

}
