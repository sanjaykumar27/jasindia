<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class BodyType extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->library('pagination');
        $this->load->model('Master/BodyType_model');
    }
    
    public function index()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $data['audit_logs'] = $this->Common_model->getLogs();
            $this->load->view('Master/body_type_master', $data);
        } else
        {
            redirect('/Auth');
        }
    }
    
    public function CreateBodyType()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $userid = $this->session->userdata('sess_user_id');
            $body_type_name = $this->input->POST('body_type_name');
			$is_exist = $this->BodyType_model->checkBodyTypeExist(trim($body_type_name),'');
            if ($is_exist)
            {
                $data = array('code' => 3, 'response' => 'This Body Type already exist');
            } else
            {
                $param = array(
                    'body_type_name' => ucwords(trim($body_type_name)),
                    'created_by' => $userid,
                );
                $cid = $this->Common_model->CommonInsert('m_body_type',$param);
                if ($cid != "")
                {
                    $log = array(
                        'action' => 'CreateBodyType',
                        'page' => 'Body Type Description Master',
                        'record' => 'Create New Body Type Description.',
                        'success' => 'Y',
                        'ip_address' => $_SERVER['REMOTE_ADDR'],
                        'created_by' => $userid,
                    );
                    $this->Common_model->CommonInsert('audit_log',$log);
                    $data = array('code' => 1, 'response' => 'Body Type Description Created succesfully!');
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
    
    public function getBodyTypes()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $userid = $this->session->userdata('sess_user_id');
            $search = array(
                'keyword' => trim($this->input->post('search_key')),
            );
            $limit = 10;
            $offset = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
            $config['base_url'] = site_url('master/BodyType/getBodyTypes');
            $config['total_rows'] = $this->BodyType_model->selectAll($limit, $offset, $search, $count = true);
            $config['uri_segment'] = 4;
            $config['num_links'] = 4;
            $this->pagination->initialize($config);
            $total = $config['total_rows'];
            $data['records'] = $this->BodyType_model->selectAll($limit, $offset, $search, $count = false);
            $pagelinks = $this->pagination->create_links();
            
            $i = $offset + 1;
            $html = '<div class="table-responsive"><table class="table m-table m-table--head-bg-success table-striped"><thead><tr><th>#</th><th>Body Type Description</th>'
                    . '<th>Action</th></tr></thead><tbody>';
            if (!empty($data['records']))
            {
                foreach ($data['records'] as $value)
                {
                    $html .= '<tr><td>'.$i.'</td><td class="text-truncate">' . $value->body_type_name . '</td><td>'
                            . '<a href="javascript:void(0)" id="m_editbutton" data-bs-toggle="modal" value="'.$value->body_type_id.'"  data-target="#ModalUpdateBodyType" class="btn m-btn--pill btn-outline-success btn-sm"><i class="fa fa-pencil-alt"></i> Edit</a></td>';
                $i++; }
            }
            $html .= '</tbody></table></div><h5>Total Body Type Descriptions: <span class="font-weight-bold">'.$total.'</span></h5>' . $pagelinks;
            $log = array(
                'action' => 'getBodyTypes',
                'page' => 'Body Type Description Master',
                'record' => 'Get Body Type Description List.',
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
            $body_type_id = $this->input->POST('body_type_id');
            $body_type_name = $this->input->POST('body_type_name');

            $is_exist = $this->BodyType_model->checkBodyTypeExist(trim($body_type_name),$body_type_id);
            if ($is_exist)
            {
                $data = array('code' => 3, 'response' => 'This Body Type Description already exist!');
            } else
            {
                $param = array(
                    'body_type_name' => ucwords(trim($body_type_name)),
                    'updated_by' => $userid,
                    'updated_on' => date('Y-m-d H:i:s')
                );
                $cid = $this->BodyType_model->updateBodyType($param, $body_type_id);
                if ($cid != "")
                {
                    $log = array(
                        'action' => 'Update',
                        'page' => 'Body Type Description Master',
                        'record' => 'Updated Body Type Description.',
                        'success' => 'Y',
                        'ip_address' => $_SERVER['REMOTE_ADDR'],
                        'created_by' => $userid,
                    );
                    $this->Common_model->CommonInsert('audit_log',$log);
                    $data = array('code' => 1, 'response' => 'Body Type Description Updated succesfully!');
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
            $body_type_id = $this->input->post('edit_id');
            $records = $this->BodyType_model->GetBodyTypeDetails($body_type_id);
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
