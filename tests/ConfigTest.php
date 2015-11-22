<?php
namespace DenDev\Plpconfig\Test;
use DenDev\Plpconfig\Config;


class ConfigTest extends \PHPUnit_Framework_TestCase 
{
	public $_config_dir;


	public function setUp()
	{
		$this->_config_dir = sys_get_temp_dir() . '/test/';
		@mkdir( $this->_config_dir, 744 );
		$content_test1 = "<?php return array( 'test1' => 'valeur test1 fichier test1', 'test2' => 'valeur test2 fichier test1', 'test3' => 'valeur test3 fichier test1' ); ";

		file_put_contents( $this->_config_dir . 'test1.php', $content_test1 );
	}

	public function test_instanciate()
	{
		$object = new Config( false, $this->_config_dir );
		$this->assertInstanceOf( "DenDev\Plpconfig\Config", $object );
	}

	public function test_get_value()
	{
		$object = new Config( false, $this->_config_dir );
		$this->assertEquals( 'valeur test1 fichier test1', $object->get_value( 'test1.test1' ) );
	}

	public function tearDown()
	{
		@unlink( $this->_config_dir . 'test1.php' );
		@rmdir( $this->_config_dir );
	}
}
