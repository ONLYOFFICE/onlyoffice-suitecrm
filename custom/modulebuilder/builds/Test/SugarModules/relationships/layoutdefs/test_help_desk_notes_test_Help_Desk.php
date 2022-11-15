<?php
 // created: 2022-11-09 11:23:36
$layout_defs["test_Help_Desk"]["subpanel_setup"]['test_help_desk_notes'] = array (
  'order' => 100,
  'module' => 'Notes',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_TEST_HELP_DESK_NOTES_FROM_NOTES_TITLE',
  'get_subpanel_data' => 'test_help_desk_notes',
  'top_buttons' => 
  array (
    0 => 
    array (
      'widget_class' => 'SubPanelTopButtonQuickCreate',
    ),
    1 => 
    array (
      'widget_class' => 'SubPanelTopSelectButton',
      'mode' => 'MultiSelect',
    ),
  ),
);
