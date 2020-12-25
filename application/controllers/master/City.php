<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class City extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Master/City_model');
        $this->load->library('pagination');
    }

    public function index()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $this->load->view('Master/city_master');
        } else
        {
            redirect('/Auth');
        }
    }

    public function create()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $cid = '';
            $userid = $this->session->userdata('sess_user_id');
            $city = $this->input->POST('city_name');
            $district_id = $this->input->POST('district_id');
            $pincode = $this->input->POST('pincode');

            $city_exist = $this->City_model->checkCityExists(trim($city), '', $district_id);
            $pincode_exist = $this->City_model->checkPincodeExists(trim($pincode), '');
            if ($city_exist)
            {
                if ($pincode_exist)
                {
                    $data = array('code' => 0, 'response' => "This pincode already exist");
                } else
                {
                    $data = array('code' => 0, 'response' => "This city already exist in this discrict");
                }
            } else
            {
                $param = array(
                    'district_id' => $district_id,
                    'city_name' => ucwords(trim($city)),
                    'created_by' => $userid,
                );
                $cid = $this->City_model->createCity($param);

                $params = array(
                    'city_id' => $cid,
                    'pincode' => trim($pincode),
                    'created_by' => $userid,
                );

                $pid = $this->City_model->createPincode($params);

                if ($pid != "" && $cid != '')
                {
                    $data = array('code' => 1, 'response' => 'City Created succesfully!');
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

    public function getCities()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $search = array(
                'keyword' => trim($this->input->post('search_key')),
                'district_id' => trim($this->input->post('district_id')),
                'state_id' => trim($this->input->post('state_id')),
            );
            $limit = 10;
            $offset = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
            $config['base_url'] = site_url('master/city/getCities');
            $config['total_rows'] = $this->City_model->selectAll($limit, $offset, $search, $count = true);
            $config['uri_segment'] = 4;
            $config['num_links'] = 4;
            $this->pagination->initialize($config);
            $data['records'] = $this->City_model->selectAll($limit, $offset, $search, $count = false);
            $pagelinks = $this->pagination->create_links();
            $total = $config['total_rows'];
            $html = '<table class="table m-table m-table--head-bg-success table-striped "><thead><tr><th>#</th><th>State Name</th><th>District Name</th><th>City Name</th><th>Pincodes</th><th>Action</th></tr></thead><tbody>';
            if (!empty($data['records']))
            {
                $i = $offset + 1;
                foreach ($data['records'] as $value)
                {
                    $html .= '<tr><td>' . $i . '</td><td>' . $value->state_name . '</td><td>' . $value->district_name . '</td><td>' . $value->city_name . '</td><td>' . $value->pincode . '</td><td>'
                            . '<a href="javascript:void(0)" id="m_editbutton" data-toggle="modal" value="' . $value->city_id . '"  data-target="#ModalUpdateCity" class="btn m-btn--pill btn-outline-success btn-sm"><i class="fa fa-pencil-alt"></i> Edit</a>'
                            . '</td>';
                    $i++;
                }
            }
            $html .= '</tbody></table><h5>Total States: <span class="font-weight-bold">' . $total . '</span></h5>' . $pagelinks;
            echo $html;
        } else
        {
            redirect('/Auth');
        }
    }

}
