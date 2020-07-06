<?php

class MODNOTES_CLASS_EventHandler
{

	/** 
	 * Removes all notes for user, when user profile is deleted
	 * Designed to take in base.user_unregister event
	 * 
	 * @param array OW_Event
	 * 
	 */
	public function modnotesRemove( OW_Event $event )
	{
		// Get params from OW_Event
		$params = $event->getParams();
		$userId = $params['userId'];

		// Get list of all notes for user
        $list = MODNOTES_BOL_Service::getInstance()->getNotesForUser( $userId );

		// Delete notes
        foreach ( $list as $note )
        {
            MODNOTES_BOL_NotesDao::getInstance()->deleteById($note->id);
        }
	}	
	 
	// Bind modnotesRemove to user delete event
    public function init ()
    {
		OW::getEventManager()->bind('base.user_unregister', array($this, 'modnotesRemove'));
    }
}
