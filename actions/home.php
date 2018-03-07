<?php

$line_tpl = bo3::mdl_load("templates-e/home/table-row.tpl");
$option_item_tpl = bo3::mdl_load("templates-e/home/option-item.tpl");

$rss = new c15_rss();
$rss = $rss->returnAllFeeds();


foreach ($rss as $feed) {
	if (!isset($table_items)) {
		$table_items = "";
	}

	$table_items .= bo3::c2r([
		"id" => $feed->id,
		"name" => strip_tags($feed->name),
		"url" => $feed->url,
		"published" => ($feed->status) ? "fa-toggle-on" : "fa-toggle-off",
		"date-created" => date('Y-m-d', strtotime($feed->date)),
		"date-updated-label" => $mdl_lang["label"]["date-updated"],
		"date-updated" => $feed->date_update,
		"but-view" => $mdl_lang["label"]["but-view"],
		"but-edit" => $mdl_lang["label"]["but-edit"],
		"but-delete" => $mdl_lang["label"]["but-delete"],
	], $line_tpl);
}



$mdl = bo3::c2r([
	"label-add" => $mdl_lang["label"]["add"],
	"name" => $mdl_lang["label"]["name"],
	"url" => $mdl_lang["label"]["url"],
	"section" => $mdl_lang["label"]["type"],
	"parent-nr" => $mdl_lang["label"]["parent-nr"],
	"published" => $mdl_lang["label"]["published"],
	"date" => $mdl_lang["label"]["date"],
	"table-body" => (isset($table_items)) ? $table_items : "",
], bo3::mdl_load("templates/home.tpl"));

include "pages/module-core.php";
