@extends('layouts.app')

@section('content') 
	
	<section>    
        <div class="container">  
        	<div class="film">
				    <div class="row">
			            <div class="col-md-4"> 
			            @if ($film->photo)
						     <img class="img-responsive" src="{{ $film->photo }}">
						@else
						    Image not avialbale
						@endif
			            </div><!-- /.col-lg-6 -->
			            
			            <div class="col-md-8">  
			            <h2>
			            	{{ $film->name }}
			            </h2>
			            <h4 class="sub-text">
			            	Release Date: {{ date('d F Y', strtotime($film->release_date)) }}<br>
			            	Price ${{ sprintf("%.2f", $film->ticket_price)}}
			            </h4>
			            <table class="table-sm text-dark">
							<tbody>
								<tr>
									<td>Country </td>  
									<td>&nbsp;</td>
									<td>:</td>
									<td>&nbsp;</td>
									<td> {{ $film->country }}</td>
								</tr>
								<tr>
									<td>Genre </td> 
									<td>&nbsp;</td> 
									<td>:</td>
									<td>&nbsp;</td>
									<td>   @foreach ($film->genres as $genre)
			                     {{ $genre->genre }},
			                     @endforeach </td> 
								</tr>
			                    
			                </tbody>
			            </table>
			            <br>
			            

			            <p>
				            {{ $film->description}}
				            <br>
			        	</p>

			        	<div class="detailed">
			            	Rating:&nbsp;&nbsp; 
				            <select id="rating">
							  <option value="1">1</option>
							  <option value="2">2</option>
							  <option value="3">3</option>
							  <option value="4">4</option>
							  <option value="5">5</option>
							</select> 
				            
			            </div> 
			            <p></p> 
			            <!-- /.col-lg-6 -->

			    		 

				    	</div>
					</div>
			    	<script type="text/javascript">
					   jQuery(function($) {
					      $('#rating').barrating({
					        theme: 'fontawesome-stars',
					        initialRating : {{ $film->rating }},
					        readonly : {{Auth::user() ? 'false' : 'true'}}
					      });
					   });
					</script>	
			</div>
			 
    </section>

@endsection

@section('scripts')
<script type="text/javascript" src="{{ URL::asset('js/films.js') }}"></script>
@endsection