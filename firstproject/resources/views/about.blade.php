
@foreach ($names as $name)
    <h2>Name is {{ $name }}</h2>
@endforeach

@forelse ($names as $name)
    <h2>Name is {{ $name }}</h2>
@empty
    <h2>There are no names.</h2>
@endforelse

{{ $i = 0 }}
@while ($i < 5)
    <h2>Number is {{ $i }}</h2>
    {{ $i++ }}
@endwhile
