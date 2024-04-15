<html>
<body>
@inject('service','App\services\SayHello')
<h1>{{$service->sayHello($name)}}</h1>
</body>
</html>
