<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ExclusionMapping extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->library('pagination');
        $this->load->model('Master/ExclusionMapping_model');
    }
    
    public function index()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $this->load->view('Master/exclusion_mapping_master');
        } else
        {
            redirect('/Auth');
        }
    }

    function getHeadings()
    {
        $category_id = $this->input->POST('category_id');
        $data = $this->ExclusionMapping_model->getAllHeadings($category_id);
            $html = '<option value="">Select Heading</option>';
            if (!empty($data))
            {
                $i = 1;
                foreach ($data as $value)
                {
                    $html .= '<option value='.$value->exclusion_heading_id.'>'.$value->exclusion_heading.'</option>';
                    $i++;
                }
            } 
        echo $html;
    }

    public function CreateMapping()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $userid = $this->session->userdata('sess_user_id');
            $selectInsurer = $this->input->POST('selectInsurer');
            $selectVehicleSegment = $this->input->POST('selectVehicleSegment');
            $selectCategory = $this->input->POST('selectCategory');
            $selectHeading = $this->input->POST('selectHeading');
            $param = array(
                'insurer_id' => $selectInsurer,
                'vehicle_segment_id' => $selectVehicleSegment,
                'insurer_category_id' => $selectCategory,
                'heading_id' => $selectHeading,
                'created_by' => $userid,
            );
            $cid = $this->Common_model->CommonInsert('m_insurer_exclusion_mapping',$param);
            if ($cid != "")
            {
                $log = array(
                    'action' => 'CreateMapping',
                    'page' => 'Exclusion Mapping Master',
                    'record' => 'Create New Exclusion Mapping.',
                    'success' => 'Y',
                    'ip_address' => $_SERVER['REMOTE_ADDR'],
                    'created_by' => $userid,
                );
                $this->Common_model->CommonInsert('audit_log',$log);
                $data = array('code' => 1, 'response' => 'Exclusion Mapping Created succesfully!');
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

    public function getExclusionMapping()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $search = array(
                'keyword' => trim($this->input->post('search_key')),
            );
            $limit = 10;
            $offset = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
            $config['base_url'] = site_url('master/ExclusionMapping/getExclusionMapping');
            $config['total_rows'] = $this->ExclusionMapping_model->selectAll($limit, $offset, $search, $count = true);
            $config['uri_segment'] = 4;
            $config['num_links'] = 4;
            $this->pagination->initialize($config);
            $total = $config['total_rows'];
            $data['records'] = $this->ExclusionMapping_model->selectAll($limit, $offset, $search, $count = false);
            $pagelinks = $this->pagination->create_links();
            
            $i = $offset + 1;
            $html = '<div class="table-responsive"><table class="table m-table m-table--head-bg-success table-striped"><thead><tr><th>#</th><th>Insurer</th>'
                    . '<th>Vehicle Segment</th><th>Heading</th><th>Category</th><th>Action</th></tr></thead><tbody>';
            if (!empty($data['records']))
            {
                foreach ($data['records'] as $value)
                {
                    $html .= '<tr><td>'.$i.'</td><td class="text-truncate">' . $value->insurer_name . '</td><td class="text-truncate">' . $value->segment_name . '</td><td class="text-truncate">' . $value->exclusion_category . '</td><td class="text-truncate">' . $value->exclusion_heading . '</td><td>'
                            . '<a href="javascript:void(0)" id="m_editbutton" data-bs-toggle="modal" value="'.$value->mapping_id.'"  data-bs-target="#ModalUpdateEngine" class="btn btn-outline-success btn-sm"><i class="fa fa-pencil-alt"></i></a></td>';
                $i++; }
            }
            $html .= '</tbody></table></div><h5>Total Engines: <span class="font-weight-bold">'.$total.'</span></h5>' . $pagelinks;
            echo $html;
        } else
        {
            redirect('/Auth');
        }
    }
}
