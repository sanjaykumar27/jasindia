<?php

class City_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function selectAll($limit, $offset, $search, $count)
    {
        $this->db->select('*');
        $this->db->from('m_cities');
        $this->db->where('deleted_on', null);
        if ($search)
        {
            $keyword = $search['keyword'];
            if ($keyword)
            {
                $this->db->where("city_name LIKE '%$keyword%'");
               
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

    function checkCityExists($city_name, $city_id)
    {
        $this->db->select('city_id');
        $this->db->from('m_cities');
        $this->db->where('city_name', $city_name);
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

    function updateCity($param, $city_id)
    {
        $this->db->where('city_id', $city_id);
        $this->db->update('m_cities', $param);
        $affected_rows = $this->db->affected_rows();
        return $affected_rows;
    }
}
