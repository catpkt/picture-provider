<?php

namespace CatPKT\PictureProvider;

use Symfony\Component\HttpFoundation\{  Request,  Response  };

////////////////////////////////////////////////////////////////

class PictureProvider
{

	/**
	 * The Storage class that extends AStorage.
	 *
	 * @access protected
	 *
	 * @var    AStorage
	 */
	protected $storage;

	/**
	 * Method __construct
	 *
	 * @access public
	 *
	 * @param  AStorage $storage
	 */
	public function __construct( AStorage$storage )
	{
		$this->storage= $storage;
	}

	/**
	 * Dispatch and run controller.
	 *
	 * @access public
	 *
	 * @param  Request $request
	 *
	 * @return Response
	 */
	public function handle( Request$request ):Response
	{
		$this->{$this->route( $request )}( $request );
	}

	/**
	 * Route the request to a controller method.
	 *
	 * @access private
	 *
	 * @param  Request $request
	 *
	 * @return string
	 */
	private function route( Request$request ):string
	{
		$path= trim( $request->path(), '/' );

		$app=  strstr( $path, '/', true  )?:$path;
		$path= strstr( $path, '/', false )?:'/';

		$this->storage->setApp( $app );

		return [
			'POST:/'=> 'upload',
			'GET:/'=> 'previewList',
			'GET:/urls'=> 'urls',
			'GET:/content'=> 'content',
			'DELETE:/'=> 'delete',
			'PUT:/'=> 'copy',
			'PATCH:/'=> 'move',
		][$request->method().':'.$path];
	}

	/**
	 * Upload a Picture
	 *
	 * @access protected
	 *
	 * @param  Request $request
	 *
	 * @return array
	 */
	protected function upload( Request$request ):array
	{
		$content=     $this->storage->app->encryptor->decrypt( $request->getContent() );
		$contentType= $request->headers->get( 'Content-Type' );
		$directory=   $request->get( 'dir' );

		$picture= $this->storage->store( $content, $directory, $contentType );

		return $picture->hash();
	}

	/**
	 * Preview Pictures in given directory.
	 *
	 * @access protected
	 *
	 * @param  Request $request
	 *
	 * @return array
	 */
	protected function previewList( Request$request ):array
	{
		#
	}

	/**
	 * Get URLs of different size of a Picture.
	 *
	 * @access protected
	 *
	 * @param  Request $request
	 *
	 * @return array
	 */
	protected function urls( Request$request ):array
	{
		$picture= $this->storage->get( $request->get( 'hash' ) );

		return array_map( function( $size )use( $picture ){
			return $picture->getUrlBySize( $size );
		}, $request->get( 'sizes' ) );
	}

	/**
	 * Get content of a Picture.
	 *
	 * @access protected
	 *
	 * @param  Request $request
	 *
	 * @return array
	 */
	protected function content( Request$request ):array
	{
		return $this->storage->get( $request->get( 'hash' ) )->getContent();
	}

	/**
	 * Delete a Picture.
	 *
	 * @access protected
	 *
	 * @param  Request $request
	 *
	 * @return array
	 */
	protected function delete( Request$request ):array
	{
		return $this->storage->delete( $request->get( 'path' ) );
	}

	/**
	 * Copy a Picture from to another directory.
	 *
	 * @access protected
	 *
	 * @param  Request $request
	 *
	 * @return array
	 */
	protected function copy( Request$request ):array
	{
		return $this->storage->copy( $request->get( 'path' ), $request->get( 'dir' ) );
	}

	/**
	 * Move a Picture from to another directory.
	 *
	 * @access protected
	 *
	 * @param  Request $request
	 *
	 * @return array
	 */
	protected function move( Request$request ):array
	{
		return $this->storage->move( $request->get( 'path' ), $request->get( 'dir' ) );
	}

}
