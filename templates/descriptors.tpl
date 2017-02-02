{foreach from=$fieldDescriptors.fields item=descriptor}
    <p>
        {assign "inputClass" ""}
        {if $descriptor.type == "Image"}
            <label>{$descriptor.name}<input type="file" name="image"></label>
            <img src="/{$childFields.{$descriptor.key_name}}" alt="">
        {elseif $descriptor.type == "Textarea"} 
            <label>{$descriptor.name}</label>
            <textarea name="fields[{$descriptor.key_name}]"></textarea>
        {else}
            {if isset($fieldDescriptors.seo_translate_key) and ($fieldDescriptors.seo_translate_key == $descriptor.key_name)}
                {assign "inputClass" "kb-seo-translate"}
                <input type="hidden" class="seo-name" name="seo_name" value="">
            {/if}
            <label>{$descriptor.name}<input class="{$inputClass}" type="text" name="fields[{$descriptor.key_name}]" value="{$childFields.{$descriptor.key_name}}"></label>
        {/if}
    </p>
{/foreach}
