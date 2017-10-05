<div class="modal fade" id="delete-dialog-{$dialogID}" tabindex="-1" role="dialog" aria-labelledby="delete-dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{$parentHREF}" method = "post" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Delete...</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="delete_node" value="{$deleteContentPath}">
          <p>Are you sure you want to delete?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Yes, I am ready to delete</button>
        </div>
      </form>
    </div>
  </div>
</div>
