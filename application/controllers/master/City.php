<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class City extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Master/City_model');
        $this->load->model('Common_model');
        $this->load->model('Master/State_model');
        $this->load->library('pagination');
    }

    public function index()
    {
        if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $data['audit_logs'] = $this->Common_model->getLogs();
            $this->load->view('Master/city_master',$data);
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
                $cid = $this->Common_model->CommonInsert('m_cities',$param);

                $params = array(
                    'city_id' => $cid,
                    'pincode' => trim($pincode),
                    'created_by' => $userid,
                );

                $pid = $this->Common_model->CommonInsert('m_pincodes',$params);

                if ($pid != "" && $cid != '')
                {
                    $log = array(
                        'action' => 'create',
                        'page' => 'City Master',
                        'record' => 'Create New City & Pincode.',
                        'success' => 'Y',
                        'ip_address' => $_SERVER['REMOTE_ADDR'],
                        'created_by' => $userid,
                    );
                    $this->Common_model->CommonInsert('audit_log',$log);
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
            $states = $this->State_model->listAllStates();
            
            $pcount = count($records);
            
            //echo '<pre>';print_r($records);die;
            if (!empty($records))
            {	
                $state_id = $records[0]['state_id'];
                $districts = $this->State_model->listAllDistricts($state_id);
                $district_id = $records[0]['district_id'];
                $drto_code = $records[0]['drto_code'];

				$html_newpincode = '<div class="align-items-center bg-light border d-flex p-1 row">
							<div class="col-lg-6 form-group">
								<input type="hidden" id="new_city_id" name="city_id" value="' . $records[0]['city_id'] . '">
								<input type="number" id="new_pincode" name="pincode" class="form-control text-capitalize" required="" placeholder="Enter Pincode" autocomplete="off">
                            </div>
                            <div class="col-lg-3 pb-1">
                                <input placeholder="RTO Code" name="rto_code" value="'.$drto_code.'" required type="text" class="form-control">
                            </div>
							<div class="col-lg-3">
                                <input type="submit" class="btn btn-primary btn-sm" id="newpincode_Btn" value="Add">
                                <button type="button" class="close ms-2" onclick="jsHide(\'formNewPincode\');jsShow(\'add_new_pincode\')">
                                    <i class="fa fa-times"></i>
                                </button>
							</div>
                        </div>';
                
                $html .='<div class="row"><div class="col form-group"><label>City Name</label>'
                        . '<input type="hidden" id="c_city_id" name="city_id" value="' . $records[0]['city_id'] . '">'
                        . '<input type="text" id="c_city_name" name="city_name" value="' . $records[0]['city_name'] . '" class="form-control text-capitalize" required="" placeholder="Enter City" autocomplete="off">'
                        . '</div></div>';
                foreach ($records as $value)
                {
                    $html .= '<div class="align-items-center d-flex row" id="inputFormRow">
                                <div class="col-lg-6 form-group">
                                <input type="hidden"  name="pincode_id[]" value="' . $value['pincode_id'] . '">
                                <input type="number" id="c_pincode" name="pincode[]" readonly value="' . $value['pincode'] . '"  class="form-control text-capitalize" required="" placeholder="Enter Pincode" autocomplete="off">
                            </div>
                            <div class="col-lg-3 pb-1">
                                <input placeholder="RTO Code" value="'.($value['rto_code'] != '' ? $value['rto_code'] : $drto_code).'" readonly id="d_district_rto_code" name="rto_code" required type="text" class="form-control">
                            </div>
                             <div class="col-lg-3"> 
                                <button id="m_editpincodebutton" dd-rto-code="'.($value['rto_code'] != '' ? $value['rto_code'] : $drto_code).'" dd-pincode-name="' . $value['pincode'] . '" value="' . $value['pincode_id'] . '" type="button" class="btn btn-outline-primary  me-2"><i class="fa fa-pencil-alt"></i></button>';
					if($pcount > 1) {
						$html .= '<button id="removePincode" value="' . $value['pincode_id'] . '" type="button" class="btn btn-outline-danger"><i class="fa fa-trash"></i></button>';
					}
                    $html .= '</div></div>';
                }
               
                $html .= '</div></div><div class="form-group text-center mt-3">
                            <input type="submit" class="btn btn-primary" id="updateBtn" value="Update"> 
                        </div>
                    ';
            }

            $data = array('NP' => $html_newpincode, 'UP' => $html, 'state_id' => $state_id, 'district_id' => $district_id,'drto_code'=>$drto_code);
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
            $city = $this->input->POST('city_name');
			$pincode = $this->input->POST('pincode');
			$pincode_id = $this->input->POST('pincode_id');
            $city_id = $this->input->POST('city_id');
            $district_id = $this->input->POST('district_id');
            $city_exist = $this->City_model->checkCityExists(trim($city), $city_id, $district_id);
			
			//$pincode_exist = $this->City_model->checkPincodeExists(trim($pincode), $pincode);
            if ($city_exist)
            {
                $data = array('code' => 3, 'response' => 'This city already exist!');
            } 
			else
            {
                $param = array(
                    'city_name' => ucwords(trim($city)),
                    'district_id' => $district_id,
                    'updated_by' => $userid,
                    'updated_on' => date('Y-m-d H:i:s')
                );
                $cid = $this->City_model->updateCity($param, $city_id);
				
                if ($cid != "")
                {
                    $log = array(
                        'action' => 'update',
                        'page' => 'City Master',
                        'record' => 'Updated City Name $city.',
                        'success' => 'Y',
                        'ip_address' => $_SERVER['REMOTE_ADDR'],
                        'created_by' => $userid,
                    );
                    $this->Common_model->CommonInsert('audit_log',$log);
                    $data = array('code' => 1, 'response' => 'City Updated succesfully!');
                } 
				else
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
            $userid = $this->session->userdata('sess_user_id');
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
            $html = '<div class="table-responsive"><table class="table  table-striped "><thead><tr><th>#</th><th>State</th><th>District</th><th>City</th><th>Pincodes</th><th>Action</th></tr></thead><tbody>';
            if (!empty($data['records']))
            {
                $i = $offset + 1;
                foreach ($data['records'] as $value)
                {
                    $html .= '<tr><td>' . $i . '</td><td>' . $value->state_name . '</td><td>' . $value->district_name . '</td><td>' . $value->city_name . '</td><td class="fw-bold">' . str_replace(',',', ',$value->pincode) . '</td><td>'
                            . '<a href="javascript:void(0)" id="m_editbutton" data-bs-toggle="modal" value="' . $value->city_id . '"  data-bs-target="#ModalUpdateCity" class="btn btn-outline-success btn-sm"><i class="fa fa-pencil-alt"></i></a>'
                            . '</td>';
                    $i++;
                }
            }

            $log = array(
                'action' => 'getCities',
                'page' => 'City Master',
                'record' => 'Viewed City List.',
                'success' => 'Y',
                'ip_address' => $_SERVER['REMOTE_ADDR'],
                'created_by' => $userid,
            );
            $this->Common_model->CommonInsert('audit_log',$log);

            $html .= '</tbody></table></div><h5>Total Cities: <span class="font-weight-bold">' . $total . '</span></h5>' . $pagelinks;
            echo $html;
        } else
        {
            redirect('/Auth');
        }
    }
	
	public function deletePincode()
	{
		if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
			$userid = $this->session->userdata('sess_user_id');
			$pincode_id = $this->input->POST('pincode_id');
			$id = $this->City_model->removePincode($pincode_id);
			$data = array('code' => 1, 'response' => 'City Deleted Succesfully!');
			$log = array(
                'action' => 'deletePincode',
                'page' => 'City Master',
                'record' => 'Deleted Pincode.',
                'success' => 'Y',
                'ip_address' => $_SERVER['REMOTE_ADDR'],
                'created_by' => $userid,
            );
            $this->Common_model->CommonInsert('audit_log',$log);
			echo json_encode($data);
		} else
		{
            redirect('/Auth');
        }
	}
	
	public function newPincode()
	{
		if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
			$userid = $this->session->userdata('sess_user_id');
			$pincode = $this->input->POST('pincode');
            $city_id = $this->input->POST('city_id');
            $rto_code = $this->input->POST('rto_code');
			$pincode_exist = $this->City_model->checkPincodeExists(trim($pincode), '');
            if ($pincode_exist)
            {
                $data = array('code' => 3, 'response' => 'This pincode already exist!');
            }
			else
			{
				$param = array(
                    'pincode' => ucwords(trim($pincode)),
                    'rto_code' => trim($rto_code),
                    'created_by' => $userid,
                    'city_id' => $city_id
                );
				$cid = $this->City_model->NewPincode($param, $city_id);
				if ($cid != "")
				{
                    $log = array(
                        'action' => 'newPincode',
                        'page' => 'City Master',
                        'record' => 'Created New Pincode.',
                        'success' => 'Y',
                        'ip_address' => $_SERVER['REMOTE_ADDR'],
                        'created_by' => $userid,
                    );
                    $this->Common_model->CommonInsert('audit_log',$log);
					$data = array('code' => 1, 'response' => 'Pincode Added succesfully!');
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
	
	public function pincodeUpdate()
	{
		if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
            $userid = $this->session->userdata('sess_user_id');
            $pincode = $this->input->POST('pincode');
            $pincode_id = $this->input->POST('pincode_id');
            $rto_code = $this->input->POST('rto_code');
            $pincode_exist = $this->City_model->checkPincodeExists(trim($pincode), $pincode_id);
            if ($pincode_exist)
            {
                $data = array('code' => 3, 'response' => 'This pincode already exist!');
            } else
            {
                $param = array(
                    'pincode' => ucwords(trim($pincode)),
                    'rto_code' => trim($rto_code),
                    'updated_by' => $userid
                );
                $cid = $this->City_model->updatePincode($param, $pincode_id);
                if ($cid != "")
                {
                    $log = array(
                        'action' => 'pincodeUpdate',
                        'page' => 'City Master',
                        'record' => 'Updated Pincode.',
                        'success' => 'Y',
                        'ip_address' => $_SERVER['REMOTE_ADDR'],
                        'created_by' => $userid,
                    );
                    $this->Common_model->CommonInsert('audit_log',$log);
                    $data = array('code' => 1, 'response' => 'Pincode Updated succesfully!');
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
