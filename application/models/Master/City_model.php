<?php

class City_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function GetPincodes($city_id)
    {
        $this->db->select('m_pincodes.pincode_id,m_pincodes.rto_code,m_districts.rto_code as drto_code,m_cities.city_name,m_districts.state_id,m_pincodes.city_id,m_pincodes.pincode,m_districts.district_id');
        $this->db->from('m_cities');
        $this->db->join('m_pincodes', 'm_pincodes.city_id = m_cities.city_id', 'left');
        $this->db->join('m_districts', 'm_districts.district_id = m_cities.district_id', 'left');
        $this->db->where('m_pincodes.deleted_on', null);
        $this->db->where('m_pincodes.city_id', $city_id);
        $data = $this->db->get();
         $num = $data->num_rows();
        if ($num > 0)
        {
            $result = $data->result_array();
            if (isset($result))
            {
                return $result;
            } else
            {
                return '';
            }
        }
    }

    function selectAll($limit, $offset, $search, $count)
    {
        $this->db->select('m_districts.district_name,m_states.state_name,m_cities.city_name,m_pincodes.city_id,'
                . ' GROUP_CONCAT(DISTINCT(`m_pincodes`.`pincode`)) as pincode');
        $this->db->from('m_cities');
        $this->db->join('m_pincodes', 'm_pincodes.city_id = m_cities.city_id', 'left');
        $this->db->join('m_districts', 'm_districts.district_id = m_cities.district_id', 'left');
        $this->db->join('m_states', 'm_states.state_id = m_districts.state_id', 'left');
        $this->db->where('m_cities.deleted_on', null);
        $this->db->where('m_pincodes.deleted_on', null);
        $this->db->group_by('m_pincodes.city_id');
        if ($search)
        {
            $keyword = $search['keyword'];
            if ($keyword)
            {
                $this->db->where("m_cities.city_name LIKE '%$keyword%'");
                $this->db->or_where("m_pincodes.pincode", $keyword);
                $this->db->or_where("m_districts.district_name LIKE '%$keyword%'");
                $this->db->or_where("m_states.state_name LIKE '%$keyword%'");
            }
        }
        if ($count)
        {
            return $this->db->count_all_results();
        } else
        {
            $this->db->limit($limit, $offset);
            $query = $this->db->get();

            if ($query->num_rows() > 0)
            {
                return $query->result();
            }
        }
        return array();
    }

    function createPincode($param)
    {
        $this->db->insert('m_pincodes', $param);
        $id = $this->db->insert_id();
        return $id;
    }
    
    function checkCityExists($city_name, $city_id, $district_id)
    {
        $this->db->select('city_id');
        $this->db->from('m_cities');
        $this->db->where('city_name', $city_name);
        $this->db->where('district_id', $district_id);
        if ($city_id)
        {
            $this->db->where('city_id !=', $city_id);
        }
        $data = $this->db->get();
        $num = $data->num_rows();
        if ($num > 0)
        {
            $result = $data->result_array();
            if (isset($result))
            {
                return $result;
            } else
            {
                return '';
            }
        }
    }

    function checkPincodeExists($pincode, $pincode_id)
    {
        $this->db->select('pincode_id');
        $this->db->from('m_pincodes');
        $this->db->where('pincode', $pincode);
        if ($pincode_id)
        {
            $this->db->where('pincode_id !=', $pincode_id);
        }
        $data = $this->db->get();
        $num = $data->num_rows();
        if ($num > 0)
        {
            $result = $data->result_array();
            if (isset($result))
            {
                return $result;
            } else
            {
                return '';
            }
        }
    }

    function updateCity($param, $city_id)
    {
        $this->db->where('city_id', $city_id);
        $this->db->update('m_cities', $param);
        $affected_rows = $this->db->affected_rows();
        return $affected_rows;
    }
	
	function removePincode($pincode_id)
	{
		$this->db->where('pincode_id', $pincode_id);
		$this->db->delete('m_pincodes');
	}
	
	function NewPincode($params)
	{
		$this->db->insert('m_pincodes', $params);
        $id = $this->db->insert_id();
        return $id;
	}
	
	function updatePincode($param, $pincode_id)
    {
        $this->db->where('pincode_id', $pincode_id);
        $this->db->update('m_pincodes', $param);
        $affected_rows = $this->db->affected_rows();
        return $affected_rows;
    }
	

}
