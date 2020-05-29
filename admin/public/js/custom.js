$(document).ready(function () {
$('#VisitorDt').DataTable();
$('.dataTables_length').addClass('bs-select');
});

function getServiceJsonData(){





	axios.get('/servicedata')
  	.then(function (response) {
  		if(response.status==200)
  		{
  			$('#dataTable').removeClass('d-none');
  			$('#loadingAnim').addClass('d-none');

  			var serviceDataJson=response.data;
    		$.each(serviceDataJson, function(i, item) {
    		$('<tr>').html(
    		"<td <img class='table-img' src="+ serviceDataJson[i].service_img + "></td>" +
    		"<td>" + serviceDataJson[i].service_name + "</td>" +
    		"<td>" + serviceDataJson[i].service_des + "</td>" +
    		"<td><a href='' ><i class='fas fa-edit'></i></a></td>" +
    		"<td><a href='' ><i class='fas fa-trash-alt'></i></a></td>").appendTo('#serviceData_table');
   			});

  		}
  		else{
  			$('#notFound').removeClass('d-none');
  			$('#loadingAnim').addClass('d-none');

  		}
    

   }).catch(function (error) {
   			$('#notFound').removeClass('d-none');
  			$('#loadingAnim').addClass('d-none');

   });
}