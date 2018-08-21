<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function html2pdf($html, $filename="quote_template", $stream=TRUE, $size='letter', $orientation='portrait', $is_full_filename=FALSE){
    $CI = & get_instance();
    require_once APPPATH.'libraries/dompdf/dompdf_config.inc.php';
    $dompdf=null;
    $dompdf = new DOMPDF();
    $dompdf->set_paper($size, $orientation);
    $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
    $dompdf->load_html($html, 'UTF-8');
    $dompdf->render();
    if ($stream) {
        $dompdf->stream($filename.".pdf", array('Attachment'=>false));
        return 0;
    } else {
        $CI->load->helper('file');
		if(!$is_full_filename){
			write_file(FT_SITE_CACHE_PDF_DIR . $filename . '.pdf', $dompdf->output());
		}
		else{
			write_file($filename, $dompdf->output());
		}
        return 1;
    }
}

//Ken Added
define('PDF_MAGIC', "\x25\x50\x44\x46\x2D");
function is_pdf($filename) {
	return (file_get_contents($filename, false, null, 0, strlen(PDF_MAGIC)) === PDF_MAGIC) ? true : false;
}
