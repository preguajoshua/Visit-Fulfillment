@if ($errors->any())
<div class="bg-red-50 text-red-700 rounded px-4 py-3 mb-3" role="alert">

    <strong>There were errors with your submission</strong>
    <ul class="list-disc list-inside text-red-600">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>

</div>
@endif
