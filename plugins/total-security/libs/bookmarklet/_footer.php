<div id="loading" class="loading-invisible">
<img src="../../images/ajax-loader.gif" width="128" height="15" border="0" alt="*" />
</div>
<script type="text/javascript">
  document.getElementById("loading").className = "loading-visible";
  var hideDiv = function(){document.getElementById("loading").className = "loading-invisible";};
  var oldLoad = window.onload;
  var newLoad = oldLoad ? function(){hideDiv.call(this);oldLoad.call(this);} : hideDiv;
  window.onload = newLoad;
</script>

</body>
</html>