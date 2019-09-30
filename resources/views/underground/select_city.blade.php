<div>
    <form method="post" action="{{ route('underground.searchStations') }}">
        @csrf
        <div>
            <label for="location">Location</label>
            <select id="location" name="location" required>
                @foreach($metros as $metro)
                    <option value="{{ $metro->id }}">{{ $metro->location }}</option>
                    @endforeach
            </select>
        </div>
        <div>
            <button type="submit">Search</button>
        </div>
    </form>
</div>
