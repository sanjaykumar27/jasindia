<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Manufacturer extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Master/Manufacturer_model');
        $this->load->model('Common_model');
        $this->load->library('pagination');
    }

    public function index()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $data['audit_logs'] = $this->Common_model->getLogs();
            $data['company_types'] = $this->Common_model->SelectAll('m_company_type');
            $this->load->view('Master/manufacturer_master', $data);
        } else
        {
            redirect('/Auth');
        }
    }

    public function getManufacturer()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $search = array(
                'keyword' => trim($this->input->post('search_key')),
            );
            $limit = 10;
            $offset = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
            $config['base_url'] = site_url('master/Manufacturer/getManufacturer');
            $config['total_rows'] = $this->Manufacturer_model->selectAll($limit, $offset, $search, $count = true);
            $config['uri_segment'] = 4;
            $config['num_links'] = 4;
            $this->pagination->initialize($config);
            $total = $config['total_rows'];
            $data['records'] = $this->Manufacturer_model->selectAll($limit, $offset, $search, $count = false);
            $pagelinks = $this->pagination->create_links();
            
            //$page_count  = ($offset) ? $offset : 1;
            //$i =  (($page_count - 1) * $limit) + 1;
            $i = $offset + 1;
            $html = '<div class="table-responsive"><table class="table  table-striped"><thead class="bg-secondary text-white"><tr><th>#</th><th>Name</th>'
                    . '<th>Email</th><th>Website</th><th>Address</th><th>Type</th><th>Action</th></tr></thead><tbody>';
            if (!empty($data['records']))
            {
                foreach ($data['records'] as $value)
                {
                    $html .= '<tr><td>'.$i.'</td><td class="">' . $value->manufacturer_name . '</td><td class="">' . $value->manufacturer_email . '</td><td class="">' . $value->manufacturer_website . '</td>'
                            . '<td>' . $value->manufacturer_address . '</td><td>'.$value->type_name.'</td><td class="text-truncate">'
                            . '<a href="javascript:void(0)" id="m_editbutton" data-bs-toggle="modal" value="'.$value->manufacturer_id.'"  data-bs-target="#ModalUpdateCompany" class="btn  btn-outline-success btn-sm "><i class="fa fa-pencil-alt"></i></a></td>';
                $i++; }
            }
            $html .= '</tbody></table><h5>Total Manufacturer: <span class="font-weight-bold">'.$total.'</span></h5><div class="d-flex flex-row justify-content-md-center align-items-center">' . $pagelinks.'</div></div>';
            echo $html;
        } else
        {
            redirect('/Auth');
        }
    }

    public function Create()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $userid = $this->session->userdata('sess_user_id');
            $manufacturer = $this->input->POST('manufacturer_name');
            $manufacturer_website = $this->input->POST('manufacturer_website');
            $manufacturer_address = $this->input->POST('manufacturer_address');
            $manufacturer_email = $this->input->POST('manufacturer_email');
            $company_type = $this->input->POST('company_type');
            $is_exist = $this->Manufacturer_model->checkManufacturerExists(trim($manufacturer),'');
            if ($is_exist)
            {
                $data = array('code' => 3, 'response' => 'This manufacturer already exist');
            } else
            {
                $param = array(
                    'manufacturer_name' => ucwords(trim($manufacturer)),
                    'manufacturer_website' => trim($manufacturer_website),
                    'manufacturer_address' => ucwords(trim($manufacturer_address)),
                    'manufacturer_type' => $company_type,
                    'manufacturer_email' => trim($manufacturer_email),
                    'created_by' => $userid,
                );
                $cid = $this->Common_model->CommonInsert('m_manufacturer',$param);
                if ($cid != "")
                {
                    $data = array('code' => 1, 'response' => 'Manufacturer Created succesfully!');
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
            $manufacturer_id = $this->input->post('edit_id');
            $records = $this->Manufacturer_model->GetManufacturerName($manufacturer_id);
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
            $manufacturer_name = $this->input->POST('manufacturer_name');
            $manufacturer_email = $this->input->POST('manufacturer_email');
            $manufacturer_address = $this->input->POST('manufacturer_address');
            $manufacturer_type = $this->input->POST('manufacturer_type');
            $manufacturer_website = $this->input->POST('manufacturer_website');
            $manufacturer_id = $this->input->POST('manufacturer_id');
            $is_exist = $this->Manufacturer_model->checkManufacturerExists(trim($manufacturer_name),$manufacturer_id);
            if ($is_exist)
            {
                $data = array('code' => 3, 'response' => 'This Manufacturer already exist!');
            } else
            {
                $param = array(
                    'manufacturer_name' => ucwords(trim($manufacturer_name)),
                    'manufacturer_email' => $manufacturer_email,
                    'manufacturer_type' => $manufacturer_type,
                    'manufacturer_address' => $manufacturer_address,
                    'manufacturer_website' => $manufacturer_website,
                    'updated_by' => $userid,
                    'updated_on' => date('Y-m-d H:i:s')
                );
                $cid = $this->Manufacturer_model->updateManufacturer($param, $manufacturer_id);
                if ($cid != "")
                {
                    $data = array('code' => 1, 'response' => 'Manufacturer Updated succesfully!');
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

    function getCompanyType()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $data = $this->Common_model->SelectAll('m_company_type');
            //print_r($data);die;
            $html = '<option value="">Select Manufacturer</option>';
            if (!empty($data))
            {
                $i = 1;
                foreach ($data as $value)
                {
                    $html .= '<option value='.$value['manufacturer_id'].'>'.$value['manufacturer_name'].'</option>';
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
