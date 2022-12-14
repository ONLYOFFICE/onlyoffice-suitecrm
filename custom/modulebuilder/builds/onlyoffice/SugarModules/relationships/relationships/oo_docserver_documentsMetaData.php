<?php
// created: 2022-11-09 13:12:09
$dictionary["oo_docserver_documents"] = array (
  'true_relationship_type' => 'one-to-one',
  'relationships' => 
  array (
    'oo_docserver_documents' => 
    array (
      'lhs_module' => 'OO_Docserver',
      'lhs_table' => 'oo_docserver',
      'lhs_key' => 'id',
      'rhs_module' => 'Documents',
      'rhs_table' => 'documents',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'oo_docserver_documents_c',
      'join_key_lhs' => 'oo_docserver_documentsoo_docserver_ida',
      'join_key_rhs' => 'oo_docserver_documentsdocuments_idb',
    ),
  ),
  'table' => 'oo_docserver_documents_c',
  'fields' => 
  array (
    0 => 
    array (
      'name' => 'id',
      'type' => 'varchar',
      'len' => 36,
    ),
    1 => 
    array (
      'name' => 'date_modified',
      'type' => 'datetime',
    ),
    2 => 
    array (
      'name' => 'deleted',
      'type' => 'bool',
      'len' => '1',
      'default' => '0',
      'required' => true,
    ),
    3 => 
    array (
      'name' => 'oo_docserver_documentsoo_docserver_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'oo_docserver_documentsdocuments_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
    5 => 
    array (
      'name' => 'document_revision_id',
      'type' => 'varchar',
      'len' => '36',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'oo_docserver_documentsspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'oo_docserver_documents_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'oo_docserver_documentsoo_docserver_ida',
      ),
    ),
    2 => 
    array (
      'name' => 'oo_docserver_documents_idb2',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'oo_docserver_documentsdocuments_idb',
      ),
    ),
  ),
);