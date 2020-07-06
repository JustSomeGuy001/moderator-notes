<?php 

class MODNOTES_BOL_Service
{
    /**
     * Class instance
     *
     * @var MODNOTES_BOL_Service
     */
    private static $classInstance;
    
    /**
     * Returns class instance
     *
     * @return MODNOTES_BOL_Service
     */
    public static function getInstance()
    {
        if ( null === self::$classInstance )
        {
            self::$classInstance = new self();
        }

        return self::$classInstance;
    }
    
    /**
     *
     * @var MODNOTES_BOL_NotesDao
     */
     private $notesDao;
    
    private function __construct()
    {
        $this->notesDao = MODNOTES_BOL_NotesDao::getInstance();
    }

    /**
     * Adds a new note to database
     * 
     * @param integer $memberId
     * @param integer $moderatorId
     * @param string $subject
     * @param string $content
     * @param integer $currentTimeStamp
     * 
     */
    public function addNote( $memberId, $moderatorId, $subject, $content, $timeStamp )
    {
        $notes = new MODNOTES_BOL_Notes();
        $notes->memberid = $memberId;
        $notes->moderatorid = $moderatorId;
        $notes->subject = $subject;
        $notes->content = $content;
        $notes->timestamp = $timeStamp;
        
        $this->notesDao->save($notes);
    }
     
    /**
     * Deletes note from database
     * 
     * @param integer $id
     * 
     */
    public function deleteDatabaseRecord( $id )
    {
        $this->notesDao->deleteById($id);
    }

    /**
     * Returns a list of all the notes for a user
     * 
     * @param integer $userId
     * 
     */
    public function getNotesForUser( $userId )
    {
        return $this->notesDao->findNotesForUser( $userId );
    }

}
