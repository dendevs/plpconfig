<?php
namespace DenDev\Plpconfig\Test;
use DenDev\Plpconfig\Lib\FileLib;;


class FileLibTest extends \PHPUnit_Framework_TestCase 
{
	private $_config_dir;
	private $content_test1;


	public function setUp()
	{
		$this->_config_dir = sys_get_temp_dir() . '/test/';
		@mkdir( $this->_config_dir );
		$this->_content_test1 = "<?php return array( 'test1' => 'valeur test1 fichier test1', 'test2' => 'valeur test2 fichier test1', 'test3' => 'valeur test3 fichier test1' ) ";

		file_put_contents( $this->_config_dir . 'test1.log', $this->_content_test1 );
	}

	public function test_instanciate()
	{
		$object = new FileLib( $this->_config_dir );
		$this->assertInstanceOf( 'DenDev\Plpconfig\Lib\FileLib', $object );
	}

	public function test_check_dir()
	{
		$object = new FileLib( $this->_config_dir );
		$this->assertTrue( $object->check_dir() );
	}

	public function test_check_bad_dir()
	{
		$object = new FileLib( 'jkljlk' );
		$this->assertFalse( $object->check_dir() );
	}

	public function test_get_path_files()
	{
		$object = new FileLib( $this->_config_dir );
        $this->assertContains( $this->_config_dir . 'test1.log', $object->get_path_files() );
	}

	public function tearDown()
	{
		@unlink( $this->_config_dir . 'test1.log' );
		@rmdir( $this->_config_dir );
	}

}
