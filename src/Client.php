<?php
namespace Segment;

use Ramsey\Uuid\Uuid;

class Client
{
	const VERSION = '1.1.3';

	const DEF_IDENTIFY = ['name' => 'identify', 'key' => 'traits'];
	const DEF_TRACK = ['name' => 'track', 'key' => 'properties'];
	const DEF_GROUP = ['name' => 'group', 'key' => 'traits'];
	const DEF_PAGE = ['name' => 'page', 'key' => 'properties'];
	const DEF_SCREEN = ['name' => 'screen', 'key' => 'properties'];
	const DEF_ALIAS = ['name' => 'alias', 'key' => 'alias'];

	/**
	 * @var Consumer
	 */
	private $consumer;

	/**
	 * Client constructor.
	 * @param Consumer $consumer
	 */
	public function __construct(Consumer $consumer)
	{
		$this->consumer = $consumer;
	}

	public function identify(array $message)
	{
		return $this->consumer->identify($this->addContext($message, self::DEF_IDENTIFY['name'], self::DEF_IDENTIFY['key']));
	}

	public function track(array $message)
	{
		return $this->consumer->track($this->addContext($message, self::DEF_TRACK['name'], self::DEF_TRACK['key']));
	}

	public function group(array $message)
	{
		return $this->consumer->group($this->addContext($message, self::DEF_GROUP['name'], self::DEF_GROUP['key']));
	}

	public function page(array $message)
	{
		return $this->consumer->page($this->addContext($message, self::DEF_PAGE['name'], self::DEF_PAGE['key']));
	}

	public function screen(array $message)
	{
		return $this->consumer->screen($this->addContext($message, self::DEF_SCREEN['name'], self::DEF_SCREEN['key']));
	}

	public function alias(array $message)
	{
		return $this->consumer->alias($this->addContext($message, self::DEF_ALIAS['name'], self::DEF_ALIAS['key']));
	}

	/**
	 * Formats context information.
	 * Adds context information if missing.
	 *
	 * @param $msg
	 * @param $key
	 * @return mixed
	 */
	private function addContext($msg, $type, $key)
	{
		if (!isset($msg[$key]) || empty($msg[$key]))
		{
			$msg[$key] = new \stdClass();
		}
		elseif($key == self::DEF_ALIAS['key'])
		{
			$msg[$key] = new \stdClass();
		}

		$msg['context'] = array_merge(isset($msg['context']) ? $msg['context'] : [], $this->getContext());
		$msg['timestamp'] = $this->formatTime(isset($msg['timestamp']) ? $msg['timestamp'] : null);
		$msg['messageId'] = Uuid::uuid4();
		$msg['type'] = $type;

		return $msg;
	}

	/**
	 * Add the segment.io context to the request
	 * @return array additional context
	 */
	private function getContext()
	{
		return [
			'library' => [
				'name'    => 'analytics-php',
				'version' => self::VERSION
			]
		];
	}

	/**
	 * Formats a timestamp by making sure it is set
	 * and converting it to iso8601.
	 *
	 * The timestamp can be time in seconds `time()` or `microtime(true)`.
	 * any other input is considered an error and the method will return a new date.
	 *
	 * @param int $ts - time in seconds (time())
	 *
	 * @return bool|string
	 */
	private function formatTime($ts)
	{
		// time()
		if ($ts == null)
		{
			$ts = microtime(true);
		}

		if (is_integer($ts))
		{
			return date('c', $ts);
		}

		// anything else return a new date.
		if (!is_float($ts))
		{
			return date('c');
		}

		return \DateTime::createFromFormat('U.u', $ts)->format('Y-m-d\TH:i:suP');
	}
}
