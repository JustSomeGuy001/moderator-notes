<?php

/** 
 * Widget for recording and viewing moderator-created notes on users
 * 
 */
class MODNOTES_CMP_ModNotesWidget extends BASE_CLASS_Widget
{
    public function __construct( BASE_CLASS_WidgetParameter $paramsObj )
    {
        // Call parent constructor 
        parent::__construct();
        
        // Hide widget if user is not Moderator or Admin
        if( !BOL_AuthorizationService::getInstance()->isModerator() && !OW::getUser()->isAdmin() ){
			$this->setVisible(false);
            return;
        }
        
        // Get stylesheet
        $staticUrl = OW::getPluginManager()->getPlugin('modnotes')->getStaticUrl();
        OW::getDocument()->addStyleSheet($staticUrl . 'style.css');

        // Create new form
        $modNotesForm = new Form('modNotesForm');
        $modNotesForm->setEnctype(Form::ENCTYPE_MULTYPART_FORMDATA);

        // Field for entering subject
        $fieldSubject = new TextField('subject');
        $fieldSubject->setLabel($this->text('modnotes', 'note_add_subject_label'));
        $fieldSubject->setDescription($this->text('modnotes', 'note_add_subject_description'));
        $fieldSubject->setHasInvitation(true);
        $fieldSubject->setRequired();        
        $modNotesForm->addElement($fieldSubject);

        // Field for entering content
        $fieldContent = new WysiwygTextarea('content');
        $fieldContent->setLabel($this->text('modnotes', 'note_add_content_label'));
        $fieldContent->setDescription($this->text('modnotes', 'note_add_content_description'));
        $fieldContent->setRequired();
        $modNotesForm->addElement($fieldContent);        

        // Create submit button
        $submitButton = new Submit('submit');
        $submitButton->setValue($this->text('modnotes', 'note_add_content_submit_button'));
        $modNotesForm->addElement($submitButton);

        // Add form to widget
        $this->addForm($modNotesForm);

        // Process form data after submit
        if ( OW::getRequest()->isPost() && $modNotesForm->isValid($_POST) )
        {
            // Get data from form
            $values = $modNotesForm->getValues();

            // Reset form
            $modNotesForm->reset();

            // Get values from form
            $formSubject = $values['subject'];
            $formContent = $values['content'];

            // Get memberId & moderatorId
            $memberId = $paramsObj->additionalParamList['entityId'];
            $moderatorId = OW::getUser()->getId();

            // Check that submitted data is valid
            if ( empty($memberId) || empty($moderatorId) || empty($formSubject) || empty($formContent) ) {
                OW::getFeedback()->error($this->text('modnotes', 'note_add_failure'));
                return;
            }

            // Add note to database
            $service = MODNOTES_BOL_Service::getInstance();
            $service->addNote( $memberId, $moderatorId, $formSubject, $formContent, time() );

            // Give feedback
            OW::getFeedback()->info($this->text('modnotes', 'note_add_successful'));

            // Reload profile page
            OW_ActionController::redirect();
        }	

        // Initialize arrays
        $allNotes = array();
        $deleteUrls = array();
        
        // Get list of notes for current user from database
        $notes = MODNOTES_BOL_Service::getInstance()->getNotesForUser( $paramsObj->additionalParamList['entityId'] );
        
        // Add notes from database to new array
        foreach ( $notes as $note )
        {
            $allNotes[$note->id]['id'] = $note->id;
            $allNotes[$note->id]['moderatorid'] = BOL_UserService::getInstance()->getDisplayName($note->moderatorid);
            $allNotes[$note->id]['subject'] = $note->subject;
            $allNotes[$note->id]['content'] = $note->content;
            $allNotes[$note->id]['timestamp'] = date('F jS Y h:i A', $note->timestamp);
            $deleteUrls[$note->id] = OW::getRouter()->urlFor('MODNOTES_CTRL_Note', 'delete', array('id' => $note->id));
        }
        
        // Assignments for use in widget
        $this->assign('allNotes', $allNotes);
        $this->assign('deleteUrls', $deleteUrls);
    }
    
    // Standard settings for widget
    public static function getStandardSettingValueList()
    {
        return array(
        	self::SETTING_WRAP_IN_BOX => true,
        	self::SETTING_SHOW_TITLE => true,
        	self::SETTING_ICON => self::ICON_MODERATOR,
        	self::SETTING_TITLE => OW::getLanguage()->text('modnotes', 'userprofile_widget_title')
        );
    }

    // Set access level
    public static function getAccess()
    {
        return self::ACCESS_MEMBER;
    }

    // Standard Oxwall text function
    private function text( $prefix, $key, array $vars = null )
    {
        return OW::getLanguage()->text($prefix, $key, $vars);
    }

}
