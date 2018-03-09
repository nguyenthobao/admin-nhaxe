<?php

if(!defined('BNC_CODE')) {
    exit('Access Denied');
}

/**
 * home model
 */
 class home extends Slide {
    /*
     * get list param
     */
    public $title;
    public $status;
    public $search;
    public $start=0;
    public $max_rec=10;//num rec
    public $num_display=5;//paging 
    public $url;
    public $paging;
    public $time_now;
    public $total;
    
    public function getList()
    {
        $this->objTable = new Model($this->getLangAndID['lang'].'_slide');
        $select = array('id','id_lang','title','status','sort','position',);
        
        //paging
        $this->objTable->where('idw',$this->idw);
        if($this->search){
            if($this->title!='') $this->objTable->where('title',"%".$this->title."%",'LIKE');
            if($this->status!='' && $this->status!=2) $this->objTable->where('status',$this->status);
        }
        
        $total = $this->objTable->num_rows();
        $this->total = $total;
        $page = pagination($this->max_rec, $total, $this->num_display, $this->url);
        $this->start = $page['start'];
        $this->paging = $page['pagination'];
        //paging end*/
        
        $this->objTable->where('idw',$this->idw);
        if($this->search){
            if($this->title!='') $this->objTable->where('title',"%".$this->title."%",'LIKE');
            if($this->status!='' && $this->status!=2) $this->objTable->where('status',$this->status);
        }
        
        $this->objTable->orderBy('create_time','DESC');
        $data = $this->objTable->get(null,array($this->start,$this->max_rec),$select);
        
        // if($this->getLangAndID['lang']!=$this->lang){
        //     foreach ($data as $k => $v) {
        //         $v['id'] = $v['id_lang'];
        //         $data[$k] = $v;
        //     }
        // }
        
        if ($data) {
            return $data;
        } 
    }

 }
