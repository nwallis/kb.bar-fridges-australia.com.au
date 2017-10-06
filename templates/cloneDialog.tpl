<div class="modal fade clone-dialog" id="clone-dialog-{$dialogID}" tabindex="-1" role="dialog" aria-labelledby="clone-dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="/" method = "post" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Clone...</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row">
              <div class="col">
                {include file="descriptors.tpl"}
              </div>
            </div>
          </div>
          <input type="hidden" name="parent_node" value="{$encodedContentPath}">
          <input type="hidden" name="clone_node" value="{$dialogID}">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
