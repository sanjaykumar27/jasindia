<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class InsurerDescription extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->library('pagination');
        $this->load->model('Master/InsurerDescription_model');
    }
    
    public function index()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $data['audit_logs'] = $this->Common_model->getLogs();
            $this->load->view('Master/insurer_description_master', $data);
        } else
        {
            redirect('/Auth');
        }
    }
    
    public function CreateInsurerDescription()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $userid = $this->session->userdata('sess_user_id');
            $insurer_description_name = $this->input->POST('insurer_description_name');
            $registored_address = $this->input->POST('registored_address');
            $website = $this->input->POST('website');
            $email = $this->input->POST('email');
			$is_exist = $this->InsurerDescription_model->checkInsurerDescriptionExist(trim($insurer_description_name),'');
            if ($is_exist)
            {
                $data = array('code' => 3, 'response' => 'This insurer description already exist');
            } else
            {
                $param = array(
                    'insurer_name' => ucwords(trim($insurer_description_name)),
                    'registored_address' => $registored_address,
                    'website' => $website,
                    'email' => $email,
                    'created_by' => $userid,
                );
                $cid = $this->Common_model->CommonInsert('m_insurer_description',$param);
                if ($cid != "")
                {
                    $log = array(
                        'action' => 'CreateInsurerDescription',
                        'page' => 'Insurer Description Master',
                        'record' => 'Create New Insurer Description.',
                        'success' => 'Y',
                        'ip_address' => $_SERVER['REMOTE_ADDR'],
                        'created_by' => $userid,
                    );
                    $this->Common_model->CommonInsert('audit_log',$log);
                    $data = array('code' => 1, 'response' => 'Insurer Description Created succesfully!');
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
    
    public function getInsurerDescriptions()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $userid = $this->session->userdata('sess_user_id');
            $search = array(
                'keyword' => trim($this->input->post('search_key')),
            );
            $limit = 10;
            $offset = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
            $config['base_url'] = site_url('master/InsurerDescription/getInsurerDescriptions');
            $config['total_rows'] = $this->InsurerDescription_model->selectAll($limit, $offset, $search, $count = true);
            $config['uri_segment'] = 4;
            $config['num_links'] = 4;
            $this->pagination->initialize($config);
            $total = $config['total_rows'];
            $data['records'] = $this->InsurerDescription_model->selectAll($limit, $offset, $search, $count = false);
            $pagelinks = $this->pagination->create_links();
            
            $i = $offset + 1;
            $html = '<div class="table-responsive"><table class="table table-striped"><thead><tr><th>#</th><th>Insurer Description</th>'
                    . '<th>Registored Address</th><th>Website</th><th>Email</th><th>Action</th></tr></thead><tbody>';
            if (!empty($data['records']))
            {
                foreach ($data['records'] as $value)
                {
                    $html .= '<tr><td>'.$i.'</td><td class="text-truncate">' . $value->insurer_name . '</td><td>' . $value->registored_address . '</td><td>' . $value->website . '</td><td>' . $value->email . '</td><td class="text-truncate">'
                            . '<a href="javascript:void(0)" id="m_editbutton" data-bs-toggle="modal" value="'.$value->description_id.'"  data-bs-target="#ModalUpdateInsurerDescription" class=" btn btn-outline-success btn-sm"><i class="fa fa-pencil-alt"></i> Edit</a>
                            <button dd-insurer-name="'.$value->insurer_name.'" value="' . $value->description_id . '" id="add_branch" class="btn btn-outline-primary btn-sm " data-bs-target="#ModalNewBranch" data-bs-toggle="modal"  title="Show list of branches" data-original-title="Show list of branches"><i class="far fa-list-alt"></i> Branches</button></td>';
                $i++; }
            }
            $html .= '</tbody></table></div><h5>Total Insurer Description: <span class="font-weight-bold">'.$total.'</span></h5>' . $pagelinks;
            $log = array(
                'action' => 'getInsurerDescriptions',
                'page' => 'Insurer Description Master',
                'record' => 'Get Insurer Description List.',
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
            $insurer_description_id = $this->input->POST('insurer_description_id');
            $insurer_description_name = $this->input->POST('insurer_description_name');
            $registored_address = $this->input->POST('registored_address');
            $website = $this->input->POST('website');
            $email = $this->input->POST('email');

            $is_exist = $this->InsurerDescription_model->checkInsurerDescriptionExist(trim($insurer_description_name),$insurer_description_id);
            if ($is_exist)
            {
                $data = array('code' => 3, 'response' => 'This Insurer Description already exist!');
            } else
            {
                $param = array(
                    'insurer_name' => ucwords(trim($insurer_description_name)),
                    'registored_address' => $registored_address,
                    'website' => $website,
                    'email' => $email,
                    'updated_by' => $userid,
                    'updated_on' => date('Y-m-d H:i:s')
                );
                $cid = $this->InsurerDescription_model->updateInsurerDescription($param, $insurer_description_id);
                if ($cid != "")
                {
                    $log = array(
                        'action' => 'Update',
                        'page' => 'Insurer Description Master',
                        'record' => 'Updated Insurer Description.',
                        'success' => 'Y',
                        'ip_address' => $_SERVER['REMOTE_ADDR'],
                        'created_by' => $userid,
                    );
                    $this->Common_model->CommonInsert('audit_log',$log);
                    $data = array('code' => 1, 'response' => 'Insurer Description Updated succesfully!');
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
            $insurer_description_id = $this->input->post('edit_id');
            $records = $this->InsurerDescription_model->GetInsurerDescriptionDetails($insurer_description_id);
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

    public function getBranch()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $insurer_id = $this->input->POST('insurer_id');
            $data['records'] = $this->InsurerDescription_model->selectAllBranches($insurer_id);
            
            $html = '<table class="table table-striped "><thead><tr><th>#</th><th>Branch Code</th><th>City</th><th>Email</th><th>Address</th><th>Action</th></tr></thead><tbody>';
            if (!empty($data['records']))
            {
                $i = 1;
                foreach ($data['records'] as $value)
                {
                    $html .= '<tr><td>' . $i . '</td><td>' . $value->branch_code . '</td><td>'.$value->city_name.'</td><td>'.$value->email.'</td><td>'.$value->address.'</td><td>'
                            . '<a href="javascript:void(0)" id="m_editbranchbutton" dd-branch-rtocode="'.$value->email.'" dd-branch-name="'.$value->branch_code.'"  value="' . $value->branch_id . '" class="btn  btn-outline-success btn-sm"><i class="fa fa-pencil-alt"></i></a>'
                            . '</td>';
                    $i++;
                }
            } else
            {
                $html .= '<tr><td colspan="6" class="text-center">No Branch Found!</td></tr></tbody></table>';
            }
            $html .= '</tbody></table>';
            echo $html;
        } else
        {
            redirect('/Auth');
        }
    }

    public function createBranch()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $userid = $this->session->userdata('sess_user_id');
            $branch = $this->input->POST('branch_code');
            $city_id = $this->input->POST('city_id');
            $insurer_id = $this->input->POST('insurer_id');
            $email = $this->input->POST('email');
            $address = $this->input->POST('address');
            
            $param = array(
                'city_id' => $city_id,
                'insurer_id' => $insurer_id,
                'address' => ucwords(trim($address)),
                'email' => ucwords(trim($email)),
                'branch_code' => ucwords(trim($branch)),
                'created_by' => $userid,
            );

            $cid = $this->Common_model->CommonInsert('m_insurer_branch',$param);
            if($cid)
            {
                $data = array('code' => 1, 'response' => 'Branch Created succesfully!');
            }
            else
            {
                $data = array('code' => 0, 'response' => 'Something wrong happened !');
            }
            echo json_encode($data);
        } 
        else
        {
            redirect('/Auth');
        }
    }
    
    public function updateBranch()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $userid = $this->session->userdata('sess_user_id');
            $branch_code = $this->input->POST('branch_code');
            $branch_id = $this->input->POST('branch_id');
            $city_id = $this->input->POST('city_id');
            $email = $this->input->POST('email');
            $address = $this->input->POST('address');
            
            $param = array(
                'branch_code' => ucwords(trim($branch_code)),
                'email' => $email,
                'address' => $address,
                'city_id' => $city_id,
                'updated_by' => $userid,
                'updated_on' => date('Y-m-d H:i:s')
            );
            $cid = $this->InsurerDescription_model->updateBranch($param, $branch_id);
            if ($cid != "")
            {
                $data = array('code' => 1, 'response' => 'Branch Updated succesfully!');
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

    public function allCities()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $data = $this->InsurerDescription_model->listAllCities();
            $html = '<option value="">Select City</option>';
            if (!empty($data))
            {
                $i = 1;
                foreach ($data as $value)
                {
                    $html .= '<option value='.$value->city_id.'>'.$value->city_name.'</option>';
                    $i++;
                }
            } 
            echo $html;
        } else
        {
            redirect('/Auth');
        }
    }

    public function getBranchDetails()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $branch_id = $this->input->POST('branch_id');
            $record = $this->InsurerDescription_model->getBranchDetails($branch_id);
            $data = array($record[0]);
            echo json_encode($data);
        } else
        {
            redirect('/Auth');
        }
    }
}
