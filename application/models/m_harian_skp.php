<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_harian_skp extends CI_Model {

    var $table = 'opmt_realisasi_harian_skp a';
    var $column_order = array(null, 'year(a.tanggal)', 'month(a.tanggal)'); //set column field database for datatable orderable
    var $column_search = array('year(a.tanggal)', 'month(a.tanggal)'); //set column field database for datatable searchable 
    var $order = array('id_opmt_realisasi_harian_skp' => 'asc'); // default order 

    public function __construct() {
        parent::__construct();
        $this->db->_protect_identifiers=false;
        $this->load->database();
    }

    private function _get_datatables_query($bulan, $tahun) {
        $id_user = $this->session->userdata('id_user');
        if ($bulan !== "all") {
            $this->db->where("month(a.tanggal)", $bulan);
        }
        if ($tahun !== "all") {
            $this->db->where("year(a.tanggal)", $tahun);
        }
        $this->db->from($this->table);
        $this->db->join("(
                SELECT a.id_opmt_target_bulanan_skp as id,b.kegiatan_tahunan as kegiatan_bulanan,'utama' as ket FROM opmt_target_bulanan_skp a
                INNER JOIN opmt_target_skp b ON a.id_opmt_target_skp=b.id_opmt_target_skp AND a.id_dd_user={$id_user}

                UNION ALL
                SELECT id_opmt_turunan_skp as id,kegiatan_turunan,'turunan'as ket FROM opmt_turunan_skp d
                INNER JOIN opmt_target_bulanan_skp e ON d.id_opmt_target_bulanan_skp=e.id_opmt_target_bulanan_skp
                INNER JOIN opmt_target_skp f on e.id_opmt_target_skp=f.id_opmt_target_skp
                INNER JOIN opmt_tahunan_skp g on g.id_opmt_tahunan_skp=f.id_opmt_tahunan_skp AND g.id_dd_user={$id_user}
                ) b", 'a.ket=b.ket COLLATE utf8_general_ci AND b.id=a.id_opmt_target_bulanan_skp', 'LEFT');
        $this->db->join('dd_kuantitas c', 'c.id_dd_kuantitas=a.satuan_kuantitas', 'LEFT');
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
        $bulan = $this->input->get('bulan');
        $tahun = $this->input->get('tahun');

        if ($bulan !== "all") {
            $this->db->where("month(a.tanggal)", $bulan);
        }
        if ($tahun !== "all") {
            $this->db->where("month(a.tanggal)", $tahun);
        }
        $this->db->from($this->table);
        $this->db->join("(
                SELECT a.id_opmt_target_bulanan_skp as id,b.kegiatan_tahunan as kegiatan_bulanan,'utama' as ket FROM opmt_target_bulanan_skp a
                INNER JOIN opmt_target_skp b ON a.id_opmt_target_skp=b.id_opmt_target_skp AND a.id_dd_user={$id_user}

                UNION ALL
                SELECT id_opmt_turunan_skp as id,kegiatan_turunan,'turunan'as ket FROM opmt_turunan_skp d
                INNER JOIN opmt_target_bulanan_skp e ON d.id_opmt_target_bulanan_skp=e.id_opmt_target_bulanan_skp
                INNER JOIN opmt_target_skp f on e.id_opmt_target_skp=f.id_opmt_target_skp
                INNER JOIN opmt_tahunan_skp g on g.id_opmt_tahunan_skp=f.id_opmt_tahunan_skp AND g.id_dd_user={$id_user}
                ) b", 'a.ket=b.ket COLLATE utf8_general_ci  AND b.id=a.id_opmt_target_bulanan_skp', 'LEFT');
        $this->db->join('dd_kuantitas c', 'c.id_dd_kuantitas=a.satuan_kuantitas', 'LEFT');

        return $this->db->count_all_results();
    }

}
