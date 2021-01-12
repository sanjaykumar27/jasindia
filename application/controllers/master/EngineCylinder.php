<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class EngineCylinder extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->library('pagination');
        $this->load->model('Master/EngineCylinder_model');
    }
    
    public function index()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $this->load->view('Master/engine_cylinder_master');
        } else
        {
            redirect('/Auth');
        }
    }
    
    public function CreateEngineCylinder()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $userid = $this->session->userdata('sess_user_id');
            $engine_cylinder_name = $this->input->POST('engine_cylinder_name');
			$is_exist = $this->EngineCylinder_model->checkEngineCylinderExist(trim($engine_cylinder_name),'');
            if ($is_exist)
            {
                $data = array('code' => 3, 'response' => 'This engine_cylinder already exist');
            } else
            {
                $param = array(
                    'engine_cylinder_name' => ucwords(trim($engine_cylinder_name)),
                    'created_by' => $userid,
                );
                $cid = $this->Common_model->CommonInsert('m_engine_cylinder',$param);
                if ($cid != "")
                {
                    $data = array('code' => 1, 'response' => 'Engine Cylinder Created succesfully!');
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
    
    public function getEngineCylinders()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $search = array(
                'keyword' => trim($this->input->post('search_key')),
            );
            $limit = 10;
            $offset = ($this->uri->segment(3)) ? $this->uri->segment(4) : 0;
            $config['base_url'] = site_url('engine_cylinder/getEngineCylinders');
            $config['total_rows'] = $this->EngineCylinder_model->selectAll($limit, $offset, $search, $count = true);
            $config['uri_segment'] = 3;
            $config['num_links'] = 3;
            $this->pagination->initialize($config);
            $total = $config['total_rows'];
            $data['records'] = $this->EngineCylinder_model->selectAll($limit, $offset, $search, $count = false);
            $pagelinks = $this->pagination->create_links();
            
            $i = $offset + 1;
            $html = '<div class="table-responsive"><table class="table m-table m-table--head-bg-success table-striped"><thead><tr><th>#</th><th>Engine Cylinder Name</th>'
                    . '<th>Action</th></tr></thead><tbody>';
            if (!empty($data['records']))
            {
                foreach ($data['records'] as $value)
                {
                    $html .= '<tr><td>'.$i.'</td><td class="text-truncate">' . $value->engine_cylinder_name . '</td><td>'
                            . '<a href="javascript:void(0)" id="m_editbutton" data-toggle="modal" value="'.$value->engine_cylinder_id.'"  data-target="#ModalUpdateEngineCylinder" class="btn m-btn--pill btn-outline-success btn-sm"><i class="fa fa-pencil-alt"></i> Edit</a></td>';
                $i++; }
            }
            $html .= '</tbody></table></div><h5>Total Engine Cylinders: <span class="font-weight-bold">'.$total.'</span></h5>' . $pagelinks;
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
            $engine_cylinder_id = $this->input->POST('engine_cylinder_id');
            $engine_cylinder_name = $this->input->POST('engine_cylinder_name');
            $is_exist = $this->EngineCylinder_model->checkEngineCylinderExist(trim($engine_cylinder_name),$engine_cylinder_id);
            if ($is_exist)
            {
                $data = array('code' => 3, 'response' => 'This EngineCylinder already exist!');
            } else
            {
                $param = array(
                    'engine_cylinder_name' => ucwords(trim($engine_cylinder_name)),
                    'updated_by' => $userid,
                    'updated_on' => date('Y-m-d H:i:s')
                );
                $cid = $this->EngineCylinder_model->updateEngineCylinder($param, $engine_cylinder_id);
                if ($cid != "")
                {
                    $data = array('code' => 1, 'response' => 'Engine Cylinder Updated succesfully!');
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
            $engine_cylinder_id = $this->input->post('edit_id');
            $records = $this->EngineCylinder_model->GetEngineCylinderDetails($engine_cylinder_id);
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
