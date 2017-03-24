<?php

namespace CatPKT\PictureProvider;

////////////////////////////////////////////////////////////////

interface IPicture
{

	/**
	 * Method getUrlBySize
	 *
	 * @abstract
	 *
	 * @access public
	 *
	 * @return string
	 */
	function getUrlBySize():string;

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

}
