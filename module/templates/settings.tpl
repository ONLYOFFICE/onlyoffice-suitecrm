<form name="onlyoffice_settings" method="POST" >
    <table width="100%" cellpadding="0" cellspacing="0" border="0" class="actionsContainer">
        <tbody>
            <tr>
                <td style="padding-bottom: 2px;">
                    <input id="btn_save" class="button primary" type="submit" name="save" value="Save" accesskey="a">
                    &nbsp;
                    <input id="btn_cancel" class="button" type="button" name="cancel" value="Cancel">
                </td>
            </tr>
        </tbody>
    </table>

    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <td width="15%" scope="row" nowrap="">
                    <span>Document server address</span>
                </td>
                <td width="35%">
                    <span>
                        <input name="documentServerUrl" tabindex="1" size="30" maxlength="50" type="text" value="{$documentServerUrl}">
                    </span>
                </td>
            </tr>
        </tbody>
    </table>
</form>