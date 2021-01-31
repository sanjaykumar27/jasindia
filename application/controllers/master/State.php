<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class State extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Master/State_model');
        $this->load->model('Common_model');
        $this->load->library('pagination');
    }

    public function index()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $data['audit_logs'] = $this->Common_model->getLogs();
            $this->load->view('Master/state_master',$data);
        } else
        {
            redirect('/Auth');
        }
    }

    public function getStates()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $search = array(
                'keyword' => trim($this->input->post('search_key')),
            );
            $limit = 10;
            $offset = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
            $config['base_url'] = site_url('master/state/getStates');
            $config['total_rows'] = $this->State_model->selectAll($limit, $offset, $search, $count = true);
            $config['uri_segment'] = 4;
            $config['num_links'] = 4;
            $this->pagination->initialize($config);
            $data['records'] = $this->State_model->selectAll($limit, $offset, $search, $count = false);
            $pagelinks = $this->pagination->create_links();
            $total = $config['total_rows'];
            $html = '<div class="table-responsive"><table class="table m-table m-table--head-bg-success table-striped "><thead><tr><th>#</th><th>State Name</th><th>Action</th></tr></thead><tbody>';
            if (!empty($data['records']))
            {
//                $page_count  = ($offset) ? $offset : 1;
//                $i =  (($page_count - 1) * $limit) + 1;
                $i = $offset + 1;
                foreach ($data['records'] as $value)
                {
                    $html .= '<tr><td>' . $i . '</td><td>' . $value->state_name . '</td><td class="text-truncate">'
                            . '<a href="javascript:void(0)" id="m_editbutton" data-bs-toggle="modal" value="' . $value->state_id . '"  data-bs-target="#ModalUpdateState" class="btn btn-outline-success btn-sm me-2 px-2"><i class="fa fa-pencil-alt"></i> Edit</a>'
                            . '<button dd-state-name="'.$value->state_name.'" value="' . $value->state_id . '" id="add_district" class="btn btn-outline-primary btn-sm px-2" data-bs-target="#ModalNewDistrict" data-bs-toggle="modal"  data-toggle="m-tooltip" data-skin="dark"  title="Show list of districts" data-original-title="Show list of districts"><i class="far fa-list-alt"></i> Districts</button></td>';
                    $i++;
                }
            }
            $html .= '</tbody></table></div><h5>Total States: <span class="font-weight-bold">' . $total . '</span></h5>' . $pagelinks;
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
                    $cid = $this->Common_model->CommonInsert('m_states',$param);
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

    function getDistricts()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $state_id = $this->input->POST('state_id');
            $data['records'] = $this->State_model->selectAllDistricts($state_id);
            
            $html = '<table class="table table-striped "><thead><tr><th>#</th><th>District Name</th><th>RTO Code</th><th>Action</th></tr></thead><tbody>';
            if (!empty($data['records']))
            {
                $i = 1;
                foreach ($data['records'] as $value)
                {
                    $html .= '<tr><td>' . $i . '</td><td>' . $value->district_name . '</td><td>'.$value->rto_code.'</td><td>'
                            . '<a href="javascript:void(0)" id="m_editdistrictbutton" dd-district-rtocode="'.$value->rto_code.'" dd-district-name="'.$value->district_name.'"  value="' . $value->district_id . '" class="btn px-2 btn-outline-success btn-sm"><i class="fa fa-pencil-alt"></i></a>'
                            . '</td>';
                    $i++;
                }
            } else
            {
                $html .= '<tr><td colspan="3" class="text-center">No District Found!</td></tr></tbody></table>';
            }
            $html .= '</tbody></table>';
            echo $html;
        } else
        {
            redirect('/Auth');
        }
    }

    public function createDistrict()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $userid = $this->session->userdata('sess_user_id');
            $district = $this->input->POST('district_name');
            $rto_code = $this->input->POST('rto_code');
            $state_id = $this->input->POST('state_id');
            $is_exist = $this->State_model->checkDistrictExists(trim($district), '', $state_id);
            if ($is_exist)
            {
                $data = array('code' => 0, 'response' => "This district already exist !");
            } 
            else
            {
                $param = array(
                    'state_id' => $state_id,
                    'rto_code' => $rto_code,
                    'district_name' => ucwords(trim($district)),
                    'created_by' => $userid,
                );
                $cid = $this->Common_model->CommonInsert('m_districts',$param);
                if($cid)
                {
                    $data = array('code' => 1, 'response' => 'District Created succesfully!');
                }
                else
                {
                    $data = array('code' => 0, 'response' => 'Something wrong happened !');
                }
                
            }
            echo json_encode($data);
        } 
        else
        {
            redirect('/Auth');
        }
    }
    
    public function updateDistrict()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $userid = $this->session->userdata('sess_user_id');
            $district = $this->input->POST('district_name');
            $district_id = $this->input->POST('district_id');
            $state_id = $this->input->POST('state_id');
            $rto_code = $this->input->POST('rto_code');
            $is_exist = $this->State_model->checkDistrictExists(trim($district), $district_id, $state_id);
            if ($is_exist)
            {
                $data = array('code' => 3, 'response' => 'This district already exist!');
            } else
            {
                $param = array(
                    'district_name' => ucwords(trim($district)),
                    'rto_code' => $rto_code,
                    'updated_by' => $userid,
                    'updated_on' => date('Y-m-d H:i:s')
                );
                $cid = $this->State_model->updateDistrict($param, $district_id);
                if ($cid != "")
                {
                    $data = array('code' => 1, 'response' => 'District Updated succesfully!');
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
    
    public function allDistricts()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $state_id = $this->input->POST('state_id');
            $data = $this->State_model->listAllDistricts($state_id);
            $html = '<option value="">Select District</option>';
            if (!empty($data))
            {
                $i = 1;
                foreach ($data as $value)
                {
                    $html .= '<option value='.$value->district_id.'>'.$value->district_name.'</option>';
                    $i++;
                }
            } 
            echo $html;
        } else
        {
            redirect('/Auth');
        }
    }
    
    public function allStates()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $data = $this->State_model->listAllStates();
            $html = '<option value="">Select State</option>';
            if (!empty($data))
            {
                $i = 1;
                foreach ($data as $value)
                {
                    $html .= '<option value='.$value->state_id.'>'.$value->state_name.'</option>';
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
