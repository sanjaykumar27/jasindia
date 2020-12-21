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
            $cities_exist = array();
            $cid = '';
            $userid = $this->session->userdata('sess_user_id');
            $cities = $this->input->POST('city_name');
            $pincodes = $this->input->POST('pincode');
            $sCount = count($cities);
            foreach ($cities as $key => $val)
            {
                $is_exist = $this->City_model->checkCityExists(trim($val), '');
                if ($is_exist)
                {
                    $cities_exist[] = trim($val);
                } else
                {
                    $param = array(
                        'city_name' => ucwords(trim($val)),
                        'pincode' => trim($pincodes[$key]),
                        'created_by' => $userid,
                    );
                    $cid = $this->City_model->createCity($param);
                }
            }

            if ($cid != "")
            {
                if (count($cities_exist) > 1 && count($cities_exist) != $sCount)
                {
                    $st = implode(', ', $cities_exist);
                    $data = array('code' => 1, 'response' => "City Created succesfully! These states already exist: $st");
                } else
                {
                    $data = array('code' => 1, 'response' => 'City Created succesfully!');
                }
            } else
            {
                if ($sCount == count($cities_exist))
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
    
    public function getCities()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $search = array(
                'keyword' => trim($this->input->post('search_key')),
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
            $html = '<table class="table m-table m-table--head-bg-success table-striped "><thead><tr><th>#</th><th>State Name</th><th>Action</th></tr></thead><tbody>';
            if (!empty($data['records']))
            {
                $i = $offset + 1;
                foreach ($data['records'] as $value)
                {
                    $html .= '<tr><td>' . $i . '</td><td>' . $value->city_name . '</td><td>'
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