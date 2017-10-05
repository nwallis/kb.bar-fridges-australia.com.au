<div class="row">
  <div class="col">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#settings-dialog-{$dialogID}">+</button>
    <div class="modal fade" id="settings-dialog-{$dialogID}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add new...</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="" method = "post" enctype="multipart/form-data">
              <div class="settings-dialog" id="settings-dialog-{$dialogID}">
                {include file="descriptors.tpl"}
                <input type="hidden" name="parent_node" value="{$encodedContentPath}">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
