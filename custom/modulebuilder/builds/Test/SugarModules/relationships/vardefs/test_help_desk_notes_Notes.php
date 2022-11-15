<?php
// created: 2022-11-09 11:23:36
$dictionary["Note"]["fields"]["test_help_desk_notes"] = array (
  'name' => 'test_help_desk_notes',
  'type' => 'link',
  'relationship' => 'test_help_desk_notes',
  'source' => 'non-db',
  'module' => 'test_Help_Desk',
  'bean_name' => false,
  'vname' => 'LBL_TEST_HELP_DESK_NOTES_FROM_TEST_HELP_DESK_TITLE',
  'id_name' => 'test_help_desk_notestest_help_desk_ida',
);
$dictionary["Note"]["fields"]["test_help_desk_notes_name"] = array (
  'name' => 'test_help_desk_notes_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_TEST_HELP_DESK_NOTES_FROM_TEST_HELP_DESK_TITLE',
  'save' => true,
  'id_name' => 'test_help_desk_notestest_help_desk_ida',
  'link' => 'test_help_desk_notes',
  'table' => 'test_help_desk',
  'module' => 'test_Help_Desk',
  'rname' => 'name',
);
$dictionary["Note"]["fields"]["test_help_desk_notestest_help_desk_ida"] = array (
  'name' => 'test_help_desk_notestest_help_desk_ida',
  'type' => 'link',
  'relationship' => 'test_help_desk_notes',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_TEST_HELP_DESK_NOTES_FROM_NOTES_TITLE',
);
