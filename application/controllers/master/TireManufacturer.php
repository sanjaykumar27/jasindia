<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class TireManufacturer extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->library('pagination');
        $this->load->model('Master/TireManufacturer_model');
    }
    
    public function index()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $this->load->view('Master/tire_manufacturer_master');
        } else
        {
            redirect('/Auth');
        }
    }

    public function CreateTireManufacturer()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $userid = $this->session->userdata('sess_user_id');
            $fields =  $this->input->POST();
            $fields['created_by'] = $userid;
            
            $cid = $this->Common_model->CommonInsert('m_tire_manufacturer',$fields);
            if ($cid != "")
            {
                $log = array(
                    'action' => 'CreateTireManufacturer',
                    'page' => 'Create Tire Manufacturer',
                    'record' => 'Create Tire Manufacturer.',
                    'success' => 'Y',
                    'ip_address' => $_SERVER['REMOTE_ADDR'],
                    'created_by' => $userid
                );
                $this->Common_model->CommonInsert('audit_log',$log);
                $data = array('code' => 1, 'response' => 'Tire Manufacturer Created succesfully!');
            } else
            {
                $data = array('code' => 2, 'response' => 'Something went wrong, Please try again!');
            }
            echo json_encode($data);
        } else
        {
            redirect('/Auth');
        }
    }

    public function getTireManufacturer()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $userid = $this->session->userdata('sess_user_id');
            $search = array(
                'keyword' => trim($this->input->post('search_key')),
            );
            $limit = 10;
            $offset = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
            $config['base_url'] = site_url('master/TireManufacturer/getTireManufacturer');
            $config['total_rows'] = $this->TireManufacturer_model->selectAll($limit, $offset, $search, $count = true);
            $config['uri_segment'] = 4;
            $config['num_links'] = 4;
            $this->pagination->initialize($config);
            $total = $config['total_rows'];
            $data['records'] = $this->TireManufacturer_model->selectAll($limit, $offset, $search, $count = false);
            //echo '<pre>';print_r($data['records']);die;
            $pagelinks = $this->pagination->create_links();
            
            $i = $offset + 1;
            $html = '<div class="table-responsive"><table class="table table-striped"><thead><tr><th>#</th><th>Manufacturer Name</th>'
                    . '<th>Action</th></tr></thead><tbody>';
            if (!empty($data['records']))
            {
                foreach ($data['records'] as $value)
                {
                    $html .= '<tr><td>'.$i.'</td><td class="text-truncate">' . $value->manufacturer_name . '</td><td>'
                            . '<a href="javascript:void(0)" id="m_editbutton" data-bs-toggle="modal" value="'.$value->manufacturer_id.'"  data-bs-target="#ModalUpdateManufacturer" class="btn btn-outline-success btn-sm"><i class="fa fa-pencil-alt"></i></a></td>';
                $i++; }
            }
            $html .= '</tbody></table></div><h5>Total Tire Manufacturers: <span class="font-weight-bold">'.$total.'</span></h5>' . $pagelinks;
            $log = array(
                'action' => 'getTireManufacturer',
                'page' => 'Tire Manufacturer Master',
                'record' => 'Get Tire Manufacturer List.',
                'success' => 'Y',
                'ip_address' => $_SERVER['REMOTE_ADDR'],
                'created_by' => $userid,
            );
            $this->Common_model->CommonInsert('audit_log',$log);
            echo $html;
        } else
        {
            redirect('/Auth');
        }
    }
}
