<?php

class c15_rss {
	protected $id;
	protected $name;
	protected $url;
	protected $user_id;
	protected $date;
	protected $date_update;
	protected $status = false;

	public function __construct() {}

	public function setId($i) {
		$this->id = $i;
	}

	public function setName($n) {
		$this->name = $n;
	}

	public function setUrl($u) {
		$this->url = $u;
	}


	public function setUserId($u) {
		$this->user_id = $u;
	}

	public function setDate($d = null) {
		$this->date = ($d !== null) ? $d : date("Y-m-d H:i:s", time());
	}

	public function setDateUpdate($d = null) {
		$this->date_update = ($d !== null) ? $d : date("Y-m-d H:i:s", time());
	}

	public function setStatus($s) {
		$this->status = $s;
	}

	public function insert() {
		global $cfg, $db;

		$query = sprintf("INSERT INTO %s_rss (name, url, date, date_update, user_id, status) VALUES ('%s', '%s', '%s','%s', '%s', '%s')",
			$cfg->db->prefix, $this->name, $this->url, $this->date, $this->date_update, $this->user_id, $this->status
		);

		$toReturn = $db->query($query);

		$this->id = $db->insert_id;

		return $toReturn;
	}

	public function update() {
		global $cfg, $db;

		$query = sprintf(
			"UPDATE %s_rss SET name = '%s', url = '%s', date = '%s', date_update = '%s', user_id = '%s', status = '%s' WHERE id = '%s'",
			$cfg->db->prefix, $this->name, $this->url, $this->date, $this->date_update, $this->user_id, $this->status, $this->id
		);

		return $db->query($query);
	}

	public function delete() {
		global $cfg, $db, $authData;

		$rss = new c15_rss();
		$rss->setId($this->id);
		$rss_obj = $rss->returnOneFeed();

		$trash = new trash();
		$trash->setCode(json_encode($rss_obj));
		$trash->setDate();
		$trash->setModule($cfg->mdl->folder);
		$trash->setUser($authData["id"]);
		$trash->insert();

		$query = sprintf("DELETE FROM %s_rss WHERE id = '%s'",$cfg->db->prefix,$this->id
		);

		$db->query($query);

		return ($rss->returnOneFeed() == FALSE) ? TRUE : FALSE;
	}

	public function returnObject() {
		return get_object_vars($this);
	}

	public function returnAllFeeds () {
		global $cfg, $db;

		$toReturn = [];

		$query = sprintf("SELECT * FROM %s_rss", $cfg->db->prefix);

		$source = $db->query($query);

		while ($data = $source->fetch_object()) {
			array_push($toReturn, $data);
		}
		return $toReturn;
	}

	// Returns one categorie in one language need category id and lang id. $this->id, $this->lang_id
	public function returnOneFeed() {
		global $cfg, $db;

		$query = sprintf("SELECT * FROM %s_rss WHERE id = '%s'", $cfg->db->prefix, $this->id);

		$source = $db->query($query);

		$toReturn = $source->fetch_object();

		return $toReturn;
	}

	public function returnFeeds($limit = 0) {
		global $cfg, $db;

		$rss_list = [];

		$feed_list = [];

		$toReturn = array();

		$query = sprintf(
			"SELECT * FROM %s_rss WHERE status = '%s'", $cfg->db->prefix, true
		);

		$source = $db->query($query);

		while ($data = $source->fetch_object()) {
			array_push($rss_list, $data);
		}

		foreach ($rss_list as $r => $rss) {
			$feed = simplexml_load_file("{$rss->url}");
			foreach ($feed as $c => $channel) {
				array_push($feed_list, $channel);
			}
		}

		foreach ($feed_list as $c => $channel) {
			$items = $channel->item;
			$n = 1;
			foreach ($items as $i => $item) {
				if($n == $limit) {
					break;
				}
				$obj = new stdClass();
				$obj->source = $channel->title;
				$obj->title = $item->title;
				$obj->description = $item->description;

				$toReturn[] = $obj;
				$n ++;
			}
		}

		shuffle($toReturn);

		return $toReturn;

	}

}
