@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h1>Profil użytkownika: {{ session('user_login') }}</h1>
        
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5>Przeczytane</h5>
                        <h3>0</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5>Czytam</h5>
                        <h3>0</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5>Średnia ocena</h5>
                        <h3>0</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5>Recenzje</h5>
                        <h3>0</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection