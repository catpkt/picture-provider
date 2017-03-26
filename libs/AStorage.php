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
	 * @access public
	 *
	 * @param  string $appName
	 *
	 * @return void
	 */
	public function setApp( string$appName )
	{
		$this->app= $this->findApp( $appName );
	}

	/**
	 * Set which App request this server.
	 *
	 * @abstract
	 *
	 * @access public
	 *
	 * @param  string $appName
	 *
	 * @return AApp
	 */
	abstract public function findApp( strnig$appName );

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
	 * @param  string $path
	 * @param  string $contentType
	 *
	 * @return IPicture
	 */
	abstract public function store( string$content, string$path='/', string$contentType=null ):IPicture;

}
