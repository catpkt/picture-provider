<?php

namespace CatPKT\PictureProvider;

////////////////////////////////////////////////////////////////

abstract class AStorage
{

	/**
	 * Var app
	 *
	 * @access protected
	 *
	 * @var    AApp
	 */
	protected $app;

	/**
	 * Method setApp
	 *
	 * @final
	 *
	 * @access public
	 *
	 * @param  string $appName
	 *
	 * @return void
	 */
	final public function setApp( string$appName )
	{
		$this->app= $this->findApp( $appName );
	}

	/**
	 * Method setApp
	 *
	 * @final
	 *
	 * @access public
	 *
	 * @return void
	 */
	final public function app()
	{
		return $this->app;
	}

	/**
	 * Set which App request this server.
	 *
	 * @abstract
	 *
	 * @access protected
	 *
	 * @param  string $appName
	 *
	 * @return AApp
	 */
	abstract protected function findApp( string$appName );

	/**
	 * List pictures from given directory.
	 *
	 * @abstract
	 *
	 * @access public
	 *
	 * @param  string $dir
	 *
	 * @return PictureList
	 */
	abstract public function list( string$dir ):PictureList;

	/**
	 * Get a picture object.
	 *
	 * @abstract
	 *
	 * @access public
	 *
	 * @param  string $hash
	 *
	 * @return IPicture
	 */
	abstract public function get( string$hash ):IPicture;

	/**
	 * Method store
	 *
	 * @abstract
	 *
	 * @access public
	 *
	 * @param  string $content
	 * @param  string $dir
	 * @param  string $contentType
	 *
	 * @return IPicture
	 */
	abstract public function store( string$content, string$dir='/', string$contentType=null ):IPicture;

	/**
	 * Method delete
	 *
	 * @abstract
	 *
	 * @access public
	 *
	 * @param  string $path
	 *
	 * @return bool
	 */
	abstract public function delete( string$path ):bool;

	/**
	 * Method copy
	 *
	 * @abstract
	 *
	 * @access public
	 *
	 * @param  string $path
	 * @param  string $dir
	 *
	 * @return bool
	 */
	abstract public function copy( string$path, string$dir ):bool;

	/**
	 * Method move
	 *
	 * @abstract
	 *
	 * @access public
	 *
	 * @param  string $path
	 * @param  string $dir
	 *
	 * @return bool
	 */
	abstract public function move( string$path, string$dir ):bool;

}
