<?php

if(!defined('BNC_CODE')) {
	exit('Access Denied');
}

/**
 * add slide model
 */
class slideNew extends Slide {
    /*
     * slide param
     */
    public $id;
    public $title;
    public $description;
    public $status;
    public $position;
    public $create_time;
    public $meta_title;
    public $meta_keywords;
    public $meta_description;
    public $sort;    
    public $not_in;
    
    /*
     * luu allbum
     */
    public function addSlide()
    {
    	$return['status'] = false;
    	$return['error'] = 'empty';
    	if(!empty($this->title)){
    		$data = array(
    			'idw'                    => $this->idw,
    			'title'                  => $this->title,
    			'description'            => $this->description,
    			'status'                 => $this->status,
                'sort'                   => $this->sort,
    			'position'               => $this->position,
    			'create_uid'             => $this->B['uid'],
    			'create_time'            => $this->create_time,
    			'meta_title'             => $this->meta_title,
    			'meta_keywords'          => $this->meta_keywords,
    			'meta_description'       => $this->meta_description,    			
                ); 
    		$this->objTable = new Model($this->getLangAndID['lang'].'_slide');
            $return['last_id'] = $result = $this->objTable->insert($data); //insert data
            
            if ($return['last_id']){
            	$this->idSlideOfPic($return['last_id'], $this->tmp_id);
            	$return['status'] = true;
            }else{
            	$return['status'] = false;
            	$return['error'] = $this->objTable->getLastError();
            }
        }
        return $return;
    }
    /*
     * cap nhat id slide cho anh
     */
    public function idSlideOfPic($slide_id, $tmp_id)
    {
    	$this->objTable = new Model($this->lang.'_slide_images');
    	$data = array(
    		'slide_id' => $slide_id
    		);
    	$this->objTable->where('idw',$this->idw);
    	$this->objTable->where('tmp_id',$tmp_id);
    	$this->objTable->update($data);
    } 
}