<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	
	 function __construct()
    {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->model('Master/State_model');
		ini_set('max_execution_time', '0');
	}
	
	public function index()
	{
		if (strlen($this->session->userdata('is_logged_in')) and $this->session->userdata('is_logged_in') == 1)
        {
			$data['audit_logs'] = $this->Common_model->getLogs();
            $this->load->view('dashboard', $data);
        } 
        else
        {
            redirect('/Auth');
        }
		
	}

	// public function setState() {
	// 	$records = $this->Common_model->SelectAll('m_states');
	// 	foreach($records as $value)
	// 	{
	// 		$param = array(
	// 			'state_name' => ucwords(strtolower(trim($value->state_name)))
	// 		);
	// 		$cid = $this->State_model->updateState($param, $value->state_id);
	// 	}
	// 	echo 'DONE';
	// }

	// public function setDistrict() {
	// 	$records = $this->Common_model->SelectAll('m_districts');
	// 	foreach($records as $value)
	// 	{
	// 		$param = array(
	// 			'district_name' => ucwords(strtolower(trim($value->district_name)))
	// 		);
	// 		$cid = $this->State_model->updateDistrict($param, $value->district_id);
	// 	}
	// 	echo 'DONE';
	// }

	public function importData() {
		// $file = fopen("pincodes.csv","r");
		// while(! feof($file))
		// {
		// 	$data[] = fgetcsv($file);
		// }
		$data = $this->Common_model->SelectAll('pincodes_final_for_new_portal_work');
		$districts = $this->Common_model->SelectAll('m_districts');
		$districts = json_decode(json_encode($districts), true);
		$data = json_decode(json_encode($data), true);
		// unset($data[0]);
		
		$i = 1;
		foreach($data as $key => $value)
		{
			// print_r($value);die;
			foreach($districts as $val) //districts
			{
				if(strtolower(trim($value['district'])) == strtolower(trim($val['district_name'])))
				{
					$param = array(
						'district_id' => $val['district_id'],
						'city_name' => $value['city'],
						'created_by' => 1
					);
					$cid = $this->Common_model->CommonInsert('m_cities',$param);

					$pr = array (
						'pincode' => $value['pincode'],
						'city_id' => $cid,
						'rto_code' => $val['rto_code']
					);

					$this->Common_model->CommonInsert('m_pincodes',$pr);
					echo '<pre>';print_r($i." record inserted.");
					$i++;
				}
			}
		}
		/*foreach($states as $value) {
		 	$param = array(
		 		'state_name' => $value,
		 		'created_by' => 1
		 	);
		 	$this->Common_model->CommonInsert('m_states',$param);
		}*/
		
		

		echo '<pre>';print_r("DONE");
	}
}
