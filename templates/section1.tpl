<div class="row knowledgebase-row">
  <div class="col">
    <a href="/{$nodeLink}">
      <img class="fridge-picture" src="/{$childFields.fridge_picture}" data-zoom-image="/{$childFields.fridge_picture}">
      <span class="{$selectedClass}">{$childFields.title}</span>
    </a>
    {if $adminAccess}
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#clone-dialog-{$dialogID}">
      <span><i class="fa fa-files-o fa-lg"></i></span>
    </button>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#delete-dialog-{$dialogID}">
      <span><i class="fa fa-trash-o fa-lg"></i></span>
    </button>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit-dialog-{$dialogID}">
      <span><i class="fa fa-pencil-square-o fa-lg"></i></span>
    </button>
    {/if}
  </div>
</div>
