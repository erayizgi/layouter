<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: ERAY
 * Date: 18.11.2016
 * Time: 12:46
 */
class Layouter
{
    protected  $ci;
    protected $header;
    protected $footer;
    protected $pages = array();
    public function __construct($header = NULL, $footer = NULL)
    {
        $this->ci =&get_instance();
        $this->setHeader($header);
        $this->setFooter($footer);
    }

    /**
     * @param mixed $header
     */
    public function setHeader($header=NULL)
    {
        if($header == NULL){
            $this->header = "header";

        }else{
            $this->header = $header;
        }
    }

    /**
     * @param mixed $footer
     */
    public function setFooter($footer)
    {
        if ($footer==NULL){
            $this->footer = "footer";
        }else{
            $this->footer = $footer;
        }
    }
    public function loadHeader()
    {
        $this->ci->load->view($this->header);
    }

    public function loadFooter()
    {
        $this->ci->load->view($this->footer);
    }

    public function loadPages($pages)
    {
        foreach ($pages as $key=>$value) {
            if(!empty($value)){
                $this->ci->load->view($key,$value["data"]);
            }else{
                $this->ci->load->view($key);
            }
        }
    }

    public function setPages($page,$data=NULL)
    {
        //array_push($this->pages,$page);
        if($data != NULL){
            $this->bindData($page,$data);
            $this->bindMessage($page);
        }else{
            $this->pages[$page] = "";
            $this->bindMessage($page);
        }

    }

    public function setMessage($message, $type)
    {
        $this->ci->session->set_flashdata("error_message",$message);
        $this->ci->session->set_flashdata("error_type",$type);
    }

    public function bindMessage($page)
    {
        if($this->ci->session->flashdata("error_message")){
            $this->pages[$page]["data"]["error_message"] = $this->ci->session->flashdata("error_message");
            $this->pages[$page]["data"]["error_type"] = $this->ci->session->flashdata("error_type");
        }
    }
    public function bindData($page, $data)
    {
        $this->pages[$page]["data"] = $data;
    }


    public function render()
    {

        $this->loadHeader();
        $this->loadPages($this->pages);
        $this->loadFooter();
    }


}