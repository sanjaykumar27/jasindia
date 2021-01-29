<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class EmissionStandard extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->library('pagination');
        $this->load->model('Master/EmissionStandard_model');
    }
    
    public function index()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $data['audit_logs'] = $this->Common_model->getLogs();
            $this->load->view('Master/emission_standard_master', $data);
        } else
        {
            redirect('/Auth');
        }
    }
    
    public function CreateEmissionStandard()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $userid = $this->session->userdata('sess_user_id');
            $emission_standard_name = $this->input->POST('emission_standard_name');
            $from_date = $this->input->POST('from_date');
            $to_date = $this->input->POST('to_date');
			$is_exist = $this->EmissionStandard_model->checkEmissionStandardExist(trim($emission_standard_name),'');
            if ($is_exist)
            {
                $data = array('code' => 3, 'response' => 'This emission_standard already exist');
            } else
            {
                $param = array(
                    'emission_name' => ucwords(trim($emission_standard_name)),
                    'from_date' => $from_date,
                    'to_date' => $to_date,
                    'created_by' => $userid,
                );
                $cid = $this->Common_model->CommonInsert('m_emission_standard',$param);
                if ($cid != "")
                {
                    $log = array(
                        'action' => 'CreateEmissionStandard',
                        'page' => 'Emission Standard Master',
                        'record' => 'Create New Emission Standard.',
                        'success' => 'Y',
                        'ip_address' => $_SERVER['REMOTE_ADDR'],
                        'created_by' => $userid,
                    );
                    $this->Common_model->CommonInsert('audit_log',$log);
                    $data = array('code' => 1, 'response' => 'Emission Standard Created succesfully!');
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
    
    public function getEmissionStandards()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $userid = $this->session->userdata('sess_user_id');
            $search = array(
                'keyword' => trim($this->input->post('search_key')),
            );
            $limit = 10;
            $offset = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
            $config['base_url'] = site_url('master/EmissionStandard/getEmissionStandards');
            $config['total_rows'] = $this->EmissionStandard_model->selectAll($limit, $offset, $search, $count = true);
            $config['uri_segment'] = 4;
            $config['num_links'] = 4;
            $this->pagination->initialize($config);
            $total = $config['total_rows'];
            $data['records'] = $this->EmissionStandard_model->selectAll($limit, $offset, $search, $count = false);
            $pagelinks = $this->pagination->create_links();
            
            $i = $offset + 1;
            $html = '<div class="table-responsive"><table class="table m-table m-table--head-bg-success table-striped"><thead><tr><th>#</th><th>Emission Standard</th>'
                    . '<th>From Date</th><th>To Date</th><th>Action</th></tr></thead><tbody>';
            if (!empty($data['records']))
            {
                foreach ($data['records'] as $value)
                {
                    $html .= '<tr><td>'.$i.'</td><td class="text-truncate">' . $value->emission_name . '</td><td>' . $value->from_date . '</td><td>' . $value->to_date . '</td><td>'
                            . '<a href="javascript:void(0)" id="m_editbutton" data-bs-toggle="modal" value="'.$value->emission_id.'"  data-bs-target="#ModalUpdateEmissionStandard" class="btn px-2 btn-outline-success btn-sm"><i class="fa fa-pencil-alt"></i></a></td>';
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
    
    function update()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $userid = $this->session->userdata('sess_user_id');
            $emission_standard_id = $this->input->POST('emission_standard_id');
            $emission_standard_name = $this->input->POST('emission_standard_name');
            $from_date = $this->input->POST('from_date');
            $to_date = $this->input->POST('to_date');

            $is_exist = $this->EmissionStandard_model->checkEmissionStandardExist(trim($emission_standard_name),$emission_standard_id);
            if ($is_exist)
            {
                $data = array('code' => 3, 'response' => 'This Emission Standard already exist!');
            } else
            {
                $param = array(
                    'emission_name' => ucwords(trim($emission_standard_name)),
                    'from_date' => $from_date,
                    'to_date' => $to_date,
                    'updated_by' => $userid,
                    'updated_on' => date('Y-m-d H:i:s')
                );
                $cid = $this->EmissionStandard_model->updateEmissionStandard($param, $emission_standard_id);
                if ($cid != "")
                {
                    $log = array(
                        'action' => 'Update',
                        'page' => 'Emission Standard Master',
                        'record' => 'Updated Emission Standard.',
                        'success' => 'Y',
                        'ip_address' => $_SERVER['REMOTE_ADDR'],
                        'created_by' => $userid,
                    );
                    $this->Common_model->CommonInsert('audit_log',$log);
                    $data = array('code' => 1, 'response' => 'Emission Standard Updated succesfully!');
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
            $emission_standard_id = $this->input->post('edit_id');
            $records = $this->EmissionStandard_model->GetEmissionStandardDetails($emission_standard_id);
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
