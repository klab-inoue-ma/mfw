<?php
require_once __DIR__.'/initialize.php';

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-10-17 at 21:06:26.
 */
class mfwTemplateTest extends PHPUnit_Framework_TestCase
{
	const BASEDIR = '/misc';

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

	public function testParameter()
	{
		$t = new mfwTemplate('test/t1',self::BASEDIR);
		$c = $t->build(array('param1'=>'hoge'));
		$exp = "<p>template 1</p>\nhoge";
		$this->assertEquals($exp,$c);
	}

	public function testTemplate1WithLayout()
	{
		$t = new mfwTemplate('test/t1',self::BASEDIR);
		$t->setLayout('layout');
		$c = $t->build(array('param1'=>'fuga'));
		$exp = "<h1>layout</h1>\n<p>template 1</p>\nfuga";
		$this->assertEquals($exp,$c);
	}

	public function testBlock()
	{
		$t = new mfwTemplate('test/t2',self::BASEDIR);
		$c = $t->build();
		$exp = "<p>template 2</p>\n<div>block 1</div><div>block 1</div>";
		$this->assertEquals($exp,$c);
	}

	public function testUrl()
	{
		unset($_SERVER['HTTPS']);
		$_SERVER['HTTP_HOST'] = 'www.example.com';
		$_SERVER['SCRIPT_NAME'] = '/path1/main.php';

		$t = new mfwTemplate('test/t3',self::BASEDIR);
		$c = $t->build();
		$exp = "<p>template 3</p>\n<div>http://www.example.com/path1/urltest</div>";
		$this->assertEquals($exp,$c);
	}

	public function testBlockNotFound()
	{
		$t = new mfwTemplate('test/t4',self::BASEDIR);
		$c = $t->build();
		$exp = "<p>template 4</p>\nblock 'dummy' is not found.";
		$this->assertEquals($exp,$c);
	}

	/**
	 */
	public function testTemplateNotFound()
	{
		try{
			$t = new mfwTemplate('dummy',self::BASEDIR);
		}
		catch(InvalidArgumentException $e){
			$msg = $e->getMessage();
		}
		$this->assertStringStartsWith('template file is not exists:',$msg);
	}

	/**
	 */
	public function testLayoutNotFound()
	{
		$t = new mfwTemplate('/test/t1',self::BASEDIR);
		try{
			$t->setLayout('dummy');
		}
		catch(InvalidArgumentException $e){
			$msg = $e->getMessage();
		}
		$this->assertStringStartsWith('layout file is not exists:',$msg);
	}

}
