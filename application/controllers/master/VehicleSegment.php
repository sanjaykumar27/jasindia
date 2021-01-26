<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class VehicleSegment extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->library('pagination');
        $this->load->model('Master/VehicleSegment_model');
    }
    
    public function index()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $data['audit_logs'] = $this->Common_model->getLogs();
            $this->load->view('Master/vehicle_segment_master', $data);
        } else
        {
            redirect('/Auth');
        }
    }
    
    public function CreateVehicleSegment()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $userid = $this->session->userdata('sess_user_id');
            $vehicle_segment_name = $this->input->POST('vehicle_segment_name');
			$is_exist = $this->VehicleSegment_model->checkVehicleSegmentExist(trim($vehicle_segment_name),'');
            if ($is_exist)
            {
                $data = array('code' => 3, 'response' => 'This vehicle_segment already exist');
            } else
            {
                $param = array(
                    'segment_name' => ucwords(trim($vehicle_segment_name)),
                    'created_by' => $userid,
                );
                $cid = $this->Common_model->CommonInsert('m_vehicle_segment',$param);
                if ($cid != "")
                {
                    $log = array(
                        'action' => 'CreateVehicleSegment',
                        'page' => 'Vehicle Segment Master',
                        'record' => 'Create New Vehicle Segment.',
                        'success' => 'Y',
                        'ip_address' => $_SERVER['REMOTE_ADDR'],
                        'created_by' => $userid,
                    );
                    $this->Common_model->CommonInsert('audit_log',$log);
                    $data = array('code' => 1, 'response' => 'Vehicle Segment Created succesfully!');
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
    
    public function getVehicleSegments()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $userid = $this->session->userdata('sess_user_id');
            $search = array(
                'keyword' => trim($this->input->post('search_key')),
            );
            $limit = 10;
            $offset = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
            $config['base_url'] = site_url('master/VehicleSegment/getVehicleSegments');
            $config['total_rows'] = $this->VehicleSegment_model->selectAll($limit, $offset, $search, $count = true);
            $config['uri_segment'] = 4;
            $config['num_links'] = 4;
            $this->pagination->initialize($config);
            $total = $config['total_rows'];
            $data['records'] = $this->VehicleSegment_model->selectAll($limit, $offset, $search, $count = false);
            $pagelinks = $this->pagination->create_links();
            
            $i = $offset + 1;
            $html = '<div class="table-responsive"><table class="table m-table m-table--head-bg-success table-striped"><thead><tr><th>#</th><th>Vehicle Segment</th>'
                    . '<th>Action</th></tr></thead><tbody>';
            if (!empty($data['records']))
            {
                foreach ($data['records'] as $value)
                {
                    $html .= '<tr><td>'.$i.'</td><td class="text-truncate">' . $value->segment_name . '</td><td>'
                            . '<a href="javascript:void(0)" id="m_editbutton" data-bs-toggle="modal" value="'.$value->segment_id.'"  data-target="#ModalUpdateVehicleSegment" class="btn m-btn--pill btn-outline-success btn-sm"><i class="fa fa-pencil-alt"></i> Edit</a></td>';
                $i++; }
            }
            $html .= '</tbody></table></div><h5>Total Vehicle Segments: <span class="font-weight-bold">'.$total.'</span></h5>' . $pagelinks;
            $log = array(
                'action' => 'getVehicleSegments',
                'page' => 'Vehicle Segment Master',
                'record' => 'Get Vehicle Segment List.',
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
            $vehicle_segment_id = $this->input->POST('vehicle_segment_id');
            $vehicle_segment_name = $this->input->POST('vehicle_segment_name');
            $is_exist = $this->VehicleSegment_model->checkVehicleSegmentExist(trim($vehicle_segment_name),$vehicle_segment_id);
            if ($is_exist)
            {
                $data = array('code' => 3, 'response' => 'This Vehicle Segment already exist!');
            } else
            {
                $param = array(
                    'segment_name' => ucwords(trim($vehicle_segment_name)),
                    'updated_by' => $userid,
                    'updated_on' => date('Y-m-d H:i:s')
                );
                $cid = $this->VehicleSegment_model->updateVehicleSegment($param, $vehicle_segment_id);
                if ($cid != "")
                {
                    $log = array(
                        'action' => 'update',
                        'page' => 'Vehicle Segment Master',
                        'record' => 'Vehicle Segment Updated.',
                        'success' => 'Y',
                        'ip_address' => $_SERVER['REMOTE_ADDR'],
                        'created_by' => $userid,
                    );
                    $this->Common_model->CommonInsert('audit_log',$log);
                    $data = array('code' => 1, 'response' => 'Vehicle Segment Updated succesfully!');
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
            $vehicle_segment_id = $this->input->post('edit_id');
            $records = $this->VehicleSegment_model->GetVehicleSegmentDetails($vehicle_segment_id);
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
