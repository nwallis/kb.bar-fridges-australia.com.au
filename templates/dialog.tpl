<div class="add-node" for="{$dialogType}-dialog-{$dialogID}">+</div>

<div class="{$dialogType}-dialog" id="{$dialogType}-dialog-{$dialogID}">
    <form action="" method = "post" enctype="multipart/form-data">

        {foreach from=$fieldDescriptors.fields item=descriptor}

            {assign "inputClass" ""}

            {if $descriptor.type == "Image"}
                <label>{$descriptor.name}<input type="file" name="image"></label>
            {elseif $descriptor.type == "Textarea"} 
                    <textarea name="fields[{$descriptor.key_name}]">{$childFields{$descriptor.key_name}}</textarea>
            {else}
                {if isset($fieldDescriptors.seo_translate_key) and ($fieldDescriptors.seo_translate_key == $descriptor.key_name)}
                    {assign "inputClass" "kb-seo-translate"}
                    <input type="hidden" class="seo-name" name="seo_name" value="">
                {/if}
                <label>{$descriptor.name}<input class="{$inputClass}" type="text" name="fields[{$descriptor.key_name}]" value="{$childFields.{$descriptor.key_name}}"></label>
            {/if}

        {/foreach}

        <input type="hidden" name="parent_node" value="{$encodedContentPath}">
        {if $dialogType == "clone"} <input type="hidden" name="clone_node" value="{$dialogID}"> {/if}

        <input type="submit" value="Save">
    </form> 
</div>
