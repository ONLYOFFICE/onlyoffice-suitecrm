<div id="onlyoffice-app">
    <div id="editorFrame" />
</div>
<script type="text/javascript" src={$documentServerUrl}/web-apps/apps/api/documents/api.js></script>
<script type="text/javascript">
    var config = {$config};
    var errMsg = "{$msgCanNotBeReached}";

    {literal}
        document.addEventListener("DOMContentLoaded", function(event) {
            if (typeof DocsAPI === "undefined") {
                const errorNode = document.createElement("p");
                errorNode.className = "error";

                const errorText = document.createTextNode(errMsg);
                errorNode.appendChild(errorText);
                errorNode.style.display = "block";

                const contentNode = document.getElementById("pagecontent");
                if (contentNode) {
                    contentNode.insertBefore(errorNode, contentNode.firstChild);
                }

                return;
            }

            if (config["type"] === "mobile") {
                document.body.classList.add("onlyoffice-mobile-mode");
            }

            var docEditor = new DocsAPI.DocEditor("editorFrame", config);
        });
    {/literal}
</script>
<style>
    {literal}
        #onlyoffice-app {
            width: 100%;
            height: calc(100vh - 60px);
            margin-top: -40px;
            margin-bottom: -40px;
        }

        body.onlyoffice-mobile-mode {
            overflow: hidden;
        }

        .onlyoffice-mobile-mode .mobile-bar {
            display: none;
        }

        .onlyoffice-mobile-mode #onlyoffice-app {
            height: calc(100vh - 60px - 60px) !important;
            margin-top: -80px;
        }

        .onlyoffice-mobile-mode #onlyoffice-app > iframe {
            position: inherit !important;
            margin-top: 10px;
        }

        .error,
        footer {
            display: none;
        }
    {/literal}
</style>