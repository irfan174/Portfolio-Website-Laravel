@extends('Layout.app')

@section('content')

<div id="dataTable" class="container d-none">
  <div class="row">
    <div class="col-md-12 p-5">
        <table id="" class="table table-striped table-bordered" cellspacing="0" width="100%">
          <thead>
            <tr>
            <th class="th-sm">Image</th>
            <th class="th-sm">Name</th>
            <th class="th-sm">Description</th>
            <th class="th-sm">Edit</th>
            <th class="th-sm">Delete</th>
            </tr>
          </thead>
          <tbody id="serviceData_table">

          </tbody>
        </table>

    </div>
  </div>
</div>

<div id="loadingAnim" class="container">
  <div class="row">
    <div class="col-md-12 text-center p-5">
      <img class="loading-anim m-5" src="{{asset('images/loader.svg')}}" alt="">
      
    </div>
    
  </div>
  
</div>

<div id="notFound" class="container d-none">
  <div class="row">
    <div class="col-md-12 text-center p-5">
      <h3>Something Went Wrong !!!</h3>
      
    </div>
    
  </div>
  
</div>

@endsection

@section('jsCode')
<script type="text/javascript">
  getServiceJsonData();
</script>
@endsection

<!--Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        <h4>Want to Delete?</h4>
        <h4 id="serviceDltId">  </h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">No</button>
        <button id="serviceDltConfirmBtn" type="button" class="btn btn-sm btn-danger">Yes</button>
      </div>
    </div>
  </div>
</div>

<!--Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body p-4 text-center">
          <!-- Material form subscription Start-->
          <div class="card">

              <!--Card content-->
              <div id="serviceEditForm" class="card-body px-lg-5 d-none ">

                  <!-- Form Start-->
                  <form  class="text-center " style="color: #757575;" action="#!">
                      <!-- Name -->
                      <h4 id="serviceEditId">  </h4> <!-- Set the id of clicked item -->
                      <div class="md-form mt-3">
                          <input id="serviceNameId" type="text"  class="form-control" placeholder="Service Name">
                          <label for="serviceNameId">Service Name</label>
                      </div>

                      <!-- Description -->
                      <div class="md-form">
                          <input id="serviceDesId" type="text"  class="form-control" placeholder="Service Description">
                          <label for="serviceDesId">Service Description</label>
                      </div>

                      <!-- Image -->
                      <div class="md-form">
                          <input id="serviceImgId" type="text"  class="form-control" placeholder="Service Image">
                          <label for="serviceImgId">Service Image link</label>
                      </div>

                      <!-- Sign in button 
                      <button class="btn btn-outline-info btn-rounded btn-block z-depth-0 my-4 waves-effect" type="submit">Sign in</button> -->

                  </form>
                  <!-- Form End-->
                  <!-- loadind and something went wrong modal for showing data to the edit modal -->
                  <div id="loadingAnimForEdit" class="container">
                    <div class="row">
                      <div class="col-md-12 text-center p-5">
                        <img class="loading-anim m-5" src="{{asset('images/loader.svg')}}" alt="">
                        
                      </div>
                      
                    </div>
                    
                  </div>

                  <div id="notFoundForEdit" class="container d-none">
                    <div class="row">
                      <div class="col-md-12 text-center p-5">
                        <h4> Something Went Wrong !!! </h4>
                        
                      </div>
                      
                    </div>
                    
                  </div>


              </div>

          </div>
          <!-- Material form subscription End-->
      
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-md btn-danger" data-dismiss="modal">Cancle</button>
        <button id="serviceEditConfirmBtn" type="button" class="btn btn-md btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>