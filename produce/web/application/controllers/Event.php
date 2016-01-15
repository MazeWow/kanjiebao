<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Event extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }   
    public function index() {
        $event_id = $this->input->get('event');
        $this->load->view('event.html', array('event_id'=>$event_id));
    }
}