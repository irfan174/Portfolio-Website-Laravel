@extends('Layout.app')

@section('content')

<div id="dataTable" class="container d-none">
  
  
  <div class="row">
       
    <div class="col-md-12 p-3">
        <button id="addNewBtnId" class="btn blue-gradient m-3">Add New Service</button>
        <br> 
        <br>  
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
  //service section; catch data and make table
function getServiceJsonData() {
    axios.get('/servicedata')
        .then(function(response) {
            if (response.status == 200){
                $('#dataTable').removeClass('d-none');
                $('#loadingAnim').addClass('d-none');
                $('#serviceData_table').empty(); //avoid clone table data after more than one time delete

                var serviceDataJson = response.data; // catch response data

                $.each(serviceDataJson, function(i, item){
                    $('<tr>').html(
                        "<td <img class='table-img' src=" + serviceDataJson[i].service_img + "></td>" +
                        "<td>" + serviceDataJson[i].service_name + "</td>" +
                        "<td>" + serviceDataJson[i].service_des + "</td>" +
                        "<td><a class='serviceEditIcon' data-id=" + serviceDataJson[i].id + "><i class='fas fa-edit'></i></a></td>" +
                        "<td><a class='serviceDltIcon' data-toggle='modal' data-id=" + serviceDataJson[i].id + " data-target='#deleteModal' ><i class='fas fa-trash-alt'></i></a></td>").appendTo('#serviceData_table');
                });
                //service section; Delete icon hold and send the id of the clicked item to the modal 
                $('.serviceDltIcon').click(function() {
                    var catchId = $(this).data('id');
                    $('#serviceDltId').html(catchId);
                })
                
                
                //service section; Edit icon
                $('.serviceEditIcon').click(function() {
                  
                    var catchIdEdit = $(this).data('id');
                    $('#serviceEditId').html(catchIdEdit);
                    serviceDetailsForEdit(catchIdEdit);
                    $('#editModal').modal('show');
                })
                

            } 
            else 
            {
                $('#notFound').removeClass('d-none');
                $('#loadingAnim').addClass('d-none');
            }


        }).catch(function(error) {
            $('#notFound').removeClass('d-none');
            $('#loadingAnim').addClass('d-none');

        });
}
//service section; Yes button of delete modal hold, get the id from the modal and send that id to the delete function
    $('#serviceDltConfirmBtn').click(function() {
        var finalDltId = $('#serviceDltId').html();
        serviceDelete(finalDltId);
    })


//service section; ajax call for delete service
function serviceDelete(deleteId) {
  $('#serviceDltConfirmBtn').html("<div class='spinner-border spinner-border-sm' role='status'></div>");//set animation on yes button of delete modal


    axios.post('/servicedelete', {
            id: deleteId
        })
        .then(function(response) {
          $('#serviceDltConfirmBtn').html("Yes");
          if(response.status == 200){
            if (response.data == 1) 
            {
                $('#deleteModal').modal('hide');
                toastr.success('Delete Successfull');
                getServiceJsonData();
            } 
            else 
            {
                $('#deleteModal').modal('hide');
                toastr.error('Delete Failed');
                getServiceJsonData();
            }

          }
          else{
            $('#deleteModal').modal('hide');
            toastr.error('Something Went Wrong!!!');

          }

            
        })
        .catch(function(error) {
          $('#deleteModal').modal('hide');
            toastr.error('Something Went Wrong!!!');
        })


}


//service section; ajax call for edit service; show each service's all data on edit modal
function serviceDetailsForEdit(detailsId) {

    axios.post('/servicedetails', {
            id: detailsId
        })
        .then(function(response) {
          if(response.status == 200){
            $('#serviceEditForm').removeClass('d-none');
            $('#loadingAnimForEdit').addClass('d-none');
            var serviceDataJson = response.data;//get all the data in json format
            $('#serviceNameId').val(serviceDataJson[0].service_name);  //set service_name column data on catched id edit modal's field ; and for one index data catch we set 0
            $('#serviceDesId').val(serviceDataJson[0].service_des);
            $('#serviceImgId').val(serviceDataJson[0].service_img);
          }
          else{
            $('#notFoundForEdit').removeClass('d-none');
            $('#loadingAnimForEdit').addClass('d-none');
          }
        })
        .catch(function(error) {
          $('#notFoundForEdit').removeClass('d-none');
          $('#loadingAnimForEdit').addClass('d-none');
        });
}


//service section; save button of edit modal 
                $('#serviceEditConfirmBtn').click(function() {

                    var finalEditId = $('#serviceEditId').html();
                    var finalEditName = $('#serviceNameId').val();
                    var finalEditDes = $('#serviceDesId').val();
                    var finalEditImg = $('#serviceImgId').val();
                    /*alert(finalEditId);
                    alert(finalEditName);
                    alert(finalEditDes);
                    alert(finalEditImg);*/
                    serviceUpdate(finalEditId,finalEditName,finalEditDes,finalEditImg);
                })


