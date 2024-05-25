<?php

function is_login(){
	$CI =& get_instance();
	
	if($CI->session->userdata('login') == FALSE){
		$CI->session->set_flashdata('error', 'Please sign in.');
		redirect('login');
	}
}
	
function is_admin()
{
	$CI =& get_instance();

	is_login();
	
	if($CI->session->userdata('role') != 1){
		redirect('errors');
	}
}
	
function is_admin_boolean()
{
	$CI =& get_instance();

	if($CI->session->userdata('role') == 1){
		return TRUE;
	}
}

function hashEncrypt($input){

	$hash = password_hash($input, PASSWORD_DEFAULT);
	
	return $hash;
}
	
function hashEncryptVerify($input, $hash){
	
	if(password_verify($input, $hash)){
	  return true;
	}else{
	  return false;
	}
}

function dd($input) {
	var_dump($input);
	die;
}

if(!function_exists('print_rr')){
	function print_rr($array){
		$count = count($array);
		if(($count) > 0) {
			foreach($array as $key=>$value){
				if(is_array($value)){
					$id = md5(rand());
					echo '[<a href="#" onclick="return expandParent(\''.$id.'\')">'.$key.'</a>]<br />';
					echo '<div id="'.$id.'" style="display:none;margin:10px;border-left:1px solid; padding-left:5px;">';
					print_rr($value, $count);
					echo '</div>';
				} else {
					echo "<b>&nbsp;&nbsp;&nbsp;&nbsp;$key</b>: ".htmlentities($value)."<br />";
				}
			}
			echo '
			<script language="Javascript">
				function expandParent(id){
					toggle="block";
					if(document.getElementById(id).style.display=="block"){
						toggle="none"
					}
					document.getElementById(id).style.display=toggle
					return false;
				};
			</script>
			';
		} else {
			echo "data kosong";
		}
	}
}

if(!function_exists('grouping_array_by_value')) {
	function grouping_array_by_value($array = array(), $key_arr = "") {
		$output = array();
		if(count($array) > 0) {
			foreach($array as $key => $subarr) {
				if (!isset($output[$subarr[$key_arr]])) {
					$output[$subarr[$key_arr]] = array();
				}
				$output[$subarr[$key_arr]][$key] = $subarr;
			}
		}
		return $output;
	}
}

function createSlug($text, $divider = '-') {
	 // replace non letter or digits by divider
	 $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

	 // transliterate
	 $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
   
	 // remove unwanted characters
	 $text = preg_replace('~[^-\w]+~', '', $text);
   
	 // trim
	 $text = trim($text, $divider);
   
	 // remove duplicate divider
	 $text = preg_replace('~-+~', $divider, $text);
   
	 // lowercase
	 $text = strtolower($text);
   
	 if (empty($text)) {
	   return 'n-a';
	 }
   
	 return $text;
} 

function searchForSlug($slug, $array) {
	foreach ($array as $key => $val) {
		if ($val['slug'] === $slug) {
			return $val;
		}
	}
	return null;
 }
 