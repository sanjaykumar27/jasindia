<?php

class EngineCylinder_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

	function checkEngineCylinderExist($engine_cylinder_name, $engine_cylinder_id)
	{
		$this->db->select('engine_cylinder_id');
        $this->db->from('m_engine_cylinder');
        $this->db->where('engine_cylinder_name', $engine_cylinder_name);
        if ($engine_cylinder_id)
        {
            $this->db->where('engine_cylinder_id !=', $engine_cylinder_id);
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
        $this->db->select('m_engine_cylinder.engine_cylinder_id,m_engine_cylinder.engine_cylinder_name');
        $this->db->from('m_engine_cylinder');
        if ($search)
        {
            $keyword = $search['keyword'];
            if ($keyword)
            {
                $this->db->where("m_engine_cylinder.engine_cylinder_name LIKE '%$keyword%'");
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

    function updateEngineCylinder($param, $engine_cylinder_id)
    {
        $this->db->where('engine_cylinder_id', $engine_cylinder_id);
        $this->db->update('m_engine_cylinder', $param);
        $affected_rows = $this->db->affected_rows();
        return $affected_rows;
    }

    function GetEngineCylinderDetails($engine_cylinder_id)
    {
        $this->db->select('engine_cylinder_name, engine_cylinder_id');
        $this->db->from('m_engine_cylinder');
        $this->db->where('engine_cylinder_id', $engine_cylinder_id);
        $query = $this->db->get();
        if (count($query->result()) > 0)
        {
            return $query->row();
        }
    }
}
