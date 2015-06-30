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
	border:1px solid #ccc;
    <?php if(get_option('mytube_border_color')!=""){ ?>
	    border:1px solid <?php echo get_option('mytube_border_color'); ?>;
    <?php } ?>
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
	font-size: 14px;
    <?php if(get_option('mytube_text_size')!=""){ ?>
	    font-size:<?php echo get_option('mytube_text_size'); ?>px;
    <?php } ?>
	line-height: 18px;
    color:#c90808;
	<?php if(get_option('mytube_text_color')!=""){ ?>
	    color:<?php echo get_option('mytube_text_color'); ?>;
    <?php } ?>
}
.mytubeListWrapper li a:hover{
	color:#333;
    <?php if(get_option('mytube_text_hover_color')!=""){ ?>
	    color:<?php echo get_option('mytube_text_hover_color'); ?>;
    <?php } ?>
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
	background:#941414;
    <?php if(get_option('mytube_view_bg_color')!=""){ ?>
	    background:<?php echo get_option('mytube_view_bg_color'); ?>;
    <?php } ?>
	padding:0 5px;
	color:#fff;
    <?php if(get_option('mytube_view_text_color')!=""){ ?>
	    color:<?php echo get_option('mytube_view_text_color'); ?>;
    <?php } ?>
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
	border:1px solid #ccc;
    <?php if(get_option('mytube_pg_border_color')!=""){ ?>
	    border:1px solid <?php echo get_option('mytube_pg_border_color'); ?>;
    <?php } ?>
	border-radius:3px;
	color:#A3A3A3;
	<?php if(get_option('mytube_pg_text_color')!=""){ ?>
	    color:<?php echo get_option('mytube_pg_text_color'); ?>;
    <?php } ?>
	margin:0 5px;
	font-size:12px;
	font-family:Arial, Helvetica, sans-serif;
	text-decoration:none;
    <?php if(get_option('mytube_pg_bg_color')!=""){ ?>
	    background:<?php echo get_option('mytube_pg_bg_color'); ?>;
    <?php } ?>
	
}
.paginationWrap a:hover{
	background:#FFF0F0;
	<?php if(get_option('mytube_pg_hover_bg_color')!=""){ ?>
	    background:<?php echo get_option('mytube_pg_hover_bg_color'); ?>;
    <?php } ?>
	border-color:#D3B6B6;
	<?php if(get_option('mytube_pg_border_hover_color')!=""){ ?>
	    border-color:<?php echo get_option('mytube_pg_border_hover_color'); ?>;
    <?php } ?>
	color:#941414;
    <?php if(get_option('mytube_pg_hover_text_color')!=""){ ?>
	    color:<?php echo get_option('mytube_pg_hover_text_color'); ?>;
    <?php } ?>
}
.paginationWrap a.active{
	background:#941414;
	<?php if(get_option('mytube_pg_act_bg_color')!=""){ ?>
	    background:<?php echo get_option('mytube_pg_act_bg_color'); ?>;
    <?php } ?>
	border-color:#941414;
    <?php if(get_option('mytube_pg_act_bg_color')!=""){ ?>
	    border-color:<?php echo get_option('mytube_pg_act_bg_color'); ?>;
    <?php } ?>
	color:#fff;
    <?php if(get_option('mytube_pg_act_text_color')!=""){ ?>
	    color:<?php echo get_option('mytube_pg_act_text_color'); ?>;
    <?php } ?>
	
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
	/*
	.mytubeListWrapper li,
	.mytubeListWrapper li:nth-child(2n+2),
	.mytubeListWrapper li:nth-child(3n+3){
		width:32%;
		margin-right:2%;
	}
	.mytubeListWrapper li:nth-child(3n+3){
		margin-right:0;
	}
	*/
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