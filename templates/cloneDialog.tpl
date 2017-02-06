<div class="clone-dialog" id="clone-dialog-{$dialogID}">
    <form action="" method = "post" enctype="multipart/form-data">
        
        {include file="descriptors.tpl"}

        <input type="hidden" name="parent_node" value="{$encodedContentPath}">
        <input type="hidden" name="clone_node" value="{$dialogID}">
        <input type="submit" value="Save">
    </form> 
</div>
