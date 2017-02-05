<?php

namespace Blogette\Provider\Impl\Rss\Model;

use Nette\InvalidStateException;
use Nette\Utils\DateTime;
use Nette\Utils\Strings;

/**
 * @property string $title
 * @property string $description
 * @property string $link
 * @property array $items
 * @property-read array $properties
 *
 * @method onPrepareProperties(array $properties)
 * @method onPrepareItem(array $item)
 */
final class RssModel
{

	/** @var array */
	private $properties;

	/** @var array */
	private $items;

	/** @var array */
	public $onPrepareProperties;

	/** @var array */
	public $onPrepareItem;

	/**
	 * Construct
	 */
	public function __construct()
	{
		// Set default prepare handlers
		$this->onPrepareProperties[] = [$this, 'prepareProperties'];
		$this->onPrepareItem[] = [$this, 'prepareItem'];
	}

	/**
	 * Convert date to RFC822
	 *
	 * @param string|DateTime $date
	 * @return string
	 */
	public static function prepareDate($date)
	{
		if (is_string($date) && $date === (string) (int) $date) {
			$date = (int) $date;
		}

		if (is_string($date) && !Strings::endsWith($date, 'GMT')) {
			$date = strtotime($date);
		}

		if (is_int($date)) {
			$date = gmdate('D, d M Y H:i:s', $date) . ' GMT';
		}

		return $date;
	}

	/**
	 * Prepare channel properties
	 *
	 * @param array $properties
	 * @return void
	 */
	public function prepareProperties(array $properties)
	{
		if (isset($properties['pubDate'])) {
			$properties['pubDate'] = self::prepareDate($properties['pubDate']);
		}

		if (isset($properties['lastBuildDate'])) {
			$properties['lastBuildDate'] = self::prepareDate($properties['lastBuildDate']);
		}
	}

	/**
	 * Prepare item
	 *
	 * @param array $item
	 * @return array
	 */
	public function prepareItem(array $item)
	{
		// guid & link
		if (empty($item['guid']) && isset($item['link'])) {
			$item['guid'] = $item['link'];
		}

		if (empty($item['link']) && isset($item['guid'])) {
			$item['link'] = $item['guid'];
		}

		// pubDate
		if (isset($item['pubDate'])) {
			$item['pubDate'] = self::prepareDate($item['pubDate']);
		}

		return $item;
	}

	/**
	 * GETTERS/SETTERS *********************************************************
	 * *************************************************************************
	 */

	/**
	 * @param string $name
	 * @param mixed $value
	 * @return void
	 */
	public function setChannelProperty($name, $value)
	{
		$this->properties[$name] = $value;
	}

	/**
	 * @param string $name
	 * @return mixed
	 */
	public function getChannelProperty($name)
	{
		return $this->properties[$name];
	}

	/**
	 * @return array
	 */
	public function getProperties()
	{
		return $this->properties;
	}

	/**
	 * @param string $title
	 * @return void
	 */
	public function setTitle($title)
	{
		$this->setChannelProperty('title', $title);
	}

	/**
	 * @return string
	 */
	public function getTitle()
	{
		return $this->getChannelProperty('title');
	}

	/**
	 * @param string $description
	 * @return void
	 */
	public function setDescription($description)
	{
		$this->setChannelProperty('description', $description);
	}

	/**
	 * @return string
	 */
	public function getDescription()
	{
		return $this->getChannelProperty('description');
	}

	/**
	 * @param string $link
	 * @return void
	 */
	public function setLink($link)
	{
		$this->setChannelProperty('link', $link);
	}

	/**
	 * @return string
	 */
	public function getLink()
	{
		return $this->getChannelProperty('link');
	}

	/**
	 * @param array $items
	 * @return void
	 */
	public function setItems($items)
	{
		$this->items = $items;
	}

	/**
	 * @param array $item
	 * @return void
	 */
	public function addItem(array $item)
	{
		$this->items[] = $item;
	}

	/**
	 * @return array
	 */
	public function getItems()
	{
		return $this->items;
	}

	/**
	 * Creates RSS feed
	 *
	 * @return object
	 */
	public function create()
	{
		// properties
		$properties = $this->getProperties();
		foreach ($this->onPrepareProperties as $callback) {
			$callback($properties);
		}

		// check
		if (empty($properties['title']) || empty($properties['description']) || empty($properties['link'])) {
			throw new InvalidStateException('At least one of mandatory properties title, description or link was not set.');
		}

		// items
		$items = $this->getItems();
		foreach ($items as &$item) {
			foreach ($this->onPrepareItem as $callback) {
				$callback($item);
			}

			// check
			if (empty($item['title']) && empty($item['description'])) {
				throw new InvalidStateException('One of title or description has to be set.');
			}
		}

		return (object) [
			'properties' => $properties,
			'items' => $items,
		];
	}

}
