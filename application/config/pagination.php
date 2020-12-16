<?php 
$config['per_page'] = 10;

$config['use_page_numbers'] = TRUE;
            $config['reuse_query_string'] = TRUE;
            
$config['full_tag_open'] = '<ul class="justify-content-center pagination">';
$config['full_tag_close'] = '</ul>';

$config['first_link'] = 'First';
$config['first_tag_open'] = '<li class="page-item disabled">';
$config['first_tag_close'] = '</li>';

$config['last_link'] = 'Last';
$config['last_tag_open'] = '<li class="page-item">';
$config['last_tag_close'] = '</li>';

$config['next_link'] = 'Next';
$config['next_tag_open'] = '<li class="page-item">';
$config['next_tag_close'] = '</li>';

$config['prev_link'] = 'Previous';
$config['prev_tag_open'] = '<li class="page-item">';
$config['prev_tag_close'] = '</li>';

$config['num_tag_open'] = '<li class="page-item">';
$config['num_tag_close'] = '</li>';

$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#" id="active-page">';
$config['cur_tag_close'] = '</a></li>';



$config['attributes'] = array('class' => 'page-link');
