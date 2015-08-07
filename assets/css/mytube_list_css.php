<?php
	require_once("../../../../../wp-blog-header.php");
	require_once("../../../../../wp-config.php");
	
	global $wpdb;

   	$mytubeListWrapper_li = "border:1px solid #ccc;";
    if(get_option('mytube_border_color')!=""){
		$mytubeListWrapper_li = "border:1px solid ".get_option('mytube_border_color').";";
	}
	
	$mytubeListWrapper_li_a_1 = "font-size: 14px;";
    if(get_option('mytube_text_size')!=""){
		$mytubeListWrapper_li_a_1 = "font-size:".get_option('mytube_text_size')."px;";
    }
	
	$mytubeListWrapper_li_a_2 = "color:#c90808;";
    if(get_option('mytube_text_size')!=""){
		$mytubeListWrapper_li_a_2 =  "color:".get_option('mytube_text_color').";";
    }
	
	$mytubeListWrapper_li_a_hover = "color:#333;";
    if(get_option('mytube_text_hover_color')!=""){
	    $mytubeListWrapper_li_a_hover = "color:".get_option('mytube_text_hover_color').";";
    }
	
	$mytubeListWrapper_li_mytubeListView_1 = "background:#941414;";
	if(get_option('mytube_view_bg_color')!=""){
		$mytubeListWrapper_li_mytubeListView_1 = "background:".get_option('mytube_view_bg_color').";";
	}
	
	$mytubeListWrapper_li_mytubeListView_2 = "color:#fff;";
	if(get_option('mytube_view_text_color')!=""){
		$mytubeListWrapper_li_mytubeListView_2 = "color:".get_option('mytube_view_text_color').";";
	}
	
	$paginationWrap_a_1 = "border:1px solid #ccc;";
	if(get_option('mytube_pg_border_color')!=""){
		$paginationWrap_a_1 = "border:1px solid ".get_option('mytube_pg_border_color').";";
	}
	
	$paginationWrap_a_2 = "color:#A3A3A3;";
	if(get_option('mytube_pg_text_color')!=""){
		$paginationWrap_a_2 = "color:".get_option('mytube_pg_text_color').";";
	}
	
	$paginationWrap_a_3 = "";
	if(get_option('mytube_pg_bg_color')!=""){
		$paginationWrap_a_3 = "background:".get_option('mytube_pg_bg_color').";";
	}
	
	$paginationWrap_a_hover_1 = "background:#FFF0F0;";
	if(get_option('mytube_pg_hover_bg_color')!=""){
		$paginationWrap_a_hover_1 = "background:".get_option('mytube_pg_hover_bg_color').";";
	}
	
	$paginationWrap_a_hover_2 = "border-color:#D3B6B6;";
	if(get_option('mytube_pg_border_hover_color')!=""){
		$paginationWrap_a_hover_2 = "border-color:".get_option('mytube_pg_border_hover_color').";";
	}
	
	$paginationWrap_a_hover_3 = "color:#941414;";
	if(get_option('mytube_pg_hover_text_color')!=""){
		$paginationWrap_a_hover_3 = "color:".get_option('mytube_pg_hover_text_color').";";
	}
	
	$paginationWrap_a_active_1 = "background:#941414;";
	if(get_option('mytube_pg_act_bg_color')!=""){
		$paginationWrap_a_active_1 = "background:".get_option('mytube_pg_act_bg_color').";";
	}
	
	$paginationWrap_a_active_2 = "border-color:#941414;";
	if(get_option('mytube_pg_act_bg_color')!=""){
		$paginationWrap_a_active_2 = " border-color:".get_option('mytube_pg_act_bg_color').";";
	}
		
	$paginationWrap_a_active_3 = "color:#fff;";
	if(get_option('mytube_pg_act_text_color')!=""){
		$paginationWrap_a_active_3 = "color:".get_option('mytube_pg_act_text_color').";";
	}
	
	
	$custom_css = "
