@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-center">Transaction & Match History</h2>

    <ul class="nav nav-tabs mb-4" id="transactionTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="deposit-tab" data-bs-toggle="tab" data-bs-target="#deposit" type="button" role="tab">Deposits</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="withdraw-tab" data-bs-toggle="tab" data-bs-target="#withdraw" type="button" role="tab">Withdrawals</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="match-tab" data-bs-toggle="tab" data-bs-target="#matches" type="button" role="tab">Match Joining & Winnings</button>
        </li>
    </ul>

    <div class="tab-content" id="transactionTabContent">
        <div class="tab-pane fade show active" id="deposit" role="tabpanel">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Method</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($deposits as $deposit)
                    <tr>
                        <td>{{ $deposit->Method }}</td>
                        <td>{{ $deposit->Amount }} TK</td>
                        <td>{{ $deposit->Status }}</td>
                        <td>{{ $deposit->Date }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="tab-pane fade" id="withdraw" role="tabpanel">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Method</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($withdrawals as $withdraw)
                    <tr>
                        <td>{{ $withdraw->Method }}</td>
                        <td>{{ $withdraw->Amount }} TK</td>
                        <td>{{ $withdraw->Status }}</td>
                        <td>{{ $withdraw->Date }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="tab-pane fade" id="matches" role="tabpanel">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>Match Key</th>
                            <th>Ingame Name</th>
                            <th>Winnings</th>
                            <th>Position</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($matchHistory as $match)
                        <tr>
                            <td>{{ $match->Match_Key }}</td>
                            <td>{{ $match->ingame_name }}</td>
                            <td class="text-success fw-bold">{{ $match->winnings }} TK</td>
                            <td>{{ $match->position ?? 'N/A' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection