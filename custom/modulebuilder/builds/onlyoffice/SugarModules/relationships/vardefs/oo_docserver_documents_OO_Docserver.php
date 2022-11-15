<?php
// created: 2022-11-09 13:12:09
$dictionary["OO_Docserver"]["fields"]["oo_docserver_documents"] = array (
  'name' => 'oo_docserver_documents',
  'type' => 'link',
  'relationship' => 'oo_docserver_documents',
  'source' => 'non-db',
  'module' => 'Documents',
  'bean_name' => 'Document',
  'vname' => 'LBL_OO_DOCSERVER_DOCUMENTS_FROM_DOCUMENTS_TITLE',
  'id_name' => 'oo_docserver_documentsdocuments_idb',
);
$dictionary["OO_Docserver"]["fields"]["oo_docserver_documents_name"] = array (
  'name' => 'oo_docserver_documents_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_OO_DOCSERVER_DOCUMENTS_FROM_DOCUMENTS_TITLE',
  'save' => true,
  'id_name' => 'oo_docserver_documentsdocuments_idb',
  'link' => 'oo_docserver_documents',
  'table' => 'documents',
  'module' => 'Documents',
  'rname' => 'document_name',
);
$dictionary["OO_Docserver"]["fields"]["oo_docserver_documentsdocuments_idb"] = array (
  'name' => 'oo_docserver_documentsdocuments_idb',
  'type' => 'link',
  'relationship' => 'oo_docserver_documents',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'left',
  'vname' => 'LBL_OO_DOCSERVER_DOCUMENTS_FROM_DOCUMENTS_TITLE',
);
