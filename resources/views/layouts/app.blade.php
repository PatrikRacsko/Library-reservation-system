<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Knižničný systém</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
        
    <div id="app">
        <main class="py-4">
            @include('inc.messages')
            @yield('content')
        </main>
    </div>
    <script>
var nieco = document.getElementById("obsahEdit").value;
var roulette=1;
function asd(id)
{
    document.getElementById("obsahEdit").value = nieco;
    document.getElementById(id).style.color = "grey";
}
function colorPanacik(id)
{
    document.getElementById(id).style.color = "green";
}
function incrementValue()
{
    /*oFormObject = document.forms['myform_id'];
    oformElement = oFormObject.elements['number'].value;
    console.log(typeof oformElement);
    var value = parseInt(oformElement);
    console.log(value+" - "+typeof value);
    value++;
    console.log(value+"LLKDASL "+pageNum);
    var string = value.toString();
    console.log(string+" - "+typeof string);
    console.log("VALUE IS "+oFormObject.elements["number"].value);
    oFormObject.elements["number"].value = string;
    console.log("VALUE IS "+oFormObject.elements["number"].value);    */
    var value = parseInt(document.getElementById('number').value);
    console.log(value+" - "+typeof value);
    value++;
    console.log(value+" - "+typeof value);
    var string = value.toString();
    console.log(string+" - "+typeof string);
    document.getElementById('number').setAttribute('value', string);
    console.log("VALUE IS "+document.getElementById('number').value);
}

function decrementValue()
{
    var value = parseInt(document.getElementById('number').value,10);
    if(value < 1)
        value = 0;
    else
        value--;
    document.getElementById('number').value = value;

}
</script>
</body>
</html>
