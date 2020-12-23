<?php

class City_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function selectAll($limit, $offset, $search, $count)
    {
        $this->db->select('m_cities.city_name,m_pincodes.city_id,GROUP_CONCAT(m_pincodes.pincode SEPARATOR ", ") as pincode');
        $this->db->from('m_cities');
        $this->db->join('m_pincodes','m_pincodes.city_id = m_cities.city_id','left');
        $this->db->where('m_cities.deleted_on', null);
        $this->db->where('m_pincodes.deleted_on', null);
        $this->db->group_by('m_pincodes.city_id');
        if ($search)
        {
            $keyword = $search['keyword'];
            $district_id = $search['district_id'];
            if ($keyword)
            {
                $this->db->where("m_cities.city_name LIKE '%$keyword%'");
                $this->db->or_where("m_pincodes.pincode",$keyword);
            }
            if ($district_id)
            {
                $this->db->where("m_cities.district_id",$district_id);
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

    function createCity($param)
    {
        $this->db->insert('m_cities', $param);
        $id = $this->db->insert_id();
        return $id;
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
    
    function checkPincodeExists($pincode, $city_id)
    {
        $this->db->select('pincode_id');
        $this->db->from('m_pincodes');
        $this->db->where('pincode', $pincode);
        if ($city_id)
        {
            $this->db->where('$pincode !=', $pincode);
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
}
