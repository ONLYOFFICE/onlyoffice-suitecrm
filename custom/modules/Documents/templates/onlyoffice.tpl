<div style="width: 100%; height: 100vh;">
 <div id='onlyoffice_editor' />
</div>
<script type="text/javascript" src={$doc_url}/web-apps/apps/api/documents/api.js></script>
<script type="text/javascript">
	var uid = '{$user->id}';
	var uname = '{$user->name}';
	var doc_id = '{$document->id}';
	var filename = '{$document->filename}';
	var doc_key = '{$doc_key}';
	var rurl = '{$root}';

	{literal}
		var config = {
		    "document": {
			"fileType": filename.split('.').pop(),
			"key": doc_key,
			"title": filename,
			"url": rurl+"index.php?entryPoint=onlyofficeDownload&id="+doc_id+"&type=Documents",
		    },
		    "editorConfig": {
			"callbackUrl": rurl+"index.php?entryPoint=onlyofficeCallback&record="+doc_id,
			"user": {
			   "id": uid,
			   "name": uname,
			},
		    },
		};
		var docEditor = new DocsAPI.DocEditor("onlyoffice_editor", config);
	{/literal}
</script>
