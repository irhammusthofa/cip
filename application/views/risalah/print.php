<?php

use Sunra\PhpSimple\HtmlDomParser;
use Dompdf\Dompdf;
foreach ($data['bab_risalah'] as $item) {
	$param['id_bab'] 	= $item->br_kode;
	$param['id_cip']	= $data['id_cip'];
	$data_bab = $this->m_bab->by_id($param['id_bab'])->row();
	if($data_bab->br_jenis==0){
		$risalah 		= $this->m_risalah->reditor_bab_by_cip_2($param)->result();
	}else{
		$risalah 		= $this->m_risalah->reditor_bab_by_cip($param)->result();
	}
	
	$data['val'] 	= '';
	$bab_risalah 	= '';
	$langkah 		= '';
	$sub_bab 		= '';
	if (count($risalah)>0){
		foreach ($risalah as $row) {
			if (!empty($row->r_value)){
				$dom = HtmlDomParser::str_get_html( $row->r_value );
				$elems = $dom->find('body',0)->innertext();
				if ($bab_risalah != $row->br_kode){
					$bab_risalah = $row->br_kode;
					$data['val'] .= '<h3>'.$row->br_bab.'</h3>';
				}
				if ($langkah != $row->ln_id){
					$langkah = $row->ln_id;
					$data['val'] .= '<h4>'.$row->ln_langkah.'</h4>';
				}
				if($data_bab->br_jenis==1){
					if ($sub_bab != $row->sb_id){
						$sub_bab = $row->sb_id;
						$data['val'] .= '<h5>'.$row->sb_sub_bab.'</h5>';
					}
				}
				
				$data['val'] .= $elems;
			}
		}
	}
	echo $data['val'];      
}