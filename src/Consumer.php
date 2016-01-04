<?php
namespace Segment;

interface Consumer
{
	/**
	 *
	 * @param  array $message
	 * @return boolean whether the call succeeded
	 */
	public function log(array $message);
}
