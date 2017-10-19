<div class="row">
  <div class="col">
    <a href="/{$nodeLink}">
      <span class="{$selectedClass}">{$childFields.title}</span>
    </a>
    {if $adminAccess}
    <button type="button" class="delete-node btn btn-primary" data-toggle="modal" data-target="#delete-dialog-{$dialogID}">
      <span><i class="fa fa-trash-o fa-lg"></i></span>
    </button>
    <button type="button" class="edit-node btn btn-primary" data-toggle="modal" data-target="#edit-dialog-{$dialogID}">
      <span><i class="fa fa-pencil-square-o fa-lg"></i></span>
    </button>
    {/if}
  </div>
</div>
