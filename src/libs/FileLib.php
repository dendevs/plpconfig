<?php
namespace DenDev\Plpconfig\Lib;


/**
 * Manipule les fichiers pour les besoins de ConfigLib
 *
 */
class FileLib
{
    /** @var string emplacemnt du repertoire */
    private $_dir_path;


    /**
     * Constructor
     *
     * Agit sur le repertoire donne en argument
     *
     * @param string $dir_path emplacemnt du repertoire
     */
    public function __construct( $dir_path )
    {
	$this->_dir_path = $dir_path;
    }


    /**
     * Verifie la validite du repertoire.
     *
     * Verifie si il existe, est un repertoire non vide 
     *
     * @param bool $need_not_empty rajoute une condition de validation, le repertoire ne peut etre vide
     *
     * @return bool true si le repertoire est utilisable
     */
    public function check_dir( $need_not_empty = true )
    {
	$ok = false;

	if( is_dir( $this->_dir_path ) && is_readable( $this->_dir_path ) ) 
	{
	    $ok = true;
	    if( $need_not_empty )
	    {
		$ok = ( count( scandir( $this->_dir_path ) ) > 0 ) ? true: false;
	    }
	}
	return $ok;
    }

    /**
     * Donne le chemin de tout les fichiers contenus dans le repertoire
     *
     * @return array tabeau des fichiers trouver
     */
    public function get_path_files()
    {
	$path_files = array();

	$tmp_contents_dir = scandir( $this->_dir_path );
	foreach( $tmp_contents_dir as $tmp_content_dir )
	{
	    if( is_file( $this->_dir_path . $tmp_content_dir ) )
	    {
		$service_name = strtolower( preg_replace('/\\.[^.\\s]{3,4}$/', '', $tmp_content_dir ) );
		$path_files[$service_name] = $tmp_content_dir;
	    }
	}

	return $path_files;
    }
}
