@if(!empty($post))
    <p> title: {{$post -> title}} </p>
    <p> content: {{$post -> content}} </p>
@else
    <p> Not Found </p>
@endif
