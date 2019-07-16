<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_tahunan_target_skp extends CI_Model {

    var $table = 'opmt_target_skp a';
    var $column_order = array(null, 'tahun', 'kegiatan_tahunan', 'target_kuantitas', 'target_kualitas'); //set column field database for datatable orderable
    var $column_search = array('tahun', 'kegiatan_tahunan'); //set column field database for datatable searchable 
    var $order = array('id_opmt_target_skp' => 'asc'); // default order 

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query($id, $status) {
        $id_user = $this->session->userdata('id_user');
        $this->db->from($this->table);
        $this->db->join('opmt_tahunan_skp b', "b.id_opmt_tahunan_skp=a.id_opmt_tahunan_skp AND b.id_dd_user={$id_user} AND b.id_opmt_tahunan_skp={$id}", 'INNER');
        $this->db->join('dd_kuantitas c', "c.id_dd_kuantitas=a.satuan_kuantitas", 'LEFT');
        if (!empty($status)) {
            $this->db->where('year(awal_periode_skp)', $status);
        }
        $this->db->select("a.*,year(b.awal_periode_skp) tahun,c.satuan_kuantitas");
        $i = 0;

        foreach ($this->column_search as $item) { // loop column 
              if (!empty($_POST['search']['value'])) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($id, $status) {
        $this->_get_datatables_query($id, $status);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($id, $status) {
        $this->_get_datatables_query($id, $status);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($id, $status) {
        $id_user = $this->session->userdata('id_user');
        $this->db->from($this->table);
        $this->db->join('opmt_tahunan_skp b', "b.id_opmt_tahunan_skp=a.id_opmt_tahunan_skp AND b.id_dd_user={$id_user} AND b.id_opmt_tahunan_skp={$id}", 'INNER');
        if (!empty($status)) {
            $this->db->where('year(awal_periode_skp)', $status);
        }
        return $this->db->count_all_results();
    }

}
