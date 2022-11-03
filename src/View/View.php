<?php

declare(strict_types = 1);

/**
 * Caldera View
 * Simple view abstraction layer, part of Vecode Caldera
 * @author  biohzrdmx <github.com/biohzrdmx>
 * @copyright Copyright (c) 2022 Vecode. All rights reserved
 */

namespace Caldera\View;

use Caldera\View\Adapter\AdapterInterface;

class View {

	/**
	 * View Adapter
	 * @var AdapterInterface
	 */
	protected $adapter;

	/**
	 * View data
	 * @var array
	 */
	protected $data = [];

	/**
	 * View template name
	 * @var string
	 */
	protected $template;

	/**
	 * Constructor
	 * @param AdapterInterface $adapter View adapter
	 */
	public function __construct(AdapterInterface $adapter) {
		$this->adapter = $adapter;
	}

	/**
	 * Set the view template
	 * @param  string $template Template name
	 * @return $this
	 */
	public function template(string $template) {
		$this->template = $template;
		return $this;
	}

	/**
	 * Add data to the template
	 * @param  mixed $name  Data name or associative array with data
	 * @param  mixed $value Data value
	 * @return $this
	 */
	public function with($name, $value = null) {
		if ( is_array($name) ) {
			$this->data = array_merge($this->data, $name);
		} else {
			$this->data[$name] = $value;
		}
		return $this;
	}

	/**
	 * Render the view
	 * @return string
	 */
	public function render(): string {
		return $this->adapter->render($this->template, $this->data);
	}
}
