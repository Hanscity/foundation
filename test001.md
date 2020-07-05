


$reflector = new \ReflectionClass('App\Http\Kernel');
$constructor = $reflector->getConstructor();
$dependencies_test = $constructor->getParameters();


commit f5b1cd6ba9b57b11134097deceaacd8de9cc81b8
Merge: 3f6d9b6 e6af502
Author: ch001 <chenhang@yunhan.xyz>
Date:   Mon Jun 15 16:15:54 2020 +0800

    getLastWeek

commit 3f6d9b6fb819dd52bb34726066f2f0ecccf19070
Author: ch001 <chenhang@yunhan.xyz>
Date:   Mon Jun 15 16:13:53 2020 +0800

    getLastWeek

commit ff36069d4e021516e85b7335b3d81d87a25fcc00
Author: ch001 <chenhang@yunhan.xyz>
Date:   Mon Jun 15 15:56:40 2020 +0800

    getRankHour
