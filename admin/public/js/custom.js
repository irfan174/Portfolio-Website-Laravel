$(document).ready(function() {
    $('#VisitorDt').DataTable();
    $('.dataTables_length').addClass('bs-select');
});

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
                // Delete icon hold and send the id of the clicked item to the modal 
                $('.serviceDltIcon').click(function() {
                    var catchId = $(this).data('id');
                    $('#serviceDltId').html(catchId);
                })
                //Yes button hold, get the id from the modal and send that id to the delete function
                $('#serviceDltConfirmBtn').click(function() {

                    var finalDltId = $('#serviceDltId').html();
                    serviceDelete(finalDltId);
                })
                //Edit icon
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
//ajax call for delete service
function serviceDelete(deleteId) {

    axios.post('/servicedelete', {
            id: deleteId
        })
        .then(function(response) {

            if (response.data == 1) 
            {
                $('#deleteModal').modal('hide');
                toastr.success('Delete Successfull');
                getServiceJsonData();
            } 
            else 
            {
                $('#deleteModal').modal('hide');
                //getServiceJsonData();
                toastr.error('Delete Failed');
            }

        })
        .catch(function(error) {

        })


}


//ajax call for edit service; show each service's all data on edit modal
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

        })


}