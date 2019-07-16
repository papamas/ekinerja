<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Html2pdf_lib {

    function __construct($params = null) {
        require_once(APPPATH . 'libraries/html2pdf/html2pdf.class.php');
        if ($params['width'] !== 'M') {
            $this->html2pdf = new HTML2PDF($params['type'], array($params['width'], $params['height']), 'en', true, 'UTF-8', array(10, 10, 10, 10));
        } else {
            $this->html2pdf = new HTML2PDF($params['type'], 'A4', 'en');
        }
//        $this->html2pdf = new HTML2PDF('P', 'A4', 'en');
        $this->CI = & get_instance();
    }

    function converHtml2pdf($content, $filename = null, $save_to = null) {
        $this->html2pdf->writeHTML($content);
        if ($save_to == '' || $save_to == null) {
            $pdffile = $this->html2pdf->Output($filename, FALSE);
        } else {
            $this->CI->load->helper('file');
            $pdffile = $this->html2pdf->Output($filename, TRUE);
            if (!write_file($save_to . '/' . $filename, $pdffile)) {
                return false;
            } else {
                return true;
            }
        }
    }

}
