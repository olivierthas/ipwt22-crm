<?php 
 //WARNING: The contents of this file are auto-generated



$hook_version = 1;

$hook_array = Array();

$hook_array['after_save'] = Array();
$hook_array['after_save'][] = Array(81, 'callApiUpdate', 'modules/accounts/Api_MapsLogicHook.php', 'Api_MapsLogicHook', 'updateAccount');

$hook_array['after_delete'] = Array();
$hook_array['after_delete'][] = Array(82, 'callApiDelete', 'modules/accounts/Api_MapsLogicHook.php', 'Api_MapsLogicHook', 'deleteAccount');


?>