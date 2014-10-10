# EncorePHP Container
[![Build Status](https://travis-ci.org/encorephp/container.png?branch=master)](https://travis-ci.org/encorephp/container)

The EncorePHP Container library provides a fast and powerful Dependency Injection Container for your application.

As well as a dependency injection container, we also allow the use of service providers
and proxies.

## Install

Via Composer

    {
        "require": {
            "encorephp/container": "dev-master"
        }
    }


## Usage

### Get a Container Object

    include 'vendor/autoload.php';

    $container = new Encore\Container\Container;

### Bind a concrete class to an interface

    $container->bind('\Foo\Bar\BazInterface', '\Foo\Bar\Baz');

### Automatic Dependency Resolution

The Container is able to recursively resolve objects and their dependencies by inspecting the type hints on an object's constructor.

    namespace Foo\Bar;

    class Baz
    {
      public function __construct(Qux $qux, Corge $corge)
      {
        $this->qux = $qux;
        $this->corge = $corge;
      }

      public function setQuux(Quux $quux)
      {
        $this->quux = $quux;
      }
    }

    $container->resolve('\Foo\Bar\Baz');

### Defining Arguments

Alternatively, you can specify what to inject into the class upon instantiation.

#### Define Constructor Args

    $container->bind('\Foo\Bar\Baz')->addArgs(array('\Foo\Bar\Quux', '\Foo\Bar\Corge'));

    $container->resolve('\Foo\Bar\Baz');

#### Define Methods to Call with Args

    $container->bind('\Foo\Bar\Baz')->withMethod('setQuux', array('\Foo\Bar\Quux'));

    $container->resolve('\Foo\Bar\Baz');

### Resolve Inherited Dependencies

Another great feature of the the container is the ability to resolve the dependencies
of inherited classes and interfaces. For example, you could bind an interface into the
container which requires a dependency injected via a method, and all classes that implement
that interface will also have that dependency injected automatically.

    $container->bind('\Foo\Bar\BazInterface')->withMethod('setQuux', ['\Foo\Bar\Quux']);

    $container->bind('\Foo\Bar\Baz');

    $container->resolve('\Foo\Bar\Baz');

### Child Containers and Scope Resolution

A great feature of the container is it's ability to provide child containers with a separate resolution scope to that of it's parent container. If you bind a concrete class to an interface within one container, you can re-bind it in the child container, without fear of overwriting the original binding in the parent container.

#### Creating a Child Container

There are two ways to create a child container.

    $child = $continer->createChild();

    // OR

    $child = new Container($container);

#### Using a Child Container

The primary benefit of using child containers is scope-specific resolution.

    $container->bind('FooInterface', 'Foo');

    // Assuming class Bar has a FooInterface dependency.
    // This would use the Foo implementation.
    $bar = $container->resolve('Bar');

    // ...
    $child = $container->createChild();
    $child->bind('FooInterface', 'Baz');

    // And this would use the Baz implementation.
    $bar = $child->resolve('Bar');


## TODO

- Extensive Documentation


## Contributing

Please see [CONTRIBUTING](https://github.com/encorephp/container/blob/master/CONTRIBUTING.md) for details.


## Credits

The EncorePHP Container is based onthe deprecated [league/di](https:/github.com/thephpleague/di)
package.

- [Chris Harvey](https://github.com/chrisnharvey)
- [Don Gilbert](https://github.com/dongilbert)
- [All Contributors](https://github.com/encorephp/container/contributors)
- [Original Contributors](https://github.com/thephpleague/di/contributors)
- [Phil Bennett](https://twitter.com/philipobenito)


## License

The MIT License (MIT). Please see [License File](https://github.com/encorephp/container/blob/master/LICENSE) for more information.
