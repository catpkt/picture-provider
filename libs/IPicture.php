<?php

namespace CatPKT\PictureProvider;

////////////////////////////////////////////////////////////////

interface IPicture
{

	/**
	 * Method getOriginUrl
	 *
	 * @abstract
	 *
	 * @access public
	 *
	 * @return string
	 */
	function getOriginUrl():string;

	/**
	 * Method getUrlBySize
	 *
	 * @abstract
	 *
	 * @access public
	 *
	 * @param int $width
	 * @param int $height
	 *
	 * @return string
	 */
	function getUrlBySize( int$width, int$height ):string;

	/**
	 * Method getContent
	 *
	 * @abstract
	 *
	 * @access public
	 *
	 * @return string
	 */
	function getContent():string;

	/**
	 * Method getHash
	 *
	 * @abstract
	 *
	 * @access public
	 *
	 * @return string
	 */
	function getHash():string;

}
