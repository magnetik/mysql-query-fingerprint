<?php
require_once '../MysqlQueryFingerprint.php';
require_once 'PHPUnit/Autoload.php';

class MysqlQueryFingerprintTest extends PHPUnit_Framework_TestCase
{
    function testSimple()
	{
		$queries = array(
			array("SELECT * FROM Foo WHERE bar=3", "SELECT * FROM Foo WHERE bar=5"),
			array("SELECT * FROM Foo WHERE bar='foo'", "SELECT * FROM Foo WHERE bar='bar'"),
		);

		$this->queriesAsert($queries);
	}

	/**
	 * @depends testSimple
	 */
	function testSpaces()
	{
		$queries = array(
			array("SELECT * FROM Foo WHERE bar=3", "SELECT * FROM Foo WHERE bar = 5"),
		);

		$this->queriesAsert($queries);
	}

	function testIn()
	{
		$queries = array(
			array("SELECT * FROM Foo WHERE bar IN ('foo', 'bar')", "SELECT * FROM Foo WHERE bar IN ('foo')"),
		);

		$this->queriesAsert($queries);
	}

	function testLimit()
	{
		$queries = array(
			array("SELECT * FROM Foo LIMIT 0,10", "SELECT * FROM Foo LIMIT 0,1"),
			array("SELECT * FROM Foo LIMIT 0,1", "SELECT * FROM Foo LIMIT 1")
		);

		$this->queriesAsert($queries);
	}

	/*
	 * Function used to test a set of queries
	 */
	function queriesAsert($queries)
	{
		foreach ($queries as $query)
		{
			$fingerprint1 = MysqlQueryFingerprint::generate($query[0]);
			$fingerprint2 = MysqlQueryFingerprint::generate($query[1]);

			$this->assertEquals($fingerprint1, $fingerprint2);
		}
	}
}
?>
