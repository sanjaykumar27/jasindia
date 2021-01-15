<?php

class EmissionStandard_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

	function checkEmissionStandardExist($emission_name, $emission_id)
	{
		$this->db->select('emission_id');
        $this->db->from('m_emission_standard');
        $this->db->where('emission_name', $emission_name);
        if ($emission_id)
        {
            $this->db->where('emission_id !=', $emission_id);
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
        $this->db->select('m_emission_standard.emission_id,m_emission_standard.emission_name,m_emission_standard.from_date, m_emission_standard.to_date');
        $this->db->from('m_emission_standard');
        if ($search)
        {
            $keyword = $search['keyword'];
            if ($keyword)
            {
                $this->db->where("m_emission_standard.emission_name LIKE '%$keyword%'");
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

    function updateEmissionStandard($param, $emission_id)
    {
        $this->db->where('emission_id', $emission_id);
        $this->db->update('m_emission_standard', $param);
        $affected_rows = $this->db->affected_rows();
        return $affected_rows;
    }

    function GetEmissionStandardDetails($emission_id)
    {
        $this->db->select('emission_name, emission_id, from_date, to_date');
        $this->db->from('m_emission_standard');
        $this->db->where('emission_id', $emission_id);
        $query = $this->db->get();
        if (count($query->result()) > 0)
        {
            return $query->row();
        }
    }
}
