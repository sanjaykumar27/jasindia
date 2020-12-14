<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class State extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Master/State_model');
        $this->load->library('pagination');
    }

    public function index()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $this->load->view('Master/state_master');
        } else
        {
            redirect('/Auth');
        }
    }

    public function list()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $search = array(
                'keyword' => trim($this->input->post('search_key')),
            );
            $limit = 10;
            $offset = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
            $config['base_url'] = site_url('master/state/list');
            $config['total_rows'] = $this->State_model->selectAll($limit, $offset, $search, $count = true);
            $config['uri_segment'] = 4;
            $config['num_links'] = 4;
            $this->pagination->initialize($config);
            $data['records'] = $this->State_model->selectAll($limit, $offset, $search, $count = false);
            $pagelinks = $this->pagination->create_links();
            $html = '<table class="table m-table m-table--head-bg-success"><thead><tr><th>#</th><th>State Name</th><th>Action</th></tr></thead><tbody>';
            if (!empty($data['records']))
            {
                $i = 1;
                foreach ($data['records'] as $value)
                {
                    $html .= '<tr><td>'.$i.'</td><td>' . $value->state_name . '</td><td>'
                            . '<a href="javascript:void(0)" id="m_editbutton" data-toggle="modal" value="'.$value->state_id.'"  data-target="#ModalUpdateState" class="btn m-btn--pill btn-success">Edit </a></td>';
                $i++; }
            }
            $html .= '</tbody></table>' . $pagelinks;
            echo $html;
        } else
        {
            redirect('/Auth');
        }
    }

    public function create()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $states_exist = array();
            $cid = '';
            $userid = $this->session->userdata('sess_user_id');
            $states = $this->input->POST('state_name');
            $sCount = count($states);
            foreach ($states as $val)
            {
                $is_exist = $this->State_model->checkStateExists(trim($val), '');
                if ($is_exist)
                {
                    $states_exist[] = trim($val);
                } else
                {
                    $param = array(
                        'state_name' => ucwords(trim($val)),
                        'created_by' => $userid,
                    );
                    $cid = $this->State_model->createState($param);
                }
            }

            if ($cid != "")
            {
                if (count($states_exist) > 1 && count($states_exist) != $sCount)
                {
                    $st = implode(', ', $states_exist);
                    $data = array('code' => 1, 'response' => "State Created succesfully! These states already exist: $st");
                } else
                {
                    $data = array('code' => 1, 'response' => 'State Created succesfully!');
                }
            } else
            {
                if ($sCount == count($states_exist))
                {
                    $data = array('code' => 3, 'response' => 'No State Inserted! All Exist');
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
            $state_id = $this->input->post('edit_id');
            $records = $this->State_model->GetStateName($state_id);
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
            $state = $this->input->POST('state_name');
            $state_id = $this->input->POST('state_id');
            $is_exist = $this->State_model->checkStateExists(trim($state), $state_id);
            if ($is_exist)
            {
                $data = array('code' => 3, 'response' => 'This state already exist!');
            } else
            {
                $param = array(
                    'state_name' => ucwords(trim($state)),
                    'updated_by' => $userid,
                    'updated_on' => date('Y-m-d H:i:s')
                );
                $cid = $this->State_model->updateState($param, $state_id);
                if ($cid != "")
                {
                    $data = array('code' => 1, 'response' => 'State Updated succesfully!');
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
