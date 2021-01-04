<?php

class Engine_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

	function checkEngineExist($engine_name, $engine_id, $manufacturer_id)
	{
		$this->db->select('engine_id');
        $this->db->from('m_engines');
        $this->db->where('engine_name', $engine_name);
        $this->db->where('manufacturer_id', $manufacturer_id);
        if ($engine_id)
        {
            $this->db->where('engine_id !=', $engine_id);
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
        $this->db->select('m_engines.engine_id,m_engines.engine_name, m_manufacturer.manufacturer_name,m_engines.manufacturer_id');
        $this->db->from('m_engines');
        $this->db->join('m_manufacturer', 'm_manufacturer.manufacturer_id = m_engines.manufacturer_id', 'left');
        if ($search)
        {
            $keyword = $search['keyword'];
            if ($keyword)
            {
                $this->db->where("m_engines.engine_name LIKE '%$keyword%'");
                $this->db->or_where("m_manufacturer.manufacturer_name LIKE '%$keyword%'");
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
}
