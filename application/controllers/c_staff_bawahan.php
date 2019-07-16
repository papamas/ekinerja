<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_staff_bawahan extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $id_user = $this->session->userdata('id_user');
        $x['staff_bawahan'] = $this->db->query("SELECT * FROM dd_user a LEFT JOIN dd_jabatan b on a.jabatan=b.id_dd_jabatan WHERE atasan_langsung={$id_user}")->result_array();
        $this->load->view('staff_bawahan/v_table_skp', $x);
    }

    public function ajax_list() {
        $this->load->model('M_staff_bawahan', 'staff_bawahan');
        //'kode_bank','nomor_rekening','nomor_akad','tgl_akad','nama','nik','nomor_sp','tgl_terbit_sp','nilai_dijamin','waktu_kirim','log_message'
        $list = $this->staff_bawahan->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $dt) {
            $no++;
            $link_drop = '<a href="javascript:void(0)" onclick="drop_staff_bawahan(' . $dt->id_dd_user . ')">
<i class="fa fa-trash text-danger"/></a>';
            $row = array();
            $row[] = $no;
            $row[] = $dt->nama;
            $row[] = $dt->nip;
            $row[] = $dt->jabatan;
            $row[] = $link_drop;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->staff_bawahan->count_all(),
            "recordsFiltered" => $this->staff_bawahan->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

}
