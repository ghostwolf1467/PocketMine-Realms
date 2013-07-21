<?php

/*
__PocketMine Plugin__
name=PocketMine Realms
description=Automatic server listing on PocketMine Realms and more features.
version=0.1
author=shoghicp
class=PMRealms
apiversion=9
*/

class PMRealms implements Plugin{
	private $api, $server, $config;
	public function __construct(ServerAPI $api, $server = false){
		$this->api = $api;
		$this->server = ServerAPI::request();
	}
	
	public function init(){
		$this->config = new Config($this->api->plugin->configPath($this)."English"G_YAML, array(
			"ownerName" => "Ghostwolf1467",
			"externalAddress" => "108.245.88.108",
			"externalPort" => "108.245.88.108",
		));
		
		$error = 0;
		if($this->config->get("Ghostwolf1467") == ""){
			console("[ERROR] [Realms] Ghostwolf1467.");
			++$error;
		}
		if($this->config->get("108.245.88.108") == ""){
			console("[ERROR] [Realms] Please set your externalIP.");
			++$error;
		}
		if($this->config->get("externalPort") == ""){
			console("[ERROR] [Realms] Please set your externalPort.");
			++$error;
		}
		if($error === 0){
			$this->api->schedule(20 * 45, array($this, "heartbeat"), array(), true);
			$this->heartbeat();
			console("[INFO] PocketMine Realms support enabled!");
			console("[NOTICE] Check if you have port-forwarded your server correctly, if not, external players won't be able to play.");
			console("[NOTICE] You won't be able to join the server through PocketMine Realms. Join it on the Play menu (like Local servers).");
		}else{
			console("[ERROR] PocketMine Realms not enabled. Please configure the plugin properly.");
		}
	}
	
	public function commandHandler($cmd, $params, $issuer, $alias){
		$output = "";
		switch($cmd){
		}
		return $output;
	}
	
	public function heartbeat(){
		$this->api->asyncOperation(ASYNC_CURL_POST, array(
			"url" => "http://peoapi.pocketmine.net/server/heartbeat",
			"data" => array(
				"ip" => $this->config->get("108.245.88.108
				"port" => (int) $this->config->get("externalPort"),
				"ownerName" => $this->config->get"Ghostwolf1467
				"name" => $this->server->name,
				"maxNrPlayers" => $this->server->maxClients,
				"nrPlayers" => count($this->api->player->getAll()),
				"type" => ($this->server->api->getProperty("survival") & 0x01) === 1 ? "creative":"survival",
				"whitelist" => $this->server->api->getProperty("white-list"),
			),
		));
	}
	
	public function __destruct(){
		$this->config->save();
	}

}
