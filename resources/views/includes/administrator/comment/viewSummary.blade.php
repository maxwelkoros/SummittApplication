
<div class="modal" id="viewSummaryModal" tabindex="-1" role="dialog" aria-labelledby="viewSummaryModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <h2 class="modal-title text-primary text-center">Profile Summary Comment</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="POST" action="#">
        	 @csrf
           
      <div class="modal-body">
		<div class="row">
		<div class="col-md-12">
			<div class="container">

	  		<div class="form-group row">
		    <div class="col-md-12">

			  		<textarea name="comment" class="form-control  @error('comment') is-invalid @enderror" row="100" style="border-radius: 0;height: 100px" id="summaryview" readonly>
			  			
			  		</textarea>
		    </div>
		    </div>
		  	</div>	

  		</div>
		</div>
      </div>
  	  </form>
    </div>
  </div>
</div>

