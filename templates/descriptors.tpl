{foreach from=$fieldDescriptors.fields item=descriptor}

{assign "inputClass" ""}

{if $descriptor.type == "Image"}

<div class="form-group row">
  <label class="col-4">{$descriptor.name}</label>
  <div class="col-8">
      <input type="file" class="form-control-file" name="image">
  </div>
</div>

{if isset($childFields.{$descriptor.key_name})}
<div class="form-group row">
  <div class="col-12">
    <img src="/{$childFields.{$descriptor.key_name}}" alt="" style="width:100%;height:auto;">
  </div>
</div>
{/if}

{elseif $descriptor.type == "Textarea"} 

<label>{$descriptor.name}</label>
<textarea name="fields[{$descriptor.key_name}]"></textarea>
<input type="hidden" name="wysiwygHTML" value="{if isset($childFields.{$descriptor.key_name}) }{$childFields.{$descriptor.key_name}|base64_encode}{/if}">

{else}

<div class="form-group row">
  <label class="col-4">{$descriptor.name}</label>
  <div class="col-8">
    <input class="form-control" type="text" name="fields[{$descriptor.key_name}]" value="{if isset($childFields.{$descriptor.key_name}) }{$childFields.{$descriptor.key_name}|escape}{/if}">
  </div>
</div>

{/if}

{/foreach}

<input type="hidden" name="seo_translate_key" value="{$fieldDescriptors.seo_translate_key}">
