<?php

declare(strict_types = 1);

/**
 * Caldera View
 * View abstraction layer, part of Vecode Caldera
 * @author  biohzrdmx <github.com/biohzrdmx>
 * @copyright Copyright (c) 2022 Vecode. All rights reserved
 */

namespace Caldera\View\Adapter;

use eftec\bladeone\BladeOne;

use Caldera\View\Adapter\AdapterInterface;

class BladeOneAdapter implements AdapterInterface {

	/**
	 * BladeOne engine
	 * @var BladeOne
	 */
	protected $engine;

	/**
	 * Templates directory
	 * @var string
	 */
	protected $template_dir;

	/**
	 * Cache directory
	 * @var string
	 */
	protected $cache_dir;

	/**
	 * Constructor
	 * @param string $template_dir Templates directory
	 * @param string $cache_dir    Cache directory
	 */
	public function __construct(string $template_dir, string $cache_dir) {
		$this->template_dir = $template_dir;
		$this->cache_dir = $cache_dir;
		# Create the engine
		$this->engine = new BladeOne($this->template_dir, $this->cache_dir);
	}

	/**
	 * Get template engine
	 * @param  string $component Component name
	 * @return mixed
	 */
	public function getEngine(string $component = '') {
		return $this->engine;
	}

	/**
	 * Render template
	 * @param  string $template Template name
	 * @param  array  $data     Template data
	 * @return string
	 */
	public function render(string $template, array $data): string {
		return $this->engine->run($template, $data);
	}

	/**
	 * Clear cache
	 * @return void
	 */
	public function clear(): void {
		$path = implode(DIRECTORY_SEPARATOR, [$this->cache_dir, '*.bladec']);
		$files = glob($path);
		array_map('unlink', $files ?: []);
	}
}
