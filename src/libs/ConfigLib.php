<?php
namespace DenDev\Plpconfig\Lib;
use DenDev\Plpconfig\Lib\FileLib;

use Herrera\Wise\Wise;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\DelegatingLoader;
use Herrera\Wise\Loader\LoaderResolver;
use Herrera\Wise\Loader\IniFileLoader;
use Herrera\Wise\Loader\JsonFileLoader;
use Herrera\Wise\Loader\PhpFileLoader;
use Herrera\Wise\Loader\XmlFileLoader;
use Herrera\Wise\Loader\YamlFileLoader;


/**
 * Implemente la recuperation de config 
 *
 * L'implementation se fait par l'utilisation de Wise
 */
class ConfigLib
{
    /** @var object gere les fichiers */
    private $_file_lib;


    /**
     * Constructor
     *
     * instancie wise et recupere les configs dans le repertoire
     *
     * @param string $config_dir emplacement vers le repertoire ou se trouve les fichiers de config
     */
    public function __construct( $config_dir )
    {
	$this->_file_lib = new FileLib( $config_dir );
	$this->_set_wise( $config_dir );
    }

    /**
     * Recupere la valeur de l'option de config
     *
     * L'option coorespond a service.option_name. Si je veux la root_path du kernel -> kernel.option_name
     *
     * @param string $option_name nom de l'option sous le format service.option_name
     * @param string $default_value donne une valeur si la config n'existe pas
     *
     * @return mixed renvoi la valeur ou false
     */ 
    public function get_value( $option_name, $default_value = false )
    {
	$service_name = substr( $option_name, 0, strpos( $option_name, '.' ) );
	$option_name = str_replace( $service_name . '.', '', $option_name );

	// debug
	// echo $service_name;
	// echo $option_name;

	$value = false;
	if( array_key_exists( $service_name, $this->_configs ) )
	{ 
	    if( array_key_exists( $option_name, $this->_configs[$service_name] ) )
	    {
		$value = $this->_configs[$service_name][$option_name];
	    }
	    else if( $default_value )
	    {
		$value = $default_value;
	    }
	}

	return $value;
    }

    /**
     * Fusionne les valeurs par defaut avec celle du fichier de config.
     *
     * Les valeurs du fichiers sont prioritaire.
     * La mise à jour n'affecte que la config du service 
     *
     * @param string $service_name cible les options a mettre a jour
     * @param array $default_values les valeurs de config du service
     *
     * @return array le tableau a jour du service.
     */
    public function merge_with_default( $service_name, $default_values )
    {
	if( is_array( $default_values ) && is_array( $this->_configs[$service_name] ) )
	{
	    $this->_configs[$service_name] = array_merge( $default_values, $this->_configs[$service_name] );
	}

	return $this->_configs[$service_name];
    }

    // -
    /**
     * Instancie wise si l'arg est valide
     *
     * @param string $config_dir emplacement vers le repertoire ou se trouve les fichiers de config
     *
     * @return bool true si reussit
     */
    private function _set_wise( $config_dir )
    {
	$ok = false;
	$this->_configs = array();

	if( $this->_file_lib->check_dir() )
	{
	    $all_configs_file = $this->_file_lib->get_path_files();

	    $wise = Wise::create( $this->_file_lib );
	    foreach( $all_configs_file as $service_name => $config_file )
	    {
		$this->_configs[$service_name] = $wise->loadFlat( $config_file );
	    }
	}

	return $ok;
    }
}
