<?php
$data['title'] = $title;
$this->load->view('templates/header', $data);
$this->load->view($main_content, $data);
$this->load->view('templates/footer');
?>
