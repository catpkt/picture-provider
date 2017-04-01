<?php

namespace CatPKT\PictureProvider;

use Symfony\Component\HttpFoundation\{  Request,  Response, JsonResponse  };

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
		$path= trim( $request->getPathInfo(), '/' );

		$app=  strstr( $path, '/', true  )?:$path;

		$this->storage->setApp( $app );

		return new Response(
			$this->storage->app()->getEncryptor()->encrypt(
				$this->{$this->route( $request )}( $request )
			)
		);
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
		$path= trim( $request->getPathInfo(), '/' );

		$path= strstr( $path, '/', false )?:'/';

		return [
			'POST:/'=> 'upload',
			'GET:/'=> 'list',
			'GET:/urls'=> 'urls',
			'GET:/content'=> 'content',
			'DELETE:/'=> 'delete',
			'PUT:/'=> 'copy',
			'PATCH:/'=> 'move',
		][$request->getMethod().':'.$path];
	}

	/**
	 * Upload a Picture
	 *
	 * @access protected
	 *
	 * @param  Request $request
	 *
	 * @return string
	 */
	protected function upload( Request$request ):string
	{
		$content=     $this->storage->app()->getEncryptor()->decrypt( $request->getContent() );
		$contentType= $request->headers->get( 'Content-Type' );
		$directory=   $request->get( 'dir' );

		$picture= $this->storage->store( $content, $directory, $contentType );

		return $picture->getHash();
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
	protected function list( Request$request ):array
	{
		if(!( $dir= $request->get( 'dir' ) ))
		{
			throw new Exceptions\BadRequest( 'Query parameter "dir" is required.' );
		}

		return $this->storage->list( $dir )->toArray();
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
		if(!( $hash= $request->get( 'hash' ) and $sizes= $request->get( 'sizes' ) ))
		{
			throw new Exceptions\BadRequest( 'Query parameter "hash" is required.' );
		}

		$picture= $this->storage->get( $hash );

		return array_combine( $sizes, array_map( function( $size )use( $picture ){

			return $picture->getUrlBySize( ...$this->parseSize( $size ) );

		}, $sizes ) );
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
	 * @return bool
	 */
	protected function delete( Request$request ):bool
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
	 * @return bool
	 */
	protected function copy( Request$request ):bool
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
	 * @return bool
	 */
	protected function move( Request$request ):bool
	{
		return $this->storage->move( $request->get( 'path' ), $request->get( 'dir' ) );
	}

	/**
	 * Method parseSize
	 *
	 * @access private
	 *
	 * @param  string $size
	 *
	 * @return array
	 */
	private function parseSize( string$size ):array
	{
		if(!( preg_match( '/\\d+x\\d+/i', $size ) ))
		{
			abort( 400, 'Invalid size format.' );
		}

		return explode( 'x', strtolower( $size ) );
	}

}
