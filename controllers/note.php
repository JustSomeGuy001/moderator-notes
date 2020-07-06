<?php

// Controller class for modnotes
class MODNOTES_CTRL_Note extends OW_ActionController {

    /** 
     * Delete note from database
     * 
     * @param array $params
     * 
     */
    public function delete( $params )
    {
        // Check if user is mod or admin
        if( !BOL_AuthorizationService::getInstance()->isModerator() && !OW::getUser()->isAdmin() ){
            return;
        }

        // Check if email id was sent
        if ( isset($params['id']) )
        {
            // Delete email from database
            MODNOTES_BOL_Service::getInstance()->deleteDatabaseRecord($params['id']);

            // Give feedback
            OW::getFeedback()->info( OW::getLanguage()->text('modnotes', 'note_delete_success') );
        }

        // Redirect back to referring page
        $this->redirect( $_SERVER['HTTP_REFERER'] );
    }
}