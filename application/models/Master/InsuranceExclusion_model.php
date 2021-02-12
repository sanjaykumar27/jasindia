<?php

class InsuranceExclusion_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

	function checkInsuranceExclusionExist($exclusion_name, $exclusion_id)
	{
		$this->db->select('exclusion_id');
        $this->db->from('m_insurance_exclusion');
        $this->db->where('exclusion_name', $exclusion_name);
        if ($exclusion_id)
        {
            $this->db->where('exclusion_id !=', $exclusion_id);
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
        $this->db->select('m_insurance_exclusion.exclusion_id,m_insurance_exclusion.exclusion_name');
        $this->db->from('m_insurance_exclusion');
        if ($search)
        {
            $keyword = $search['keyword'];
            if ($keyword)
            {
                $this->db->where("m_insurance_exclusion.exclusion_name LIKE '%$keyword%'");
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

    function updateInsuranceExclusion($param, $exclusion_id)
    {
        $this->db->where('exclusion_id', $exclusion_id);
        $this->db->update('m_insurance_exclusion', $param);
        $affected_rows = $this->db->affected_rows();
        return $affected_rows;
    }

    function GetInsuranceExclusionDetails($exclusion_id)
    {
        $this->db->select('exclusion_name, exclusion_id');
        $this->db->from('m_insurance_exclusion');
        $this->db->where('exclusion_id', $exclusion_id);
        $query = $this->db->get();
        if (count($query->result()) > 0)
        {
            return $query->row();
        }
    }
}
