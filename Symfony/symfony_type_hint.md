# Type Hint

php 在版本 5 之后，有了类型提示；在版本 7 之后，类型提示变得全面；这个不难理解。

可是在加入了注入之后，情况如下：

```
class LeapYearController
{
    //method one
    /*public function indexAction($year)
    {
        if (is_leap_year($year)) {
            return new Response('Yep, this is a leap year!');
        }

        return new Response('Nope, this is not a leap year.');
    }*/

    // method two
    public function indexAction(Request $request)
    {
        if (is_leap_year($request->attributes->get('year'))) {
            return new Response('Yep, this is a leap year!');
        }

        return new Response('Nope, this is not a leap year.');
    }

}

$routes->add('leap_year', new Routing\Route('/is_leap_year/{year}', array(
    'year' => null,
    '_controller' => 'LeapYearController::indexAction',
)));

```

这是 Symfony 创建框架之HttpKernel组件：控制器解析器章节中的路由部分，方法二中，如果不加
类型提示，则会报错，如下所示：

```

public function indexAction($request)
{
    if (is_leap_year($request->attributes->get('year'))) {
        return new Response('Yep, this is a leap year!');
    }

    return new Response('Nope, this is not a leap year.');
}

```

报错内容如下：

```
Controller "LeapYearController::indexAction()" requires that you provide a value for the "$request" argument. Either the argument is nullable and no null value has been provided, no default value has been provided or because there is a non optional argument after this one.

```

文章解释是 
> indexAction()方法需要Request对象作为参数。如果该对象被正确地进行了“类型提示”（type-hint），getArguments()方法知道何时正确地注入它：


## 如何知道何时正确地注入？

答案就是利用了反射类。这一点得重点理解 php-di/php-di 这个包


