<div id="onlyoffice-app">
    <div id="editorFrame" />
</div>
<script type="text/javascript" src={$documentServerUrl}/web-apps/apps/api/documents/api.js></script>
<script type="text/javascript">
    var config = {$config}

    {literal}
        document.addEventListener("DOMContentLoaded", function(event) {
            if (typeof DocsAPI === 'undefined') {
                return;
            }

            var docEditor = new DocsAPI.DocEditor("editorFrame", config);
        });
    {/literal}
</script>
<style>
    {literal}
        #onlyoffice-app {
            width: 100%;
            height: 879px;
            margin-top: -40px;
            margin-bottom: -40px;
        }

        .error,
        footer {
            display: none;
        }
    {/literal}
</style>