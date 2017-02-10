<div>
    <a href="/{$nodeLink}">
        <span class="{$selectedClass}">{$childFields.title}</span>
    </a>
    {if $adminAccess}
        <span class="delete-node" for="delete-dialog-{$dialogID}"><i class="fa fa-trash-o fa-lg"></i></span>
        <span class="edit-node" for="edit-dialog-{$dialogID}"><i class="fa fa-pencil-square-o fa-lg"></i></span>
    {/if}
</div>
