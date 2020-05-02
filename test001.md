


$reflector = new \ReflectionClass('App\Http\Kernel');
$constructor = $reflector->getConstructor();
$dependencies_test = $constructor->getParameters();


