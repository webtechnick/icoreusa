<?php
App::uses('AppShell','Console/Command');
class DeployShell extends AppShell {

	/**
	* Current environment to deploy to
	*/
	var $environment = null;
	
	/**
	* Show output as it happens
	*/
	var $verbose = false;
	
	/**
	* Path to work in
	*/
	var $path = null;

	function main(){
		$this->out('Deploy Shell');
		$this->hr();
		$this->help();
	}
	
	function help(){
		$this->out(' cake deploy app      Deploy the master application');
	}
	
	function app(){
		$this->out('Deploying IcoreUSA');
		$server = "icoreusa.com";
		$user = "icoreusa";
		$pass = "buzTbJcGs126";
		$this->ssh_open($server,$user,$pass,9394);
		$this->deployLogic();
		$this->ssh_close();
		$this->out();
		$this->out('Finished Deploying');
	}
	
	function deployLogic(){
		$this->ssh_setpath("/home/icoreusa/public_html");
		$this->ssh_exec("git checkout master");
		$this->ssh_exec("git pull");
		$this->ssh_exec("git fetch --tags");
		$this->ssh_exec("git submodule init");
		$this->ssh_exec("git submodule update");
		$this->ssh_setpath("/home/icoreusa/public_html/app");
		$this->ssh_exec("cake Migrations.migration run all");
	}

  /**
	* Connect and authenticate to an ssh server
	* @param string server to connec to
	* @param string user to use to conenct to server with
	* @param string password to use to conenct to server with
	* @param string port to use to conenct to server with
	* @return void
	*/
	function ssh_open($server, $user, $pass, $port = 22, $methods = array()){
		$methods = array_merge(array(
			'client_to_server' => array(
				'crypt' => '3des-cbc',
				'comp' => 'none'),
			'server_to_client' => array(
				'crypt' => 'aes256-cbc,aes192-cbc,aes128-cbc',
				'comp' => 'none')
		), $methods);
		if(!function_exists("ssh2_connect")){
			$this->__errorAndExit("function ssh2_connect doesn't exit.  Run \n\n   Ubuntu: sudo apt-get install libssh2-1-dev libssh2-php\n\n    Mac: sudo port install php5-ssh2");
		}
		
		if($server == 'server.example.com'){
			$this->__errorAndExit("Please fill in the deploy() function in your new app task");
		}
		
		$this->connection = ssh2_connect($server, $port, $methods);
		
		if(!$this->connection){
			$this->__errorAndExit("Unable to connect to $server");
		}
		
		if(!ssh2_auth_password($this->connection, $user, $pass)){
			$this->__errorAndExit("Failed to authenticate");
		}
	}
	
	/**
	* Send and receive the result of an ssh command
	* @param string command to execute on remote server
	* @param boolean get stderr instead of stdout stream
	* @return mixed result of command.
	*/
	function ssh_exec($cmd, $error = false){
		if(!$this->connection){
			$this->__errorAndExit("No open connection detected.");
		}
		
		if($this->path){
			$cmd = "cd {$this->path} && $cmd";
		}
		if($this->verbose){
			$this->out($cmd);
		}
		$stream = ssh2_exec($this->connection, $cmd);
		
		if(!$stream){
			$this->__errorAndExit("Unable to execute command $cmd");
		}
		
		$errorStream = ssh2_fetch_stream($stream, SSH2_STREAM_STDERR);
		
		stream_set_blocking($stream, true);
		stream_set_blocking($errorStream, true);
		
		$retval = $error ? stream_get_contents($errorStream) : stream_get_contents($stream);
		$retval = trim($retval);
		
		fclose($stream);
		fclose($errorStream);
		
		//Show output or at least progress dots.
		if($this->verbose){
			$this->out($retval);
		}
		else {
			echo '.';
		}
		
		return $retval;
	}
	
	/**
	* Set the path to append to each command.
	* @param string path (without cd)
	* @return void
	*/
	function ssh_setpath($path){
		$this->path = $path;
	}
	
	/**
	* Close the current connection
	*/
	function ssh_close(){
		if($this->connection){
			$this->ssh_exec("exit");
		}
		$this->connection = null;
	}
	
	/**
	* Private method to output the error and exit(1)
	* @param string message to output
	* @return void
	* @access private
	*/
	protected function __errorAndExit($message){
		$this->out("Error: $message");
		exit(1);
	}
	
	/**
	* Prompt the user with a yes no question
	* @param string text
	* @param string default answer
	* @return result strlowered
	*/
	private function promptYesNo($text, $default = "Y"){
		return trim(strtolower($this->in($text,array('Y','n','q'), $default)));
	}
	
	/**
	* Prompt to continue, helper method, will exit if answer is n or q, returns true otherwise
	* @param string text to prompt
	*/
	private function promptContinue($text = null){
		switch($this->promptYesNo($text)){
			case 'q':
			case 'n':
				$this->out("Exiting.");
				exit();
		}
		return true;
	}
}