.mytubeListWrapper{
	width:100%;
	overflow:hidden;
	padding-left:0;
	margin:20px 0 15px 0;
}
.mytubeListWrapper li{
	list-style:none;
	width:32%;
	float:left;
	margin-right:2%;
	
	".$mytubeListWrapper_li."	
	
	-webkit-box-sizing:border-box;
	-moz-box-sizing:border-box;
	-o-box-sizing:border-box;
	box-sizing:border-box;
	margin-bottom:10px;
	padding:5px;
	position:relative;
	height: 170px;
	overflow:hidden;
}
.vimeoVid li{
	height: 210px;
}
.mytubeListWrapper li:nth-child(3n+3){
	margin-right:0;
}
.mytubeListTwo li,
.mytubeListTwo li:nth-child(3n+3){
	width:49%;
	margin-right:2%;
	height: 210px;
}
.mytubeListTwo li:nth-child(2n+2){
	margin-right:0;
}

.mytubeListTwo.vimeoVid li{
    height: 270px;
}

.mytubeListFour li,
.mytubeListFour li:nth-child(3n+3){
	width:24%;
	margin-right:1.3%;
	height: 170px;
}
.mytubeListFour li:nth-child(4n+4){
	margin-right:0;
}

.mytubeListWrapper li img{
	width:100%;
	display:block;
	margin-bottom:4px;
}
.mytubeListWrapper li a{
	display:block;
	
	".$mytubeListWrapper_li_a_1."
	
	line-height: 18px;
    
	".$mytubeListWrapper_li_a_2."
}
.mytubeListWrapper li a:hover{
	".$mytubeListWrapper_li_a_hover."
	text-decoration:underline;
}
.mytubeListWrapper li span{
	display:block;
	clear:both;
	font-size:12px;
	color:#999;
}
.mytubeListWrapper li .mytubeListView{
	position:absolute;
	right:0;
	top:0;
	padding:5px 10px;
	
	".$mytubeListWrapper_li_mytubeListView_1."
	
	padding:0 5px;
	
    ".$mytubeListWrapper_li_mytubeListView_2."
	
	height:30px;
	line-height:30px;
	text-align:center;
}
.paginationWrap{
	clear:both;
	overflow:hidden;
}
.paginationWrap a{
	float:left;
	display:block;
	min-width:10px;
	text-align:center;
	padding:7px 8px;
	
    ".$paginationWrap_a_1."
	
	border-radius:3px;
	
	".$paginationWrap_a_2."
	
	margin:0 5px;
	font-size:12px;
	font-family:Arial, Helvetica, sans-serif;
	text-decoration:none;
	
    ".$paginationWrap_a_3."
}

.paginationWrap a:hover{
	".$paginationWrap_a_hover_1."
	".$paginationWrap_a_hover_2."
	".$paginationWrap_a_hover_3."
}
.paginationWrap a.active{
	
	".$paginationWrap_a_active_1."
	".$paginationWrap_a_active_2."
	".$paginationWrap_a_active_3."
	
}

@media screen and (max-width:1000px){
	.mytubeListWrapper li,
	.mytubeListWrapper li:nth-child(3n+3){
		width:49%;
		margin-right:2%;
		height: 210px;
	}
	.mytubeListWrapper li:nth-child(2n+2){
		margin-right:0;
	}
	.vimeoVid li{
		height: 270px !important;
	}
}
@media screen and (max-width:768px){
	.vimeoVid li {
		height: 245px !important;
	}
}
@media screen and (max-width:480px){
	.mytubeListWrapper li,
	.mytubeListWrapper li:nth-child(3n+3),
	.mytubeListWrapper li:nth-child(2n+2){
		width:100%;
		margin-right:0;
		height:auto;
	}
	.mytubeListWrapper li a {
		font-size: 12px;
		line-height: 16px;
	}
	.mytubeListWrapper li span {
		font-size: 10px;
	}
	.vimeoVid li {
		height: auto !important;
	}
}
";
