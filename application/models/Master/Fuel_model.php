<?php

class Fuel_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

	function checkFuelExist($fuel_name, $fuel_id)
	{
		$this->db->select('fuel_id');
        $this->db->from('m_fuel');
        $this->db->where('fuel_name', $fuel_name);
        if ($fuel_id)
        {
            $this->db->where('fuel_id !=', $fuel_id);
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
	
    function selectAll($limit, $offset, $search, $count)
    {
        $this->db->select('m_fuel.fuel_id,m_fuel.fuel_name');
        $this->db->from('m_fuel');
        if ($search)
        {
            $keyword = $search['keyword'];
            if ($keyword)
            {
                $this->db->where("m_fuel.fuel_name LIKE '%$keyword%'");
            }
        }
        if ($count)
        {
            return $this->db->count_all_results();
        }
        else {
            $this->db->limit($limit, $offset);
            $query = $this->db->get();

            if ($query->num_rows() > 0)
            {
                return $query->result();
            }
        }
        return array();
    }

    function updateFuel($param, $fuel_id)
    {
        $this->db->where('fuel_id', $fuel_id);
        $this->db->update('m_fuel', $param);
        $affected_rows = $this->db->affected_rows();
        return $affected_rows;
    }

    function GetFuelDetails($fuel_id)
    {
        $this->db->select('fuel_name, fuel_id');
        $this->db->from('m_fuel');
        $this->db->where('fuel_id', $fuel_id);
        $query = $this->db->get();
        if (count($query->result()) > 0)
        {
            return $query->row();
        }
    }
}
