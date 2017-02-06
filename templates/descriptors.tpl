{foreach from=$fieldDescriptors.fields item=descriptor}
    <p>
        {assign "inputClass" ""}
        {if $descriptor.type == "Image"}
            <label>{$descriptor.name}<input type="file" name="image"></label>
            {if isset($childFields.{$descriptor.key_name}) }<img src="/{$childFields.{$descriptor.key_name}}" alt="">{/if}
        {elseif $descriptor.type == "Textarea"} 
            <label>{$descriptor.name}</label>
            <textarea name="fields[{$descriptor.key_name}]"></textarea>
            <input type="hidden" name="wysiwygHTML" value="{if isset($childFields.{$descriptor.key_name}) }{$childFields.{$descriptor.key_name}}{/if}">
        {else}
            {if isset($fieldDescriptors.seo_translate_key) and ($fieldDescriptors.seo_translate_key == $descriptor.key_name)}
                {assign "inputClass" "kb-seo-translate"}
                <input type="hidden" class="seo-name" name="seo_name" value="">
            {/if}
            <label>{$descriptor.name}<input class="{$inputClass}" type="text" name="fields[{$descriptor.key_name}]" value="{if isset($childFields.{$descriptor.key_name}) }{$childFields.{$descriptor.key_name}}{/if}"></label>
        {/if}
    </p>
{/foreach}
