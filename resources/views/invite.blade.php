@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Invite a Teammate') }}</div>

                <div class="card-body">
                 Link for the  Invitation:
                 <br>
                 {{-- 
                    - organizaiton id or user id checked and added to link.
                    - If user has organization use it else use user id.
                    - ? means if condition true use the argument after ? if not use argunment after :
                    _ ? means the if condition.
                    
                    --}}
                 {{ route('register') }}?organization_id={{ auth()->user()->organization_id ? auth()->user()->organization_id : auth()->id()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
