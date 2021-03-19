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

	public function setState() {
		$records = $this->Common_model->SelectAll('m_states');
		foreach($records as $value)
		{
			$param = array(
				'state_name' => ucwords(strtolower(trim($value->state_name)))
			);
			$cid = $this->State_model->updateState($param, $value->state_id);
		}
		echo 'DONE';
	}

	public function setDistrict() {
		$records = $this->Common_model->SelectAll('m_districts');
		foreach($records as $value)
		{
			$param = array(
				'district_name' => ucwords(strtolower(trim($value->district_name)))
			);
			$cid = $this->State_model->updateDistrict($param, $value->district_id);
		}
		echo 'DONE';
	}

	public function importData() {
		$file = fopen("pincodes.csv","r");
		while(! feof($file))
		{
			$data[] = fgetcsv($file);
		}
		
		$records = $this->Common_model->SelectAll('m_states');
		$records = json_decode(json_encode($records), true);
		unset($data[0]);
		
		foreach($data as $key => $value) {
			$districts[] = $value['2']."##".$value['3'];
		}
			
		$districts = array_unique($districts);
		
		$i = 1;
		foreach($districts as $key => $value)
		{
			foreach($records as $val)
			{
				$split = explode("##",$value);
				if($split['1'] == $val['state_name'])
				{
					$param = array(
						'state_id' => $val['state_id'],
						'district_name' => $split['0'],
						'created_by' => 1
					);
					$this->Common_model->CommonInsert('m_districts',$param);
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
