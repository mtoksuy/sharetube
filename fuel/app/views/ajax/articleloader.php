<?php
		header("Content-Type: text/javascript; charset=utf-8");
//echo $ajax_data['json_data'];
//var_dump($ajax_data);
//echo $ajax_data['json_data']['tweet_id'];
echo(json_encode($ajax_data));