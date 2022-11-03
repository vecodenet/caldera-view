<?php

declare(strict_types = 1);

/**
 * Caldera View
 * Simple view abstraction layer, part of Vecode Caldera
 * @author  biohzrdmx <github.com/biohzrdmx>
 * @copyright Copyright (c) 2022 Vecode. All rights reserved
 */

namespace Caldera\View\Adapter;

interface AdapterInterface {

	/**
	 * Get template engine
	 * @return mixed
	 */
	public function getEngine(string $component = '');

	/**
	 * Render template
	 * @param  string $template Template name
	 * @param  array  $data     Template data
	 * @return string
	 */
	public function render(string $template, array $data): string;

	/**
	 * Clear cache
	 * @return void
	 */
	public function clear(): void;
}
