<?php 

$install_flag = TRUE;
if($install_flag === FALSE){
	$redir = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
			  $redir .= "://".$_SERVER['HTTP_HOST'];
			  $redir .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
			  $redir = str_replace('install/','',$redir); 
			  header( 'Location:'.$redir.'admin', 'refresh') ;
}