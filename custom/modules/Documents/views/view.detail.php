<?php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once 'modules/Documents/views/view.detail.php';

class CustomDocumentsViewDetail extends DocumentsViewDetail {
    function display() {
        parent::display();

        $js = <<<JS
            <script type="text/javascript">
                document.addEventListener("DOMContentLoaded", function(){
                    var tab = document.querySelector("#tab-actions .dropdown-menu");
                    var li = document.createElement("li");
                    var input = document.createElement("input");
                    input.className = "button";
                    input.type = "button";
                    input.title = "Open in ONLYOFFICE";
                    input.value = "Open in ONLYOFFICE";
                    input.onclick = function(){
                        var id = [...document.getElementById("formDetailView").children].find((child) => child.name === "record").value;
                        window.location.href="index.php?module=Onlyoffice&action=editor&record=" + id;
                    };
                    li.appendChild(input);
                    tab.appendChild(li);
                });
            </script>
        JS;

        print $js;
    }
}