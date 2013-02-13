# Wire

Wire is a dependency injection framework, it can be used to rapidly build prototypes by
building objects and resolving dependencies.

## Usage

Put the `wire/framework` directory in your PHP path:

    set_include_path(implode(PATH_SEPARATOR, array(
        get_include_path()
        , "path/to/wire/framework" )));

I will read up more on PHP module distribution, for now it will do. Then, the dependency
definitions look like:

    // This is a class that has one dependency and one value
	$class_def = array( "class" => "dot.notation.path.to.Class"
                      , "args" => array( array( "class" => "dot.notation.path.to.Dependency" )
                                       , array( "value" => 1 )));

    // This is a class without any dependencies
    $dependency_def = array( "class" => "dot.notation.path.to.Dependency" );

This isn't particularly friendly, I advocate finding a better way. Then you pass the definitions
to the `WireFactory` constructor:

    require_once "WireFactory";

    $factory = new WireFactory(array( $class_def
                                    , $dependency_def ));

The constructor to the `dot.notation.path.to.Class` class should be as follows and imagine it
also has the following `do` method:

    class Class {

        private $dependency;
        private $value;

        function __construct($dependency, $value) {
            $this->dependency = $dependency;
            $this->value = $value;
        }

        function do() {
            $this->dependency->output($value);
        }

    }

Then the `dot.notation.path.to.Dependency` is as follows:

    class Dependency {

        function output($value) {
            echo "The value is $value";
        }

    }

WireFactory will automatically resolves the correct dependencies (which can be derived and not
necessarily directly the same type).

	// Returns an instance of class containing dependency
	$instance = $factory->getInstance("dot.notation.path.to.Class");
    $instance->do(); // Echoes "The value is 1"

This is in effect performing the following:

    require_once "dot/notation/path/to/Dependency.php";
    $dependency = new Dependency();
    require_once "dot/notation/path/to/Class.php";
    $instance = new Class($dependency, 1);
    $instance->do();
    