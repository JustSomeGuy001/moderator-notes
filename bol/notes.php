<?php

/**
 * Data Transfer Object for 'modnotes_notes'
 */
class MODNOTES_BOL_Notes extends OW_Entity
{
	/**
     *
     * @var int
     */
    public $id;

    /**
     *
     * @var int
     */
    public $memberid;

    /**
     *
     * @var int
     */
    public $moderatorid;
           
    /**
     *
     * @var string
     */
    public $subject;

    /**
     *
     * @var string
     */
    public $content;
    
    /**
     *
     * @var int
     */
    public $timestamp;
}
