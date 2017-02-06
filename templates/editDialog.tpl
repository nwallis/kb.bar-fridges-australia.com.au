<div class="edit-dialog" id="edit-dialog-{$dialogID}">
    <form action="{$parentHREF}" method = "post" enctype="multipart/form-data">
        {include file="descriptors.tpl"}
        <input type="hidden" name="parent_node" value="{$encodedContentPath}">
        <input type="hidden" name="edit_node_guid" value="{$dialogID}">
        <input type="submit" value="Save">
    </form> 
</div>
