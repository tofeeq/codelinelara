@extends('layouts.app')

@section('content') 
	<section>    
        <div class="container">  

        	@if ($errors->any())
			    <div class="alert alert-danger">
			        <ul>
			            @foreach ($errors->all() as $error)
			                <li>{{ $error }}</li>
			            @endforeach
			        </ul>
			    </div>
			@endif

			@if(session('message'))
				<div class="alert alert-success">
  					{{session('message')}}
  				</div>
			@endif

        	<div class="form"> 
				{{ Form::model($modelFilm, ['route' => ['films.store', $modelFilm->id], 'class' => 'form-horizontal' , "id" => "films-form", "files" => true]) }}
				<div class="form-group">
				    {{ Form::label('name', 'Name', ["class" => "control-label"]) }}
				    {{ Form::text('name', '', ["class" => "form-control",  "required" ]) }}
				</div>
				<div class="form-group">
				    {{ Form::label('description', 'Description', ["class" => "control-label"]) }}
				    {{ Form::textarea('description', '', ["class" => "form-control", "rows" => "5", "required"]) }}
				</div>
				<div class="form-group date">
				    {{ Form::label('release_date', 'Release Date', ["class" => "control-label"]) }}
				    {{ Form::text('release_date', '', ["class" => "form-control ", "required"]) }}
	                
				</div>
				<div class="form-group">
				    {{ Form::label('rating', 'Rating', ["class" => "control-label"]) }}
				    {{ Form::text('rating', '', ["class" => "form-control", "required", "max" => 5]) }}
				    <span>Rating from 1 to 5</span>
				</div>
				<div class="form-group">
				    {{ Form::label('ticket_price', 'Ticket Price', ["class" => "control-label"]) }}
				    {{ Form::text('ticket_price', '', ["class" => "form-control", "required"]) }}
				</div>
				<div class="form-group">
				    {{ Form::label('country', 'Country', ["class" => "control-label"]) }}
				    {{ Form::text('country', '', ["class" => "form-control", "required"]) }}
				</div>
				<div class="form-group">
				    {{ Form::label('genre', 'genre', ["class" => "control-label"]) }}
				    {{ Form::text('genre', '', ["class" => "form-control", "required"]) }}
				    <span>Separate multiple genres with comma ie. Thriller,Drama</span>
				</div>

				<div class="form-group">
				    {{ Form::label('photo', 'Photo', ["class" => "control-label"]) }}
				    {{ Form::file('photo', ["class" => "form-control", "required"]) }}
				</div>
				
				<div class="form-group">
					{{ Form::submit('Create', ['class' => 'btn btn-primary']) }}
				</div>
				{!! Form::close() !!}
			</div>
			<div id="form-msg"></div>
		</div>		
	</section>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ URL::asset('js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/films.js') }}"></script>
<link rel="stylesheet" href="{{ URL::asset('css/bootstrap-datepicker.min.css') }}" />
 
@endsection
