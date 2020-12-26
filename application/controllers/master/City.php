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

    function edit()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $html = '';
            $city_id = $this->input->post('city_id');
            $records = $this->City_model->GetPincodes($city_id);
            //echo '<pre>';print_r($records);die;
            if (!empty($records))
            {
                $html .= '<div class="row"><div class="col form-group"><label>City Name</label>'
                        . '<input type="hidden" id="c_district_id" name="district_id" value="' . $records[0]['district_id'] . '"><input type="hidden" id="c_city_id" name="city_id" value="' . $records[0]['city_id'] . '">'
                        . '<input type="text" id="c_city_name" name="city_name" value="' . $records[0]['city_name'] . '" class="form-control text-capitalize" required="" placeholder="Enter City" autocomplete="off">'
                        . '</div></div>';
                foreach ($records as $value)
                {
                    $html .= '<div class="row" id="inputFormRow"><div class="col-10 form-group"><label>Pincode</label>';
                    $html .= '<input type="number" id="c_pincode" name="pincode[]" value="' . $value['pincode'] . '"  class="form-control text-capitalize" required="" placeholder="Enter Pincode" autocomplete="off">';
                    $html .= '</div>';
                    $html .= '<div class="align-items-center col-2 d-flex">';
                    $html .= '<button id="removePincode" value="' . $value['pincode_id'] . '" type="button" class="btn btn-danger  mt-2 py-4"><i class="fa fa-minus"></i></button>';
                    $html .= '</div></div>';
                }

                $html .= '<div id="newRow"></div><div class="row"><div class="align-items-center col-2 d-flex"><button class="btn btn-primary mt-2 py-4" type="button" id="addPincodeRow"><i class="fa fa-plus"></i></button>';
                $html .= '</div></div>';
            }
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
            $city = $this->input->POST('city_name');
            $city_id = $this->input->POST('city_id');
            $district_id = $this->input->POST('district_id');
            $city_exist = $this->City_model->checkCityExists(trim($city), $city_id, $district_id);
            if ($city_exist)
            {
                $data = array('code' => 3, 'response' => 'This city already exist!');
            } else
            {
                $param = array(
                    'city_name' => ucwords(trim($city)),
                    'updated_by' => $userid,
                    'updated_on' => date('Y-m-d H:i:s')
                );
                $cid = $this->City_model->updateCity($param, $city_id);
                if ($cid != "")
                {
                    $data = array('code' => 1, 'response' => 'City Updated succesfully!');
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
