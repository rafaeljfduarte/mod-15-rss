<?php

if (!isset($_POST["save"])) {

	$nav_tpl = bo3::mdl_load("templates-e/add/nav-tab-item.tpl");
	$nav_content_tpl = bo3::mdl_load("templates-e/add/tab-content-item-input.tpl");
	$option_item_tpl = bo3::mdl_load("templates-e/add/option-item.tpl");

	$mdl = bo3::c2r(
		[
			"content" => bo3::mdl_load("templates-e/add/form.tpl"),

			"name" => $mdl_lang["label"]["name"],
			"url" => $mdl_lang["label"]["url"],
			"date" => $mdl_lang["label"]["date"],
			"date-value" => date("Y-m-d H:i:s"),
			"published" => $mdl_lang["label"]["published"],
			"but-submit" => $mdl_lang["label"]["but-submit"]
		],
		bo3::mdl_load("templates/add.tpl")
	);
} else {
	$rss_feed = new c15_rss();

	$rss_feed->setName($_POST["name"]);
	$rss_feed->setUrl($_POST["url"]);
	$rss_feed->setDate($_POST["date"]);
	$rss_feed->setDateUpdate();
	$rss_feed->setStatus(isset($_POST["status"]) ? $_POST["status"] : 0);
	$rss_feed->setUserId($authData["id"]);

	if ($rss_feed->insert()) {
		$textToPrint = $mdl_lang["add"]["success"];
	} else {
		$textToPrint = $mdl_lang["add"]["failure"];
	}

	$mdl = bo3::c2r(["content" => (isset($textToPrint)) ? $textToPrint : ""], bo3::mdl_load("templates/result.tpl"));
}

include "pages/module-core.php";
