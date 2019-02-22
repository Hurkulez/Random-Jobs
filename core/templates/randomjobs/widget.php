<div id="jobwidget"></div>

<script>
  (function worker() {
  $.ajax({
    url: '<?php echo SITE_URL ?>/action.php/randomjobs/innerwidget', 
    success: function(data) {
      $('#jobwidget').html(data);
    },
    complete: function() {
      // Schedule the next request when the current one's complete
      setTimeout(worker, 20000);
    }
  });
})();
</script>
