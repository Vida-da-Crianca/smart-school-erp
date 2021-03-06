<?php


namespace Packages\Commands\Migrations;

use Packages\Commands\Core\Migration;




class Rollback extends Migration
{
	protected $name        = 'migrate:rollback';
	protected $description = 'Rollback from the last migration';

	public function start()
	{
		$migrations = $this->migration->find_migrations();
		$versions   = array_map('intval', array_keys($migrations));

		$db_version = intval($this->migration->get_db_version());

		end($versions);
		
		while ($version = prev($versions)) 
		{
			if ($version == ($db_version - 1)) 
			{
				break;
			}
		}

		if($version < 0)
		{
			return $this->note("Can't rollback anymore");
		}
		else
		{
			if ($version == $db_version) 
			{
				$version = 0;
			}
			$this->text('Migrating database <info>DOWN</info> to version <comment>'.$version.
				'</comment> from <comment>'.$db_version.'</comment>');
			$case = 'reverting';
			$signal = '--';
		}

		$this->newLine();
		$this->text('<info>'.$signal.'</info> '.$case);		

		$time_start = microtime(true);

		$this->migration->version($version);

		$time_end = microtime(true);

		list($query_exec_time, $exec_queries) = $this->measureQueries($this->migration->db->queries);
	
		$this->summary($signal, $time_start, $time_end, $query_exec_time, $exec_queries);
	}
}