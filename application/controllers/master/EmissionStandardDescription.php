<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class EmissionStandardDescription extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->library('pagination');
        $this->load->model('Master/EmissionStandardDescription_model');
        $this->load->model('Master/EmissionStandard_model');
        $this->load->model('Master/VehicleSegment_model');
    }
    
    public function index()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $data['vehicle_segment'] = $this->VehicleSegment_model->listAllData();
            $data['emission_standard'] = $this->EmissionStandard_model->listAllData();
            $this->load->view('Master/emission_standard_description_master',$data);
        } else
        {
            redirect('/Auth');
        }
    }

    public function CreateEmissionStandardDescription()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $userid = $this->session->userdata('sess_user_id');
            $fields =  $this->input->POST();
            $fields['created_by'] = $userid;
            
            $cid = $this->Common_model->CommonInsert('m_emmision_standard_description',$fields);
            if ($cid != "")
            {
                $log = array(
                    'action' => 'CreateEmissionStandardDescription',
                    'page' => 'Create Emmission Standard Description',
                    'record' => 'Create Emmission Standard Description.',
                    'success' => 'Y',
                    'ip_address' => $_SERVER['REMOTE_ADDR'],
                    'created_by' => $userid
                );
                $this->Common_model->CommonInsert('audit_log',$log);
                $data = array('code' => 1, 'response' => 'Emmission Standard Description Created succesfully!');
            } else
            {
                $data = array('code' => 2, 'response' => 'Something went wrong, Please try again!');
            }
            
        } else
        {
            redirect('/Auth');
        }
    }

    public function getEmissionStandardDescription()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $userid = $this->session->userdata('sess_user_id');
            $search = array(
                'keyword' => trim($this->input->post('search_key')),
            );
            $limit = 10;
            $offset = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
            $config['base_url'] = site_url('master/EmissionStandardDescription/getEmissionStandardDescription');
            $config['total_rows'] = $this->EmissionStandardDescription_model->selectAll($limit, $offset, $search, $count = true);
            $config['uri_segment'] = 4;
            $config['num_links'] = 4;
            $this->pagination->initialize($config);
            $total = $config['total_rows'];
            $data['records'] = $this->EmissionStandardDescription_model->selectAll($limit, $offset, $search, $count = false);
            //echo '<pre>';print_r($data['records']);die;
            $pagelinks = $this->pagination->create_links();
            
            $i = $offset + 1;
            $html = '<div class="table-responsive"><table class="table table-striped"><thead><tr><th>#</th><th>Emission Standard</th>'
                    . '<th>Vehicle Segment</th><th>Carbon Monoxcide</th><th>Carbon Dioxide</th><th>Hydro Carbon</th><th>Nitrogen Oxcide</th><th>HC NOX</th><th>Particulate Matter</th><th>Action</th></tr></thead><tbody>';
            if (!empty($data['records']))
            {
                foreach ($data['records'] as $value)
                {
                    $html .= '<tr><td>'.$i.'</td><td class="text-truncate">' . $value->emission_name . '</td><td>' . $value->segment_name . '</td><td>' . $value->carbon_monoxcide . '</td><td>' . $value->carbon_dioxcide . '</td><td>' . $value->hydro_carbons . '</td><td>' . $value->nitrogen_oxcide . '</td><td>' . $value->hc_nox . '</td><td>' . $value->particulate_matter . '</td><td>'
                            . '<a href="javascript:void(0)" id="m_editbutton" data-bs-toggle="modal" value="'.$value->description_id.'"  data-bs-target="#ModalUpdateEmissionStandard_" class="btn btn-outline-success btn-sm"><i class="fa fa-pencil-alt"></i></a></td>';
                $i++; }
            }
            $html .= '</tbody></table></div><h5>Total Emission Standards: <span class="font-weight-bold">'.$total.'</span></h5>' . $pagelinks;
            $log = array(
                'action' => 'getEmissionStandards',
                'page' => 'Emission Standard Master',
                'record' => 'Get Emission Standard List.',
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
