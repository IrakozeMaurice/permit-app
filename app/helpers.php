<?php

use App\Models\Claim;

function getClaims()
{
	$claims = Claim::where('addressed',false)->get();
	if($claims && !empty($claims))
		return count($claims);
	else
		return 0;
}