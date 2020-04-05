@extends('guest/layout', ['webpage_title'=>'Home'])

@section('content')
<style>
h1 {
    margin-top: 60px;
    font-size: 84px;
    margin-bottom: 30px;
    text-align: center;
}

.links {
    margin: 0px auto;
    text-align: center;
}

.links>a {
    color: #636b6f;
    padding: 0 25px;
    font-size: 13px;
    font-weight: 600;
    letter-spacing: .1rem;
    text-decoration: none;
    text-transform: uppercase;
}
</style>

<div class="container">
    <h1>
        PHP Serverless
    </h1>

    <div class="links">
        <a href="https://github.com/phpserverless/phpsererless">Docs</a>
        <a href="https://github.com/phpserverless/phpsererless">GitHub</a>
    </div>
</div>

@endsection