

<select name="{$fields.account_type.name}"
        id="{$fields.account_type.name}"
        title=''  tabindex="1"          
        >

    {if isset($fields.account_type.value) && $fields.account_type.value != ''}
        {html_options options=$fields.account_type.options selected=$fields.account_type.value}
    {else}
        {html_options options=$fields.account_type.options selected=$fields.account_type.default}
    {/if}
</select>