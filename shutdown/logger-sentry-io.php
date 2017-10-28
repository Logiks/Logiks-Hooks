<?php
if(isset($_REQUEST['debug']) && $_REQUEST['debug']=="true") {
  
} else {
  if(isset($_SESSION['SESS_ACCESS_SITES'])) {
    if(!in_array("cms",$_SESSION['SESS_ACCESS_SITES'])) {
      if(!isset($_SESSION['SESS_PRIVILEGE_ID']) || $_SESSION['SESS_PRIVILEGE_ID']>3) {
        return;
      }
    }
  } else {
    return;
  }
}
// printArray($_SESSION);
?>
<script src="https://cdn.ravenjs.com/3.15.0/raven.min.js" crossorigin="anonymous"></script>
<script>
    Raven.config('https://f80feaca6b754052acdfc2c1af67b139@sentry.io/175654', {
        release: '<?=SITENAME."-v".APPS_VERS?>',
        logger: '<?=SITENAME?>',
        environment: 'dev',
        tags: {"VERS":'<?=APPS_VERS?>'},
        debug: true,
        ignoreUrls: [
            /disqus\.com/,
            /google\.com/,
            /getsentry\.com/
        ],
        ignoreErrors: [
            'fb_xd_fragment',
            /ReferenceError:.*/
        ]
//         ,includePaths: [
//             /https?:\/\/(www\.)?getsentry\.com/
//         ]
    }).install();
</script>
<style>
  .sentry-logger {
        font-size: 3em;
        position: fixed;
        left: 10px;
        bottom: 10px;
        cursor: pointer;
        color: maroon;
        z-index: 9999999999999;
  }
  .sentry-error-embed {
    padding:20px !important;
  }
</style>
<a id='sentry-logger' class='sentry-logger' href='#'><i class='fa fa-bug'></i></a>
<script>
$( function() {
  return;
  $("#sentry-logger").draggable();
  $("#sentry-logger").click(function(e) {
    e.preventDefault();
    
    lgksPrompt("Log Message !", "Logger!",function(ans) {
      if(ans!=null) {
        Raven.captureMessage(ans, {
          level: 'warning'
        });
        Raven.showReportDialog();
      }
    });
    
    return false;
  });
  Raven.setUserContext({
      email: '<?=isset($_SESSION['SESS_USER_EMAIL'])?$_SESSION['SESS_USER_EMAIL']:''?>',
      username: '<?=isset($_SESSION['SESS_USER_ID'])?$_SESSION['SESS_USER_ID']:''?>',
      ip_address: '<?=$_SERVER['REMOTE_ADDR']?>'
  });
});
</script>
