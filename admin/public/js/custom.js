$(document).ready(function() {
    $('#VisitorDt').DataTable();
    $('.dataTables_length').addClass('bs-select');
});

function getServiceJsonData() {
    axios.get('/servicedata')
        .then(function(response) {
            if (response.status == 200) {


                $('#dataTable').removeClass('d-none');
                $('#loadingAnim').addClass('d-none');

                $('#serviceData_table').empty(); //avoid clone table data after more than one time delete

                var serviceDataJson = response.data;
                $.each(serviceDataJson, function(i, item) {
                    $('<tr>').html(
                        "<td <img class='table-img' src=" + serviceDataJson[i].service_img + "></td>" +
                        "<td>" + serviceDataJson[i].service_name + "</td>" +
                        "<td>" + serviceDataJson[i].service_des + "</td>" +
                        "<td><a href='' ><i class='fas fa-edit'></i></a></td>" +
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



            } else {
                $('#notFound').removeClass('d-none');
                $('#loadingAnim').addClass('d-none');

            }


        }).catch(function(error) {
            $('#notFound').removeClass('d-none');
            $('#loadingAnim').addClass('d-none');

        });
}

function serviceDelete(deleteId) {

    axios.post('/servicedelete', {
            id: deleteId
        })
        .then(function(response) {

            if (response.data == 1) {
                $('#deleteModal').modal('hide');
                toastr.success('Delete Successfull');
                getServiceJsonData();

            } 
            else {
                $('#deleteModal').modal('hide');
                //getServiceJsonData();
                toastr.error('Delete Failed');

            }

        })
        .catch(function(error) {

        })


}