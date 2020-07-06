<?php

/**
 * Data Access Object for `modnotes_notes` table.
 *
 */
class MODNOTES_BOL_NotesDao extends OW_BaseDao
{

     /**
     * Constructor.
     *
     */
    protected function __construct()
    {
        parent::__construct();
    }

	
    /**
     * Singleton instance.
     *
     * @var MODNOTES_BOL_NotesDao
     */
    private static $classInstance;

    /**
     * Returns an instance of class (singleton pattern implementation).
     *
     * @return MODNOTES_BOL_NotesDao
     */
    public static function getInstance()
    {
        if ( self::$classInstance === null )
        {
            self::$classInstance = new self();
        }

        return self::$classInstance;
    }

    /**
     * @see OW_BaseDao::getDtoClassName()
     *
     */
    public function getDtoClassName()
    {
        return 'MODNOTES_BOL_Notes';
    }

    /**
     * @see OW_BaseDao::getTableName()
     *
     */
    public function getTableName()
    {
        return OW_DB_PREFIX . 'modnotes_notes';
    } 

    /** 
     * Find list of all moderator notes for given user
     * 
     * @param integer $userId
     * @return array
     * 
     */
    public function findNotesForUser( $userId ) {
        $example = new OW_Example();
        $example->andFieldEqual( 'memberid', $userId );
        $example->setOrder('`timestamp` DESC');

        return $this->findListByExample($example);
    }

} 
