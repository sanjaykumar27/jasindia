<?php

class VehicleSegment_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

	function checkVehicleSegmentExist($segment_name, $segment_id)
	{
		$this->db->select('segment_id');
        $this->db->from('m_vehicle_segment');
        $this->db->where('segment_name', $segment_name);
        if ($segment_id)
        {
            $this->db->where('segment_id !=', $segment_id);
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
        $this->db->select('m_vehicle_segment.segment_id,m_vehicle_segment.segment_name');
        $this->db->from('m_vehicle_segment');
        if ($search)
        {
            $keyword = $search['keyword'];
            if ($keyword)
            {
                $this->db->where("m_vehicle_segment.segment_name LIKE '%$keyword%'");
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

    function updateVehicleSegment($param, $segment_id)
    {
        $this->db->where('segment_id', $segment_id);
        $this->db->update('m_vehicle_segment', $param);
        $affected_rows = $this->db->affected_rows();
        return $affected_rows;
    }

    function GetVehicleSegmentDetails($segment_id)
    {
        $this->db->select('segment_name, segment_id');
        $this->db->from('m_vehicle_segment');
        $this->db->where('segment_id', $segment_id);
        $query = $this->db->get();
        if (count($query->result()) > 0)
        {
            return $query->row();
        }
    }
}