//service section; ajax call for Edit service
function serviceUpdate(updateId,serName,serDes,serImg) {
//validation 
if(serName.length == 0){
     toastr.error('Service Name not found');

  }
  else if(serDes.length == 0){
    toastr.error('Service Description not found');

  }
  else if(serImg.length == 0){
    toastr.error('Service Image not found');

  }
  else{
    $('#serviceEditConfirmBtn').html("<div class='spinner-border spinner-border-sm' role='status'></div>");//set animation on save button of edit modal
    axios.post('/serviceupdate', {
            id: updateId,
            name: serName,
            des: serDes,
            img: serImg,

        })
        .then(function(response) {

          $('#serviceEditConfirmBtn').html("Save");
          if(response.status == 200){
            if (response.data == 1) 
            {
                $('#editModal').modal('hide');
                toastr.success('Update Successfull');
                getServiceJsonData();
            } 
            else 
            {
                $('#editModal').modal('hide');
                
                toastr.error('Update Failed');
                getServiceJsonData();
            }


          }
          else{
            $('#editModal').modal('hide');
            toastr.error('Something Went Wrong!!!');

          }


          
          
        })
        .catch(function(error) {
          
        });

  }

    
}


//service section; ADD NEW SERVICE button click
$('#addNewBtnId').click(function() {
        $('#addNewServiceModal').modal('show');
    })
//service section; add this service button click
$('#serviceAddNewConfirmBtn').click(function() {

    var finalAddName = $('#serviceAddNameId').val();
    var finalAddDes = $('#serviceAddDesId').val();
    var finalAddImg = $('#serviceAddImgId').val();
    serviceInsert(finalAddName,finalAddDes,finalAddImg);
})
//service section; ajax call for add this service button click of add new service modal
function serviceInsert(serName,serDes,serImg) {
//validation 
if(serName.length == 0){
     toastr.error('Service Name is empty!!');

  }
  else if(serDes.length == 0){
    toastr.error('Service Description is empty!!');

  }
  else if(serImg.length == 0){
    toastr.error('Service Image is empty!!');

  }
  else{
    $('#serviceAddNewConfirmBtn').html("<div class='spinner-border spinner-border-sm' role='status'></div>");//set animation on save button of edit modal
    axios.post('/serviceinsert', {
            name: serName,
            des: serDes,
            img: serImg,

        })
        .then(function(response) {

          $('#serviceAddNewConfirmBtn').html("Save");
          if(response.status == 200){

            if (response.data == 1) 
            {
                $('#addNewServiceModal').modal('hide');
                toastr.success('Insert Successfull');
                getServiceJsonData();
                $('#serviceAddNameId').val(null);
                $('#serviceAddDesId').val(null);
                $('#serviceAddImgId').val(null);
            } 
            else 
            {
                $('#addNewServiceModal').modal('hide');
                
                toastr.error('Insert Failed!!');
                getServiceJsonData();
            }


          }
          else{
            $('#addNewServiceModal').modal('hide');
            toastr.error('Something Went Wrong!!!');

          }


          
          
        })
        .catch(function(error) {
          
        });

  }

    
}
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



<!--Add New Service Modal -->
<div class="modal fade" id="addNewServiceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body p-4 text-center">
          <!-- Material form subscription Start-->
          <div class="card">

              <!--Card content-->
              <div id="serviceAddForm" class="card-body px-lg-5">
                <h5 id="">Add New Service</h5>
                  <!-- Form Start-->
                  <form  class="text-center " style="color: #757575;" action="#!">
                      <!-- Name -->
                      <div class="md-form mt-3">
                          <input id="serviceAddNameId" type="text"  class="form-control">
                          <label for="serviceAddNameId">Service Name</label>
                      </div>

                      <!-- Description -->
                      <div class="md-form">
                          <input id="serviceAddDesId" type="text"  class="form-control">
                          <label for="serviceAddDesId">Service Description</label>
                      </div>

                      <!-- Image -->
                      <div class="md-form">
                          <input id="serviceAddImgId" type="text"  class="form-control">
                          <label for="serviceAddImgId">Service Image link</label>
                      </div>


                  </form>
                  <!-- Form End-->
                  <!-- loadind and something went wrong modal for showing data to the edit modal -->

              </div>
          <!-- Material form subscription End-->
      
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-md btn-danger" data-dismiss="modal">Cancle</button>
            <button id="serviceAddNewConfirmBtn" type="button" class="btn btn-md btn-primary">Add This Service</button>
          </div>
      </div>
    </div>
  </div>
</div>