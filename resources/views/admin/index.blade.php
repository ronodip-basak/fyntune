@extends('public.layout')

@section('content')
<div class="container" style="padding-top: 2rem;">
<div class="row">
    <div class="col-md-3">
        <input type="text" class="form-control" placeholder="Search" onkeyup="search()">
    </div>
    <div class="col-md-2">
        
    </div>
    <div class="col-md-1"></div>
    <div class="col-md-6">
        <form>
            <div class="row">
                <div class="col-md-5">
                    <select name="order_by" class="form-control" required>
                        <option value="">Order By</option>
                        <option value="score_recieved" @if (request()->get('order_by') == 'score_recieved')
                        selected
                        @endif>Recieved Score</option>
                        <option value="total_score" @if (request()->get('order_by') == 'total_score')
                            selected
                            @endif>Total Score</option>
                    </select>
                </div>
                <div class="col-md-5">
                    <select name="order_type" class="form-control">
                        <option value="">Order type</option>
                        <option value="ASC" @if (request()->get('order_type') == 'ASC')
                            selected
                            @endif>ASC</option>
                        <option value="DESC" @if (request()->get('order_type') == 'DESC')
                            selected
                            @endif>DESC</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-secondary">Sort</button>
                </div>            
            </div>
        </form>
    </div>
    
    
</div>
    <table class="table" id="search_result" style="display: none; margin-bottom: 3rem;">
        {{-- <h5>Seach Results</h5> --}}
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Recieved Score</th>
                <th scope="col">Total Score</th>
            </tr>
        </thead>
        <tbody id="search_result_table_body">
            
        </tbody>
    </table>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Recieved Score</th>
                <th scope="col">Total Score</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tests as $item)
                <tr>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ $item->user->email }}</td>
                    <td>{{ $item->user->phone }}</td>
                    <td>{{ $item->score_recieved }}</td>
                    <td>{{ $item->total_score }}</td>
                </tr>
            @endforeach            
        </tbody>
    </table>

    <div>
        {{ $tests->links() }}
    </div>
</div>

<script>
    const search = () => {
        const query = event.target.value;
        if(query.length < 2){
            document.getElementById('search_result').style.display = 'none';
            return;
        }

        const baseUrl = `{{ route('userData.search') }}`; 
        const searchUrl = baseUrl + `?search=${encodeURI(query)}`;
        fetch(`${searchUrl}`)
            .then(response => response.json())
            .then(response => {
                let html = '';
                response.forEach(item => {
                    html += '<tr>';
                    html += `<td>${item.name}</td>`;
                    html += `<td>${item.email}</td>`;
                    html += `<td>${item.phone}</td>`;
                    html += `<td>${item.test.score_recieved}</td>`;
                    html += `<td>${item.test.total_score}</td>`;
                    html += '</tr>';

                });
                document.getElementById('search_result_table_body').innerHTML = html;
                document.getElementById('search_result').style.display = 'block';
            })
    }
</script>
@endsection
