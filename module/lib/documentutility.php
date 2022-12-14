<?php

class DocumentUtility
{
    public static function GetKey($document) {
        $revisionId = $document->document_revision_id;
        $lastModified = $document->date_modified;

        $expectedKey = $revisionId . strtotime($lastModified);

        return self::GenerateRevisionId($expectedKey);
    }

    private static function GenerateRevisionId(string $expectedKey)
    {
        if (strlen($expectedKey) > 20) $expectedKey = crc32( $expectedKey);
        $key = preg_replace("[^0-9-.a-zA-Z_=]", "_", $expectedKey);
        $key = substr($key, 0, min(array(strlen($key), 20)));
        return $key;
    }
}