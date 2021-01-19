<?php

class BodyType_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

	function checkBodyTypeExist($body_type_name, $body_type_id)
	{
		$this->db->select('body_type_id');
        $this->db->from('m_body_type');
        $this->db->where('body_type_name', $body_type_name);
        if ($body_type_id)
        {
            $this->db->where('body_type_id !=', $body_type_id);
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
        $this->db->select('m_body_type.body_type_id,m_body_type.body_type_name');
        $this->db->from('m_body_type');
        if ($search)
        {
            $keyword = $search['keyword'];
            if ($keyword)
            {
                $this->db->where("m_body_type.body_type_name LIKE '%$keyword%'");
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

    function updateBodyType($param, $body_type_id)
    {
        $this->db->where('body_type_id', $body_type_id);
        $this->db->update('m_body_type', $param);
        $affected_rows = $this->db->affected_rows();
        return $affected_rows;
    }

    function GetBodyTypeDetails($body_type_id)
    {
        $this->db->select('body_type_name, body_type_id');
        $this->db->from('m_body_type');
        $this->db->where('body_type_id', $body_type_id);
        $query = $this->db->get();
        if (count($query->result()) > 0)
        {
            return $query->row();
        }
    }
}
