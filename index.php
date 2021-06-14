<!DOCTYPE html>
<html>
  <head>
    <title>Facebook Style Load Data in Timeline with PHP Mysql Ajax</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/placeholder-loading/dist/css/placeholder-loading.min.css">
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <br />
    <div class="container">
      <h3 align="center">Facebook Style Load Data in Timeline with PHP Mysql Ajax</h3>
      <br />
      <div class="card">
        <div class="card-header">Dynamic Data</div>
        <div class="card-body">
          <ul class="timeline">

            <li class="clearfix" id="clearfix_id" style="float: none;"></li>
          </ul>
          <span id="no_more_data"></span>
        </div>
      </div>
      <br />
      <br />
    </div>
  </body>
</html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
  $(document).ready(function(){
    
    var action = 'inactive';

    function load_timeline_data(last_id = '')
    {      
      $.ajax({
        url:"fetch.php",
        method:"POST",
        data:{last_id:last_id},
        dataType:'json',
        success:function(data)
        {
          setTimeout(function(){
            $('.removeTimeline').remove();
            $('#clearfix_id').remove();
            $('.timeline').append(data.timeline_output);
            if(data.no_data_output != '')
            {
              $('#no_more_data').html(data.no_data_output);
            }
            action = 'inactive';
          }, 1000);
        }
      });
    }

    function make_skeleton()
    {
      var output = '';
      $('#clearfix_id').remove();
      for(var count = 0; count < 4; count++)
      {
        temporary_class = '';
        if(count%2 != 0)
        {
          temporary_class = 'class="timeline-inverted removeTimeline"';
        }
        else
        {
          temporary_class = 'class="removeTimeline"';
        }

        output += '<li '+temporary_class+'>';
        output += '<div class="timeline-badge primary"><a><i class="fa fa-dot-circle-o" aria-hidden="true"></i></a></div>';
        output += '<div class="timeline-panel">';
        output += '<div class="timeline-heading"></div>';
        output += '<div class="timeline-body">';
        output += '<div class="ph-item">';
        output += '<div class="ph-col-4">';
        output += '<div class="ph-picture"></div>';
        output += '</div>';
        output += '<div>';
        output += '<div class="ph-row">';
        output += '<div class="ph-col-12 big"></div>';
        output += '<div class="ph-col-12"></div>';
        output += '<div class="ph-col-12"></div>';
        output += '<div class="ph-col-12"></div>';
        output += '<div class="ph-col-12"></div>';
        output += '</div></div></div>';
        output += '</div>';
        output += '</div></div></li>';
      }
      output += '<li class="clearfix" id="clearfix_id" style="float: none;"></li>';
      $('.timeline').append(output);
    }

    if(action == 'inactive')
    {
      make_skeleton();

      setTimeout(function(){ 
        load_timeline_data(); 
      }, 3000);
    }

    $(window).scroll(function(){
      var last_id = $('#clearfix_id').data('last_id');
      if(last_id != '')
      {
        if($(window).scrollTop() + $(window).height() > $(".timeline").height() && action == 'inactive')
        {
          action = 'active';
          make_skeleton();

          setTimeout(function(){ 
            load_timeline_data(last_id); 
          }, 5000);
        }
      }
    });

  });
</script>