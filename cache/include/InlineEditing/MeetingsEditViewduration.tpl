

<select name="{$fields.duration.name}"
        id="{$fields.duration.name}"
        title=''  tabindex="1"          
        >

    {if isset($fields.duration.value) && $fields.duration.value != ''}
        {html_options options=$fields.duration.options selected=$fields.duration.value}
    {else}
        {html_options options=$fields.duration.options selected=$fields.duration.default}
    {/if}
</select>