<?php
namespace DenDev\Plpconfig\Test;
use DenDev\Plpconfig\Lib\ConfigLib;;


class ConfigLibTest extends \PHPUnit_Framework_TestCase 
{
    private $_config_dir;
    private $content_test1;


    public function setUp()
    {
	$this->_config_dir = sys_get_temp_dir() . '/test/';
	@mkdir( $this->_config_dir );

	$this->_content_test1 = "<?php return array( 'test1' => 'valeur test1 fichier test1', 'test2' => 'valeur test2 fichier test1', 'test3' => 'valeur test3 fichier test1' ); ";
	$this->_content_test2 = "<?php return array( 'test0' => 'valeur test0 fichier test2', 'test1' => 'valeur test1 fichier test2', 'test4' => 'valeur test4 fichier test2' ); ";

	file_put_contents( $this->_config_dir . 'test1.php', $this->_content_test1 );
	file_put_contents( $this->_config_dir . 'test2.php', $this->_content_test2 );
    }

    public function test_instanciate()
    {
	$object = new ConfigLib( $this->_config_dir );
	$this->assertInstanceOf( 'DenDev\Plpconfig\Lib\ConfigLib', $object );
    }

    public function test_get_value()
    {
	$object = new ConfigLib( $this->_config_dir );
	$this->assertEquals( 'valeur test1 fichier test1', $object->get_value( 'test1.test1' ) );
	$this->assertEquals( 'default_value ok',  $object->get_value( 'test1.not_found', 'default_value ok' ) );
	$this->assertFalse(  $object->get_value( 'not_found' ) );
    }

    public function test_merge_with_default()
    {
	$object = new ConfigLib( $this->_config_dir );
	$default_values = array( 'test1' => 'value 1 from default', 'test3' => 'value 3 from default', 'test5' => 'other' );
	$this->assertArrayHasKey( 'test5', $object->merge_with_default( 'test1', $default_values ) );
	$this->assertEquals( 'valeur test1 fichier test1', $object->get_value( 'test1.test1' ) );
	$this->assertEquals( 'other', $object->get_value( 'test1.test5' ) );
    }

    public function tearDown()
    {
	@unlink( $this->_config_dir . 'test1.php' );
	@rmdir( $this->_config_dir );
    }
}
