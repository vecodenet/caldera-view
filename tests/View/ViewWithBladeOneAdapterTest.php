<?php

declare(strict_types = 1);

/**
 * Caldera View
 * View abstraction layer, part of Vecode Caldera
 * @author  biohzrdmx <github.com/biohzrdmx>
 * @copyright Copyright (c) 2022 Vecode. All rights reserved
 */

namespace Caldera\Tests\View;

use eftec\bladeone\BladeOne;

use Caldera\View\Adapter\BladeOneAdapter;
use Caldera\View\View;

use PHPUnit\Framework\TestCase;

class ViewWithBladeOneAdapterTest extends TestCase {

	function testConstructorCreateEngine() {
		$template_dir = dirname(__FILE__) . '/templates';
		$cache_dir = BASE_DIR . '/tests/output';
		$adapter = new BladeOneAdapter($template_dir, $cache_dir);
		$this->assertInstanceOf(BladeOne::class, $adapter->getEngine());
	}

	function testRenderTemplateWithScalarData() {
		$template_dir = dirname(__FILE__) . '/templates';
		$cache_dir = BASE_DIR . '/tests/output';
		$adapter = new BladeOneAdapter($template_dir, $cache_dir);
		$view = new View($adapter);
		$template = $view->template('simple')
			->with('num', 5)
			->render();
		$this->assertEquals('<em>5</em>', $template);
	}

	function testRenderTemplateWithArrayData() {
		$template_dir = dirname(__FILE__) . '/templates';
		$cache_dir = BASE_DIR . '/tests/output';
		$adapter = new BladeOneAdapter($template_dir, $cache_dir);
		$view = new View($adapter);
		$template = $view->template('array')
			->with(['two' => 2, 'three' => 3, 'five' => 5, 'seven' => 7, 'eleven' => 11])
			->render();
		$this->assertEquals('<ul><li>2</li><li>3</li><li>5</li><li>7</li><li>11</li></ul>', $template);
	}

	function testClearCacheFiles() {
		$template_dir = dirname(__FILE__) . '/templates';
		$cache_dir = BASE_DIR . '/tests/output';
		$adapter = new BladeOneAdapter($template_dir, $cache_dir);
		$engine = $adapter->getEngine();
		$compiled = $engine->getCompiledFile('simple');
		$adapter->clear();
		$this->assertFileDoesNotExist($compiled);
	}
}
