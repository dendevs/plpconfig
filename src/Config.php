<?php
namespace DenDev\Plpconfig;
use DenDev\Plpconfig\ConfigInterface;
use DenDev\Plpadaptability\Adaptability;


/**
 * Permet de charger la configuration. 
 *
 * Class wrapper qui permet l'utilisation de differente librairie ainsi que leur remplacement
 */
class Config extends Adaptability implements ConfigInterface
{
    private $_config;


    /**
     * Set le kernel du servie 
     *
     * @param object $krl la ref du kernel auquel appartient le service ou false par defaut.
     *
     * @return void
     */
    public function __construct( $krl = false, $config_dir )
    {
        parent::__construct( $krl );
	$this->_config = array();
    }

    /**
     * Recupere la valeur de l'option demander.
     *
     * Donne une valeur par default si non trouver et argument 2 exists
     *
     * @param string $config_name nom de l'option de Configuration a retrouver
     * @param string $default_value false par defaut. 
     *
     * @return false|mixed la valeur de l'option
     */
    public function get_value( $config_name, $default_value = false )
    {
	if( array_key_exists( $config_name, $this->_config ) )
	{
	    $value = $this->_config[$config_name];
	}
	else 
	{
	    $value = $default_value;
	}

	return $value;
    }

    /**
     * Configuration par defaut du service
     *
     * @return array tableau associatif option value.
     */
    public function get_default_configs()
    {
        return array();
    }

    /**
     * Set les informations de base au sujet du service.
     *
     * son nom sous forme slugifier ( mon_serice et non Mon service )
     * son numero de version 
     *
     * @return void
     */
    public function set_service_metas()
    {
	$this->_service_metas = array( 
	    'service_name' => 'config',
	    'service_version' => '0.0.0',
	);
    }
}
