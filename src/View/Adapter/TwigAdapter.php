<?php

declare(strict_types = 1);

/**
 * Caldera View
 * View abstraction layer, part of Vecode Caldera
 * @author  biohzrdmx <github.com/biohzrdmx>
 * @copyright Copyright (c) 2022 Vecode. All rights reserved
 */

namespace Caldera\View\Adapter;

use Twig\Environment;
use Twig\Loader\LoaderInterface;
use Twig\Loader\FilesystemLoader;

use Caldera\View\Adapter\AdapterInterface;

class TwigAdapter implements AdapterInterface {

	/**
	 * Twig engine
	 * @var Environment
	 */
	protected $engine;

	/**
	 * Twig loader
	 * @var LoaderInterface
	 */
	protected $loader;

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
		$this->loader = new FilesystemLoader($this->template_dir);
		$this->engine = new Environment($this->loader, [
			'cache' => $this->cache_dir
		]);
	}

	/**
	 * Get template engine
	 * @param  string $component Component name
	 * @return mixed
	 */
	public function getEngine(string $component = '') {
		$ret = null;
		switch ($component) {
			case 'loader':
				$ret = $this->loader;
			break;
			default:
				$ret = $this->engine;
			break;
		}
		return $ret;
	}

	/**
	 * Render template
	 * @param  string $template Template name
	 * @param  array  $data     Template data
	 * @return string
	 */
	public function render(string $template, array $data): string {
		return $this->engine->render("{$template}.twig", $data);
	}

	/**
	 * Clear cache
	 * @return void
	 */
	public function clear(): void {
		$path = implode(DIRECTORY_SEPARATOR, [$this->cache_dir, '*']);
		$files = glob($path);
		if ($files) {
			foreach($files as $file){
				if ( is_dir($file) && !in_array($file, ['..', '.']) ) {
					$contents = glob( implode(DIRECTORY_SEPARATOR, [$file, '*.php']) );
					array_map('unlink', $contents ?: []);
					# Only remove folders which names consist of two hexadecimal characters
					if ( preg_match('/[\/\\][0-9a-f]{2}$/', $file) === 1 ) {
						@rmdir($file);
					}
				}
			}
		}
	}
}
