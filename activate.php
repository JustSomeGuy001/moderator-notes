<?php

$widgetService = BOL_ComponentAdminService::getInstance();

// Register widget, not cloneable
$widget = $widgetService->addWidget('MODNOTES_CMP_ModNotesWidget', false); 

// Add widget to profile page
$widgetPlace = $widgetService->addWidgetToPlace($widget, BOL_ComponentService::PLACE_PROFILE); 

 // Place widget on top right
$widgetService->addWidgetToPosition($widgetPlace, BOL_ComponentService::SECTION_RIGHT, 0);
