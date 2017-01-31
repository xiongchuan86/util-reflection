Reflector
==================

This library add new capabilities to natives php reflectors.

## Installation

You can install this library with composer.

```php
composer require kassko/config:master
```

## Usage

```php
$reflectorRepo = new Kassko\Util\Reflection\ReflectorRepository;
```

`Kassko\Util\Reflection\ReflectorRepository` allows you to get the natives reflectors or some wrappers that add new features to native reflection and caches them.

### The natives reflectors
```php
/** Returns \ReflectionClass */
$reflClass = $reflectorRepo->reflClass();
/** Returns \ReflectionMethod */
$reflMethod = $reflectorRepo->reflMethod();
/** Returns \ReflectionProperty */
$reflProperty = $reflectorRepo->reflProperty();
```

### The wrappers

#### Advanced class reflector

```php
class MyClass
{
    private $foo;
    private $bar;

    public function fooMethod() {}
    public function barMethod() {}
}
```

```php
$reflectorRepo = new Kassko\Util\Reflection\ReflectorRepository;
/** Returns Kassko\Util\Reflection\ReflectionClass */
$advReflClass = $reflectorRepo->advReflClass();

/** Returns ['foo', 'bar']. */
$propNames = $advReflClass->getPropertiesNames();

/** Returns ['fooMethod', 'barMethod']. */
$methodsNames = $advReflClass->getMethodsNames();
```
#### Class doc comment parser

```php
/**
 * @author foo
 * @author bar
 *
 * @package My package
 */
class MyClass
{
}
```

```php
/** Returns Kassko\Util\Reflection\DocCommentParser\Scope\Class_ */
$docParser = $reflectorRepo->classDocParser('MyClass');

$tag = $docParser->getTag('author'); /** Returns \Kassko\Util\Reflection\Tag */
echo $tag; /** Displays author. Because class is stringifiable. */
echo $tag->getTagName(); /** Displays author. */
echo $tag->getField(0); /** Displays foo. */

$tags = $docParser->getTags('author'); /** Returns \Kassko\Util\Reflection\Tag[] */
echo sizeof($tags); /** Displays 2. */

$tags = $docParser->getAllTags(); /** Returns \Kassko\Util\Reflection\Tag[] */
echo sizeof($tags); /** Displays 3 */
echo $tag[0]; /** Displays `author`. */
echo $tag[1]; /** Displays `author`. */
echo $tag[2]; /** Displays `package`. */
```

#### Method doc comment parser

```php
class MyClass
{
    /**
     * @param string    $foo My foo desc
     * @param int       $bar
     *
     * @return string
     *
     * @throws MyThrowable My throwable
     */
    public function myMethod(string $foo, int $bar) : string
    {
        //...
    }
}
```

```php
/** Returns Kassko\Util\Reflection\DocCommentParser\Scope\Method */
$docParser = $reflectorRepo->methodDocParser('MyClass', 'myMethod');

$tags = $docParser->getTags('param'); /** Returns \Kassko\Util\Reflection\Tag\Param[] */

echo $tag[0]; /** Displays `param`. */
echo $tag[0]->getTagName(); /** Displays `param`. */
echo $tag[0]->getType(); /** Displays `string`. */
echo $tag[0]->getName(); /** Displays `foo`. */
echo $tag[0]->getDescription(); /** Displays `My foo desc`. */

echo $tag[1]; /** Displays `param`. */
echo $tag[1]->getType(); /** Displays `int`. */
echo $tag[1]->getName(); /** Displays `bar`. */
echo $tag[1]->getDescription(); /** Displays `null`. */

$tag = $docParser->getTag('return'); /** Returns \Kassko\Util\Reflection\Tag\Return_ */
echo $tag->getType(); /** Displays `string`. */
echo $tag->getDescription(); /** Displays `null`. */

$docParser->getTag('throws'); /** Returns \Kassko\Util\Reflection\Tag\Throws[] */
echo $tag->getClass(); /** Displays `MyThrowable`. */
echo $tag->getDescription(); /** Displays `My throwable`. */
```

#### Property doc comment parser

```php
class MyClass
{
    /**
     * @var string
     */
    private $myProp;
}
```

```php
/** Returns Kassko\Util\Reflection\DocCommentParser\Scope\Property */
$docParser = $reflectorRepo->propertyDocParser($classNameOrObject, $propName);

$tag = $docParser->getTag('var'); /** \Kassko\Util\Reflection\Tag\Var_[] */
echo $tag; /** Displays `var`. */
echo $tag->getTagName(); /** Displays `var`. */
echo $tag->getType(); /** Displays `string`. */
```

