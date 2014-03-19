<?php
/**
 * This file is part of the Encore\Container library.
 * Originally part of the League\Di package.
 *
 * (c) Don Gilbert <don@dongilbert.net>
 * (c) Chris Harvey <chris@chrisnharvey.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Encore\Container\Test;

use Encore\Container\Container;

/**
 * Container Test class
 *
 * @author  Don Gilbert <don@dongilbert.net>
 */
class ContainerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * Setup procedure which runs before each test.
     *
     * @return void
     */
    public function setUp()
    {
        $this->container = new Container;
    }

    /**
     * Tests creating a new Container.
     *
     * @return void
     */
    public function testConstruct()
    {
        $this->assertAttributeEquals(
            null,
            'parent',
            $this->container,
            'When creating a new Container, the $parent property should be null.'
        );
    }

    /**
     * Tests the creation of a child Container.
     *
     * @return void
     */
    public function testCreateChild()
    {
        $child = $this->container->createChild();

        $this->assertAttributeInstanceOf(
            'Encore\\Container\\Container',
            'parent',
            $child,
            'When create a child container, the $parent property should be an instance of Encore\\Container\\Container.'
        );

        $this->assertAttributeSame(
            $this->container,
            'parent',
            $child,
            'When creating a child container, the $parent property should be the same as the creating Container.'
        );
    }

    /**
     * Tests binding a concrete to an abstract.
     *
     * @return void
     */
    public function testBind()
    {
        $this->container->bind('Encore\\Container\\Test\\Stub\\BarInterface', 'Encore\\Container\\Test\\Stub\\Bar');

        $bindings = $this->readAttribute($this->container, 'bindings');

        $this->assertArrayHasKey(
            'Encore\\Container\\Test\\Stub\\BarInterface',
            $bindings,
            'The key for the binding should equal the first argument passed.'
        );

        $definition = $bindings['Encore\\Container\\Test\\Stub\\BarInterface'];

        $this->assertInstanceOf(
            'Encore\\Container\\Definition',
            $definition,
            'Passing a string as the $concrete should result in an instance of Definition.'
        );

        $this->assertAttributeEquals(
            'Encore\\Container\\Test\\Stub\\Bar',
            'class',
            $definition,
            'The class attribute on the definition should be the $concrete param.'
        );
    }

    /**
     * Tests binding an abstract multiple times.
     *
     * @return void
     */
    public function testBindSameAbstractName()
    {
        $this->container->bind('foo', 'Encore\\Container\\Test\\Stub\\Baz');
        $this->container->bind('foo', 'Encore\\Container\\Test\\Stub\\Qux');

        $this->assertAttributeCount(
            1,
            'bindings',
            $this->container,
            'Binding the same abstract should overwrite an existing binding of the same name.'
        );
    }

    /**
     * Test binding a class, using the abstract as the concrete.
     *
     * @return void
     */
    public function testBindNoConcretePassed()
    {
        $this->container->bind('Encore\\Container\\Test\\Stub\\Baz');

        $bindings = $this->readAttribute($this->container, 'bindings');

        $this->assertArrayHasKey(
            'Encore\\Container\\Test\\Stub\\Baz',
            $bindings,
            'The key for the binding should equal the first argument passed.'
        );

        $definition = $bindings['Encore\\Container\\Test\\Stub\\Baz'];

        $this->assertInstanceOf(
            'Encore\\Container\\Definition',
            $definition,
            'Passing an empty $concrete should result in an instance of Definition.'
        );

        $this->assertAttributeEquals(
            'Encore\\Container\\Test\\Stub\\Baz',
            'class',
            $definition,
            'The class attribute on the created Definition should match the $abstract param if no $concrete is passed.'
        );
    }

    /**
     * Tests that a binding key has been bound.
     *
     * @return void
     */
    public function testBound()
    {
        $this->container->bind('foo', 'Encore\\Container\\Test\\Stub\\Foo');

        $this->assertTrue(
            $this->container->bound('foo'),
            'When checking a key that has been bound, this method should return true.'
        );
    }

    /**
     * Tests that a binding key has been bound.
     *
     * @return void
     */
    public function testNotBound()
    {
        $this->assertFalse(
            $this->container->bound('foo'),
            'When checking a key that has not been bound, this method should return false.'
        );
    }

    /**
     * Tests extending an existing binding.
     *
     * @return void
     */
    public function testExtend()
    {
        $reflection = new \ReflectionProperty($this->container, 'bindings');
        $reflection->setAccessible(true);

        $reflection->setValue($this->container, array('foo' => function () { return 'bar'; }));

        $this->container->extend('foo', function ($container, $instance) {
            return $instance . ' has been extended';
        });

        $bindings = $this->readAttribute($this->container, 'bindings');

        $this->assertArrayHasKey(
            'foo',
            $bindings,
            'An extended binding should have the same binding key as the original.'
        );

        $this->assertEquals(
            'bar has been extended',
            $this->container->resolve('foo'),
            'An extended binding should take the results of the original and pass them to the extended version.'
        );
    }

    /**
     * Tests that extending a non-existant binding throws an exception.
     *
     * @return void
     *
     * @expectedException \InvalidArgumentException
     */
    public function testExtendNotYetBound()
    {
        $this->container->extend('foo', function () { return 'bar'; });
    }

    /**
     * Tests getting the dependencies of a class method.
     *
     * @return void
     */
    public function testGetDependencies()
    {
        $reflection = new \ReflectionMethod($this->container, 'getDependencies');
        $reflection->setAccessible(true);

        $bar = new \ReflectionClass('Encore\\Container\\Test\\Stub\\Bar');

        $constructor = $bar->getConstructor();

        $dependencies = $reflection->invoke($this->container, $constructor);

        $this->assertTrue(
            is_array($dependencies),
            'Dependencies should be returned as an array.'
        );

        $this->assertInstanceOf(
            'Encore\\Container\\Test\\Stub\\Qux',
            $dependencies[0],
            'Dependencies should be resolved based on the parameter type hint.'
        );
    }

    /**
     * Tests getting dependency array from a class that has no dependencies.
     *
     * @return void
     */
    public function testGetDependenciesFromMethodWithoutDependencies()
    {
        $reflection = new \ReflectionMethod($this->container, 'getDependencies');
        $reflection->setAccessible(true);

        $bar = new \ReflectionClass('Encore\\Container\\Test\\Stub\\Baz');

        $method = $bar->getMethod('noDependencies');

        $dependencies = $reflection->invoke($this->container, $method);

        $this->assertEmpty(
            $dependencies,
            'A method without dependencies should return an empty array.'
        );
    }

    /**
     * Tests getting dependency array from a class that has no dependencies.
     *
     * @return void
     */
    public function testGetDependenciesFromMethodWithoutTypeHintsButWithDefaultValue()
    {
        $reflection = new \ReflectionMethod($this->container, 'getDependencies');
        $reflection->setAccessible(true);

        $bar = new \ReflectionClass('Encore\\Container\\Test\\Stub\\Baz');

        $method = $bar->getMethod('noTypeHint');

        $dependencies = $reflection->invoke($this->container, $method);

        $this->assertEquals(
            $dependencies[0],
            'baz',
            'A method without type hinted dependencies should return the default value, if available.'
        );
    }

    /**
     * Tests getting dependency array from a class that has no dependencies.
     *
     * @return void
     *
     * @expectedException \InvalidArgumentException
     */
    public function testGetDependenciesFromMethodWithoutTypeHintsAndWithoutDefaultValue()
    {
        $reflection = new \ReflectionMethod($this->container, 'getDependencies');
        $reflection->setAccessible(true);

        $bar = new \ReflectionClass('Encore\\Container\\Test\\Stub\\Baz');

        $method = $bar->getMethod('noTypeHintOrDefaultValue');

        $reflection->invoke($this->container, $method);
    }

	/**
	 * Tests getting the raw data for a binding.
	 *
	 * @return void
	 */
	public function testGetRaw()
	{
		$reflection = new \ReflectionProperty($this->container, 'bindings');
		$reflection->setAccessible(true);

		$reflection->setValue($this->container, array('foo' => function () {
			return 'bar';
		}));

		$raw = $this->container->getRaw('foo');

		$this->assertInstanceOf(
			'Closure',
			$raw,
			'The raw value should be returned, un-executed, when using getRaw.'
		);
	}

	/**
	 * Tests getting the raw data for a binding.
	 *
	 * @return void
	 */
	public function testGetRawFromParent()
	{
		$reflection = new \ReflectionProperty($this->container, 'bindings');
		$reflection->setAccessible(true);

		$reflection->setValue($this->container, array('foo' => function () {
			return 'bar';
		}));

		$child = new Container($this->container);

		$raw = $child->getRaw('foo');

		$this->assertInstanceOf(
			'Closure',
			$raw,
			'The getRaw method should recursively check parent containers.'
		);

		$bindings = $this->readAttribute($child, 'bindings');

		$this->assertArrayNotHasKey(
			'foo',
			$bindings,
			'Ensure that the $bindings array of the child Container does not contain the binding key.'
		);
	}

    /**
     * Tests building a class that has no dependencies.
     *
     * @return void
     */
    public function testBuildClassNoDependencies()
    {
        $qux = $this->container->build('Encore\\Container\\Test\\Stub\\Qux');

        $this->assertInstanceOf(
            'Encore\\Container\\Test\\Stub\\Qux',
            $qux,
            'Building a class that has not been bound should return an instance of the specified class.'
        );
    }

    /**
     * Tests building a class with a dependency declared in the constructor.
     *
     * @return void
     */
    public function testBuildClassWithConstructorDependency()
    {
        $bar = $this->container->build('Encore\\Container\\Test\\Stub\\Bar');

        $this->assertInstanceOf(
            'Encore\\Container\\Test\\Stub\\Bar',
            $bar,
            'Building a class should return an instance of the specified class.'
        );

        $this->assertAttributeInstanceOf(
            'Encore\\Container\\Test\\Stub\\Qux',
            'qux',
            $bar,
            'A class with a constructor dependency should receive that dependency.'
        );
    }

    /**
     * Tests building a class that declares a dependency upon an interface in its constructor,
     * but that interface has not been bound within the container.
     *
     * @return void
     *
     * @expectedException \InvalidArgumentException
     */
    public function testBuildClassWithUnboundInterfaceDependency()
    {
        $this->container->build('Encore\\Container\\Test\\Stub\\Foo');
    }

    /**
     * Test building a class that declares a dependency opon an interface in its constructor.
     *
     * @return void
     */
    public function testBuildClassWithConstructorInterfaceDependency()
    {
        $this->container->bind('Encore\\Container\\Test\\Stub\\BarInterface', 'Encore\\Container\\Test\\Stub\\Bar');
        $this->container->bind('Encore\\Container\\Test\\Stub\\BazInterface', 'Encore\\Container\\Test\\Stub\\Baz');

        $foo = $this->container->build('Encore\\Container\\Test\\Stub\\Foo');

        $this->assertInstanceOf(
            'Encore\\Container\\Test\\Stub\\Foo',
            $foo,
            'Building a class should return an instance of the specified class.'
        );

        $this->assertAttributeInstanceOf(
            'Encore\\Container\\Test\\Stub\\Bar',
            'bar',
            $foo,
            'A class declaring a dependency on an interface should use the resolved interface object from the container.'
        );

        $this->assertAttributeInstanceOf(
            'Encore\\Container\\Test\\Stub\\Baz',
            'baz',
            $foo,
            'A class declaring a dependency on an interface should use the resolved interface object from the container.'
        );
    }

    /**
     * Tests resolving a class which has been bound in the container.
     *
     * @return void
     */
    public function testResolveBound()
    {
        $this->container->bind('qux', 'Encore\\Container\\Test\\Stub\\Qux');

        $qux = $this->container->resolve('qux');

        $this->assertInstanceOf(
            'Encore\\Container\\Test\\Stub\\Qux',
            $qux,
            'A class that has been bound should resolve to the bound definition.'
        );
    }

	/**
	 * Tests resolving a class which has not been bound in the container.
	 *
	 * @return void
	 */
	public function testResolveNotBound()
	{
		$bar = $this->container->resolve('Encore\\Container\\Test\\Stub\\Bar');

		$this->assertInstanceOf(
			'Encore\\Container\\Test\\Stub\\Bar',
			$bar,
			'A class that has not been bound should still resolve to an instance of the requested class.'
		);

		$bindings = $this->readAttribute($this->container, 'bindings');

		$this->assertArrayHasKey(
			'Encore\\Container\\Test\\Stub\\Bar',
			$bindings,
			'A class that has not yet been bound should be bound prior to resolution.'
		);
	}

	/**
	 * Tests resolving a class which has not been bound in the container.
	 *
	 * @return void
	 */
	public function testResolveFromParent()
	{
		$reflection = new \ReflectionProperty($this->container, 'bindings');
		$reflection->setAccessible(true);

		$reflection->setValue($this->container, array('foo' => function () {
			return 'bar';
		}));

		$child = new Container($this->container);

		$foo = $child->resolve('foo');

		$this->assertEquals(
			'bar',
			$foo,
			'Resolving should recursively look for a binding in the parent Container until found.'
		);

		$bindings = $this->readAttribute($child, 'bindings');

		$this->assertArrayNotHasKey(
			'foo',
			$bindings,
			'Ensure that the $bindings array of the child Container does not contain the binding key.'
		);
	}
}
