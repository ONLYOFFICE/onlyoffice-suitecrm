<?php
// created: 2022-11-09 13:12:09
$dictionary["Document"]["fields"]["oo_docserver_documents"] = array (
  'name' => 'oo_docserver_documents',
  'type' => 'link',
  'relationship' => 'oo_docserver_documents',
  'source' => 'non-db',
  'module' => 'OO_Docserver',
  'bean_name' => false,
  'vname' => 'LBL_OO_DOCSERVER_DOCUMENTS_FROM_OO_DOCSERVER_TITLE',
  'id_name' => 'oo_docserver_documentsoo_docserver_ida',
);
$dictionary["Document"]["fields"]["oo_docserver_documents_name"] = array (
  'name' => 'oo_docserver_documents_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_OO_DOCSERVER_DOCUMENTS_FROM_OO_DOCSERVER_TITLE',
  'save' => true,
  'id_name' => 'oo_docserver_documentsoo_docserver_ida',
  'link' => 'oo_docserver_documents',
  'table' => 'oo_docserver',
  'module' => 'OO_Docserver',
  'rname' => 'document_name',
);
$dictionary["Document"]["fields"]["oo_docserver_documentsoo_docserver_ida"] = array (
  'name' => 'oo_docserver_documentsoo_docserver_ida',
  'type' => 'link',
  'relationship' => 'oo_docserver_documents',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'left',
  'vname' => 'LBL_OO_DOCSERVER_DOCUMENTS_FROM_OO_DOCSERVER_TITLE',
);
