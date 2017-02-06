<div class="delete-dialog" id="delete-dialog-{$dialogID}">
    <form action="{$parentHREF}" method = "post" enctype="multipart/form-data">
        <input type="hidden" name="delete_node" value="{$deleteContentPath}">
        <p>Are you sure you want to delete?</p>
        <input type="submit" value="OK"> </form> 
</div>
