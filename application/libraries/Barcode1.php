<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once dirname(__FILE__) . '/tcpdf/tcpdf_barcodes_1d.php';

class Barcode1 extends TCPDFBarcode {

    private $code;

    function __construct($code,$type) {
//        $code = 'sss';
//        $type = 'C128';
        parent::__construct($code='sss', $type='C128');
    }

}
