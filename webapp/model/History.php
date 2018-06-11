<?php
use ActiveRecord\Model; 
use ArmoredCore\WebObjects\Session;

class History extends Model{
	static $table_name = 'history';
	static $primary_key = 'id';
	static $connection = 'development';
	static $db = 'blackjackdb';
}
$connections = array(
	'development' => 'mysql://root:@127.0.0.1/blackjackdb'
);
	ActiveRecord\Config::initialize(function($cfg) use ($connections)
{
    $cfg->set_model_directory('.');
    $cfg->set_connections($connections);
});
?>