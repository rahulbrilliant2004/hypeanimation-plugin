<?
add_shortcode( 'hypeanimations_anim', 'hypeanimations_anim');
function hypeanimations_anim($args){
	global $wpdb;
	global $table_name;
	$actid=$args['id'];
	$upload_dir = wp_upload_dir();
	$uploadfinaldir = $upload_dir['baseurl'].'/hypeanimations/';
	$output='';
	$sql = "SELECT code,slug,container,containerclass FROM ".$table_name." WHERE id='".$actid."' LIMIT 1";
	$result = $wpdb->get_results($sql);
	foreach( $result as $results ) {
		$width = "";
		$height = "";
		$type = "";
		$code = str_replace("https://", "//", html_entity_decode($results->code));
		$code = str_replace("http://", "//", html_entity_decode($results->code));
		list($before, $after) = explode('x', $results->slug, 2);
		if($before != ""){
			$width = preg_replace('/\D/', '', $before);
		}
		if($after != ""){
			$height = preg_replace('/\D/', '', $after);
			$type = preg_replace('/[0-9]/', '', $after);
		}
		if($type == 'fixed'){
			$temp = ($width != "" ? 'width="'.$width.'"' : '').' '.($width != "" ? 'height="'.$height.'"' : '');
		}else{
			$style_explode_width = explode('width', $results->code);
			$style_explode_height = explode('height', $results->code);
			$style_explode_width = explode(';', $style_explode_width[1]);
			$style_explode_height = explode(';', $style_explode_height[1]);
			$width = str_replace(":", "", $style_explode_width[0]);
			$height = str_replace(":", "", $style_explode_height[0]);
			$temp = ($width != "" ? 'width="'.$width.'"' : '').' '.($width != "" ? 'height="'.$height.'"' : '');
		}
		if ($results->container=='div') { $output.='<div '.($results->containerclass!='' ? 'class="'.$results->containerclass.'"' : '').'>'; }
		if ($results->container=='iframe') { $output.='<iframe '.$temp.' '.($results->containerclass!='' ? 'class="'.$results->containerclass.'"' : '').' src="'.site_url().'?just_hypeanimations='.$actid.'">'; }
		if ($results->container!='iframe') { $output.=$code; }
		if ($results->container=='div') { $output.='</div>'; }
		if ($results->container=='iframe') { $output.='</iframe>'; }
	}
	return $output;
}
?>