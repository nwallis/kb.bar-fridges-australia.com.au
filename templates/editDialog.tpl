<div class="edit-dialog" id="edit-dialog-{$dialogID}">
    <form action="" method = "post" enctype="multipart/form-data">

        {include file="descriptors.tpl"}

        <input type="hidden" name="parent_node" value="{$encodedContentPath}">

        <input type="submit" value="Save">
    </form> 
</div>
