<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class InsuranceExclusion extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->library('pagination');
        $this->load->model('Master/InsuranceExclusion_model');
    }
    
    public function index()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $data['audit_logs'] = $this->Common_model->getLogs();
            $this->load->view('Master/insurance_exclusion_master', $data);
        } else
        {
            redirect('/Auth');
        }
    }
    
    public function CreateInsuranceExclusion()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $userid = $this->session->userdata('sess_user_id');
            $exclusion_category = $this->input->POST('exclusion_category');
			$is_exist = $this->InsuranceExclusion_model->checkInsuranceExclusionExist(trim($exclusion_category),'');
            if ($is_exist)
            {
                $data = array('code' => 3, 'response' => 'This Exclusion category already exist');
            } else
            {
                $param = array(
                    'exclusion_category' => trim($exclusion_category),
                    'created_by' => $userid,
                );
                $cid = $this->Common_model->CommonInsert('m_insurance_exclusion',$param);
                if ($cid != "")
                {
                    $log = array(
                        'action' => 'CreateInsuranceExclusion',
                        'page' => 'Exclusion category Master',
                        'record' => 'Create New Exclusion category .',
                        'success' => 'Y',
                        'ip_address' => $_SERVER['REMOTE_ADDR'],
                        'created_by' => $userid,
                    );
                    $this->Common_model->CommonInsert('audit_log',$log);
                    $data = array('code' => 1, 'response' => 'Exclusion category Created succesfully!');
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
    
    public function getInsuranceExclusions()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $userid = $this->session->userdata('sess_user_id');
            $search = array(
                'keyword' => trim($this->input->post('search_key')),
            );
            $limit = 10;
            $offset = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
            $config['base_url'] = site_url('master/InsuranceExclusion/getInsuranceExclusions');
            $config['total_rows'] = $this->InsuranceExclusion_model->selectAll($limit, $offset, $search, $count = true);
            $config['uri_segment'] = 4;
            $config['num_links'] = 4;
            $this->pagination->initialize($config);
            $total = $config['total_rows'];
            $data['records'] = $this->InsuranceExclusion_model->selectAll($limit, $offset, $search, $count = false);
            $pagelinks = $this->pagination->create_links();
            
            $i = $offset + 1;
            $html = '<div class="table-responsive"><table class="table m-table m-table--head-bg-success table-striped"><thead><tr><th>#</th><th>Exclusion category </th>'
                    . '<th>Action</th></tr></thead><tbody>';
            if (!empty($data['records']))
            {
                foreach ($data['records'] as $value)
                {
                    $html .= '<tr><td>'.$i.'</td><td>' . $value->exclusion_category . '</td><td class="text-truncate">'
                            . '<a href="javascript:void(0)" id="m_editbutton" data-bs-toggle="modal" value="'.$value->exclusion_id.'"  data-bs-target="#ModalUpdateInsuranceExclusion" class="btn  btn-outline-success btn-sm"><i class="fa fa-pencil-alt"></i></a>
                            <button  value="' . $value->exclusion_id . '" id="add_description" class="btn btn-outline-primary btn-sm " data-bs-target="#ModalNewMapping" data-bs-toggle="modal"  title="Company Vehicle Mappin" data-original-title="Exclusion Heading"><i class="far fa-list-alt"></i> Headings</button></td>';
                $i++; }
            }
            $html .= '</tbody></table></div><h5>Total Exclusion categorys: <span class="font-weight-bold">'.$total.'</span></h5>' . $pagelinks;
            $log = array(
                'action' => 'getInsuranceExclusions',
                'page' => 'Exclusion category  Master',
                'record' => 'Get Exclusion category  List.',
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
            $exclusion_id = $this->input->POST('exclusion_id');
            $exclusion_category = $this->input->POST('exclusion_category');

            $is_exist = $this->InsuranceExclusion_model->checkInsuranceExclusionExist(trim($exclusion_category),$exclusion_id);
            if ($is_exist)
            {
                $data = array('code' => 3, 'response' => 'This Exclusion category  already exist!');
            } else
            {
                $param = array(
                    'exclusion_category' => trim($exclusion_category),
                    'updated_by' => $userid,
                    'updated_on' => date('Y-m-d H:i:s')
                );
                $cid = $this->InsuranceExclusion_model->updateInsuranceExclusion($param, $exclusion_id);
                if ($cid != "")
                {
                    $log = array(
                        'action' => 'Update',
                        'page' => 'Exclusion category Master',
                        'record' => 'Updated Exclusion category .',
                        'success' => 'Y',
                        'ip_address' => $_SERVER['REMOTE_ADDR'],
                        'created_by' => $userid,
                    );
                    $this->Common_model->CommonInsert('audit_log',$log);
                    $data = array('code' => 1, 'response' => 'Exclusion category  Updated succesfully!');
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
            $exclusion_id = $this->input->post('edit_id');
            $records = $this->InsuranceExclusion_model->GetInsuranceExclusionDetails($exclusion_id);
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

    function AllDescriptions()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $exclusion_id = $this->input->POST('exclusion_id');
            $data['records'] = $this->InsuranceExclusion_model->selectAllDescriptions($exclusion_id);
            //echo '<pre>';print_r($data);die;
            $html = '<table class="table table-striped "><thead><tr><th>#</th><th>Heading</th><th>Description</th><th>Action</th></tr></thead><tbody>';
            if (!empty($data['records'][0]))
            {
                $i = 1;
                foreach ($data['records'] as $value)
                {
                    $html .= '<tr><td>' . $i . '</td><td>' . $value->exclusion_heading . '</td><td>'.$value->exclusion_explaination.'</td><td>'
                            . '<a href="javascript:void(0)" id="m_editbranchbutton"  value="' . $value->exclusion_heading_id . '" class="btn  btn-outline-success btn-sm"><i class="fa fa-pencil-alt"></i></a>'
                            . '</td>';
                    $i++;
                }
            } else
            {
                $html .= '<tr><td colspan="6" class="text-center">No Description Found!</td></tr></tbody></table>';
            }
            $html .= '</tbody></table>';
            echo $html;
        } else
        {
            redirect('/Auth');
        }
    }

    function CreateInsuranceDescription(){
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $userid = $this->session->userdata('sess_user_id');
            $exclusion_category_id = $this->input->POST('exclusion_category_id');
            $exclusion_heading = $this->input->POST('exclusion_heading');
            $description = $this->input->POST('description');
			$param = array(
                'exclusion_category_id' => $exclusion_category_id,
                'exclusion_heading' => $exclusion_heading,
                'exclusion_explaination' => $description,
                'created_by' => $userid,
            );
            $cid = $this->Common_model->CommonInsert('m_insurance_exclusion_heading',$param);
            if ($cid != "")
            {
                $log = array(
                    'action' => 'CreateInsuranceDescription',
                    'page' => 'Exclusion category Description Master',
                    'record' => 'Create New Exclusion category Description.',
                    'success' => 'Y',
                    'ip_address' => $_SERVER['REMOTE_ADDR'],
                    'created_by' => $userid,
                );
                $this->Common_model->CommonInsert('audit_log',$log);
                $data = array('code' => 1, 'response' => 'Exclusion category Description Created succesfully!');
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

    function getExclusionDetails()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $exclusion_mapping_id = $this->input->POST('exclusion_mapping_id');
            $record = $this->InsuranceExclusion_model->getExclustionDetails($exclusion_mapping_id);
            $data = array($record[0]);
            echo json_encode($data);
        } else
        {
            redirect('/Auth');
        }
    }

    public function UpdateExclusion()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $userid = $this->session->userdata('sess_user_id');
            $exclusion_heading_id = $this->input->POST('exclusion_heading_id');
            $exclusion_explaination = $this->input->POST('exclusion_explaination');
            $exclusion_heading = $this->input->POST('exclusion_heading');
            $exclusion_category_id = $this->input->POST('exclusion_category_id');
            
            $param = array(
                'exclusion_explaination' => $exclusion_explaination,
                'exclusion_heading' => $exclusion_heading,
                'exclusion_category_id' => $exclusion_category_id,
                'updated_by' => $userid,
                'updated_on' => date('Y-m-d H:i:s')
            );
            $cid = $this->InsuranceExclusion_model->updateExclustionMapping($param, $exclusion_heading_id);
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

    function AllCategories()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $html ='';
            $data['records'] = $this->InsuranceExclusion_model->selectAllCategories();
            foreach($data['records'] as $value)
            {
                $html .='<option value='.$value->exclusion_id.'>'.$value->exclusion_category.'</option>';
            }
            echo $html;
        }
        else
        {
            redirect('/Auth');
        }
    }
}
