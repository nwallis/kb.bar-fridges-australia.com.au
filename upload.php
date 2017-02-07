<div class="col-md-12 main-button-container">
    <div class="well center-block first-upload-container">
    <button type="button" class="btn btn-success btn-lg btn-block" id="upload-new">
    Upload New Media
    </button>
    <button type="button" class="btn btn-info btn-lg btn-block" id="select-media">
    Select Media
    </button>
    </div>
</div>
<input type="hidden" name="media-url" id="media-url" data-media-type="image" data-caption=""/>

<div class="col-md-12 upload-new-container">
<h3>Upload New Media File</h3>
<p>Media File</p>
<input type="file" name="mediafile-new" id="mediafile-new" />
<br/>
<p>Caption</p>
<input type="text" name="caption-new" id="caption-new" class="form-control"/>
<br/>
<button class="btn btn-block btn-success" id="upload-new-media">Upload</button>
<button class="btn btn-block btn-error" id="upload-new-cancel">Cancel</button>
</div>

<div class="col-md-12 select-media-viewer well center-block">
<h3 class="media-viewer-title">Media On File</h3>
<p class="media-viewer-subtext">
Please click the media you want to add to your article. Then Click use media</p>
<br/>
<div class="gallery">

</div>
<button class="btn btn-block btn-info use-media"> Use Media</button>
<button class="btn btn-block btn-error" id="use-media-cancel">Cancel</button>
</div>
