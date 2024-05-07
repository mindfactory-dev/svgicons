<?php

declare(strict_types=1);

namespace Mindfactory\Svgicons\Test\TestCase\View\Helper;

use Cake\TestSuite\TestCase;
use Cake\View\View;
use Mindfactory\Svgicons\View\Helper\IconHelper;

/**
 * Mindfactory\Svgicons\View\Helper\IconHelper Test Case
 */
class IconHelperTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Mindfactory\Svgicons\View\Helper\IconHelper
     */
    protected $Icon;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        error_reporting(E_ALL);
        parent::setUp();
        $view = new View();
        $this->Icon = new IconHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Icon);

        parent::tearDown();
    }

    /** @test */
    public function icon_name_in_file(): void
    {
        $this->Icon->setConfig('iconSets.provider-a.svg', 'node_modules/provider-a/{icon}.svg');

        $result = $this->Icon->get('provider-a.a-a');
        $expected = 'svg-a-a';

        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function iconName_in_folder(): void
    {
        $this->Icon->setConfig('iconSets.provider-b.svg', 'node_modules/provider-b/{icon}/version.svg');


        $result = $this->Icon->get('provider-b.b-a');
        $expected = 'svg-b-a';

        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function default_icon_set_when_one_is_provided(): void
    {
        $this->Icon->setConfig('iconSets.default.svg', 'node_modules/provider-a/{icon}.svg');

        $result = $this->Icon->get('a-a');
        $expected = 'svg-a-a';

        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function wrong_icon_name(): void
    {
        $this->Icon->setConfig('iconSets.default.svg', 'node_modules/provider-a/{icon}.svg');

        $result = $this->Icon->get('wrong-icon-name');
        $expected = '';

        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function wrong_provider_name(): void
    {
        $this->Icon->setConfig('iconSets.provider-a.svg', 'node_modules/provider-a/{icon}.svg');

        $result = $this->Icon->get('wrong-provider-name.icon');
        $expected = '';

        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function with_other_delimiter(): void
    {
        $this->Icon->setConfig('iconSets.provider-a.svg', 'node_modules/provider-a/{icon}.svg');
        $this->Icon->setConfig('delimiter', '/');


        $result = $this->Icon->get('provider-a/a-a');
        $expected = 'svg-a-a';

        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function setting_with_slashes(): void
    {
        $this->Icon->setConfig('iconSets.provider-a.svg', 'node_modules/provider-a/{icon}.svg');

        $result = $this->Icon->get('provider-a.a-a');
        $expected = 'svg-a-a';

        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function add_css_classes_to_svg(): void
    {
        $this->Icon->setConfig('iconSets.provider-a.svg', 'node_modules/provider-a/{icon}.svg');

        $result = $this->Icon->get('provider-a.real', 'size-6');
        $expected = [
            'svg' => [
                'class' => 'size-6',
                'xmlns' => 'http://www.w3.org/2000/svg',
                'fill' => 'none',
                'viewBox' => '0 0 24 24',
                'stroke-width' => '1.5',
                'stroke' => 'currentColor',
                'aria-hidden' => 'true',
                'data-slot' => 'icon',
            ],
            'path' => [
                'stroke-linecap' => 'round',
                'stroke-linejoin' => 'round',
                'd' => 'M5 12h14',
            ],
            '/svg',
        ];

        $this->assertHtml($expected, $result);
    }

    /** @test */
    public function no_css_classes_added_to_svg(): void
    {
        $this->Icon->setConfig('iconSets.provider-a.svg', 'node_modules/provider-a/{icon}.svg');

        $result = $this->Icon->get('provider-a.real');
        $expected = [
            'svg' => [
                'xmlns' => 'http://www.w3.org/2000/svg',
                'fill' => 'none',
                'viewBox' => '0 0 24 24',
                'stroke-width' => '1.5',
                'stroke' => 'currentColor',
                'aria-hidden' => 'true',
                'data-slot' => 'icon',
            ],
            'path' => [
                'stroke-linecap' => 'round',
                'stroke-linejoin' => 'round',
                'd' => 'M5 12h14',
            ],
            '/svg',
        ];

        $this->assertHtml($expected, $result);
    }

    /** @test */
    public function css_classes_is_empty_string_no_css_added_to_svg(): void
    {
        $this->Icon->setConfig('iconSets.provider-a.svg', 'node_modules/provider-a/{icon}.svg');

        $result = $this->Icon->get('provider-a.real', '');
        $expected = [
            'svg' => [
                'xmlns' => 'http://www.w3.org/2000/svg',
                'fill' => 'none',
                'viewBox' => '0 0 24 24',
                'stroke-width' => '1.5',
                'stroke' => 'currentColor',
                'aria-hidden' => 'true',
                'data-slot' => 'icon',
            ],
            'path' => [
                'stroke-linecap' => 'round',
                'stroke-linejoin' => 'round',
                'd' => 'M5 12h14',
            ],
            '/svg',
        ];

        $this->assertHtml($expected, $result);
    }

    /** @test */
    public function css_class_exists_on_orginal_will_be_removed(): void
    {
        $this->Icon->setConfig('iconSets.provider-a.svg', 'node_modules/provider-a/{icon}.svg');

        $result = $this->Icon->get('provider-a.real-with-class');
        $expected = [
            'svg' => [
                'xmlns' => 'http://www.w3.org/2000/svg',
                'fill' => 'none',
                'viewBox' => '0 0 24 24',
                'stroke-width' => '1.5',
                'stroke' => 'currentColor',
                'aria-hidden' => 'true',
                'data-slot' => 'icon',
            ],
            'path' => [
                'stroke-linecap' => 'round',
                'stroke-linejoin' => 'round',
                'd' => 'M5 12h14',
            ],
            '/svg',
        ];

        $this->assertHtml($expected, $result);
    }

    /** @test */
    public function default_css_classes_exists_and_none_in_params(): void
    {
        $this->Icon->setConfig('iconSets.provider-a.svg', 'node_modules/provider-a/{icon}.svg');
        $this->Icon->setConfig('defaultCss', 'size-4');


        $result = $this->Icon->get('provider-a.real');
        $expected = [
            'svg' => [
                'class' => 'size-4',
                'xmlns' => 'http://www.w3.org/2000/svg',
                'fill' => 'none',
                'viewBox' => '0 0 24 24',
                'stroke-width' => '1.5',
                'stroke' => 'currentColor',
                'aria-hidden' => 'true',
                'data-slot' => 'icon',
            ],
            'path' => [
                'stroke-linecap' => 'round',
                'stroke-linejoin' => 'round',
                'd' => 'M5 12h14',
            ],
            '/svg',
        ];

        $this->assertHtml($expected, $result);
    }

    /** @test */
    public function overite_css_when_default_css_applayed(): void
    {
        $this->Icon->setConfig('iconSets.provider-a.svg', 'node_modules/provider-a/{icon}.svg');
        $this->Icon->setConfig('defaultCss', 'size-4');

        $result = $this->Icon->get('provider-a.real', 'size-6');
        $expected = [
            'svg' => [
                'class' => 'size-6',
                'xmlns' => 'http://www.w3.org/2000/svg',
                'fill' => 'none',
                'viewBox' => '0 0 24 24',
                'stroke-width' => '1.5',
                'stroke' => 'currentColor',
                'aria-hidden' => 'true',
                'data-slot' => 'icon',
            ],
            'path' => [
                'stroke-linecap' => 'round',
                'stroke-linejoin' => 'round',
                'd' => 'M5 12h14',
            ],
            '/svg',
        ];

        $this->assertHtml($expected, $result);
    }

    /** @test */
    public function apend_css_when_default_css_appalyed(): void
    {
        $this->Icon->setConfig('iconSets.provider-a.svg', 'node_modules/provider-a/{icon}.svg');
        $this->Icon->setConfig('defaultCss', 'size-4');
        $this->Icon->setConfig('overwriteCss', false);

        $result = $this->Icon->get('provider-a.real', 'text-white');
        $expected = [
            'svg' => [
                'class' => 'size-4 text-white',
                'xmlns' => 'http://www.w3.org/2000/svg',
                'fill' => 'none',
                'viewBox' => '0 0 24 24',
                'stroke-width' => '1.5',
                'stroke' => 'currentColor',
                'aria-hidden' => 'true',
                'data-slot' => 'icon',
            ],
            'path' => [
                'stroke-linecap' => 'round',
                'stroke-linejoin' => 'round',
                'd' => 'M5 12h14',
            ],
            '/svg',
        ];

        $this->assertHtml($expected, $result);
    }

    /** @test */
    public function apend_css_when_default_css_isent_appalyed(): void
    {
        $this->Icon->setConfig('iconSets.provider-a.svg', 'node_modules/provider-a/{icon}.svg');
        $this->Icon->setConfig('overwriteCss', false);

        $result = $this->Icon->get('provider-a.real', 'text-white');
        $expected = [
            'svg' => [
                'class' => 'text-white',
                'xmlns' => 'http://www.w3.org/2000/svg',
                'fill' => 'none',
                'viewBox' => '0 0 24 24',
                'stroke-width' => '1.5',
                'stroke' => 'currentColor',
                'aria-hidden' => 'true',
                'data-slot' => 'icon',
            ],
            'path' => [
                'stroke-linecap' => 'round',
                'stroke-linejoin' => 'round',
                'd' => 'M5 12h14',
            ],
            '/svg',
        ];

        $this->assertHtml($expected, $result);
    }

    /** @test */
    public function when_svg_attributs_on_seperate_rows(): void
    {
        $this->Icon->setConfig('iconSets.provider-a.svg', 'node_modules/provider-a/{icon}.svg');

        $result = $this->Icon->get('provider-a.real-seperate-rows', 'size-6');
        $expected = [
            'svg' => [
                'class' => 'size-6',
                'xmlns' => 'http://www.w3.org/2000/svg',
                'fill' => 'none',
                'viewBox' => '0 0 24 24',
                'stroke-width' => '1.5',
                'stroke' => 'currentColor',
                'aria-hidden' => 'true',
                'data-slot' => 'icon',
            ],
            'path' => [
                'stroke-linecap' => 'round',
                'stroke-linejoin' => 'round',
                'd' => 'M5 12h14',
            ],
            '/svg',
        ];

        $this->assertHtml($expected, $result);
    }

    /** @test */
    public function add_stroke_if_set_in_config(): void
    {
        $this->Icon->setConfig('iconSets.provider-a.svg', 'node_modules/provider-a/{icon}.svg');
        $this->Icon->setConfig('iconSets.provider-a.addStroke', true);

        $result = $this->Icon->get('provider-a.real-no-currentcolor');
        $expected = [
            'svg' => [
                'xmlns' => 'http://www.w3.org/2000/svg',
                'viewBox' => '0 0 24 24',
                'stroke-width' => '1.5',
                'stroke' => 'currentColor',
                'aria-hidden' => 'true',
                'data-slot' => 'icon',
            ],
            'path' => [
                'stroke-linecap' => 'round',
                'stroke-linejoin' => 'round',
                'd' => 'M5 12h14',
            ],
            '/svg',
        ];

        $this->assertHtml($expected, $result);
    }

    /** @test */
    public function add_fill_if_set_in_config(): void
    {
        $this->Icon->setConfig('iconSets.provider-a.svg', 'node_modules/provider-a/{icon}.svg');
        $this->Icon->setConfig('iconSets.provider-a.addFill', true);

        $result = $this->Icon->get('provider-a.real-no-currentcolor');
        $expected = [
            'svg' => [
                'xmlns' => 'http://www.w3.org/2000/svg',
                'viewBox' => '0 0 24 24',
                'stroke-width' => '1.5',
                'fill' => 'currentColor',
                'aria-hidden' => 'true',
                'data-slot' => 'icon',
            ],
            'path' => [
                'stroke-linecap' => 'round',
                'stroke-linejoin' => 'round',
                'd' => 'M5 12h14',
            ],
            '/svg',
        ];

        $this->assertHtml($expected, $result);
    }
}
