<div style="width: 100%; height: 100vh;">
    <div id="editorFrame" />
</div>
<script type="text/javascript" src={$documentServerUrl}/web-apps/apps/api/documents/api.js></script>
<script type="text/javascript">
    var config = {$config}
    var docEditor = new DocsAPI.DocEditor("editorFrame", config);
</script>