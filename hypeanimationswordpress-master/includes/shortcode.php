<?
add_shortcode( 'hypeanimations_anim', 'hypeanimations_anim');
function hypeanimations_anim($args){
	global $wpdb;
	global $table_name;
	$actid=$args['id'];
	$upload_dir = wp_upload_dir();
	$uploadfinaldir = $upload_dir['baseurl'].'/hypeanimations/';
	$output='';
	$sql = "SELECT code,container,containerclass FROM ".$table_name." WHERE id='".$actid."' LIMIT 1";
	$result = $wpdb->get_results($sql);
	foreach( $result as $results ) {
		if ($results->container=='div') { $output.='<div '.($results->containerclass!='' ? 'class="'.$results->containerclass.'"' : '').'>'; }
		if ($results->container=='iframe') { $output.='<iframe '.($results->containerclass!='' ? 'class="'.$results->containerclass.'"' : '').' src="'.site_url().'?just_hypeanimations='.$actid.'">'; }
		if ($results->container!='iframe') { $output.=html_entity_decode($results->code); }
		if ($results->container=='div') { $output.='</div>'; }
		if ($results->container=='iframe') { $output.='</iframe>'; }
	}
	return $output;
}
?>