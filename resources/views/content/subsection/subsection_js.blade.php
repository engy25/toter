<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script src="http://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>


<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<!-- CSS files -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Toastr JS -->
<script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


</script>



<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
  $(document).ready(function () {
        // Update image preview when a file is selected
        $('#subimage').change(function () {
            var input = this;
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#image-preview').attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        });
    });
</script>







{{-- /** to fetch list of the data of Sections and populate the dropdown*/// --}}
<script>
  $(document).ready(function(){

    $.ajax({
  url: "{{ route('sections.display') }}",
  method: 'GET',
  dataType: "json",
  success: function (data) {
    // console.log(data);
    // populate the dropdown with the received section data
    var options='<option value=""> Select Section </option>';
    $.each(data, function (index, section) {
      var sectionName = section.translations ? section.translations[0].name : section.name;
      options += '<option value="' + section.id + '">' + sectionName+ '</option>';
    });
    $('#section_id').html(options);
  },
  error: function (response) {
    // console.log(response);
    // Handle error if fetching countries fails
    console.error('Error fetching sections:', response);
  }
});


  });

</script>

{{-- ----------------------------------- --}}





{{-- to fetch the list of the section when  update subsection --}}





{{-- /** to fetch list of the data of countries and populate the dropdown in update */// --}}
<script>
  $(document).ready(function(){

    $.ajax({
  url: "{{ route('sections.display') }}",
  method: 'GET',
  dataType: "json",
  success: function (data) {
    // populate the dropdown with the received country data
    var options='<option value=""> Select Section </option>';
    $.each(data, function (index, section) {
     var sectionName = section.translations ? section.translations[0].name : section.name;

      options += '<option value="' + section.id + '">' + sectionName+ '</option>';
    });
    $('#up_section_id').html(options);
  },
  error: function (response) {
    // Handle error if fetching countries fails
    console.error('Error fetching sections:', response);
  }
});


  });

</script>

















{{-- ////////////////////////////////////////**add Subsection///////////////////////////////////--}}

<script>
  $(document).ready(function(){
    // console.log('Document is ready.');
    $(document).on("click", '.add_subsection', function(e){
    e.preventDefault();
    let name_en = $('#name_en').val();
    let name_ar= $('#name_ar').val();
    let description_en = $('#description_en').val();
    let description_ar= $('#description_ar').val();
    let section_id=$('#section_id').val();
    let image = $('#subimage')[0].files[0];

    var formData = new FormData();
    formData.append('name_en', name_en);
    formData.append('name_ar', name_ar);
    formData.append('description_en', description_en);
    formData.append('description_ar', description_ar);
    formData.append('section_id', section_id);
    formData.append('image', image);
    $('.errMsgContainer').empty();
    // Clear previous error messages

    $.ajax({

      url: "{{ route('subsections.store') }}",
      method: 'post',
      data: formData,
      dataType: "json",
      contentType: false,  // Set to false for FormData
      processData: false,  // Set to false for FormData
      headers: {

        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },

      success: function(data) {
      console.log(data);
      $('.errMsgContainer').empty(); // Clear previous error messages
      $("#addSubsectionModal").modal("hide");
      $('#addSubsectionForm')[0].reset();
      $('#data-table2').load(location.href+' #data-table2');
      $('#success1').show();
      /* hide success message after 4 seconds */
       setTimeout(function() {

        $('#success1').hide();
       }, 2000); // 2000 milliseconds = 2 seconds

      $('.errMsgContainer').empty(); // Clear previous error messages
      },
      error: function(response) {
        console.log(response.responseJSON);
        $('.errMsgContainer').empty(); // Clear previous error messages
        errors = response.responseJSON.errors;
        $.each(errors, function(index, value){
          $('.errMsgContainer').append('<span class="text-danger">'+value+'</span><br />');
        });
      }
    });
  });
});

</script>

{{-- ///////////////////////////////////////////////////////////////////////////--}}





{{-- //////////////////////////////DElete Store////////////////////////////// --}}



<script>
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

  $(document).on('click', '.delete-subsection', function (e) {
  $('.errMsgContainer').empty(); // Clear previous error messages
    e.preventDefault();

    e.stopPropagation();
    var subsection_id = $(this).data('id');



    if (confirm("Are you sure you want to delete this Subsection?")) {
        $.ajax({
            url: '/subsections/' + subsection_id,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}',
                subsection: subsection_id,

            },
            success: function (data) {
              ///
              if (data.status === true) {
                $('#data-table2').load(location.href + ' #data-table2');
                $('#success3').show();
                setTimeout(function () {
                  $('#success3').hide();
                }, 2000);
              } else if (data.status === false) {
                 // side could not be deleted due to relationships
                alert(data.msg);
              } else if (data.status === 403) {
                 // side deletion forbidden due to relationships
                alert(data.msg);

              }
            },
            error: function (data) {
              alert('Deletion of this Subsection is forbidden as it is related to other tables.');
                console.log(data);
                if(data.status==false){
                  alert('Deletion of this Subsection is forbidden as it is related to other tables.');
                }
                if (data.status !== 500) {
                    alert('An error occurred while deleting the Subsection.');
                }
            }
        });
    }
});


</script>

{{-- //////////////////////////////DElete City////////////////////////////// --}}



{{-- /////////////////////////////Pagination City///////////////////////////////////// --}}
<script>
  $(document).on('click', '.pagination a', function(e){

  e.preventDefault();
  let page = $(this).attr('href').split('page=')[1];
  subsection(page);
});

function subsection(page) {
    $.ajax({
      url: "/pagination/paginate-subsection?page=" + page,
        type: 'get',
        success: function(data) {
            $('.table-responsive').html(data);
        }
    });
}

</script>
{{-- /////////////////////////////Pagination City///////////////////////////////////// --}}


{{-- /////////////////////////////Search City///////////////////////////////////// --}}
<script>
  $(document).on('keyup',function(e){
  e.preventDefault();
  let search_string=$('#search').val();
  // console.log(search_string);
  $.ajax({
    url:"{{ route('search.subsection') }}",
    method:'GET',
    data:{
      search_string:search_string
    },
    success:function(data){

      $('.table-responsive').html(data);
    }

  });



})

</script>


{{-- ///////////////////////////////////////////////////////////////// --}}

{{-- update subsection --}}



