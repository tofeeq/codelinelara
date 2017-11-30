@extends('layouts.app')

@section('content') 
	
	<section>    
        <div class="container">  
        	<div class="film">
	            @forelse ($paginator->data as $film)
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
			            	<a href="films/{{ $film->slug }}">{{ $film->name }}</a>
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
			            </div><!-- /.col-lg-6 -->
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
				@empty
				    <p>No film found</p>
				@endforelse
			</div>

	
			<div class="pagination">
				@if ($paginator->last_page > 1)
				<ul class="pagination">
				    <li class="{{ ($paginator->current_page == 1) ? ' disabled' : '' }}">
				        <a href="<?php echo env('APP_URL'); ?>/films?page={{ $paginator->current_page - 1}}">Previous</a>
				    </li>
				    @for ($i = 1; $i <= $paginator->last_page; $i++)
				        <li class="{{ ($paginator->current_page == $i) ? ' active' : '' }}">
				            <a href="<?php echo env('APP_URL'); ?>/films?page={{ $i }}">{{ $i }}</a>
				        </li>
				    @endfor
				    <li class="{{ ($paginator->current_page  == $paginator->last_page ) ? ' disabled' : '' }}">
				        <a href="<?php echo env('APP_URL'); ?>/films?page={{ $paginator->current_page + 1 }}" >Next</a>
				    </li>
				</ul>
				@endif
			</div>
        </div>
    </section>

@endsection
