<?php
namespace DenDev\Plpconfig;
use DenDev\Plpconfig\ConfigInterface;
use DenDev\Plpadaptability\Adaptability;
use DenDev\Plpconfig\Lib\ConfigLib;

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
    public function __construct( $krl = false, $args )
    {
        parent::__construct( $krl );
	$this->_config_lib = new ConfigLib( $args['config_dir'] );
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
	return $this->_config_lib->get_value( $config_name, $default_value );
    }

    /**
     * Retourne toute la configuration.
     *
     * Renvoi toute la config d'un service ou de tout les services
     *
     * @param string $service_name le nom du service dont on veut tout
     *
     * @return array tableau ou tableau de tableau de config
     */
    public function get_values( $service_name = false )
    {
	return $this->_config_lib->get_values( $service_name );
    }

    /**
     * Configuration par defaut du service
     *
     * La format pour une option de config est service_name.option_name.sous_option_name
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
