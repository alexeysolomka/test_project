<div>
    <form method="post" action="{{ route('underground.search') }}">
        @csrf
        <div>
            <label for="from">From</label>
            <select id="from" name="from" required>
                @foreach($stations as $station)
                    <option value="{{ $station->id }}">{{ $station->name }}</option>
                    @endforeach
            </select>
        </div>
        <div>
            <label for="to">To</label>
            <select id="to" name="to">
                @foreach($stations as $station)
                    <option value="{{ $station->id }}">{{ $station->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <button type="submit">Search</button>
        </div>
    </form>
</div>
