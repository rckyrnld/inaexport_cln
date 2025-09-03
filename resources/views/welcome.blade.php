@include('header')
        
         
<div class="padding">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header">
          <h2>Horizontal form</h2>
          <small>Use Bootstrap's predefined grid classes to align labels and groups of form controls in a horizontal layout by adding .form-horizontal to the form. Doing so changes .form-groups to behave as grid rows, so no need for .row.</small>
        </div>
        <div class="box-divider m-0"></div>
        <div class="box-body">
          <form>
            <div class="col-md-6">

            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
              <div class="col-sm-8">
                <input type="email" class="form-control" id="inputEmail3" placeholder="Email">
              </div>
            </div>
            <div class="form-group row">
              <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
              <div class="col-sm-8">
                <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
              </div>
            </div>
       
            <button type="submit" class="btn primary">Sign in</button>

            </div>
          </form>
        </div>
      </div>
    </div>
  
  </div>
 
</div>


@include('footer')