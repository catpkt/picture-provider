<?php

namespace CatPKT\PictureProvider;

////////////////////////////////////////////////////////////////

final class PictureList implements Iterator, ArrayAccess
{

	/**
	 * Var array
	 *
	 * @access protected
	 *
	 * @var    array
	 */
	protected $array= [];

	/**
	 * Var index
	 *
	 * @access protected
	 *
	 * @var    int
	 */
	protected $index= 0;

	/**
	 * Constructor
	 *
	 * @access public
	 *
	 * @param  iterable $pictures
	 *
	 * @return
	 */
	public function __construct( iterable$pictures )
	{
		foreach( $pictures as $picture )
		{
			$this->append( $picture );
		}
	}

	/**
	 * Add a Picture to this list.
	 *
	 * @access public
	 *
	 * @param  IPicture $pictuce
	 *
	 * @return void
	 */
	public function append( IPicture$pictuce )
	{
		$this->array[]= $pictuce;
	}

	/**
	 * Pop the last item from this list.
	 *
	 * @access public
	 *
	 * @return ?IPicture
	 */
	public function pop()/*:?IPicture*/
	{
		return array_pop( $this->array );
	}


	/******************\
	 * ArrayAccess    *
	\******************/

	/**
	 * Check wheather offset exists.
	 *
	 * @access public
	 *
	 * @param  int $offset
	 *
	 * @return bool
	 */
	public function offsetExists( int$offset ):bool
	{
		return array_key_exists( $offset, $this->array );
	}

	/**
	 * Get Picture by offset.
	 *
	 * @access public
	 *
	 * @param  int $offset
	 *
	 * @return IPicture
	 */
	public function offsetGet( int$offset ):IPicture
	{
		return $this->array[$offset];
	}

	/**
	 * Set Picture to given offset.
	 *
	 * @access public
	 *
	 * @param  int $offset
	 * @param  IPicture $picture
	 *
	 * @return void
	 */
	public function offsetSet( int$offset, IPicture$picture )/*:void*/
	{
		$count= count( $this->array );

		if( $offset>$count )
		{
			throw new Exception( 'The offset is to big.' );
		}
		elseif( $offset>=0 )
		{
			$this->array[$offset]= $picture;
		}
		elseif( $offset>=-$count )
		{
			$this->array[$count+$offset]= $picture;
		}
		else
		{
			throw new Exception( 'The offset is to small.' );
		}
	}

	/**
	 * Cannot unset a Picture by offset. Pleace use pop or splice.
	 *
	 * @access public
	 *
	 * @param  int $offset
	 *
	 * @return void
	 */
	public function offsetUnset( int$offset )/*:void*/
	{
		throw new Exception( 'Cannot unset a Picture by offset. Pleace use pop or splice.' );
	}


	/************\
	 * Iterator *
	\************/

	/**
	 * Get current Picture.
	 *
	 * @access public
	 *
	 * @return IPicture
	 */
	public function current():IPicture
	{
		return $this->offsetGet( $this->index );
	}

	/**
	 * Get current key.
	 *
	 * @access public
	 *
	 * @return int
	 */
	public function key():int
	{
		return $this->index;
	}

	/**
	 * Move to next Picture.
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function next()/*:void*/
	{
		++$this->key;
	}

	/**
	 * Move to the first Picture.
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function rewind()/*:void*/
	{
		$this->key= 0;
	}

	/**
	 * Check wheather are more Pictures left.
	 *
	 * @access public
	 *
	 * @return bool
	 */
	public function valid():bool
	{
		return $this->offsetExists( $this->index );
	}

}
