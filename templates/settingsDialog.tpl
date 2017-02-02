<div class="add-node" for="settings-dialog-{$dialogID}">+</div>

<div class="settings-dialog" id="settings-dialog-{$dialogID}">
    <form action="" method = "post" enctype="multipart/form-data">
        
        {include file="descriptors.tpl"}

        <input type="hidden" name="parent_node" value="{$encodedContentPath}">
        <input type="submit" value="Save">

    </form> 
</div>
