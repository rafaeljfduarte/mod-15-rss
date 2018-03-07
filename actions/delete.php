<?php

	if (isset($id) && !empty($id)) {
		// Return all category info
		$rss = new c15_rss();
		$rss->setId($id);
		$toReturn = "";

		if (isset($_POST["submit"])) {
			if ($rss->delete()) {
				$toReturn = $mdl_lang["delete"]["success"];
			} else {
				$toReturn =  $mdl_lang["delete"]["failure"];
			}
		} else {
			$rss = $rss->returnOneFeed();

			$toReturn = bo3::c2r(
				[
					"id" => $id,

					"phrase" => $mdl_lang["delete"]["phrase"],
					"title" => $rss->name,

					"del" => $mdl_lang["delete"]["button-del"],
					"cancel" => $mdl_lang["delete"]["button-cancel"]
				],
				bo3::mdl_load("templates-e/delete/form.tpl")
			);
		}

		$mdl = bo3::c2r(["content" => $toReturn], bo3::mdl_load("templates/del.tpl"));
	} else {
		// if doesn't exist an action response, system sent you to 404
		header("Location: {$cfg->system->path_bo}/0/{$lg_s}/404/");
	}

include "pages/module-core.php";
