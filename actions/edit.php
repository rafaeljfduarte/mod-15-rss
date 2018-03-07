<?php

if (!isset($_POST["save"])){
	if (isset($id) && !empty($id)) {
		$user_select_tpl = bo3::mdl_load("templates-e/edit/user-select.tpl");

		// Return all article info
		$rss = new c15_rss();
		$rss->setId($id);
		$rss_result = $rss->returnOneFeed();

		$mdl = bo3::c2r(
			[
				"content" => bo3::mdl_load("templates-e/edit/form.tpl"),

				"name" => $rss_result->name,
				"url" => $rss_result->url,
				"date" => $mdl_lang["label"]["date"],
				"date-placeholder" => $mdl_lang["form"]["date-placeholder"],
				"date-value" => $rss_result->date,
				"published" => $mdl_lang["label"]["published"],
				"published-checked" => ($rss_result->status) ? "checked" : "",
				"but-submit" => $mdl_lang["label"]["but-submit"],
			],
			bo3::mdl_load("templates/add.tpl")
		);
	} else {
		// if doesn't exist an action response, system sent you to 404
		header("Location: {$cfg->system->path_bo}/0/{$lg_s}/404/");
	}
} else {
	$rss = new c15_rss();

	$rss->setId($id);
	$rss->setName($_POST["name"]);
	$rss->setUrl($_POST["url"]);
	$rss->setDate($_POST["date"]);
	$rss->setDateUpdate();
	$rss->setStatus(isset($_POST["status"]) ? $_POST["status"] : 0);
	$rss->setUserId($authData["id"]);

	if ($rss->update()) {
		$textToPrint = $mdl_lang["add"]["success"];
	} else {
		$textToPrint = $mdl_lang["add"]["failure"];
	}

	$mdl = bo3::c2r(["content" => (isset($textToPrint)) ? $textToPrint : ""], bo3::mdl_load("templates/result.tpl"));
}

include "pages/module-core.php";