#### Full doc comment parser

```php
/**
 * @author foo
 *
 * @mytag
 */
class MyClass
{
    /**
     * @var string
     */
    private $myPropA;
    /**
     * @var string
     */
    private $myPropB;

    /**
     * @param string    $foo My foo desc
     * @param int       $bar
     *
     * @return string
     *
     * @throws MyThrowable My throwable
     */
    public function myMethod(string $foo, int $bar) : string
    {
        //...
    }
```

```php
/** Returns Kassko\Util\Reflection\DocCommentParser\FullScope */
$docParser = $reflectorRepo->fullDocParser('MyClass');

$tags = $docParser->getAllTags(); /** Returns \Kassko\Util\Reflection\Tag[] */
echo sizeof($tags); /** Displays `8`. */

$tags = $docParser->getAllCustomTags(); /** Returns \Kassko\Util\Reflection\Tag[] */
echo sizeof($tags); /** Displays `1`. */
echo $tags[0]; /** Displays `mytag`. */
```

#### All wrappers doc comment parser

You can retrieve custom user tags.
```php
/**
 * Needed to know how to parse.
 * Example:
 * Given `@mytag My description`
 * if $fieldsNumbersByTags=2, there are 2 fields which are `mytag` and `My description`
 * if $fieldsNumbersByTags=3, there are 3 fields which are `mytag` and `My` and `description`
 * if $fieldsNumbersByTags=1, there is only 1 field which is `mytag` (and not and `mytag My description` because of spaces)
 */
$docParser->setFieldsNumbersByTags(['mytag' => 2]);

/**
 * Gets the custom user tag `@mytag`
 * You can use this feature on all scope.
 */
$docParser->getTags('mytag');
```

#### Accessors finder
```php
/** ReflectionClass */
$accessorsFinder = $reflectorRepo->accessorFinder($classNameOrObject);

/**
 * Find all getters.
 * Method starting with "get", "is" or "has" and having a corresponding property.
 */
$accessorsFinder->getGetters();
/**
 * Find all strict getters.
 * Methods starting with "get" and having a corresponding property.
 */
$accessorsFinder->getStrictGetters();
/**
 * Find all strict isers.
 * Methods starting with "is" and having a corresponding property.
 */
$accessorsFinder->getIsers();
/**
 * Find all strict hasers.
 * Methods starting with "has" and having a corresponding property.
 */
$accessorsFinder->getHasers();

/**
 * Find all setters.
 * Methods starting with "set", "with" or "make" and having a corresponding property.
 */
$accessorsFinder->getSetters();
/**
 * Find all strict setters.
 * Methods starting with "set" and having a corresponding property.
 */
$accessorsFinder->getStrictSetters();
/**
 * Find all isers.
 * Methods starting with "is" and having a corresponding property.
 */
$accessorsFinder->getWithers();
/**
 * Find all hasers.
 * Methods starting with "has" and having a corresponding property.
 */
$accessorsFinder->getMakers();

/**
 * Find the getter of a given property.
 * Look first if there is a getter, then an isser and finally a haser.
 * Example: for the property $name, returns in the order `getName()`, `isName()`, `hasName()` or null.
 * Of course, in this case isName() and hasName() make no sense.
 */
$accessorsFinder->findPropGetter($propName);

/**
 * Find the item getter of a given property.
 * Example: for the property $dogs, returns `getDogsItem` or null.
 * You must have the following method prototype: `getDogsItem($key)`.
 */
$accessorsFinder->findPropItemGetter($propName);

/**
 * Find the setter of a given property.
 * Look first if there is a setter, then a wither and finally a maker.
 * Example: For the property $name, returns in the order `setName`, `withName`, `makeName` or null.
 * You must have one of the following methods prototype: `setName($name)`, `makeName($name)`, `withName($name)`.
 */
$accessorsFinder->findPropSetter($propName);

/**
 * Find the adder of a given property.
 * Example: For the property $dogs, returns in the order `addDogsItem`, `pushDogsItem`, `appendDogsItem` or null.
 * You must have one of the following methods prototype: `addDogsItem($dog)`, `pushDogsItem($dog)`, `appendDogsItem($dog)`.
 */
$accessorsFinder->findPropAdder($propName);

/**
 * Find the associative adder of a given property.
 * Example: For the property $dogs, returns in the order `addDogsItem`, `setDogsItem` or null.
 * You must have one of the following methods prototype: `addDogsItem($key, $dog)`, `setDogsItem($key, $dog)`.
 */
$accessorsFinder->findPropAssocAdder($propName);
```

## Roadmap

* implement all the tags. Actually tere are treat like custom user tags.
