<div class="row">
  <div class="col">
    <a href="/{$nodeLink}">
      <img class="fridge-picture" src="/{$childFields.fridge_picture}" data-zoom-image="/{$childFields.fridge_picture}">
      <span class="{$selectedClass}">{$childFields.title}</span>
    </a>
    {if $adminAccess}
    <span class="clone-node" for="clone-dialog-{$dialogID}"><i class="fa fa-files-o fa-lg"></i></span>
    <span class="delete-node" for="delete-dialog-{$dialogID}"><i class="fa fa-trash-o fa-lg"></i></span>
    <span class="edit-node" for="edit-dialog-{$dialogID}"><i class="fa fa-pencil-square-o fa-lg"></i></span>
    {/if}
  </div>
</div>
