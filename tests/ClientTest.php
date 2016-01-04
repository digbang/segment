<?php
use Segment\Client;

class ClientTest extends PHPUnit_Framework_TestCase
{
	private $identifyMessage = [
		'userId' => 'Calvin',
		'traits' => [
			'loves_php' => false,
			'type'      => 'analytics.log',
			'birthday'  => 1399997957,
		]
	];

	private $trackMessage = [
		'userId' => 'some-user',
        'event' => 'File PHP Event'
	];

	private $groupMessage = [
		'userId' => 'user-id',
		'groupId' => 'group-id',
		'traits' => [
			'type' => 'consumer analytics.log test'
		],
	];

	private $pageMessage = [
		'userId' => 'user-id',
		'name' => 'analytics-php',
		'category' => 'analytics.log',
		'properties' => [
			'url' => 'https://www.example.com/'
		]
	];

	private $pageNoUrlMessage = [
		'userId' => 'user-id',
		'name' => 'analytics-php',
		'category' => 'analytics.log',
		'properties' => []
	];

	private $screenMessage = [
		'userId' => 'user-id',
		'name' => 'Home',
		'properties' => [
			'name' => 'Login'
		]
	];

	private $aliasMessage = [
		'previousId' => 'previous-id',
		'userId' => 'user-id',
	];

	/** @var \Mockery\MockInterface|Segment\Consumer */
	private $consumer;

	/** @var Client */
	private $client;

	/**
	 * Sets up the fixture, for example, open a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->consumer = Mockery::mock(Segment\Consumer::class);
		$this->client = new Client($this->consumer);
	}

	public function testIdentify()
	{
		$this->consumer->shouldReceive('identify')->with(Mockery::subset(array_merge(
			$this->identifyMessage,
			[
				'context' => [
					'library' => [
						'name'    => 'analytics-php',
						'version' => Client::VERSION
					]
				],
				'type' => Client::DEF_IDENTIFY_TYPE
			]
		)))->once();

		$this->client->identify($this->identifyMessage);
	}

	public function testIdentifyWithMessageId()
	{
		$this->consumer->shouldReceive('identify')->with(Mockery::hasKey('messageId'))->once();

		$this->client->identify($this->identifyMessage);
	}
	public function testIdentifyWithTimestamp()
	{
		$this->consumer->shouldReceive('identify')->with(Mockery::hasKey('timestamp'))->once();

		$this->client->identify($this->identifyMessage);
	}

	public function testTrack()
	{
		$this->consumer->shouldReceive('track')->with(Mockery::subset(array_merge(
			$this->trackMessage,
			[
				'context' => [
					'library' => [
						'name'    => 'analytics-php',
						'version' => Client::VERSION
					]
				],
				'type' => Client::DEF_TRACK_TYPE
			]
		)))->once();

		$this->client->track($this->trackMessage);
	}

	public function testTrackWithMessageId()
	{
		$this->consumer->shouldReceive('track')->with(Mockery::hasKey('messageId'))->once();

		$this->client->track($this->trackMessage);
	}
	public function testTrackWithTimestamp()
	{
		$this->consumer->shouldReceive('track')->with(Mockery::hasKey('timestamp'))->once();

		$this->client->track($this->trackMessage);
	}

	public function testGroup()
	{
		$this->consumer->shouldReceive('group')->with(Mockery::subset(array_merge(
			$this->groupMessage,
			[
				'context' => [
					'library' => [
						'name'    => 'analytics-php',
						'version' => Client::VERSION
					]
				],
				'type' => Client::DEF_GROUP_TYPE
			]
		)))->once();

		$this->client->group($this->groupMessage);
	}

	public function testGroupWithMessageId()
	{
		$this->consumer->shouldReceive('group')->with(Mockery::hasKey('messageId'))->once();

		$this->client->group($this->groupMessage);
	}
	public function testGroupWithTimestamp()
	{
		$this->consumer->shouldReceive('group')->with(Mockery::hasKey('timestamp'))->once();

		$this->client->group($this->groupMessage);
	}

	public function testPage()
	{
		$this->consumer->shouldReceive('page')->with(Mockery::subset(array_merge(
			$this->pageMessage,
			[
				'context' => [
					'library' => [
						'name'    => 'analytics-php',
						'version' => Client::VERSION
					]
				],
				'type' => Client::DEF_PAGE_TYPE
			]
		)))->once();

		$this->client->page($this->pageMessage);
	}

	public function testPageWithMessageId()
	{
		$this->consumer->shouldReceive('page')->with(Mockery::hasKey('messageId'))->once();

		$this->client->page($this->pageMessage);
	}
	public function testPageWithTimestamp()
	{
		$this->consumer->shouldReceive('page')->with(Mockery::hasKey('timestamp'))->once();

		$this->client->page($this->pageMessage);
	}

	public function testPageNoUrl()
	{
		$subsetMessage = $this->pageNoUrlMessage;
		unset($subsetMessage['properties']);

		$this->consumer->shouldReceive('page')->with(Mockery::subset(array_merge(
			$subsetMessage,
			[
				'context' => [
					'library' => [
						'name'    => 'analytics-php',
						'version' => Client::VERSION
					]
				],
				'type' => Client::DEF_PAGE_TYPE
			]
		)))->once();

		$this->client->page($this->pageNoUrlMessage);
	}

	public function testPageNoUrlWithMessageId()
	{
		$this->consumer->shouldReceive('page')->with(Mockery::hasKey('messageId'))->once();

		$this->client->page($this->pageNoUrlMessage);
	}
	public function testPageNoUrlWithTimestamp()
	{
		$this->consumer->shouldReceive('page')->with(Mockery::hasKey('timestamp'))->once();

		$this->client->page($this->pageNoUrlMessage);
	}

	public function testScreen()
	{
		$this->consumer->shouldReceive('screen')->with(Mockery::subset(array_merge(
			$this->screenMessage,
			[
				'context' => [
					'library' => [
						'name'    => 'analytics-php',
						'version' => Client::VERSION
					]
				],
				'type' => Client::DEF_SCREEN_TYPE
			]
		)))->once();

		$this->client->screen($this->screenMessage);
	}

	public function testScreenWithMessageId()
	{
		$this->consumer->shouldReceive('screen')->with(Mockery::hasKey('messageId'))->once();

		$this->client->screen($this->screenMessage);
	}
	public function testScreenWithTimestamp()
	{
		$this->consumer->shouldReceive('screen')->with(Mockery::hasKey('timestamp'))->once();

		$this->client->screen($this->screenMessage);
	}

	public function testAlias()
	{
		$this->consumer->shouldReceive('alias')->with(Mockery::subset(array_merge(
			$this->aliasMessage,
			[
				'context' => [
					'library' => [
						'name'    => 'analytics-php',
						'version' => Client::VERSION
					]
				],
				'type' => Client::DEF_ALIAS
			]
		)))->once();

		$this->client->alias($this->aliasMessage);
	}

	public function testAliasWithMessageId()
	{
		$this->consumer->shouldReceive('alias')->with(Mockery::hasKey('messageId'))->once();

		$this->client->alias($this->aliasMessage);
	}
	public function testAliasWithTimestamp()
	{
		$this->consumer->shouldReceive('alias')->with(Mockery::hasKey('timestamp'))->once();

		$this->client->alias($this->aliasMessage);
	}

	/**
	 * Tears down the fixture, for example, close a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
		Mockery::close();
	}
}
