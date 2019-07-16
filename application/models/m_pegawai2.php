<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_pegawai2 extends CI_Model {

    var $table = 'dd_user a';
    var $column_order = array(null, 'tahun', 'bulan'); //set column field database for datatable orderable
    var $column_search = array('tahun', 'bulan'); //set column field database for datatable searchable 
    var $order = array('d.Lokasi,a.nama' => 'asc'); // default order 

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->db->_protect_identifiers = false;
    }

    private function _get_datatables_query($bulan, $tahun) {
        $this->db->from($this->table);
        $this->db->select("a.nama,a.nip,b.unitkerja,d.Lokasi");
        $this->db->join('tblstruktural b', 'a.unit_kerja=b.kodeunit', 'INNER');
        $this->db->join("tblrekaptk c", 'c.nip=a.nip', 'LEFT');
        $this->db->join("tbllokasikerja d", 'c.kodelokasi=d.KodeLokasi', 'LEFT');
        $this->db->join("opmt_bulanan_skp e", "e.id_dd_user=a.id_dd_user AND nilai_skp is NULL AND e.bulan={$bulan} AND e.tahun={$tahun}", 'LEFT');
        $this->db->where("e.id_opmt_bulanan_skp is null");
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

    function get_datatables($bulan, $tahun) {
        $this->_get_datatables_query($bulan, $tahun);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($bulan, $tahun) {
        $this->_get_datatables_query($bulan, $tahun);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($bulan, $tahun) {
        $id_user = $this->session->userdata('id_user');
        $this->db->from($this->table);
        $this->db->select("a.nama,a.nip,b.unitkerja,d.Lokasi");
        $this->db->join('tblstruktural b', 'a.unit_kerja=b.kodeunit', 'INNER');
        $this->db->join("tblrekaptk c", 'c.nip=a.nip', 'LEFT');
        $this->db->join("tbllokasikerja d", 'c.kodelokasi=d.KodeLokasi', 'LEFT');
        $this->db->join("opmt_bulanan_skp e", "e.id_dd_user=a.id_dd_user AND nilai_skp is NULL AND e.bulan={$bulan} AND e.tahun={$tahun}", 'LEFT');
        $this->db->where("e.id_opmt_bulanan_skp is null");
      
        return $this->db->count_all_results();
    }

}
